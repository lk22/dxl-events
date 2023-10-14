<?php 
namespace DxlEvents\Classes\Controllers\Calendar;

use Dxl\Classes\Abstracts\AbstractActionController as Controller;

use DxlEvents\Classes\Repositories\CalendarEventRepository;

use Dxl\Classes\Utilities\CalendarUtility;

use DateTime;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('CalendarController') ) {
  class CalendarController extends Controller {
    public function __construct() 
    {
      $this->calendarEventRepository = new CalendarEventRepository();
      $this->registerAdminActions();
    }

    public function registerAdminActions(): void
    {
      add_action('wp_ajax_dxl_calendar_event_create', [$this, 'createCalendarEventAction']);
      add_action('wp_ajax_dxl_calendar_event_update', [$this, 'updateCalendarEventAction']);
      add_action('wp_ajax_dxl_calendar_event_delete', [$this, 'deleteCalendarEventAction']);
      add_action('wp_ajax_dxl_calendar_event_complete', [$this, 'completeCalendarEventAction']);
      add_action('wp_ajax_dxl_calendar_event_archive', [$this, 'archiveCalendarEventAction']);
      add_action('wp_ajax_dxl_event_associate_members', [$this, 'getAssociateMembersAction']);
    }

    public function registerGuestActions(): void {}

    /**
     * Manage views for calendar events
     *
     * @return void
     */
    public function manage(): void
    {
      if ($this->hasUriKey('action')) {
        switch($this->getUriKey('action')) {
          case 'list': 
            $this->getCalendarEvents();
            break;

          case 'details': 
            $this->getCalendarEventDetails();
            break;

          default:
            $this->getCalendarEvents();
            break;
        }
      } else {
        $this->getCalendarEvents();
      }
    }

    /**
     * Render the calendar event list view for the admin
     *
     * @return void
     */
    public function getCalendarEvents(): void
    {
      global $wpdb;

      $isArchived = false;

      // query for all the board members
      $associates = $wpdb->get_results(
        "SELECT 
          ID as id,
          post_title as name,
          post_name as slug 
        FROM dxl_posts 
        WHERE post_type = 'dxl_board_members'"
      );

      if ( isset($_REQUEST["archived"]) && $_REQUEST["archived"] == true ) {
        $isArchived = true;
      } else {
        $isArchived = false;
      }

      if ( isset($_REQUEST["month"]) && isset($_REQUEST["year"]) ) {

        if ( $_REQUEST["month"] > 12) {
          $currentMonth = 1;
          $currentYear = $_REQUEST["year"] + 1;
        } else if ( $_REQUEST["month"] < 1 ) {
          $currentMonth = 12;
          $currentYear = $_REQUEST["year"] - 1;
        } else {
          $currentMonth = $_REQUEST["month"];
          $currentYear = $_REQUEST["year"];
        }

        // $currentMonth = $_REQUEST["month"];
        // $currentYear = $_REQUEST["year"];
      } else {
        $currentMonth = date('m');
        $currentYear = date("Y"); 
        $nextYear = $currentYear + 1;
      }


      $monthNames = CalendarUtility::getMonths($currentYear);
      $dayNames = CalendarUtility::getWeekDays();

      $firstDay = date("w", mktime(0, 0, 0, $currentMonth, 0, $currentYear));
      $daysInMonth = date("t", mktime(0, 0, 0, $currentMonth, 1, $currentYear));

      $days = CalendarUtility::getMonthDays($daysInMonth);

      // get me a list of all the days in current month
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/list.php";
    }

    /**
     * Render the calendar event details view for the admin
     *
     * @return void
     */
    public function getCalendarEventDetails(): void
    {
      $calendarEventId = $_GET["id"];
      $event = $this->calendarEventRepository->find($calendarEventId);
      $updated_at = date("d-m-Y H:i", $event->updated_at + 7200);
      $created_at = date("d-m-Y H:i", $event->created_at + 7200);
      $completed_at = date("d-m-Y H:i", $event->completed_at + 7200);
      $archived_at = date("d-m-Y H:i", $event->archived_at + 7200);
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/details.php";
    }

    /**
     * Creating calendar event action
     *
     * @return void
     */
    public function createCalendarEventAction(): void
    {
        $data = $_REQUEST;

        $interval = CalendarUtility::getIntervalPeriod(
          $data["eventDate"],
          $data["eventEndDate"],
          "P1D",
          "+1 day"
        );

        foreach ($interval as $date) {
          $this->calendarEventRepository->create([
            "event_name" => $data["eventName"],
            "description" => $data["description"],
            "event_date" => $date->format("Y-m-d"),
            "event_end_date" => $date->format("Y-m-d"),
            "event_year" => $date->format("Y"),
            "event_deadline" => $data["eventDeadline"],
            "associate" => $data["associate"],
            "priority" => $data["priority"],
            "created_at" => time()
          ]);
        }

        // if the event is recurring then create multiple event for the same interval period yearly
        if ( isset($data["isRecurring"]) && $data["isRecurring"] == "true" ) {

          $nextYearStartDate = new \DateTime($data["eventDate"]);
          $nextYearEndDate = new \DateTime($data["eventEndDate"]);

          $nextYearStartDate->modify('+1 year');
          $nextYearEndDate->modify('+1 year');
          
          // wp_die();
          $interval = CalendarUtility::getIntervalPeriod(
            $nextYearStartDate->format("d-m-Y"),
            $nextYearEndDate->format("d-m-Y"),
            "P1D",
            "+1 day"
          );

          foreach ($interval as $date) {
            $this->calendarEventRepository->create([
              "event_name" => $data["eventName"],
              "description" => $data["description"],
              "event_date" => $date->format("Y-m-d"),
              "event_end_date" => $date->format("Y-m-d"),
              "event_year" => $date->format("Y"),
              "event_deadline" => $data["eventDeadline"],
              "associate" => $data["associate"],
              "priority" => $data["priority"],
              "created_at" => time()
            ]);
          }
        }


        wp_send_json_success([
          "message" => "Opgaven blev oprettet"
        ]);
    }

    /**
     * Updating existing calendar event action
     *
     * @return void 
     */
    public function updateCalendarEventAction(): void 
    {
        $updated = $this->calendarEventRepository->update([
          "event_name" => $_REQUEST["eventName"],
          "description" => $_REQUEST["description"],
          "event_date" => $_REQUEST["eventDate"],
          "event_year" => $_REQUEST["eventYear"],
          "event_deadline" => $_REQUEST["eventDeadline"],
          "updated_at" => time()
        ], (int) $_REQUEST["eventId"]);

        if ( ! $updated ) {
          wp_send_json_error([
            "message" => "Noget gik galt, kunne ikke opdatere eventet"
          ]);
        }

        wp_send_json_success([
          "message" => "Opgaven er opdateret"
        ]);
    }

    /**
     * Delete calendar event action
     *
     * @return void
     */
    public function deleteCalendarEventAction(): void 
    {
      $deleted = $this->calendarEventRepository->delete((int) $_REQUEST["eventId"]);
      if ( ! $deleted ) {
        wp_send_json_error([
          "message" => "Noget gik galt, kunne ikke slette eventet"
        ]);
      }

      wp_send_json_success([
        "message" => "Opgaven blev slettet"
      ]);
    }

    /**
     * Completed calendar event resource
     *
     * @return void
     */
    public function completeCalendarEventAction(): void {
      $completed = $this->calendarEventRepository->update([
        "is_completed" => 1,
        "completed_at" => time()
      ], (int) $_REQUEST["eventId"]);

      if ( ! $completed ) {
        wp_send_json_error([
          "message" => "Noget gik galt, kunne ikke fuldføre opgave"
        ]);
      }

      wp_send_json_success([
        "message" => "Opgaven er fuldført"
      ]);
    }

    /**
     * Archive calendar event resource
     *
     * @return void
     */
    public function archiveCalendarEventAction(): void 
    {
      $archived = $this->calendarEventRepository->update([
        "is_archived" => 1,
        "archived_at" => time()
      ], (int) $_REQUEST["eventId"]);

      if ( ! $archived ) {
        wp_send_json_error([
          "message" => "Noget gik galt, kunne ikke arkivere opgave"
        ]);
      }

      wp_send_json_success([
        "message" => "Opgaven er arkiveret"
      ]);
    }
  }
}
?>
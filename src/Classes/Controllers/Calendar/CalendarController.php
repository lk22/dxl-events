<?php 
namespace DxlEvents\Classes\Controllers\Calendar;

use Dxl\Classes\Abstracts\AbstractActionController as Controller;

use DxlEvents\Classes\Repositories\CalendarEventRepository;

use Dxl\Classes\Utilities\CalendarUtility;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('CalendarController') ) {
  class CalendarController extends Controller {
    public function __construct() 
    {
      $this->calendarEventRepository = new CalendarEventRepository();
      $this->registerAdminActions();
    }

    public function registerAdminActions() 
    {
      add_action('wp_ajax_dxl_calendar_event_create', [$this, 'createCalendarEventAction']);
    }

    public function registerGuestActions() {}

    /**
     * Manage views for calendar events
     *
     * @return void
     */
    public function manage() 
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
    public function getCalendarEvents() 
    {
      global $wpdb;
      
      // $daysPeriod = new \DatePeriod(
      //   new \DateTime('first day of this month'),
      //   new \DateInterval('P1D'),
      //   new \DateTime('first day of next month')
      // );

      // foreach ($daysPeriod as $day) {
      //   $days[] = $day->format('Y-m-d');
      // }

      // // get current month in human readable format
      // $currentMonth = date('F', strtotime('now'));

      // // give me a list of all dates in current month
      // $dates = [];
      // foreach($daysPeriod as $day) {
      //   $dates[] = [
      //     "date" => $day->format('d'),
      //     "formatted" => $day->format('l')
      //   ];
      // }

      $currentMonth = date('m');
      $currentYear = date("Y"); 

      $monthNames = CalendarUtility::getMonths();
      $dayNames = CalendarUtility::getWeekDays();

      $firstDay = date("w", mktime(0, 0, 0, $currentMonth, 0, $currentYear));
      $daysInMonth = date("t", mktime(0, 0, 0, $currentMonth, 1, $currentYear));

      $days = CalendarUtility::getMonthDays($daysInMonth);

      // $events = $wpdb->get_results(
      //   "SELECT * FROM {$wpdb->prefix}calendar_events WHERE event_date BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-{$currentMonth}-{$daysInMonth}'"
      // );

      // get me a list of all the days in current month
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/list.php";
    }

    /**
     * Render the calendar event details view for the admin
     *
     * @return void
     */
    public function getCalendarEventDetails() 
    {
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/details.php";
    }

    /**
     * Creating calendar event action
     *
     * @return void
     */
    public function createCalendarEventAction() 
    {
      $created = $this->calendarEventRepository->create([
        "event_name" => $_REQUEST["eventName"],
        "description" => $_REQUEST["description"],
        "event_date" => $_REQUEST["eventDate"],
        "event_deadline" => $_REQUEST["eventDeadline"],
      ]);

      if ( ! $created ) {
        wp_send_json_error([
          "message" => "Noget gik galt, kunne ikke oprette eventet"
        ]);
      }

      wp_send_json_success([
        "message" => "Eventet blev oprettet"
      ]);
    }
  }
}


?>
<?php 
namespace DxlEvents\Classes\Controllers\Calendar;

use Dxl\Classes\Abstracts\AbstractActionController as Controller;

use DxlEvents\Classes\Repositories\CalendarEventRepository;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('CalendarController') ) {
  class CalendarController extends Controller {
    public function __construct() {
      $this->CalendarEventRepository = new CalendarEventRepository();
    }

    public function registerAdminActions() {}
    public function registerGuestActions() {}

    /**
     * Manage views for calendar events
     *
     * @return void
     */
    public function manage() {
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
    public function getCalendarEvents() {
      global $wpdb;
      
      $daysPeriod = new \DatePeriod(
        new \DateTime('first day of this month'),
        new \DateInterval('P1D'),
        new \DateTime('first day of next month')
      );

      // get current month in human readable format
      $currentMonth = date('F', strtotime('now'));

      // give me a list of all dates in current month
      $dates = [];
      foreach($daysPeriod as $day) {
        $dates[] = $day->format('d');
      }

      $events = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}calendar_events WHERE event_date BETWEEN '{$daysPeriod->start->format('Y-m-d')}' AND '{$daysPeriod->end->format('Y-m-d')}'"
      );

      // get me a list of all the days in current month
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/list.php";
      
    }

    /**
     * Render the calendar event details view for the admin
     *
     * @return void
     */
    public function getCalendarEventDetails() {
      require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/details.php";
    }
  }
}


?>
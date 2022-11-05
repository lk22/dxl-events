<?php 

/**
 * Plugin Name: DXL Event Manager
 * Description: Håndtering af DXL begivenheder
 * Author: Leo Knudsen
 * Version: 1.0.0
 */

require_once dirname(__FILE__) . "/vendor/autoload.php";
require_once ABSPATH . "wp-content/plugins/dxl-memberships/PhpSpreadsheet/vendor/autoload.php";

use DxlEvents\Classes\Controllers\LanController;
use DxlEvents\Classes\Controllers\TournamentController;
use DxlEvents\Classes\Controllers\TrainingAction;
use DxlEvents\Classes\Controllers\GameController;
use DxlEvents\Classes\Controllers\EventController;

use DxlEvents\Classes\Services\EventService;

if( !class_exists('DxlEvent') ){
    class DxlEvent 
    {

        protected $commands = [
            'SetTournamentHeldStatus' => 'DxlEvents\Classes\Cron\ChangeTournamentHeldStatus',
            'AutoChangeLanHeldStatus' => 'DxlEvents\Classes\Cron\AutoChangeLanHeldStatus',
        ];

        public function __construct()
        {
            $this->lan = new LanController();
            $this->tournament = new TournamentController();
            $this->training = new TrainingAction();
            $this->game = new GameController();
            $this->constructFrontend();
            $this->register_cron_tasks();
            add_action( 'admin_menu', [$this, 'registerModuleMenu']);
            add_action('admin_enqueue_scripts', [$this, 'enqueueAdminEventScripts']);
            // add_action( 'wp_dashboard_setup', [$this, 'register_event_widgets']);

            // construct shortcodes
            add_shortcode('frontpage_latest_events', [$this, 'construct_latest_events']);
            add_shortcode('events_page_lan_events', [$this, 'construct_events']);
        }

        public function registerModuleMenu()
        {
            add_menu_page(
				'Events',
				'Events',
				'manage_options',
				'dxl-events',
				array($this, 'manage_tournaments'),
                'dashicons-calendar',
                2
			);

            add_submenu_page(
				'dxl-events',
				'Turneringer',
				'Turneringer',
				'manage_options',
				'dxl-events-tournaments',
				array($this, 'manage_tournaments')
			);

            add_submenu_page(
				'dxl-events',
				'LAN',
				'LAN',
				'manage_options',
				'dxl-events-lan',
				array($this, 'manage_lan_events')
			);

            add_submenu_page(
				'dxl-events',
				'Spil',
				'Spil',
				'manage_options',
				'dxl-events-games',
				array($this, 'manage_games')
			);
        }

        public function register_event_widgets()
        {
            wp_add_dashboard_widget('dxl_latest_members_widget', esc_html__('LAN Deltagere', ''), [$this, 'register_event_participants_widget']);
        }

        public function enqueueAdminEventScripts()
        {
            wp_register_script('dxl-admin-events', plugins_url('dxl-events/src/Admin/assets/js/admin-events.js'), array('jquery'));
            wp_enqueue_script('dxl-admin-events');
        }

        public function constructFrontend()
        {
            add_action('wp_enqueue_scripts', [$this, 'enqueeuFrontendEventScripts']);
        }

        /**
         * register events cron tasks
         *
         * @param array $commands
         * @return void
         */
        public function register_cron_tasks()
        {
            foreach($this->commands as $command) {
                return new $command;
            }
        }

        /**
         * enqueuing event scripts only on event pages
         *
         * @return void
         */
        public function enqueeuFrontendEventScripts()
        {

        }

        public function register_event_participants_widget()
        {
            $participants = $this->lan->getEventParticipants();
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/widget/participants.php";
        }

        /**
         * Construct latest events shortcode event
         *
         * @return void
         */
        public function construct_latest_events(): void 
        {
            $events = [
                "lan" => $this->lan->getEvents(),
                // "tournaments" => $this->tournament->getEvents(),
                "training" => $this->training->getEvents(2)
            ];

            // var_dump($events); die();
            
            $eventData = [];
            foreach($events["lan"] as $l => $lan) {
                $eventData["lan"][$l] = [
                    "title" => $lan->title,
                    "startdate" => $lan->start,
                    "enddate" => $lan->end
                ];
            }

            foreach($events["training"] as $t => $training) {
                $eventData["training"][$t] = [
                    "title" => $training->name,
                    "starttime" => date("H", $training->starttime),
                    "endtime" => date("H", $training->endtime),
                    "is_recurring" => $training->is_recurring,
                    "event_day" => $training->event_day
                ];
            }
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/latest.php";
        }

        public function construct_events()
        {
            $eventController = new EventController;
            $eventController->manageFrontendEventViews();
        }

        public function manage_tournaments()
        {
            $this->tournament->manage();
        }

        public function manage_lan_events()
        {
            $this->lan->manage();
        }

        public function manage_games()
        {
            $this->game->manage();
        }
    }
}

new DxlEvent();


?>
<?php 
namespace DxlEvents\Classes\Controllers;

require_once(ABSPATH . "wp-content/plugins/dxl-core/src/Classes/Core.php");
require_once(ABSPATH . "wp-content/plugins/dxl-core/src/Classes/Discord/DiscordWebhookService.php");
use Dxl\Classes\Abstracts\AbstractActionController as Controller;
use Dxl\Classes\Core;

// Repositories
use DxlEvents\Classes\Repositories\LanRepository as Lan;
use DxlEvents\Classes\Repositories\TournamentRepository;
use DxlEvents\Classes\Repositories\LanParticipantRepository;
use DxlEvents\Classes\Repositories\EventWorkChoresRepository;

// services
use DxlEvents\Classes\Services\LanEventService as Service;

use DxlEvents\Classes\Factories\TimeplanFactory;

use Dxl\Classes\Discord\DiscordWebhookService;

if( !class_exists('LanController') ) 
{
    class LanController extends Controller
    {

        /**
         * Dxl core object
         *
         * @var \Dxl\Classes\Core
         */
        public $dxl;

        /**
         * Undocumented variable
         *
         * @var \DxlEventds\Classes\Repositories\LanRepository;
         */
        protected $lan;

        /**
         * Tournament repository
         *
         * @var DxlEvents\Classes\Repositories\TournamentRepository
         */
        protected $tournamentRepository;

         /**
         * Lan Participant repository
         *
         * @var DxlEvents\Classes\Repositories\TournamentRepository
         */
        protected $lanParticipantRepository;

        /**
         * Event work chore repository
         *
         * @var DxlEvents\Classes\Repositories\eventWorkChoreRepository
         */
        protected $eventWorkChoreRepository;

        /**
         * Event service 
         *
         * @var DxlEvents\Classes\Services\EventService
         */
        protected $eventService;

        /**
         * Action constructor
         */
        public function __construct() 
        {
            parent::__construct();
            $this->lanRepository = new Lan();
            $this->tournamentRepository = new TournamentRepository();
            $this->lanParticipantRepository = new LanParticipantRepository();
            $this->eventWorkChoreRepository = new EventWorkChoresRepository();
            $this->dxl = new Core();
            $this->eventService = new Service();
            $this->registerAdminActions();
            $this->registerGuestActions();
        }

        /**
         * Registering admin actions
         *
         * @return void
         */
        public function registerAdminActions()
        {
            add_action("wp_ajax_dxl_event_create", [$this, 'ajaxCreateEvent']);
            add_action("wp_ajax_dxl_event_configure", [$this, 'ajaxConfigureEvent']);
            add_action("wp_ajax_dxl_event_update", [$this, 'ajaxUpdateEvent']);
            add_action("wp_ajax_dxl_lan_event_delete", [$this, 'ajaxDeleteEvent']);
            add_action("wp_ajax_dxl_event_publish", [$this, 'ajaxPublishEvent']);
            add_action("wp_ajax_dxl_event_unpublish", [$this, 'ajaxUnpublishEvent']);
            add_action("wp_ajax_dxl_event_export_participants", [$this, 'ajaxExportParticipants']);
            add_action("wp_ajax_dxl_event_create_update_timeplanner", [$this, 'ajaxCreateTimeplanner']);
            add_action("wp_ajax_dxl_event_update_workchores", [$this, 'ajaxUpdateWorkChores']);
        }

        /**
         * registering actions for non admin users
         *
         * @return void
         */
        public function registerGuestActions()
        {

        }

        /**
         * Create LAN Event ressource
         *
         * @return void
         */
        public function ajaxCreateEvent(): void 
        {
            global $current_user;
            $logger = $this->dxl->getUtility('Logger');
            $logger->log('Trigger method ' . __METHOD__);

            $newEvent = $this->get('event');
            $newEvent = $_REQUEST["event"];

            $defaultWorkChores = $this->eventService->initializeDefaultWorkChores();

            // $this->dxl->response('event', [
            //     "error" => true,
            //     "response" => $defaultWorkChores
            // ]);

            // wp_die();

            $event = $this->lanRepository->create([
                "title" => $newEvent["title"],
                "slug" => strtolower(str_replace(' ', '-', $newEvent["title"])),
                "is_draft" => 1,
                "description" => $newEvent["description"],
                "extra_description" => $newEvent['description_extra'],
                "start" => strtotime($newEvent['startdate']),
                "end" => strtotime($newEvent['enddate']),
                "participants_count" => 0,
                "tournaments_count" => 0,
                "author" => $current_user->ID,
                "created_at" => time(),
                "seats_available" => $newEvent['seats_available']
            ]);

            $this->lanRepository->settings()->create([
                "event_id" => $event,
                "event_location" => $newEvent['location'],
                "event_price" => 0,
                "breakfast_friday_price" => 0,
                "breakfast_saturday_price" => 0,
                "lunch_saturday_price" => 0,
                "dinner_saturday_price" => 0,
                "breakfast_sunday_price" => 0,
                "start_at" => 0, // timestamp
                "end_at" => 0, // timestamp
                "latest_participation_date" => 0, // timestamp
                "participation_opening_date" => 0, // timestampe
            ]);
            

            $this->eventWorkChoreRepository->create([
                "event_id" => $event,
                "chores" => json_encode($defaultWorkChores)
            ]);

            if( !$event ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke oprette begivenhed"
                ]);
                wp_die();
            }

            $this->dxl->response('event', [
                "response" => "Begivenhed oprettet successfuldt"
            ]);
            $logger->log("Created event: " . $newEvent["title"] . " " . __METHOD__);
            wp_die();
        }

        /**
         * configure specific event ressource with remaining information before publishing
         *
         * @return void
         */
        public function ajaxConfigureEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Trigger method: " . __METHOD__, 'events');

            $config = $_REQUEST['config'];
            $event = $this->lanRepository->find($_REQUEST['event']);

            $is_configured = $this->eventService->configureEvent($event->id, $config);
            
            if( ! $is_configured ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke konfigurer begivenheden"
                ]);
                $logger->log("Failed to configure event, something went wrong " . __METHOD__, 'events');
                wp_die();
            }

            $this->dxl->response('event', [
                "error" => false,
                "response" => "Begivenhed konfigureret"
            ]);

            $logger->log("Configured event, " . $event->title . " succesfully", 'events');
            wp_die();
        }

        /**
         * Update event information
         *
         * @return void
         */
        public function ajaxUpdateEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering action: " . __METHOD__);

            $event = $_REQUEST["event"];
            $settings = $event["settings"];

            // echo json_encode($event["description"]); wp_die();

            $this->lanRepository->update([
                "title" => $event["title"],
                "description" => $event["description"],
                "extra_description" => $event["description_extra"],
                "start" => strtotime($event["startdate"]),
                "end" => strtotime($event["enddate"]),
                "updated_at" => time(),
                "seats_available" => $event["seats_available"]
            ], (int) $event["id"]);

            $this->eventService->configureEvent((int) $event["id"], $settings);

            $this->dxl->response('event', [
                "response" => "Begivenhed opdateret"
            ]);

            $logger->log("updated event, " . $event["title"] . " succesfully", 'events');
            wp_die();
        }

        /**
         * Delete LAN event resources
         *
         * @return void
         */
        public function ajaxDeleteEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering action: " . __METHOD__);

            $event = $_REQUEST["event"];

            // $this->eventService->removeEvent($event["id"]);
            
            $delete = $this->lanRepository->delete($event);
            $this->lanRepository->settings()->delete($event);
            $this->lanRepository->participants()->delete($event);

            if( ! $delete ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke slette begivenheden"
                ]);
                $logger->log("Failed to delete event, something went wrong " . __METHOD__, 'events');
                wp_die();
            }

            $this->dxl->response('event', [
                'response' => 'Begivenhed slettet'
            ]);

            $logger->log("Event deleted sucessfully, " . __METHOD__);
            wp_die();
        }

        /**
         * Publis backend event
         *
         * @return void
         */
        public function ajaxPublishEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("triggering action: " . __METHOD__);

            $event = $this->lanRepository->find((int) $_REQUEST["event"]);

            $this->lanRepository->update(["is_draft" => 0], (int) $event->id);

            $this->dxl->response('event', [
                "response" => "Begivenhed offentliggjort og kan nu deltages"
            ]);
            $logger->log("Published event " . $event->title . " and is now ready to be participated " . __METHOD__);
            
            $discord = new DiscordWebhookService(get_option("dxl_discord_webhook"));
            $discord->send_message("Ny begivenhed er blevet offentliggjort: " . $event->title . " " . get_site_url() . "/begivenhed/" . $event->id);
            
            wp_die();
        }

        /**
         * Unpublish event
         *
         * @return void
         */
        public function ajaxUnpublishEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("triggering action: " . __METHOD__);

            $event = $this->lanRepository->find((int) $_REQUEST["event"]);

            $this->lanRepository->update(["is_draft" => 1], (int) $event->id);

            $this->dxl->response('event', [
                "response" => "Begivenhed skjult og kan ikke deltages mere"
            ]);

            $logger->log("Closed event " . $event->title . " and is now closed to participation " . __METHOD__);
            wp_die();
        }

        /**
         * Export all participants to CSV
         */
        public function ajaxExportParticipants(): void
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("triggering action: " . __METHOD__);

            $participants = $this->lanParticipantRepository
                ->select()
                ->where('event_id', $_REQUEST["event"])
                ->get();

            $tournaments = $this->tournamentRepository
                ->select()
                ->where('has_lan', 1)
                ->whereAnd('lan_id', $_REQUEST["event"])
                ->get();

            if ( count($participants) < 1) {
                echo $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Ingen deltagere fundet"
                ]);
                wp_die();
            }

            $export = $this->eventService->exportParticipants($participants, $tournaments, $_REQUEST["event"]);
            echo $this->dxl->response('event', [
                "error" => false,
                "response" => "Deltagere eksporteret",
                "export" => $export
            ]);
            wp_die();
        }

        /**
         * Create timeplan for lan events
         *
         * @return void
         */
        public function ajaxCreateTimeplanner(): void {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("triggering action: " . __METHOD__);
            
            $event = $this->lanRepository->find($_REQUEST["event"]);

            $factory = new TimeplanFactory();
            $timeplanUpdated = $factory->get($_REQUEST["timeplanAction"])->call();
                
            echo json_encode($timeplanUpdated);
            wp_die();
        }

        /**
         * Updating work chores for event
         *
         * @return void
         */
        public function ajaxUpdateWorkChores(): void 
        {
            $logger = $this->dxl->getUtility("Logger");
            $logger->log("triggering action: " . __METHOD__);

            $event = $this->lanRepository->find($_REQUEST["event"]["id"]);

            $workChoresUpdated = $this->eventWorkChoreRepository->update([
                "chores" => json_encode($_REQUEST["event"]["fields"])
            ], $event->id);

            if ( ! $workChoresUpdated == 1 ) {
                //$logger->log("Failed to update work chores on event " . $event->name . " " . __METHOD__);
                echo $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, der fandtes ingen arbejdsopgaver at opdatere"
                ]);
                wp_die();
            }

            echo $this->dxl->response('event', [
                "error" => false,
                "response" => "Arbejdsopgaver opdateret"
            ]);

            wp_die();
        }

        /**
         * rendering LAN managing views
         *
         * @return void
         */
        public function manage(): void
        {
            if( $this->hasUriKey('action') ) {
                switch($this->getUriKey('action')) {
                    case 'list': 
                        $this->list();
                        break;

                    case 'details': 
                        $this->details();
                        break;

                    case 'participate':
                        $this->participate();
                    break;
                }
            } else {
                $this->list();
            }
        }

        /**
         * Get latest events
         *
         * @return void
         */
        public function getEvents()
        {
            return $this->lanRepository->select()->where('is_draft', 0)->limit(1)->get();
        }

        /**
         * fetch event participants
         *
         * @return void
         */
        public function getEventParticipants()
        {
            // fetch latest event
            $event = $this->lanRepository->select()->limit(1)->getRow();
            
            // fetch its newest participants
            $participants = $this->lanRepository->getParticipants($event->id);
            return $participants;
        }

        /**
         * rendering list view for all LAN events
         *
         * @return void
         */
        public function list(): void
        {
            $events = $this->lanRepository->all();
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/lan/list.php";
        }

        /**
         * fetch details on the event
         *
         * @return void
         */
        public function details(): void
        {
            $event = $this->lanRepository->find($this->getUriKey('id'));
            $settings = $this->lanRepository->settings()->find($this->getUriKey('id'));
            $tournaments = $this->tournamentRepository->select()->where('lan_id', $event->id)->get() ?? [];
            $participants = $this->lanParticipantRepository->findByEvent($event->id);
            $workchores = $this->eventWorkChoreRepository->select(['chores'])->where('event_id', $event->id)->get();
            $fridayChores = json_decode($workchores[0]->chores)->friday;
            $saturdayChores = json_decode($workchores[0]->chores)->saturday;
            $sundayChores = json_decode($workchores[0]->chores)->sunday;
            $participantsWithFood = $this->lanParticipantRepository->select()->where('event_id', $event->id)->whereAnd('food_ordered', 1)->get();
            $timeplan = $this->lanRepository->timeplan()->select()->where('event_id', $event->id)->get();
            $timeplanIsDraft = $timeplan->is_draft ?? 0;
            $timeplan = ($timeplan) ? json_decode($timeplan[0]->content) : [];
            $tournamentData = [];

            // var_dump(json_decode($workchores[0]->chores));
            // wp_die();
            
            foreach($tournaments as $t => $tournament) {
                $tournamentData[$t] = [
                    "title" => $tournament->title,
                    "participants_count" => $tournament->participants_count,
                    "startdate" => $tournament->start,
                ];
            } 
            
            $breakfast_friday = $settings->breakfast_friday_price;
            $breakfast_saturday = $settings->breakfast_saturday_price;
            $lunch_saturday = $settings->lunch_saturday_price;
            $dinner_saturday = $settings->dinner_saturday_price;
            $breakfast_sunday = $settings->breakfast_sunday_price;
            $start_at = $settings->start_at;
            $end_at = $settings->end_at;
            $latest_participation_date = $settings->latest_participation_date;
            $participant_opening_date = $settings->participation_opening_date;
            
            $is_configured = true;

            if( 
                $breakfast_friday == 0  || 
                $breakfast_saturday == 0  || 
                $lunch_saturday == 0 || 
                $dinner_saturday == 0 ||
                $breakfast_sunday == 0 ||
                $start_at == 0 ||
                $end_at == 0 ||
                $latest_participation_date == 0 ||
                $participant_opening_date == 0 
            ) {
                $is_configured = false;
            }

            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/lan/details.php";
        }
    }
}


?>
<?php 
namespace DxlEvents\Classes\Controllers;

use Dxl\Classes\Abstracts\AbstractActionController;
use DxlEvents\Classes\Repositories\TournamentRepository as Tournament;
use DxlEvents\Classes\Repositories\TournamentSettingRepository as TournamentSetting;
use DxlEvents\Classes\Repositories\ParticipantRepository as Participant;
use DxlEvents\Classes\Repositories\LanRepository as Lan;
use DxlEvents\Classes\Repositories\GameRepository as Game;
use DxlEvents\Classes\Repositories\GameModeRepository;
use DxlEvents\Classes\Services\EventService;

use DxlEvents\Classes\Actions\TournamentPublishAction;
use DxlEvents\Classes\Actions\TournamentUnpublishAction;
use DxlEvents\Classes\Actions\TournamentAttachGame;

use DxlEvents\Classes\Factories\TournamentActionFactory;
use DXL\Classes\Core;

if( ! class_exists('TournamentController') ) 
{
    class TournamentController extends AbstractActionController
    {
        /**
         * DXL Core
         *
         * @var \Dxl\Classes\Core
         */
        public $dxl;

        /**
         * Tournament repository
         *
         * @var DxlEvents\Classes\Repositories\TournamentRepository
         */
        public $tournament;

        /**
         * Tournament Settings repository
         *
         * @var DxlEvents\Classes\Repositories\TournamentSettingRepository
         */
        public $tournamentSetting;

        /**
         * Participant Repository
         *
         * @var \DxlEvents\Classes\Repositories\ParticipantRepository
         */
        public $participant;

        /**
         * Lan Repository
         *
         * @var \DxlEvents\Classes\Repositories\LanRepository
         */
        public $lan;

        /**
         * Game Repository
         *
         * @var \DxlEvents\Classes\Repositories\GameRepository
         */
        public $gameRepository;

        /**
         * Game Mode Repository
         *
         * @var \DxlEvents\Classes\Repositories\GameModeRepository
         */
        public $gameModeRepository;

        /**
         * Event Service
         *
         * @var \DxlEvents\Classes\Services\EventService
         */
        public $eventService;

        /**
         * Tournament action constructor
         */
        public function __construct() 
        {
            parent::__construct();
            $this->tournament = new Tournament();
            $this->tournamentSetting = new TournamentSetting();
            $this->participant = new Participant();
            $this->lan = new Lan();
            $this->gameRepository = new Game();
            $this->dxl = new Core;
            $this->eventService = new EventService();
            $this->gameModeRepository = new GameModeRepository();
            $this->registerAdminActions();
            $this->registerGuestActions();
        }

        /**
         * tournament admin action
         *
         * @return void
         */
        public function registerAdminActions(): void
        {
            add_action("wp_ajax_dxl_admin_tournament_fetch_participants", [$this, 'ajaxFetchTournamentParticipants']);
            add_action("wp_ajax_dxl_admin_tournament_remove_participants", [$this, 'ajaxRemoveParticipantFromEvent']);
            add_action("wp_ajax_dxl_admin_tournament_delete", [$this, 'ajaxDeleteTournament']);
            add_action("wp_ajax_dxl_admin_tournament_create", [$this, 'ajaxCreateTournament']);
            add_action("wp_ajax_dxl_admin_tournament_update", [$this, 'ajaxUpdateTournament']);
            add_action("wp_ajax_dxl_admin_fetch_game_modes", [$this, 'ajaxFetchGameModes']);
        }

        /**
         * register non admin tournament actions 
         *
         * @return void
         */
        public function registerGuestActions(): void
        {

        }
        

        /**
         * manage tournemnt views
         *
         * @return void
         */
        public function manage()
        {
            if( isset($_GET["action"]) ) {
                if( $_GET["action"] == "list" ) return $this->list();
                if( $_GET["action"] == "details" ) return $this->details();
            } else {
                return $this->list();
            }
        }

        /**
         * get latest 5 tournaments
         *
         * @return void
         */
        public function getEvents()
        {
            return $this->tournament->select()->limit(5)->get();
        }

        /**
         * render list view
         *
         * @return void
         */
        public function list(): void
        {
            $tournaments = $this->tournament->select()->where('has_lan', 1)->whereAnd('is_held', 0)->get();
            $onlineTournaments = $this->tournament->select()->where('has_lan', 0)->whereAnd('is_held', 0)->get();
            $heldTournaments = $this->tournament
                ->select()
                ->where('is_held', 1)
                ->get();
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/tournaments/list.php";
        }

        /**
         * render details view for tournaments
         *
         * @return void
         */
        public function details(): void
        {
            $tournament = $this->tournament->find((int) $this->getUrikey('id'));
            $settings = $this->tournamentSetting->find($tournament->id);
            $lan = $this->lan->select(['id', 'title'])->get();
            $games = $this->gameRepository->all();
            $attachedGame = $this->gameRepository->find($settings->game_id);
            $attachedGameMode = $this->gameModeRepository->find($settings->game_mode);
            $attachedLanEvent = $this->lan->find($tournament->lan_id);
            $type = ($tournament->type == 2) ? "Online Turnering" : "LAN Turnering";
            $participants = $this->participant->findByEvent($tournament->id);
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/tournaments/details.php";
        }

        /**
         * fetch game modes to attach to the tournament
         *
         * @return void
         */
        public function ajaxFetchGameModes(): void
        {
            $this->dxl->response('event', [
                'data' => $this->gameRepository->gameModes((int) $_REQUEST["event"]["game"]["id"])
            ]);
            wp_die();
        }

        /**
         * Create a new tournemnt event
         *
         * @return void
         */
        public function ajaxCreateTournament(): void
        {
            global $current_user;

            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering action: " . __METHOD__, 'events');

            $type = (int) $_REQUEST["event"]["type"];

            $created = $this->tournament->create([
                "is_draft" => 1,
                "type" => $type,
                "title" => $_REQUEST["event"]["title"],
                "slug" => str_replace(" ", "-", $_REQUEST["event"]["title"]),
                "description" => "",
                "start" => strtotime($_REQUEST["event"]["startdate"]),
                "end" => strtotime($_REQUEST["event"]["enddate"]),
                "starttime" => strtotime($_REQUEST["event"]["starttime"]),
                "endtime" => strtotime($_REQUEST["event"]["endtime"]),
                "participants_count" => 0,
                "author" => $current_user->ID,
                "has_lan" => ($type == 3) ? 1 : 0,
                "lan_id" => 0,
                "is_team_tournament" => $_REQUEST["event"]["is_team_tournament"],
                "created_at" => time(),
                "updated_at" => 0
            ]);

            if( $created < 1 ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke oprette turnering prøv igen",
                    "data" => $_REQUEST["event"]
                ]);
                $logger->log("Failed to create tournament: " . $_REQUEST["event"]["title"] . " " . __METHOD__, 'events');
                wp_die("Failed to create tournament: " . $_REQUEST["event"]["title"] . "", 500);
            }

            $this->tournamentSetting->create([
                "event_id" => $created,
                "event_mode" => $type,
                "game_id" => 0,
                "game_mode" => 0,
                "membership_is_required" => 1,
                "min_participants_count" => $_REQUEST["event"]["min_participants"],
                "max_participants_count" => $_REQUEST["event"]["max_participants"],
                "start_at" => strtotime($_REQUEST["event"]["startdate"]),
                "end_at" => strtotime($_REQUEST["event"]["enddate"])
            ]);

            $this->dxl->response('event', [
                "response" => "Turnering er oprettet",
                "data" => ["id" => $created]
            ]);
            $logger->log("Created new tournament: " . $_REQUEST["event"]["title"] . __METHOD__, 'events');
            wp_die();
        }

        /**
         * Fetching all tournament specific participants 
         *
         * @return void
         */
        public function ajaxFetchTournamentParticipants(): void
        {
            $validated = $this->validateRequest($_REQUEST["event"]);
            echo json_encode(["event" => ["data" => $validated, "participants" => []]]); wp_die();
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering event: " . __METHOD__, 'events');
            $verified = $this->verify_nonce();
            if( ! $verified ) {
                $this->dxl->forbiddenRequest('events');
                $logger->log("Unauthorized request caught, invalid nonce " . __METHOD__, 'events');
                wp_die();
            }

            $tournament_id = (int) $_REQUEST["event"]["tournament"];
            $participants = $this->participant->findByEvent($tournament_id);
            
            $this->dxl->response('event', [
                "response" => "Vi fandt " . count($participants) . " på dette event",
                "participants" => $participants,
                "data" => $tournament_id
            ]);
            wp_die();
        }

        /**
         * remove participant from event
         *
         * @return void
         */
        public function ajaxRemoveParticipantFromEvent()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering event: " . __METHOD__, 'events');

            $event = (int) $_REQUEST["event"]["tournament"];
            $participant = (int) $_REQUEST["event"]["participant"];
            $this->participant->removeFromEvent($participant, $event);

            $this->dxl->response('event', ["response" => "Deltager er fjernet fra turneringen"]);
            wp_die();
        }

        /**
         * delete tournament participant
         *
         * @return void
         */
        public function ajaxDeleteTournament()
        {
            
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering event: " . __METHOD__, 'events');

            $tournament = $this->tournament->find($_REQUEST['event']['tournament']);

            if( $tournament && $tournament->has_lan && $tournament->lan_id != 0 ) {
                $lan = $this->lan->find($tournament->lan_id);
                $tournaments_count = $lan->tournaments_count;
                $this->lan->update(["tournaments_count" => $tournaments_count - 1], $lan->id);
            }

            // fetch all participants
            $participants = $this->participant->select()->where('event_id', $_REQUEST["event"]["tournament"])->get();
            if( $participants > 0 )
            {
                $this->eventService->removeAttachedParticipants((int) $_REQUEST["event"]["tournament"], $participants);
            }

            $this->tournament->delete((int) $_REQUEST["event"]["tournament"]);
            $this->dxl->response('event', ["response" => "begivenheden er fjernet"]);
            wp_die();
        }

        /**
         * Update existing tournament ressource can be used for multiple editing actions
         *
         * @return void
         */
        public function ajaxUpdateTournament()
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering event: " . __METHOD__, 'events');
            if ( ! isset($_REQUEST["event"]["action"]) ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke opdatere turnering prøv igen",
                    "data" => $_REQUEST["event"]
                ]);
                $logger->log("Could not find update event");
                wp_die('Could not read your event action to trigger', 404);
            }
            
            $tournament = (isset($_REQUEST["event"]["id"])) ? (int) $_REQUEST["event"]["id"] : false;
            
            if( ! $tournament ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "kunne ikke finde dit turnering ID din forespørgsel",
                    "data" => $_REQUEST['event']
                ]);
                $logger->log("Could not find event Identifier " . __METHOD__, 'events');
                wp_die('', 404);
            }
            
            $logger->log("Triggering update event: " . $_REQUEST['event']["action"] . " on action " . __METHOD__, 'events');
            
            $factory = new TournamentActionFactory();
            $result = $factory->get($_REQUEST["event"]["action"])->call();

            echo $this->dxl->response('event', $result);
            wp_die();
        }
    }
}

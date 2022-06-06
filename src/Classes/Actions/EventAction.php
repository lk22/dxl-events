<?php 

namespace DxlEvents\Classes\Actions;

use Dxl\Classes\Abstracts\AbstractAction as Action;
use Dxl\Classes\Core;
use DxlEvents\Classes\Repositories\GameRepository;
use DxlEvents\Classes\Repositories\GameModeRepository;
use DxlEvents\Classes\Repositories\TournamentSettingRepository;
use DxlEvents\Classes\Repositories\TournamentRepository;
use DxlEvents\Classes\Repositories\LanRepository;
use DxlEvents\Classes\Repositories\TrainingRepository;
use DxlEvents\Classes\Repositories\ParticipantRepository;
use DxlEvents\Classes\Repositories\LanParticipantRepository;
use DxlMembership\Classes\Repositories\MemberRepository;

if( !class_exists('EventAction')) 
{
    class EventAction extends Action 
    {
        /**
         * Dxl core object
         *
         * @var \Dxl\Classes\Core
         */
        public $dxl;

        /**
         * Game Repository
         *
         * @var \DxlEvents\Classes\Repositories\GameRepository
         */
        public $gameRepository;
        
        /**
         * Tournaments repository
         *
         * @var \DxlEvents\Classes\Repositories\TournamentRepository
         */
        public $tournamentRepository;

        /**
         * Tournament settings
         *
         * @var \DxlEvents\Classes\Repositories\TournamentSettingRepository
         */
        public $tournamentSettingsRepository;

        /**
         * Tournament settings
         *
         * @var \DxlEvents\Classes\Repositories\ParticipantRepository
         */
        public $participantRepository;

        /**
         * LAN events repository
         *
         * @var \DxlEvents\Classes\Repositories\LanRepository;
         */
        public $lanRepository;

        /**
         * Undocumented variable
         *
         * @var DxlEvents\Classes\Repositories\LanParticipantRepository
         */
        public $lanParticipantRepository;

        /**
         * Training events repository
         *
         * @var \DxlEvents\Classes\Repositories\TrainingRepository;
         */
        public $trainingRepository;

        /**
         * Gamer Mode Repository
         *
         * @var DxlEvents\Classes\Repositories\GameModeRepository
         */
        public $gameModeRepository;

        /**
         * Member repository
         *
         * @var DxlMembership\Classes\Repositories\MemberRepository
         */
        public $memberRepository;

        /**
         * Game action constructor
         */
        public function __construct()
        {
            $this->dxl = new Core();
            $this->gameRepository = new GameRepository();
            $this->tournamentSettingsRepository = new TournamentSettingRepository();
            $this->tournamentRepository = new TournamentRepository();
            $this->lanRepository = new LanRepository();
            $this->trainingRepository = new TrainingRepository();
            $this->participantRepository = new ParticipantRepository();
            $this->gameModeRepository = new GameModeRepository();
            $this->memberRepository = new MemberRepository();
            $this->lanParticipantRepository = new LanParticipantRepository();
            $this->registerAdminActions();
            $this->registerGuestActions();
        }

        /**
         * registering admin actions
         *
         * @return void
         */
        public function registerAdminActions(): void
        {
            add_action("wp_ajax_dxl_event_game_create", [$this, 'ajaxCreateGame']);
            add_action("wp_ajax_dxl_event_game_update", [$this, 'ajaxUpdateGame']);
            add_action("wp_ajax_dxl_event_gamemode_delete", [$this, 'ajaxDeleteGameMode']);
            add_action("wp_ajax_dxl_event_game_delete", [$this, 'ajaxDeleteGame']);
            add_action("wp_ajax_dxl_event_game_type_create", [$this, 'ajaxCreateGameType']);
            add_action("wp_ajax_dxl_event_game_type_delete", [$this, 'ajaxDeleteGameType']);
        }

        /**
         * register guest actions
         *
         * @return void
         */
        public function registerGuestActions(): void
        {

        }

        public function manage() {}

        /**
         * manage frontend event views determing the 
         * @todo: 1: render list of events for list page
         * @todo: 2: render details page for single event
         * @todo: 3: add participate view for LAN events
         * @return void
         */
        public function manageFrontendEventViews() 
        {
            $type = $this->getUriKey('type');
            $event = $this->getUriKey('event');
            $action = $this->getUriKey('action');
            
            switch($action) 
            {
                case "list": 
                    $this->renderEventsList($type, $event);
                    break;

                case "details": 
                    $this->renderEventDetails($type, $event);
                    break;

                case "participate": 
                    $this->renderEventParticipate($event);
                    break;

                default:
                    $this->renderEventsList();
                break;
            }
        }

        /**
         * render complete list of events
         *
         * @return void
         */
        public function renderEventsList()
        {
            $events = [];
            $lan = $this->lanRepository->all();
            $tournaments = $this->tournamentRepository->all();
            $training = $this->trainingRepository->all();
            // var_dump($tournaments);
            
            if( $lan > 0 ) {
                foreach($lan as $l => $event) {
                    $settings = $this->lanRepository->settings()->find($event->id);
                    $events["lan"][$l] = [
                        "title" => $event->title,
                        "startdate" => $event->start,
                        "enddate" => $event->end,
                        "starttime" => $settings->start_at,
                        "endtime" => $settings->end_at,
                        "tournaments_count" => $event->tournaments_count,
                        "participants_count" => $event->participants_count,
                        "available_seats" => $event->seats_available,
                        "latest_participation_date" => $settings->latest_participation_date,
                        "link" => "?action=details&type=lan&event=" . $event->id,
                        "type" => "LAN"
                    ];
                }
            }

            if( $tournaments > 0 ) {
                foreach($tournaments as $t => $event) {
                    $author = get_userdata($event->author);
                    $events["tournaments"][$t] = [
                        "title" => $event->title,
                        "startdate" => date("d", $event->start),
                        "enddate" => date("d", $event->end),
                        "starttime" => date("H:i", $event->starttime),
                        "endtime" => date("H:i", $event->endtime),
                        "author" => $author,
                        "participants_count" => $event->participants_count,
                        "link" => "?action=details&type=tournament&event=" . $event->id,
                        "type" => "Turnering"
                    ];
                }
            }

            // fill in training events if they exists
            if( $training > 0 ) {
                foreach($training as $t => $event) {
                    $participants_count = $this->participantRepository->findByEvent($event->id);
                    $events["training"][$t] = [
                        "title" => $event->name,
                        "startdate" => date("d F Y", $event->start_date),
                        "event_day" => $event->event_day,
                        "is_recurring" => $event->is_recurring,
                        "participants_count" => count($participants_count),
                        "link" => "?action=details&type=training&event=" . $event->id,
                        "type" => "Træning"
                    ];
                }
            }

            require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/list.php";
        }

        /**
         * Get event details from a specified event type and event
         *
         * @param [type] $type
         * @param [type] $event
         * @return void
         */
        public function renderEventDetails($type, $identifier) 
        {
            global $current_user;
            
            if( $current_user->ID !== 0 ) {
                $member = $this->memberRepository->select(["id", "email", "gamertag"])->where('user_id', $current_user->ID)->getRow();
            } else {
                $member = false;
            }

            switch($type) {
                case "lan":
                    $event = $this->lanRepository->find($identifier);
                    // var_dump($event);
                    $settings = $this->lanRepository->settings()->find($event->id);
                    $participants = $this->lanRepository->getParticipants($event->id);
                    $tournaments = $this->tournamentRepository
                        ->select()
                        ->where('has_lan', 1)
                        ->whereAnd('lan_id', $event->id)
                        ->get();
                    
                    $participated = ($member) 
                        ? $this->lanParticipantRepository->findByEvent($event->id)
                        : false;

                        require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/lan/details.php";
                    break;

                case "tournament":
                    $event = $this->tournamentRepository->find($identifier);
                    $settings = $this->tournamentSettingsRepository->find($event->id);
                    $participants = $this->participantRepository->findByEvent($event->id);
                    require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/details.php";
                    break;

                case "training": 
                    $event = $this->trainingRepository->find($identifier);
                    $participants = $this->participantRepository->findByEvent($event->id);
                    $game = $this->gameRepository->find($event->game_id);
                    $author = $this->memberRepository->select(["gamertag"])->where('user_id', $event->author)->getRow();
                    $gameMode = ($game) ? $this->gameModeRepository->find($game->id) : false;
                    $participated = ($member) ? $this->participantRepository->select()->where('member_id', $member->id)->whereAnd('event_id', $event->id)->getRow() : false;
                    require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/details.php";
                    break;
                    
            }

            // require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/details.php";
        }

        /**
         * Rendering participate view
         *
         * @param [type] $event
         * @return void
         */
        public function renderEventParticipate($event)
        {
            global $current_user;

            $details = $this->lanRepository->select(["title", "seats_available", "extra_description"])->getRow();

            $member = $this->memberRepository
                ->select()
                ->where('user_id', $current_user->ID)
                ->getRow();

            $members = $this->memberRepository->all();

            $tournaments = $this->tournamentRepository
                ->select()
                ->where('has_lan', 1)
                ->whereAnd('lan_id', $event)
                ->get();

            require_once ABSPATH . "wp-content/plugins/dxl-events/src/frontend/views/lan/participate.php";
        }
    }
}

?>
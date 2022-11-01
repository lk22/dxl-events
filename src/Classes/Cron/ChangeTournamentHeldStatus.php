<?php 
namespace DxlEvents\Classes\Cron;

use DxlEvents\Classes\Repositories\TournamentRepository;
use DxlEvents\Classes\Repositories\LanRepository;

use DxlEvents\Classes\Mails\CronTournamentsHeldStatusChanged;

use DXL\Classes\Core;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('ChangeTournamentHeldStatus') )
{
    class ChangeTournamentHeldStatus
    {
        /**
         * Tournament repository
         *
         * @var DxlEvents\Classes\Repositories\TournamentRepository
         */
        public $tournamentRepository;

        /**
         * Logger utiltiy
         *
         * @var [type]
         */
        public $logger;

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->tournamentRepository = new TournamentRepository();
            $this->lanRepository = new LanRepository();
            $this->logger = (new Core())->getUtility('Logger');
            
            if ( isset($_GET["action"]) && $_GET["action"] == "dxl_events_change_tournament_held_status" ) {
                $this->changeTournamentHeldStatus();
            }
        }

        /**
         * Change tournament held status
         */
        public function changeTournamentHeldStatus()
        {
            $this->logger->logCronReport("Changing tournament held status, hold on...");
            $today = strtotime(date("Y-m-d"));
            $lanEvents = $this->lanRepository->all();

            $eventsData = [];
            // for each lan event that is held from end date of the event
            if ( count($lanEvents) > 0) {
                foreach ( $lanEvents as $e => $event ) {
                    $eventData[$e] = [
                        "id" => $event->id,
                        "name" => $event->title,
                        "end_date" => strtotime($event->end),
                    ];
                    $tournaments = $this->tournamentRepository
                        ->select()
                        ->where('lan_id', $event->id)
                        ->get();
                    // if there are tournaments and todays date are greater than the end date of the event, change the status of the tournaments to held
                    if ( count($tournaments) && $today > strtotime($event->end) ) {
                        foreach ( $tournaments as $tournament ) {
                            if ( $tournament->is_held == 0 ) {
                                $this->logger->logCronReport("Held status changed for tournament with name: " . $tournament->title);
                                $this->tournamentRepository->update([
                                    "is_held" => 1
                                ], $tournament->id);
                                $eventData[$e]["tournaments"][] = $tournament->title;
                            }
                        }
                    }
                }
            } else {
                $this->logger->logCronReport("Found no events to update");
            }

            $mail = (new CronTournamentsHeldStatusChanged($eventData))
                ->setSubject("Cron job: Tournaments held status changed")
                ->setReciever("knudsenudvikling@gmail.com")
                ->send();

            if ( ! $tournaments ) {
                return;
            }

            return true;
        }
    }
}

?>
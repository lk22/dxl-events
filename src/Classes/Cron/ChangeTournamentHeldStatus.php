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
            
            if ( $_GET["action"] == "dxl_events_change_tournament_held_status" ) {
                $this->changeTournamentHeldStatus();
            }
        }

        /**
         * Change tournament held status
         */
        public function changeTournamentHeldStatus()
        {
            $this->logger->log("Changing tournament held status, hold on...");
            $today = strtotime(date("Y-m-d"));
            $lanEvents = $this->lanRepository->all();

            $eventsData = [];
            // for each lan event that is held from end date of the event
            foreach ( $lanEvents as $e => $events ) {
                $eventsData[$e] = [
                    "id" => $events->id,
                    "name" => $events->name,
                    "end_date" => strtotime($events->end_date),
                ];
                $tournaments = $this->tournamentRepository
                    ->select()
                    ->where('lan_id', $events->id)
                    ->get();

                // if there are tournaments and todays date are greater than the end date of the event, change the status of the tournaments to held
                if ( count($tournaments) && $today > strtotime($events->end_date) ) {
                    foreach ( $tournaments as $tournament ) {
                        if ( $tournament->is_held == 0 ) {
                            $this->logger->log("Held status changed for tournament with name: " . $tournament->title);
                            $this->tournamentRepository->update([
                                "is_held" => 1
                            ], $tournament->id);
                            $eventsData[$e]["tournaments"][] = $tournament->title;
                        }
                    }
                }
            }

            $mail = (new CronTournamentsHeldStatusChanged($eventsData))
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
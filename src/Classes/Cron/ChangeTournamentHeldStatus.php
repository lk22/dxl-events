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
        }

        /**
         * Change tournament held status
         */
        public function call()
        {
            $today = strtotime(date("Y-m-d"));
            $lanEvents = $this->lanRepository->all();

            $eventsData = [];

            if ( count($lanEvents) < 1) {
                $this->logger->logCronReport("No LAN events found.");
                return;
            }

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
    
            $mail = (new CronTournamentsHeldStatusChanged($eventData))
                ->setSubject("Cron job: Tournaments held status changed")
                ->setReciever("knudsenudvikling@gmail.com")
                ->send();

            return true;
        }
    }
}

?>
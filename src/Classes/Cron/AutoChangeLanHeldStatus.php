<?php 
namespace DxlEvents\Classes\Cron;

use DxlEvents\Classes\Repositories\LanRepository;
// use DxlEvents\Classes\Mails\CronTournamentsHeldStatusChanged;

use DXL\Classes\Core;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('AutoChangeLanHeldStatus') )
{
    class AutoChangeLanHeldStatus
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
            $this->logger->logCronReport("Changing LAN event held status, hold on...");
            $today = strtotime(date("Y-m-d"));
            $lanEvents = $this->lanRepository->select(['id', 'end'])->get();

            $eventsData = [];
            // for each lan event that is held from end date of the event
            if ( count($lanEvents) > 0) {
                foreach ( $lanEvents as $event) {
                    if ( $today > $event->end ) {
                        $this->lanRepository->update([
                            "is_held" => 1
                        ], $event->id);
                    }
                }
             } else {
                $this->logger->logCronReport("Found no events to update");
            }

            // $mail = (new CronTournamentsHeldStatusChanged($eventData))
            //     ->setSubject("Cron job: Tournaments held status changed")
            //     ->setReciever("knudsenudvikling@gmail.com")
            //     ->send();

            if ( ! $lanEvents ) {
                $this->logger->logCronReport("Could not find any events to update");
                return;
            }

            return true;
        }
    }
}

?>
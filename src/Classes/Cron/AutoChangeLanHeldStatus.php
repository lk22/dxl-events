<?php 
namespace DxlEvents\Classes\Cron;

use DxlEvents\Classes\Repositories\LanRepository;
use DxlEvents\Classes\Mails\CronLanEventHeldStatusChanged;

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
            $this->lanRepository = new LanRepository();
            $this->logger = (new Core())->getUtility('Logger');
        }

        /**
         * Change tournament held status
         */
        public function call()
        {
            $today = strtotime(date("Y-m-d"));
            $lanEvents = $this->lanRepository
                ->select(['id', 'title', 'end'])
                ->where('is_held', 0)
                ->get();

            $eventsData = [];

            // for each lan event that is held from end date of the event
            if ( count($lanEvents) > 0) {
                $count = count($lanEvents);
                foreach ( $lanEvents as $event) {
                    if ( $today > $event->end ) {
                        $this->logger->logCronReport("Changing LAN event {$event->title} held status");
                        $this->lanRepository->update([
                            "is_held" => 1
                        ], $event->id);
                    }
                }
                $mail = (new CronLanEventHeldStatusChanged($eventsData))->setReciever("knudsenudvikling@gmail.com")->send();
             } else {
                $this->logger->logCronReport("Found no events to update");
                return false;
            }
            
            return true;
        }
    }
}

?>
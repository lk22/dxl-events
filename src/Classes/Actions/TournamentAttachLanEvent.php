<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Interfaces\ActionInterface;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use DxlEvents\Classes\Repositories\LanRepository;

    if ( !defined("ABSPATH") ) die("Access denied");

    if ( ! class_exists("TournamentAttachLanEvent") ) 
    {
        class TournamentAttachLanEvent implements ActionInterface 
        {
            /**
             * Tournament Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentRepository
             */
            public $tournamentRepository;

            /**
             * Lan Repository
             *
             * @var DxlEvents\Classes\Repositories\LanRepository
             */
            public $lanRepository;

            /**
             * Tournament bulk update description class constructor
             */
            public function __construct()
            {
                $this->tournamentRepository = new TournamentRepository();
                $this->lanRepository = new LanRepository();
            }

            /**
             * Trigger action ( updating description for a tournament )
             *
             * @return void
             */
            public function call() 
            {
                $logger = Logger::getInstance();;
                $attached = $this->tournamentRepository->update([
                    "lan_id" => $_REQUEST["event"]["lan"]
                ], $_REQUEST["event"]["id"]);

                $lanEvent = $this->lanRepository->find($_REQUEST["event"]["lan"]);

                if ( ! $attached ) {
                    return [
                        "response" => "Der opstod en fejl, kunne ikke tilføje LAN",
                        "data" => $_REQUEST
                    ];
                    $logger->log(__METHOD__ . " Failed to perform event: " . $_REQUEST["event"]["action"]);
                    wp_die();
                }

                $this->lanRepository->update([
                    "tournaments_count" => $lanEvent->tournaments_count + 1
                ], $_REQUEST["event"]["lan"]);

                return [
                    "response" => "Event er tilknyttet"
                ];
                wp_die();
            }
        }
    }
?>
<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Interfaces\ActionInterface;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use DxlEvents\Classes\Repositories\LanRepository;

    if ( !defind("ABSPATH") ) die("Access denied");

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
            }

            /**
             * Trigger action ( updating description for a tournament )
             *
             * @return void
             */
            public function trigger() 
            {
                $attached = $this->tournamentRepository->update([
                    "lan_id" => $_REQUEST["event"]["lan_id"]
                ], $_REQUEST["event"]["id"]);

                if ( ! $attached ) {
                    echo wp_send_json_error([
                        "response" => "Der opstod en fejl, kunne ikke tilføje LAN",
                        "data" => $_REQUEST
                    ]);
                    Logger::getInstsance()->log("Failed to perform event: " . $_REQUEST["event"]["action"]);
                    wp_die();
                }

                echo wp_send_json_success([
                    "response" => "Event er tilknyttet"
                ]);
                wp_die();
            }
        }
    }
?>
<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Interfaces\ActionInterface;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\TournamentRepository;

    if ( !defind("ABSPATH") ) die("Access denied");

    if ( ! class_exists("TournamentBulkUpdateDescription") ) 
    {
        class TournamentBulkUpdateDescription implements ActionInterface 
        {
            /**
             * Tournament Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentRepository
             */
            public $tournamentRepository;

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
            public function call() 
            {
                $updated = $this->tournamentRepository->update([
                    "description" => $_REQUEST["event"]["description"]
                ], $_REQUEST["event"]["id"]);

                if ( ! $updated ) {
                    Logger::getInstsance()->log("Failed to perform event: " . $_REQUEST["event"]["action"]);
                    return [
                        "response" => "Der opstod en fejl, kunne ikke opdatere beskrivelse",
                        "data" => $_REQUEST
                    ];
                }

                return [
                    "response" => "Beskrivelsen er opdateret"
                ];
            }
        }
    }
?>
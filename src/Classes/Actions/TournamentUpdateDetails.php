<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentUpdateDetails') ) 
    {
        class TournamentUpdateDetails implements ActionInterface
        {
            /**
             * Tournament Setting Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentRepository
             */
            public $tournamentRepository;

            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->tournamentRepository = new TournamentRepository();
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                $game = $_REQUEST["event"]["game"];
                $event = (int) $_REQUEST["event"]["id"];
                $details = $_REQUEST["event"];

                $updated = $this->tournamentRepository->update([
                  "title" => $details["title"],
                  "start" => strtotime($details["startdate"]),
                  "end" => strtotime($details["enddate"]),
                  "starttime" => strtotime($details["starttime"]),
                  "endtime" => strtotime($details["endtime"]),
                ], $_REQUEST["event"]["id"]);

                if ( ! $updated ) {
                    return wp_send_json_error([
                        "message" => "Noget gik galt, kunne ikke opdatere turneringen",
                        "data" => $_REQUEST["event"]
                    ]);
                    $logger->log(__METHOD__ . " Failed to attach game to event"); 
                }

                return wp_send_json_success([
                    "message" => "Turnering er opdateret",
                ]);
            }
        }
    }

?>
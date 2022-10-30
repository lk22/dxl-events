<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentSetHeldStatus') ) 
    {
        class TournamentSetHeldStatus implements ActionInterface
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
                $this->tournamentRepository();
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                $game = $_REQUEST["event"]["game"];
                $event = (int) $_REQUEST["event"]["id"];

                $attached = $this->tournamentRepository->update([
                    "game_mode" => isset($game["mode"]) ? (int) $game["mode"] : 0,
                    "game_id" => (int) $game["id"]
                ], $event);

                if ( ! $attached ) {
                    $logger->log("Failed to attach game to event"); 
                    return wp_send_json_error([
                        "message" => "Failed to attach game to event",
                        "data" => $_REQUEST["event"]
                    ]);
                }

                return wp_send_json_success([
                    "message" => "Game successfully attached",
                ]);
            }
        }
    }

?>
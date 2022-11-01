<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use Dxl\Classes\Utilities\Logger;
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
                $this->tournamentRepository = new TournamentRepository();
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                $event = (int) $_REQUEST["event"]["id"];

                $statusChanged = $this->tournamentRepository->update([
                    "is_held" => 1
                ], $event);

                if ( ! $statusChanged ) {
                    $logger->log(__METHOD__ . "Failed to change held status on event"); 
                    return wp_send_json_error([
                        "message" => "Failed to change held status",
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
<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentPublishAction') ) 
    {
        class TournamentPublishAction implements ActionInterface
        {
            /**
             * Tournament Repository
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
            public function trigger(): void
            {
                $published = $this->tournamentRepository->update([
                    "is_draft" => 0
                ], $_REQUEST["event"]["id"]);

                if ( ! $published ) {
                    wp_send_json_error([
                        "message" => "Failed to publish event",
                        "data" => $_REQUEST["event"]
                    ]);
                    Logger::getInstance()->log("Failed to publish event");
                    wp_die();
                }

                wp_send_json_success([
                    "message" => "Event published successfully",
                ]);
                wp_die();
            }
        }
    }

?>
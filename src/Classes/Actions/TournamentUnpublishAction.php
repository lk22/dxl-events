<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentUnpublishAction') ) 
    {
        class TournamentUnpublishAction implements ActionInterface
        {
            /**
             * Tournament Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentRepository
             */
            public $tournamentRepository;

            /**
             * Tournament Unpublish action constructor
             */
            public function __construct()
            {
                $this->tournamentRepository = new TournamentRepository();
            }

            /**
             * Trigger Unpublish action
             */
            public function trigger(): void
            {
                $unpublished = $this->tournamentRepository->update([
                    "is_draft" => 1
                ], $_REQUEST["event"]["id"]);

                if ( ! $unpublished ) {
                    wp_send_json_error([
                        "message" => "Failed to unpublish event",
                        "data" => $_REQUEST["event"]
                    ]);
                    Logger::getInstance()->log("Failed to unpublish event");
                    wp_die();
                }

                wp_send_json_success([
                    "message" => "Event unpublished successfully",
                ]);
                wp_die();
            }
        }
    }

?>
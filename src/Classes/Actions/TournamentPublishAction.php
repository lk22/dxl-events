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
            public function call()
            {
                $logger = Logger::getInstance();
                $published = $this->tournamentRepository->update([
                    "is_draft" => 0
                ], $_REQUEST["event"]["id"]);

                if ( ! $published ) {
                    $logger->log(__METHOD__ . " Failed to publish event");
                    return [
                        "message" => "Failed to publish event",
                        "data" => $_REQUEST["event"]
                    ];
                }

                return [
                    "message" => "Event published successfully",
                ];
            }
        }
    }

?>
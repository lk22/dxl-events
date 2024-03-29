<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\LanRepository;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('PublishEventTimeplan') ) 
    {
        class PublishEventTimeplan implements ActionInterface
        {
            /**
             * Tournament Setting Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentSettingRepository
             */
            public $lanRepository;

            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->lanRepository = new lanRepository();
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                $event = $this->lanRepository->find($_REQUEST["event"]);
                $timeplan = $this->lanRepository->timeplan()->select(["id"])->where("event_id", $event->id)->get();

                $published = $this->lanRepository->timeplan()->update([
                  "is_draft" => 0
                ], $timeplan[0]->id);

                $logger->log("timeplan for event " . $event->id . " - " . $event->slug . " " . ($published ? "published" : "failed"));

                return wp_send_json_success([
                    "message" => ( $published ) ? "Timeplan published successfully" : "failed",
                ]);
            }
        }
    }

?>
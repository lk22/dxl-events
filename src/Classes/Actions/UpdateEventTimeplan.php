<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\LanRepository;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('UpdateEventTimeplan') ) 
    {
        class UpdateEventTimeplan implements ActionInterface
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

                $new_json = json_encode($_REQUEST["timeplan"]);

                $updated = $this->lanRepository->timeplan()->update([
                  "content" => json_encode($_REQUEST["timeplan"])
                ], $timeplan[0]->id);

                return wp_send_json_success([
                    "message" => ( $updated ) ? "Timeplan updated successfully" : "failed",
                ]);
            }
        }
    }

?>
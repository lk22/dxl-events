<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\LanRepository;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('DeleteEventTimeplan') ) 
    {
        class DeleteEventTimeplan implements ActionInterface
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

                $this->lanRepository->update([
                  "has_timeplan" => 0
                ], $event->id);

                $deleted = $this->lanRepository->timeplan()->delete($timeplan[0]->id);

                return wp_send_json_success([
                    "message" => ( $deleted ) ? "Timeplan deleted successfully" : "failed",
                ]);
            }
        }
    }

?>
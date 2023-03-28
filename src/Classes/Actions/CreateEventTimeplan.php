<?php 
    namespace DxlEvents\Classes\Actions;

    use Dxl\Classes\Utilities\Logger;

    use DxlEvents\Classes\Repositories\LanRepository;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('CreateEventTimeplan') ) 
    {
        class CreateEventTimeplan implements ActionInterface
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
                
                $this->lanRepository->update([
                  "has_timeplan" => 1,
                ], $event->id);

                $created = $this->lanRepository->timeplan()->create([
                  "event_id" => $_REQUEST["event"],
                  "content" => json_encode($_REQUEST["timeplan"]),
                  "is_draft" => 1
                ]);

                if ( $created ) {
                  $logger->log("Timeplan created for event " . $event->title . " successfully");
                } else {
                  $logger->log("Timeplan created for event " . $event->title . " failed");
                }
                
                return wp_send_json_success([
                    "message" => ( $created ) ? "Timeplan created successfully" : "failed",
                ]);
            }
        }
    }

?>
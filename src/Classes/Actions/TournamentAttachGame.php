<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentSettingRepository as TournamentSetting;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentAttachGame') ) 
    {
        class TournamentAttachGame implements ActionInterface
        {

            private $result;

            /**
             * Tournament Setting Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentSettingRepository
             */
            public $tournamentSettingRepository;

            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->tournamentSettingRepository = new TournamentSetting();
            }

            /**
             * Trigger publish action
             */
            public function trigger(): void
            {
                $game = $_REQUEST["event"]["game"];
                $event = (int) $_REQUEST["event"]["id"];

                $attached = $this->tournamentSettingRepository->update([
                    "game_mode" => isset($game["mode"]) ? (int) $game["mode"] : 0,
                    "game_id" => (int) $game["id"]
                ], $event);

                if ( ! $attached ) {
                    $this->result = [
                        "message" => "Failed to attach game to event",
                        "data" => $_REQUEST["event"]
                    ];
                    
                    // wp_send_json_error([
                    //     "message" => "Failed to attach game to event",
                    //     "data" => $_REQUEST["event"]
                    // ]);
                    Logger::getInstance()->log("Failed to attach game to event");
                    return $this->result;
                    wp_die();
                }

                wp_send_json_success([
                    "message" => "Game successfully attached",
                ]);
                wp_die();
            }
        }
    }

?>
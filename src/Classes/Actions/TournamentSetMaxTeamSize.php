<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentRepository;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentSetMaxTeamSize') ) 
    {
        class TournamentSetMaxTeamSize implements ActionInterface
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
            public function trigger()
            {
                $updated = $this->tournamentRepository->update([
                    "max_team_size" => $_REQUEST["event"]["max_team_size"]
                ], $_REQUEST["event"]["id"]);

                echo json_encode($updated); wp_die();

                if ( ! $updated ) {
                    echo wp_send_json_error([
                        "message" => "Failed to set max team size",
                        "data" => $_REQUEST["event"]
                    ]);
                    Logger::getInstance()->log("Failed to set max team size on event");
                    wp_die();
                }

                return json_encode(["response" => "Event updated successfully"]);
 
                // echo wp_send_json_success([
                //     "message" => "Event updated successfully",
                // ]);
                // wp_die();
            }
        }
    }

?>
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
            public function call()
            {
                $updated = $this->tournamentRepository->update([
                    "max_team_size" => $_REQUEST["event"]["max_team_size"]
                ], $_REQUEST["event"]["id"]);

                if ( ! $updated ) {
                    Logger::getInstance()->log("Failed to set max team size on event");
                    return [
                        "message" => "Failed to update max team size",
                        "data" => $_REQUEST["event"]
                    ];
                }

                return [
                    "message" => "Max team size updated",
                    "data" => $_REQUEST["event"]
                ];
            }
        }
    }

?>
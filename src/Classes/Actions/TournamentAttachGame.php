<?php 
    namespace DxlEvents\Classes\Actions;

    use DxlEvents\Classes\Repositories\TournamentSettingRepository as TournamentSetting;
    use DxlEvents\Classes\Repositories\GameRepository;
    use DxlEvents\Classes\Repositories\GameModeRepository;
    use DxlEvents\Classes\Repositories\GameTypeRepository;
    use Dxl\Classes\Utilities\Logger;

    use Dxl\Interfaces\ActionInterface;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentAttachGame') ) 
    {
        class TournamentAttachGame implements ActionInterface
        {
            /**
             * Tournament Setting Repository
             *
             * @var DxlEvents\Classes\Repositories\TournamentSettingRepository
             */
            public $tournamentSettingRepository;

            /**
             * Game Repository
             *
             * @var DxlEvents\Classes\Repositories\GameRepository
             */
            public $gameRepository;

            /**
             * Game Mode Repository
             *
             * @var DxlEvents\Classes\Repositories\GameModeRepository
             */
            public $gameModeRepository;
            
            /**
             * Game Type Repository
             *
             * @var DxlEvents\Classes\Repositories\GameTypeRepository
             */
            public $gameTypeRepository;

            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->tournamentSettingRepository = new TournamentSetting();
                $this->gameRepository = new GameRepository();
                $this->gameModeRepository = new GameModeRepository();
                $this->gameTypeRepository = new GameTypeRepository();
            }

            /**
             * Trigger publish action
             */
            public function call(): void
            {
                $logger = Logger::getInstance();
                $game = $_REQUEST["event"]["game"];
                $event = (int) $_REQUEST["event"]["id"];

                // make sure the game type exists

                if ( false == $this->findExistingGame($game["name"]) ) {
                    $currentGameType = $this->findOrCreateGameType($game["type"]);

                    if ( false == $currentGameType ) {
                        return wp_send_json_error([
                            "message" => "Failed to create game type",
                            "data" => $_REQUEST["event"]
                        ]);
                        $logger->log(__METHOD__ . " - " . __CLASS__ . " Failed to create game type for " . $game["name"]); 
                    }

                    if ( false == $existingGameMode ) {
                        return wp_send_json_error([
                            "message" => "Failed to create game mode",
                            "data" => $_REQUEST["event"]
                        ]);
                    }

                    $created = $this->gameRepository->create([
                        "name" => $game["name"],
                        "game_type" => $currentGameType
                    ]);
                }

                $attached = $this->tournamentSettingRepository->update([
                    "game_mode" => $game["mode"],
                    "game_id" => (int) $game["id"]
                ], $event);

                if ( ! $attached ) {
                    return wp_send_json_error([
                        "message" => "Failed to attach game to event",
                        "data" => $_REQUEST["event"]
                    ]);
                    $logger->log(__METHOD__ . " Failed to attach game to event"); 
                }

                return wp_send_json_success([
                    "message" => "Game successfully attached",
                ]);
            }

            /**
             * make a check for existing game resource
             *
             * @param [type] $game
             * @return void
             */
            private function findExistingGame(string $game): bool {
                $existingGame = $this->gameRepository
                    ->select()
                    ->where("name", "'$game'")
                    ->get();

                return (count($existingGame)) ? true : false;
            }

            /**
             * Find or create a new Game mode
             *
             * @param [type] $mode
             * @param [type] $game
             * @return void
             */
            private function findOrCreateGameMode(string $mode, int|string $game): int|bool {
                $existingGameMode = $this->gameModeRepository
                    ->select()
                    ->where("name", "'$mode'")
                    ->getRow();

                if ( $existingGameMode > 0 ) {
                    return $existingGameMode->id;
                }

                $created = $this->gameModeRepository->create([
                    "name" => $mode
                ]);

                return ($created) ? $created->insert_id : false;
            }

            /**
             * Find or create new game type
             *
             * @param [type] $type
             * @return void
             */
            private function findOrCreateGameType(string $type): int|bool {
                $existingGameType = $this->gameTypeRepository
                    ->select()
                    ->where("name", "'$type'")
                    ->getRow();

                // if game type exists, return the game type identifier
                if ( $existingGameType > 0 ) {
                    return $existingGameType->id;
                }

                $created = $this->gameTypeRepository->create([
                    "name" => $type
                ]);

                return ($created) ? $created->insert_id : false;
            }
        }
    }

?>
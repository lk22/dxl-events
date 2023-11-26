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
            private $tournamentSettingRepository;

            /**
             * Game Repository
             *
             * @var DxlEvents\Classes\Repositories\GameRepository
             */
            private $gameRepository;
            
            /**
             * Game Mode Repository
             *
             * @var DxlEvents\Classes\Repositories\GameModeRepository
             */
            private $gameModeRepository;
            
            /**
             * Game Type Repository
             *
             * @var DxlEvents\Classes\Repositories\GameTypeRepository
             */
            private $gameTypeRepository;
            
            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->request = $this->get_request();
                $this->tournamentSettingRepository = new TournamentSetting();
                $this->gameRepository = new GameRepository();
                $this->gameModeRepository = new GameModeRepository();
                $this->gameTypeRepository = new GameTypeRepository();
            }

            /**
             * Get Request Data
             *
             * @return void
             */
            private function get_request()
            {
                return $_REQUEST;
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                try {
                    $game = $this->findOrCreateGame($this->request["event"]["game"]);
                    $this->attachGameToEvent($game, $this->request["event"]["id"]);

                    return wp_send_json_success(["message" => "Game successfully attached", "game" => $game]);
                } catch (\Exception $e) {
                    return wp_send_json_error(["message" => $e->getMessage()]);
                }
            }

            /**
             * Find or create a new game resource
             *
             * @param [type] $gameData
             * @return void
             */
            private function findOrCreateGame($gameData)
            {
                $gameName = $gameData["name"] ?? "";

                if ( isset($gameName) && isset($gameData["type"]) && ! $this->findExistingGame($gameName) ) {
                    $currentGameType = $this->findOrCreateGameType($gameData["type"]);

                    if ( $currentGameType === false ) throw new \Exception("Failed to create game type for " . $gameData["name"]);

                    $newGame = $this->gameRepository->create([
                        "name" => $gameData["name"],
                        "game_type" => $currentGameType,
                    ]);

                    if ( ! $newGame ) throw new \Exception("Something went wrong, Failed to create game " . $gameData["name"]);

                    $existingGameMode = $this->findOrCreateGameMode($gameData["mode"], $newGame->insert_id);
                    if ( ! $existingGameMode ) throw new \Exception("Failed to create game mode for " . $gameData["name"]);

                    return ["game" => $newGame->insert_id, "mode" => $existingGameMode];
                }

                $existingGame = $this->gameRepository->select()->where('id', $gameData["id"])->getRow();
                $existingGameMode = $this->gameModeRepository->select()->where('game_id', $existingGame->id)->getRow();

                return ["game" => $existingGame->id, "mode" => $existingGameMode->id];
                
            }

            /**
             * Attache game to tournament
             *
             * @param [type] $game
             * @param [type] $eventId
             * @return void
             */
            private function attachGameToEvent($game, $eventId)
            {
                $attached = $this->tournamentSettingRepository->update([
                    "game_mode" => (int) $game["mode"],
                    "game_id" => (int) $game["game"]
                ], $eventId);

                if ( ! $attached ) {
                    throw new \Exception("Failed to attach game to event");
                }
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
            private function findOrCreateGameMode(string $mode, string $game) {
                $existingGameMode = $this->gameModeRepository
                    ->select()
                    ->where("name", "'$mode'")
                    ->whereAnd("game_id", $game)
                    ->getRow();

                if ( $existingGameMode > 0 ) {
                    return $existingGameMode->id;
                }

                $created = $this->gameModeRepository->create([
                    "name" => $mode,
                    "game_id" => $game
                ]);

                return ($created) ? $created->insert_id : false;
            }

            /**
             * Find or create new game type
             *
             * @param [type] $type
             * @return void
             */
            private function findOrCreateGameType(string $type) {
                $existingGameType = $this->gameTypeRepository
                    ->select()
                    ->where("name", "'$type'")
                    ->getRow();

                // if game type exists, return the game type identifier
                if ( count($existingGameType) > 0 ) {
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
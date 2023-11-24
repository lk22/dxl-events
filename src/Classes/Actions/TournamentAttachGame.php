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
            protected $tournamentSettingRepository;

            /**
             * Game Repository
             *
             * @var DxlEvents\Classes\Repositories\GameRepository
             */
            protected $gameRepository;

            /**
             * Game Mode Repository
             *
             * @var DxlEvents\Classes\Repositories\GameModeRepository
             */
            protected $gameModeRepository;
            
            /**
             * Game Type Repository
             *
             * @var DxlEvents\Classes\Repositories\GameTypeRepository
             */
            protected $gameTypeRepository;

            /**
             * Tournament publish action constructor
             */
            public function __construct()
            {
                $this->request = $this->getRequestData();
                $this->tournamentSettingRepository = new TournamentSetting();
                $this->gameRepository = new GameRepository();
                $this->gameModeRepository = new GameModeRepository();
                $this->gameTypeRepository = new GameTypeRepository();
            }

            /**
             * Trigger publish action
             */
            public function call()
            {
                $logger = Logger::getInstance();
                try {
                    $game = $this->findOrCreateGame($this->request["event"]["game"]);
                    $attached = $this->attachGameToEvent($game, $this->request["event"]["id"]);
                    return $attached;
                    return wp_send_json_success(["message" => "Game successfully attached",]);
                } catch (\Exception $e) {
                    return wp_send_json_error(["message" => $e->getMessage()]);
                }
            }

            private function getRequestData()
            {
                return $_REQUEST;
            }

            private function findOrCreateGame($gameData) 
            {
                $gameName = $gameData["name"] ?? "";
                
                if ( isset($gameName) && false == $this->findExistingGame($gameName) ) {
                    return $gameData;
                    $currentGameType = $this->findOrCreateGameType($gameData["type"]);
                    $existingGameMode = $this->findOrCreateGameMode($gameData["mode"], $gameData["id"]);
                    if ( false == $currentGameType ) {
                        throw new \Exception("Failed to create game type for " . $gameData["name"]);
                    }

                    if ( false == $existingGameMode ) {
                        throw new \Exception("Failed to create game mode for " . $gameData["name"]);
                    }
                    return $this->gameRepository->create([
                        "name" => $gameData["name"],
                        "game_type" => $currentGameType
                    ]);
                }

                $existing = $this->gameRepository
                    ->select()
                    ->where("name", "'$gameName'")
                    ->getRow();
                return $existing;
            }

            private function attachGameToEvent($game, $eventId)
            {
                return [
                    "game" => $game];
                $attached = $this->tournamentSettingsRepository->update([
                    "game_mode" => $this->request->game["mode"],
                    "game_id" => (int) $game
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
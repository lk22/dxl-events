<?php 

namespace DxlEvents\Classes\Controllers;

use Dxl\Classes\Abstracts\AbstractActionController as Controller;
use Dxl\Classes\Core;

// Repositories
use DxlEvents\Classes\Repositories\GameRepository as Game;
use DxlEvents\Classes\Repositories\TournamentSettingRepository as TournamentSetting;

// Actions
use DxlEvents\Classes\Actions\Game\CreateGameAction;
use DxlEvents\Classes\Actions\Game\UpdateGame;

// services
use DxlEvents\Classes\Services\GameService;

if( !class_exists('GameController')) 
{
    class GameController extends Controller 
    {
        /**
         * Dxl core object
         *
         * @var \Dxl\Classes\Core
         */
        public $dxl;

        /**
         * Game Repository
         *
         * @var \DxlEvents\Classes\Repositories\GameRepository
         */
        public $gameRepository;

        /**
         * Tournament settings
         *
         * @var \DxlEvents\Classes\Repositories\TournamentSetting
         */
        public $tournamentSettings;

        /**
         * Game service
         *
         * @var \DxlEvents\Classses\Services\GameService;
         */
        public $gameService;

        /**
         * Game action constructor
         */
        public function __construct()
        {
            parent::__construct();
            $this->gameRepository = new Game();
            $this->dxl = new Core();
            $this->tournamentSettings = new TournamentSetting();
            $this->gameService = new GameService();
            $this->registerAdminActions();
            $this->registerGuestActions();
        }

        /**
         * registering admin actions
         *
         * @return void
         */
        public function registerAdminActions(): void
        {
            add_action("wp_ajax_dxl_event_game_create", [$this, 'ajaxCreateGame']);
            add_action("wp_ajax_dxl_event_game_update", [$this, 'ajaxUpdateGame']);
            add_action("wp_ajax_dxl_event_gamemode_delete", [$this, 'ajaxDeleteGameMode']);
            add_action("wp_ajax_dxl_event_game_delete", [$this, 'ajaxDeleteGame']);
            add_action("wp_ajax_dxl_event_game_type_create", [$this, 'ajaxCreateGameType']);
            add_action("wp_ajax_dxl_event_game_type_delete", [$this, 'ajaxDeleteGameType']);
        }

        /**
         * register guest actions
         *
         * @return void
         */
        public function registerGuestActions(): void
        {

        }

        /**
         * Create new game resource
         *
         * @return void
         */
        public function ajaxCreateGame(): void 
        {
            $logger = $this->dxl->getUtility('Logger');

            $created = $this->gameRepository->create([
                "name" => $_REQUEST["game"],
                "game_type" => (int) $_REQUEST["gametype"]
            ]);

            if ( ! $created ) {
                $logger->log("Game not created, something went wrong");
                echo $this->dxl->response('events', ["error" => true, "response" => "game creating failed, something went wrong, try again"]);
                wp_die(409);
            }

            $this->dxl->response('events', [
                "error" => falase,
                "response" => "Spil oprettet"
            ]);
            wp_die(201);
        }

        /**
         * delete game mode
         *
         * @return void
         */
        public function ajaxDeleteGameMode(): void 
        {
            $logger = $this->dxl->getUtility('Logger');

            $game_mode_id = (int) $_REQUEST["gameMode"];

            $existingGame = $this->gameRepository->find($game_id);
            $gameMode = $this->gameRepository->gameMode()->find($game_mode_id);
            $this->gameRepository->gameMode()->delete($gameMode->id);

            wp_die();
        }

        /**
         * Delete game resource action
         *
         * @return void
         */
        public function ajaxDeleteGame(): void 
        {
            $logger = $this->dxl->getUtility('Logger');

            $existingGame = $this->gameRepository->find((int) $_REQUEST["id"]);
            $settings = $this->tournamentSettings->findByGame($existingGame->id);

            $updated = $this->tournamentSettings->update([
                "game_id" => 0,
                "game_mode" => 0
            ], $settings->event_id);
            
            $gameModes = $this->gameRepository->gameMode()->select()->where('game_id', $existingGame->id)->get();

            foreach($gameModes as $mode)
            {
                $this->gameRepository->gameMode()->delete($mode->id);
            }

            $this->gameRepository->delete($existingGame->id);
            wp_die();
        }

        /**
         * updating game
         *
         * @return void
         */
        public function ajaxUpdateGame(): void
        {
            // Logger utility
            $logger = $this->dxl->getUtility('Logger');

            // game object
            $request = $this->get('game');
            $request = $_REQUEST["game"];
            $gameType = $request["type"];
            $gameModes = $request["modes"];
            $game_id = $request["id"];

            $game = $this->gameRepository->find($game_id);

            $logger->log("Updating game ressource: " . $game->name . " " . __METHOD__, 'events');

            // updating game type
            $this->gameRepository->gameType()->update([
                "name" => $gameType
            ], (int) $game->game_type);

            $inserted = $this->gameService->insertGameModes($gameModes, $game);

            if ( ! $inserted ) {
                $this->dxl->response('events', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke opdatere spillet."
                ]);
                wp_die(409, '');
            }

            $this->dxl->response('events', [
                "error" => false,
                "response" => "Spillet er opdateret!"
            ]);

            wp_die();
        }

        /**
         * Creating new game type 
         * 
         * @return void
         */
        public function ajaxCreateGameType() : void
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering method, " . __METHOD__, 'events');

            if( ! $_REQUEST['type'] ) {
                $this->dxl->response('event', [
                    "error" => true,
                    "response" => "Noget gik galt, kunne ikke oprette spil type"
                ]);
                $logger->log("Failed to create game type, could not find type in request " . __METHOD__, 'events');
                wp_die('', 404);
            }

            $created = $this->gameRepository->gameType()->create([
                "name" => $this->get('type')
            ]);

            $this->dxl->response('event', [
                "response" => "Spil type oprettet",
                "id" => $created 
            ]);

            wp_die();
        }

        /**
         * Deleting game type resources
         *
         * @return void
         */
        public function ajaxDeleteGameType(): void 
        {
            $logger = $this->dxl->getUtility('Logger');
            $logger->log("Triggering method, " . __METHOD__, 'events');

            if( !$this->has('type') ) {
                $logger->log("Failed to delete game type, could not find type identifier, " . __METHOD__ . 'events');
            }

            $deleted = $this->gameRepository->gameType()->delete((int) $_REQUEST["type"]);

            if( ! $deleted ) {
                $logger->log("Failed to delete game type, delete query failed");
                wp_die(500);
            }

            $this->dxl->response('event', [
                "error" => false,
                "response" => "Spil type er fjernet"
            ]);
            wp_die();
        }

        /**
         * rendering manage view
         *
         * @return void
         */
        public function manage(): void
        {
            if( $this->hasUriKey('action') ) {
                switch($this->getUriKey('action')) {
                    case "list":
                        $this->manageList();
                        break;

                    case "details":
                        $this->manageDetails();
                        break;
                }
            } else {
                $this->manageList();
            }
        }

        /**
         * Manage list resources
         *
         * @return void
         */
        public function manageList(): void
        {

            if( $this->hasUriKey('types') ) {
                $this->manageGameTypesList();
                wp_die();
            }

            $games = $this->gameRepository->all();
            $gameTypes = $this->gameRepository->gameType()->all();

            foreach( $games as $g => $game )
            {
                $gameType = $this->gameRepository->findGameTypeBy($game->game_type);
                // var_dump($gameType);
                $gameModes = $this->gameRepository->gameModes($game->id);
                $gameList[$g] = [
                    "id" => $game->id,
                    "name" => $game->name,
                    "type" => $gameType,
                    "modes" => $gameModes,
                ];
            }

            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/games/list.php";
        }

        /**
         * manage details view
         *
         * @return void
         */
        public function manageDetails(): void
        {
            $game = $this->gameRepository->find((int) $_GET["id"]);
            $gameType = $this->gameRepository->findGameTypeBy($game->game_type);
            $gameModes = $this->gameRepository->gameModes($game->id);

            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/games/details.php";
        }

        /**
         * 
         *
         * @return void
         */
        public function manageGameTypesList() 
        {
            $gameTypes = $this->gameRepository->gameType()->all();
            require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/games/types/list.php";
        }
    }
}

?>
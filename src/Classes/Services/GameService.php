<?php 

namespace DxlEvents\Classes\Services;

use DxlEvents\Classes\Repositories\GameRepository;

if ( !defined('ABSPATH') ) exit;

if( !class_exists('GameService') ) 
{
    class GameService 
    {
        /**
         * Game repository
         *
         * @var [type]
         */
        public $gameRepository;

        /**
         * Game service constructor
         */
        public function __construct() 
        {
            $this->gameRepository = new GameRepository();
        }

        /**
         * Inserting game modes in to specific game
         *
         * @param array $gameModes
         * @return boolean
         */
        public function insertGameModes($game, array $gameModes = []): bool 
        {
            foreach($gameModes as $mode)    
            {
                // dont do anything if the one row is empty
                if( empty($mode) ) {
                    continue;
                }

                // creating new row for the game Mode
                if( !empty($mode["name"]) ) {
                    // $logger->log("inserting game mode to game: " . $game->name . " " . __METHOD__);
                    $created = $this->gameRepository->gameMode()->create([
                        "name" => $mode["name"],
                        "game_id" => $game->id
                    ]);

                    if ( ! $created ) return false;
                }
            }
            
            return true;
        }
    }
}

?>
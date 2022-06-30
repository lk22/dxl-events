<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;
use DxlEvents\Classes\Repositories\GameModeRepository;
use DxlEvents\Classes\Repositories\GameTypeRepository;

if( ! class_exists('GameRepository') )
{
    class GameRepository extends Repository
    {
        protected $repository = "tournament_games";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";

        /**
         * return new game type repository 
         *
         * @return void
         */
        public function gameType()
        {
            return new GameTypeRepository();
        }

        /**
         * Game types 
         *
         * @return void
         */
        public function gameTypes($game) 
        {
            // TODO query game types attached to a game
            return (new GameTypeRepository())
                ->select()
                ->where('game_id', $game)
                ->get();
        }

        /**
         * find single game type resource bound to game id
         *
         * @param [type] $gameType
         * @return void
         */
        public function findGameTypeBy($gameType)
        {
            return (new GameTypeRepository())->find($gameType);
        }

        /**
         * Use Game Mode Repository as shortcut to the game mode repository
         *
         * @return void
         */
        public function gameMode()
        {
            return new GameModeRepository();
        }

        /**
         * fetch game modes attached to game
         *
         * @param [type] $game
         * @return void
         */
        public function gameModes($game) 
        {
            // TODO: query game mode attached to a game
            return (new GameModeRepository())
                ->select()
                ->where('game_id', $game)
                ->get();
        }
    }
}

?>
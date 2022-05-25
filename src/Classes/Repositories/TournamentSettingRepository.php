<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;

if( ! class_exists('TournamentSettingRepository') )
{
    class TournamentSettingRepository extends Repository
    {
        use TrashableTrait;

        protected $repository = "tournament_settings";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "event_id";

        /**
         * get tournament event settings by attached game
         *
         * @param [type] $game
         * @return void
         */
        public function findByGame($game) 
        {
            return $this->select()->where('game_id', $game)->getRow();
        }
    }
}

?>
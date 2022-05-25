<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;

if( ! class_exists('GameModeRepository') )
{
    class GameModeRepository extends Repository
    {
        protected $repository = "game_modes";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";
    }
}

?>
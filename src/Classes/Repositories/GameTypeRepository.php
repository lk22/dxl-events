<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;

if( ! class_exists('GameTypeRepository') )
{
    class GameTypeRepository extends Repository
    {
        protected $repository = "game_types";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";
    }
}

?>
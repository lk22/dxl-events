<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;

if( ! class_exists('CalendarEventRepository') )
{
    class CalendarEventRepository extends Repository
    {
        protected $repository = "tournament_games";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";
    }
}

?>
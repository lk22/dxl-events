<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;

if( ! class_exists('CalendarEventRepository') )
{
    class CalendarEventRepository extends Repository
    {
        protected $repository = "calendar_events";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";
    }
}

?>
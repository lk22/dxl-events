<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;

if( ! class_exists('EventWorkChoresRepository') )
{
    class EventWorkChoresRepository extends Repository
    {
        protected $repository = "events_workchores";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";
    }
}

?>
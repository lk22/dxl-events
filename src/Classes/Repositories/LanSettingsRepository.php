<?php 
namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;

if( !class_exists('LanSettingsRepository')) 
{
    class LanSettingsRepository extends Repository 
    {
        protected $repository = "event_lan_settings";
        protected $primaryIdentifier = "event_id";
        protected $defaultOrder = "DESC";
    }
}
?>
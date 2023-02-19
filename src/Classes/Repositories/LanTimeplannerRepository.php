<?php 
  /**
   * LanTimeplannerRepository
   * create a repository for the lan timeplanner table
   */
  namespace DxlEvents\Classes\Repositories;

  use Dxl\Classes\Abstracts\AbstractRepository as Repository;

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

  if( ! class_exists('LanTimeplannerRepository') )
  {
    class LanTimeplannerRepository extends Repository
    {
      protected $repository = "lan_timeplan";
      protected $defaultOrder = "ASC";
      protected $primaryIdentifier = "id";

      public function findByEvent(int $event): array
      {
        return $this->select()->where('event_id', $event)->get();
      }
    }
  }
?>
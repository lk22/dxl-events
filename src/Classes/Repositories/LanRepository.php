<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use DxlEvents\Classes\Repositories\LanSettingsRepository;
use DxlEvents\Classes\Repositories\LanParticipantRepository;
use Dxl\Classes\Traits\TrashableTrait;

if( ! class_exists('LanRepository') )
{
    class LanRepository extends Repository
    {
        use TrashableTrait;
        
        protected $repository = "events";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";

        public function drafts()
        {
            return $this->select()->where('is_draft', 1)->get();
        }

        public function latest()
        {
            return $this->select()->limit(1)->get();
        }

        /**
         * settings repository 
         *
         * @return void
         */
        public function settings(): LanSettingsRepository
        {
            return new LanSettingsRepository();
        }

        /**
         * Fetch LAN Participants
         *
         * @param int $event
         * @return void
         */
        public function getParticipants(int $event): array
        {
            return (new LanParticipantRepository())->findByEvent($event);
        }
    }
}

?>
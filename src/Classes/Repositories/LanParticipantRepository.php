<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;

if( !class_exists('LanParticipantRepository') )
{
    class LanParticipantRepository extends Repository
    {
        use TrashableTrait;

        /**
         * repository database table
         *
         * @var string
         */
        protected $repository = "lan_participants";

        /**
         * Default order property
         *
         * @var string
         */
        protected $defaultOrder = "DESC";

        /**
         * Find by specific event identifier
         *
         * @param [type] $event
         * @return void
         */
        public function findByEvent(int $event)
        {
            return $this->select()->where('event_id', $event)->get();
        }

        /**
         * remove participant model from specific event
         *
         * @param int $participant
         * @param int $event
         * @return void
         */
        public function removeFromEvent(int $participant, int $event) {
            return $this->handler->delete($this->handler->prefix . $this->repository, [
                $this->primaryIdentifier => (int) $participant,
                "event_id" => (int) $event
            ]);
        }
    }
}

?>
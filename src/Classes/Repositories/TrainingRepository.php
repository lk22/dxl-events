<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;

use DxlEvents\Classes\Repositories\ParticipantRepository;

if( ! class_exists('TrainingRepository') )
{
    class TrainingRepository extends Repository
    {
        protected $repository = "training_events";
        protected $defaultOrder = "DESC"; 
        protected $primaryIdentifier = "id";

        public function participants() {
            return (new ParticipantRepository())->all();
        }

        public function participant($participant) {
            return (new ParticipantRepository())->find($participant);
        }

        public function removeParticipant($participant, $event) 
        {
            return (new ParticipantRepository())->removeFromEvent($participant, $event);
        }

        public function addParticipant($participant)
        {
            return (new ParticipantRepository())->create($participant);
        }

        public function getTrainingsByMember($member) {
            return $this->select()->where('author', $member->user_id)->get();
        }
    }
}

?>
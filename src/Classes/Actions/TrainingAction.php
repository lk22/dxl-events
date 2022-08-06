<?php 
namespace DxlEvents\Classes\Actions;

use DxlEvents\Classes\Repositories\TrainingRepository;

if( !class_exists('TrainingAction') ) 
{
    class TrainingAction
    {
        /**
         * Training repository
         *
         * @var \DxlEvents\Classes\Repositories\TrainingRepository;
         */
        protected $trainingRepository;

        /**
         * Training action constructor
         */
        public function __construct()
        {
            $this->trainingRepository = new TrainingRepository;
        }

        /**
         * fetch latest events
         *
         * @return void
         */
        public function getEvents()
        {
            return $this->trainingRepository->select()->where('is_draft', 0)->get();
        }

        public function getTrainingByMember($member) {
            return $this->select()->where('author', $member->user_id)->get();
        }
    }
}

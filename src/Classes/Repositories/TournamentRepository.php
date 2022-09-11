<?php 

namespace DxlEvents\Classes\Repositories;

use Dxl\Classes\Abstracts\AbstractRepository as Repository;
use Dxl\Classes\Traits\TrashableTrait;
use DxlEvents\Classes\Repositories\TournamentSettingRepository as Setting;
use DxlEvents\Classes\Repositories\ParticipantRepository;

if( ! class_exists('TournamentRepository') )
{
    class TournamentRepository extends Repository
    {
        protected $repository = "tournaments";
        protected $defaultOrder = "DESC";
        protected $primaryIdentifier = "id";

        public function participants(): ParticipantRepository
        {
            return new ParticipantRepository();
        }

        public function getByMember($member)
        {
            return $this->select()->where('author', $member->user_id)->get();
        }
    }
}

?>
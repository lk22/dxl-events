<?php 

    namespace DxlEvents\Classes\Repositories;

    use Dxl\Classes\Abstracts\AbstractRepository;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('CooperationEventsRepository') )
    {
        class CooperationEventRepository extends AbstractRepository
        {
            protected $repository = "cooperation_events";
            protected $defaultOrder = "DESC";
            protected $primaryIdentifier = "id";

            public function participants() 
            {
                return (new ParticipantRepository());
            }
        }
    }

?>
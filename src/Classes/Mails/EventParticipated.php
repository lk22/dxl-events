<?php 
    namespace DxlEvents\Classes\Mails;

    if( !defined('ABSPATH') ) {
        exit;
    }

    if( !class_exists('EventParticipateMail') ) 
    {
        class EventParticipateMail extends \Dxl\Classes\Abstracts\AbstractMailer 
        {
            public $participant;
            public function __construct($participant)
            {
                $this->participant = $participant;
            }

            public function send()
            {
                
            }
        }
    }

?>
<?php 
    namespace DxlEvents\Classes\Mails;
    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('LanEventUnparticipated') ) 
    {
        class LanEventUnparticipated extends Mail 
        {
            /**
             * Participated event
             *
             * @var array
             */
            public $event;

            /**
             * participant
             *
             * @var array
             */
            public $participant;

            /**
             * Mail constructor
             *
             * @param [type] $event
             * @param [type] $participant
             */
            public function __construct($event, $participant) 
            {
                $this->event = $event;
                $this->participant = $participant;
            }

            /**
             * Send mail method
             *
             * @return void
             */
            public function send()
            {
                add_filter('wp_mail_content_type', [$this, 'setContentType']);
                wp_mail($this->receiver, $this->getSubject(), $this->template(), $this->getHeaders(), $this->getAttachments());
                remove_filter('wp_mail_content_type', [$this, 'setContentType']);
            }

            /**
             * Mail template definition
             *
             * @return void
             */
            protected function template()
            {
                ?>
                    <h2>Test</h2>;
                <?php
                return true;
            }
        }
    }
?>
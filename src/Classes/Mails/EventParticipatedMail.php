<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !defined('ABSPATH') ) {
        exit;
    }

    if( !class_exists('EventParticipatedMail') ) 
    {
        class EventParticipatedMail extends Mail 
        {
            /**
             * Participant
             *
             * @var array
             */
            public $participant;

            /**
             * Participated event
             *
             * @var [type]
             */
            public $event;

            /**
             * Constructor
             *
             * @param [type] $participant
             */
            public function __construct($participant, $event)
            {
                $this->participant = $participant;
                $this->event = $event;
            }

            /**
             * Send the HTML mail template
             *
             * @return void
             */
            public function send()
            {
                // $this->setView('dxl-events/src/admin/views/mails/event-participated-mail.php');
                // str_replace('[participant_name]', $this->participant->name, file_get_contents($this->view));
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
                $template = "<h2><strong>Kære " . $this->participant->name . "</strong><h2>\n\n";
                $template .= "<p>Vi har modtaget din tilmelding til " . $this->event->title . ",</p>\n";
                $template .= "<p>Du vil inden længe modtage en faktura</p>\n\n";
                $template .= "<p>OBS: vær opmærksom på prisen kan variere efter madvalg</p>\n\n";
                $template .= "<p>Vl glæder os til at se dig</p>";
                return $template;
            }   
        }
    }

?>
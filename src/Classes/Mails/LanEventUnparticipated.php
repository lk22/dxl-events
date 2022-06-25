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
             * participant message
             *
             * @var string
             */
            protected $message;

            /**
             * Mail constructor
             *
             * @param [type] $event
             * @param [type] $participant
             */
            public function __construct($event, $participant, string $message) 
            {
                $this->event = $event;
                $this->participant = $participant;
                $this->message = $message;
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
                $template = "<h3>Ny afmelding</h3>";
                $template .= "<p>Der er kommet en ny afmelding fra følgende medlem</p> \n\n";
                $template .= "<p>Navn: " . $this->participant->name . "</p>";
                $template .= "<p>Email: " . $this->participant->email . "</p>";
                $template .= "<p>Telefon: " . $this->participant->phone . "</p>";
                $template .= "<p>Besked: " . $this->message . "</p> \n\n";
                return $template;
            }
        }
    }
?>
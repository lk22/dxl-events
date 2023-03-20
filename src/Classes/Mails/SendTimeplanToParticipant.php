<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('SendTimeplanToParticipant') )
    {
        class SendTimeplanToParticipant extends Mail
        {
            /**
             * participated event
             *
             * @var object
             */
            public $event;

            /**
             * participant
             *
             * @var object
             */
            public $participant;

            /**
             * Event timeplan
             *
             * @var Array
             */
            public $timeplan;

            /**
             * Mail constructor
             *
             * @param object $event
             * @param object $participant
             */
            public function __construct($participant, $timeplan, $event)
            {
                $this->event = $event;
                $this->timeplan = $timeplan;
                $this->participant = $participant;
            }

            /**
             * mail send method
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
                $template = "<h2>Kære " . $this->participant->name . "</h2>";
                $template .= "<p>Vi har endelig fået tidsplanen for " . $this->event->title . " klar</p>";
                $template .= "<p>Nedenunder kan du se tidsplanen</p>\n\n";

                $template .= "<p>Vi er kede af du ikke kan komme alligevel, vi håber på at se dig næste gang</p> \n\n";
                $template .= "<p>Venlig hilsen</p>\n<p>Danish Xbox League</p>";
                return $template;
            }
        }
    }
?>
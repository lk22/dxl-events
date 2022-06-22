<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('EventUnparticipated') )
    {
        class EventUnparticipated extends Mail
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
             * Mail constructor
             *
             * @param object $event
             * @param object $participant
             */
            public function __construct($event, $participant)
            {
                $this->event = $event;
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
                $template .= "<p>Vi har modtaget din afmelding på begivenheden " . $this->event->title . "</p>";
                $template .= "<p>Vi er kede af du ikke kan komme alligevel, vi håber på at se dig næste gang</p> \n\n";
                $template .= "<p>Venlig hilsen</p>\n<p>Danish Xbox League</p>";
                return $template;
            }
        }
    }
?>
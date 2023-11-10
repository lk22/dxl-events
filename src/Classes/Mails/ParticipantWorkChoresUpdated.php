<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('ParticipantWorkChoresUpdated') )
    {
        class ParticipantWorkChoresUpdated extends Mail
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
             * List of workchore field
             *
             * @var array
             */
            public $workchores;

            /**
             * Mail constructor
             *
             * @param object $event
             * @param object $participant
             */
            public function __construct($participant, $event, $workchores)
            {
                $this->event = $event;
                $this->participant = $participant;
                $this->workchores = $workchores;
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

                $template .= "<p>Vi har modtaget dine nye ønsker for arbejdsopgaver til " . $this->event->title . "</p>\n";
                $template .= "<p>Vi har noteret følgende ønsker for arbejdsopgaver:</p>\n\n";

                if ( $this->workchores ) {
                  foreach( $this->workchores as $chore ) {
                    $template .= "- " . $chore["label"] . "\n\n";
                  }
                }

                $template .= "<p>Venlig hilsen</p>\n<p>Danish Xbox League</p>";
                return $template;
            }
        }
    }
?>
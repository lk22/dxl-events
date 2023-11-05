<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('LanWorkChoresUpdated') )
    {
        class LanWorkChoresUpdated extends Mail
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
                $template = "<h2>Der er modtaget opdatering på arbejdsopgaver</h2>\n\n";
                $template .= "Deltager: " . $this->participant->name . "\n";
                $template .= "Event: " . $this->event->title . "\n\n";
                $template .= "Arbejdsopgaver: \n";
                if( $this->workchores ) {
                  foreach ( $this->workchores as $chore ) {
                    $template .= "- " . $chore["label"] . "\n\n";
                  }
                }

                return $template;
            }
        }
    }
?>
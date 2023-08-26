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
             * @var object
             */
            public $participant;

            /**
             * Participated event
             *
             * @var object]
             */
            public $event;

            /**
             * Other participating seated members
             *
             * @var array
             */
            public $seatedMembers;

            /**
             * Participant notice message
             *
             * @var string
             */
            public $notice;

            /**
             * Companion name
             */
            public $companion;

            /**
             * Work chores checked has a participant decided to assign work chores
             *
             * @var bool
             */
            public $workChoresCheked;

            /**
             * Work chores
             *
             * @var Array
             */
            public $workchores;

            /**
             * Constructor
             *
             * @param [type] $participant
             */
            public function __construct(
                $participant,
                $event,
                $workChoresChecked,
                $workchores,
                $seatedMembers = [],
                $companion = [],
                $notice = ""
            )
            {
                $this->participant = $participant;
                $this->event = $event;
                $this->seatedMembers = $seatedMembers;
                $this->notice = $notice;
                $this->companion = $companion;
                $this->workChoresChecked = $workChoresChecked;
                $this->workchores = $workchores;
            }

            /**
             * Send the HTML mail template
             *
             * @return void
             */
            public function send(): void
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
            protected function template() : string
            {
                $template = "<h2><strong>Kære " . $this->participant->name . "</strong><h2>\n\n";
                $template .= "<p>Vi har modtaget din tilmelding til " . $this->event->title . ",</p>\n";
                $template .= "<p>OBS: vær opmærksom på prisen kan variere efter madvalg</p>\n\n";

                $template .= $this->getSeatedMembers($this->seatedMembers);
                $template .= $this->getCompanion($this->companion); 
                $template .= $this->getWorkChores(
                    $this->workChoresChecked, 
                    $this->workchores
                );

                if( ! empty($this->notice) ) {
                    $template .= "<p>Vi har noteret din bemærkning</p>\n";
                    $template .= "<p>" . $this->notice . "</p>";
                }

                $template .= "\n\n<p>Vl glæder os til at se dig</p>";
                return $template;
            }

            /**
             * render seated members partial
             *
             * @param [type] $seatedMembers
             * @return string
             */
            private function getSeatedMembers($seatedMembers): string 
            {
                if( $seatedMembers) {
                    $partial = "<p>Vi har noteret os du gerne vil sidde sammen med følgende:</p>\n";
                    $partial .= "<ul>";
                    foreach( $seatedMembers as $member ) {
                        $partial .= "<li>" . $member . "</li>";
                    }
                    $partial .= "</ul>\n";
                }

                return $partial ?? "";
            }

            /**
             * render companion mail template partial
             *
             * @param [type] $companion
             * @return string
             */
            private function getCompanion($companion): string 
            {
                if ( $this->companion ) {
                    $partial = "<p>Vi har noteret os du gerne vil have følgende med som ledsager:</p>\n";
                    $partial .= "<ul>";
                    $partial .= "<li>" . $this->companion["name"] . "</li>";
                    $partial .= (!empty($this->companion["mail"])) ? "<li>" . $this->companion["mail"] . "</li>" : "";
                    $partial .= (!empty($this->companion["phone"])) ? "<li>" . $this->companion["phone"] . "</li>" : "";
                    $partial .= "</ul>\n";
                }

                return $partial ?? "";
            }

            /**
             * Render workchores information partial
             *
             * @param [type] $checked
             * @param [type] $workchores
             * @return string
             */
            private function getWorkChores($checked, $workchores): string 
            {
                if ( $checked && count($workchores) ) {
                    $partial = "<p>Du ønsker og tage følgende arbejdsopgaver</p>\n\n";

                    if ( count($workchores) ) {
                        $partial .= "<ul>";
                        foreach( $workchores["items"] as $chore ) {
                            $partial .= "<li>- " . $chore["label"] . "</li>";
                        }
                        $partial .= "</ul>";
                    }
                }

                return $partial ?? "";
            }
        }
    }
?>
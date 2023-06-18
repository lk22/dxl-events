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
                $seatedMembers = [], 
                $notice, 
                $companion,
                $workChoresChecked,
                $workchores
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
                $template = "<h2><strong>Kære " . $this->participant->name . "</strong><h2>\n\n";
                $template .= "<p>Vi har modtaget din tilmelding til " . $this->event->title . ",</p>\n";
                
                $template .= "<p>OBS: vær opmærksom på prisen kan variere efter madvalg</p>\n\n";

                if( $this->seatedMembers) {
                    $template .= "<p>Vi har noteret os du gerne vil sidde sammen med følgende:</p>\n";
                    $template .= "<ul>";
                    foreach( $this->seatedMembers as $member ) {
                        $template .= "<li>" . $member . "</li>";
                    }
                    $template .= "</ul>\n";
                }

                if ( $this->companion ) {
                    $template .= "<p>Vi har noteret os du gerne vil have følgende med som ledsager:</p>\n";
                    $template .= "<ul>";
                    $template .= "<li>" . $this->companion["name"] . "</li>";
                    $template .= (!empty($this->companion["mail"])) ? "<li>" . $this->companion["mail"] . "</li>" : "";
                    $template .= (!empty($this->companion["phone"])) ? "<li>" . $this->companion["phone"] . "</li>" : "";
                    $template .= "</ul>\n";
                }

                if ( $this->workChoresChecked ) {
                    $template .= "<p>Du ønsker og tage følgende arbejdsopgaver</p>\n";
                    if ( $this->workchores ) {
                        $template .= "Fredag: \n";
                        if ( $this->workchores["participant-work-friday-trash"] ) {
                            $template .= "<p>Tømning af affald</p>\n";
                        }

                        if ( $this->workchores["participant-work-friday-fireroute"] ) {
                            $template .= "<p>Gå brandrunde</p>\n";
                        }

                        $template .= "\n<h4>Lørdag: </h4>\n";
                        if ( $this->workchores["participant-work-saturday-trash"] ) {
                            $template .= "<p>Tømning af affald</p>\n";
                        }

                        if ( $this->workchores["participant-work-saturday-fireroute"] ) {
                            $template .= "<p>Gå brandrunde</p>\n";
                        }

                        $template .= "\n<h4>Lørdag</h4>\n";
                        if ( $this->workchores["participant-work-sunday-trash"] ) {
                            $template .= "<p>Tømning af affald</p>\n";
                        }
    
                        if ( $this->workchores["participant-work-sunday-fireroute"] ) {
                            $template .= "<p>Gå brandrunde</p>\n";
                        }
                    }
                }

                if( !empty($this->notice) ) {
                    $template .= "<p>Vi har noteret din bemærkning</p>\n";
                    $template .= "<p>" . $this->notice . "</p>";
                }
                $template .= "\n\n<p>Vl glæder os til at se dig</p>";
                return $template;
            }   
        }
    }

?>
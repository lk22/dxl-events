<?php 
    namespace DxlEvents\Classes\Mails;
    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('LanEventFoodOrderParticipant') )
    {
        class LanEventFoodOrderParticipant extends Mail 
        {
            /**
             * participant
             *
             * @var array
             */
            public $participant;

            /**
             * Undocumented variable
             *
             * @var array
             */
            public $foodOrder;

            /**
             * Food ordered for companion
             *
             * @var boolean
             */
            public $foodOrderedForCompanion;

            /**
             * Specific note about the food order
             *
             * @var string
             */
            public $note;

            /**
             * Mail constructor
             *
             * @param array $foodOrder
             * @param boolean $foodOrderedForCompanion
             * @param object $participant
             * @param string $note
             */
            public function __construct($foodOrder, $foodOrderedForCompanion, $participant, $note) 
            {
                $this->foodOrder = $foodOrder;
                $this->foodOrderedForCompanion = $foodOrderedForCompanion;
                $this->participant = $participant;
                $this->note = $note;
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
                $template = "<p>Kære " . $this->participant->name . "</p>\n";
                $template .= "<p>Vi har modtaget dine madvalg</p>";
                $template .= "<p>Mad tilvalg</p>";
                foreach($this->foodOrder as $key => $food) {
                  $translated = "";
                  if( $key == "has_friday_breakfast" ) $translated = "Morgenmad (Fredag, Lørdag)";
                  else if( $key == "has_saturday_breakfast" ) $translated = "Morgenmad (Lørdag)";
                  else if( $key == "has_saturday_lunch" ) $translated = "Frokost (Lørdag)";
                  else if( $key == "has_saturday_dinner" ) $translated = "Aftensmad (Lørdag)";
                  else if( $key == "has_sunday_breakfast" ) $translated = "Morgenmad (Søndag)";
                  $template .= "<p>" . $translated ."</p>";
                }

                if ( $this->foodOrderedForCompanion ) {
                    $template .= "<p>Vi har noteret mad bestilling til din ledsager</p>";
                }

                if ( ! empty($this->note) ) {
                    $template .= "<p>Notat af mad bestilling</p>";
                    $template .= "<p>" . $this->note . "</p>";
                }

                return $template;
            }
        }
    }
?>
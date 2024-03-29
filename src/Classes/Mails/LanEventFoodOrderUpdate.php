<?php 
    namespace DxlEvents\Classes\Mails;
    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('LanEventFoodOrderUpdate') ) 
    {
        class LanEventFoodOrderUpdate extends Mail 
        {
            /**
             * participant data property
             *
             * @var array
             */
            public $participant;

            /**
             * List of ordered food
             *
             * @var array
             */
            public $foodOrder;

            /**
             * Property for companion ordered food
             *
             * @var boolean
             */
            public $foodOrderedForCompanion;

            /**
             * Note about the food ordering
             *
             * @var string
             */
            public $note;

            /**
             * Mail constructor
             *
             * @param [type] $event
             * @param [type] $participant
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
                $template = "<h2>Mad bestilling for deltager: " . $this->participant->name . "</h2>";
                $template .= "<h4>Mad tilvalg</h4>";
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
                    $template .= "<p>Der er bestilt mad til ledsager</p>";
                }

                if ( ! empty($this->note) ) {
                    $template .= "<h4>Notat af mad bestilling</h4>";
                    $template .= "<p>" . $this->note . "</p>";
                }

                return $template;
            }
        }
    }
?>
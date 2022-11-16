<?php 
    namespace DxlEvents\Classes\Mails;
    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !class_exists('LanEventFoodOrderUpdate') ) 
    {
        class LanEventFoodOrderUpdate extends Mail 
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
             * Mail constructor
             *
             * @param [type] $event
             * @param [type] $participant
             */
            public function __construct($foodOrder, $participant) 
            {
                $this->foodOrder = $foodOrder;
                $this->participant = $participant;
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
                $template = "<p>Mad bestilling for deltager: " . $this->participant->name . "</p>";
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

                return $template;
            }
        }
    }
?>
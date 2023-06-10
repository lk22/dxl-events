<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !defined('ABSPATH') ) {
        exit;
    }

    if( !class_exists('CronTournamentsHeldStatusChanged') ) 
    {
        class CronTournamentsHeldStatusChanged extends Mail 
        {

            /**
             * Event data
             */
            public $eventsData = [];

            /**
             * Constructor
             *
             * @param [type] $participant
             */
            public function __construct($eventsData)
            {
                $this->eventsData = $eventsData;
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
                $template = "<h3>Afholdte turneringer</h3>";
                $template .= "<p>Opdateret turneringer</p>";
                $template .= "<ul>";
                foreach ( $this->eventsData as $e => $event ) {
                    $template .= "<li>{$event['name']}";
                    $template .= "<ul>";
                    if (isset($eventData["tournaments"]) && count($eventData["tournaments"]) > 0) {
                        foreach ( $eventData['tournaments'] as $t => $tournament ) {
                            $template .= "<li>{$tournament[$t]}</li>";
                        }
                    }
                    $template .= "</ul>";
                }
                $template .= "</ul>";
                return $template;
            }   
        }
    }

?>
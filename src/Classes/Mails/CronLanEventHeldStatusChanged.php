<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !defined('ABSPATH') ) {
        exit;
    }

    /**
     * TODO: should run once a week at midnight
     * @author Leo knudsen <knudsenudvikling@gmail.dk>
     */
    if( !class_exists('CronLanEventHeldStatusChanged') ) 
    {
        class CronLanEventHeldStatusChanged extends Mail 
        {
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
                $template = "<h3>Afholdte LAN begivenheder</h3>";
                $template .= "<p>Opdateret turneringer</p>";
                $template .= "<ul>";
                if ( isset($eventData) && count($eventData)) {
                    foreach ( $this->eventsData as $e => $event ) {
                        $template .= "<li>{$event['name']}";
                        $template .= "<ul>";
                        if (isset($event["tournaments"]) && count($event["tournaments"]) > 0) {
                            foreach ( $event['tournaments'] as $t => $tournament ) {
                                $template .= "<li>{$tournament['name']}</li>";
                            }
                        }
                        $template .= "</ul>";
                    }
                } else {
                    $template .= "<li>Fandt ingen nye afholdte LAN begivenheder</li>";
                }
                $template .= "</ul>";
                return $template;
            }   
        }
    }

?>
<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;

    if( !defined('ABSPATH') ) {
        exit;
    }

    if( !class_exists('CalendarEventCreated') ) 
    {
        class CalendarEventCreated extends Mail 
        {
            /**
             * Constructor
             *
             * @param [type] $participant
             */
            public function __construct($event)
            {
                $this->event = $event;
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
             * @return string
             */
            protected function template(): string
            {
              $template = "<h3>Kære Danish Xbox League</h3>\n";
              $template .= "<p>Der er blevet oprettet en opgave: " . $this->event["eventName"] . "</p>\n";
              $template .= "<p>Beskrivelse: " . $this->event["eventName"] . "</p>\n";
              $template .= "<p><strong>Deadline:</strong> " . $this->event["eventDeadline"] . "</p>\n";
              $template .= "<p><strong>dato:</strong> " . $this->event["eventDate"] . " - " . $this->event["eventEndDate"] . "</p>\n";
              $template .= "<p><strong>Prioritet:</strong> " . $this->getPriority($this->event["priority"]) . "</p>\n";
              $template .= "<p><strong>Ansvarlig:</strong> " . $this->getBoardMember($this->event["associate"])->name . "</p>\n";
              return $template;
            }

            /** 
             * get event priority
             *
             * @param int $priority
             * @return string
             */
            private function getPriority( int $priority ): string
            {
                switch($priority) {
                    case 1:
                        return "Lav";
                        break;
                    case 2:
                        return "mellem";
                        break;
                    case 3:
                        return "Høj";
                        break;
                    default:
                        return "Lav";
                        break;
                }
            }

            /**
             * Get board member 
             *
             * @param int $boardMemberIdentifier
             * @return WP_Post
             */
            private function getBoardMember($associate): object {
                global $wpdb;

                $boardMember = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT 
                            ID as id,
                            post_title as name,
                            post_name as slug 
                        FROM dxl_posts 
                        WHERE post_type = 'dxl_board_members' 
                        AND ID = %d",
                        $associate
                    )
                );
                
                return $boardMember;
            }
        }
    }

?>
<?php 
    namespace DxlEvents\Classes\Mails;

    use Dxl\Classes\Abstracts\AbstractMailer as Mail;
    use DxlEvents\Classes\Repositories\LanParticipantRepository;

    if( !defined('ABSPATH') ) {
        exit;
    }

    if( !class_exists('LanEventParticipatedMail') ) 
    {
        class LanEventParticipatedMail extends Mail 
        {
            /**
             * Participant
             *
             * @var array
             */
            public $participant;

            /**
             * Lan event
             *
             * @var array
             */
            public $event;

            public $lanParticipantRepository;

            /**
             * Constructor
             *
             * @param [type] $participant
             */
            public function __construct($participant, $event)
            {
                $this->participant = $participant;
                $this->event = $event;
                $this->lanParticipantRepository = new LanParticipantRepository();
            }

            /**
             * Send the HTML mail template
             *
             * @return void
             */
            public function send()
            {
                return $this->getParticipantDetails();
                // $this->setView('dxl-events/src/admin/views/mails/lan-event-participant-mail.php');
                // str_replace('[participant_name]', $this->participant->name, file_get_contents($this->view));
                add_filter('wp_mail_content_type', [$this, 'setContentType']);
                wp_mail($this->receiver, $this->getSubject(), $this->template(), $this->getHeaders(), $this->getAttachments());
                remove_filter('wp_mail_content_type', [$this, 'setContentType']);
            }

            /**
             * Define mail template to send
             *
             * @return void
             */
            public function template() {
                $template = "
                    <h3>Ny deltager " . $this->participant->name . "</h3>
                    <p>Info om deltager</p>
                    <ul>
                        <li>Gamertag: " . $this->participant->gamertag . "</li>
                ";

                if( $this->getParticipantDetails()->has_friday_lunch ) {
                    $template .= "<li>Ønsker aftensmad (fredag): ja</li>";
                }

                if( 
                    $this->getParticipantDetails()->has_saturday_breakfast &&
                    $this->getParticipantDetails()->has_sunday_breakfast
                 ) {
                    $template .= "<li>Ønsker brunch (lørdag / søndag): ja</li>";
                }

                if( $this->getParticipantDetails()->has_saturday_dinner ) {
                    $template .= "<li>Ønsker aftensmad (Lørdag): ja</li>";
                }

                $template .= "</ul>";
                return $template;
            }

            /**
             * Get participant details
             *
             * @return void
             */
            protected function getParticipantDetails()
            {
                return $this->lanParticipantRepository
                    ->select()
                    ->where('member_id', $this->participant->id)
                    ->whereAnd('event_id', $this->event->id)
                    ->getRow();
            }
        }
    }

?>
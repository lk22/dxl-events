<?php 

namespace DxlEvents\Classes\Services;

use DxlEvents\Classes\Repositories\ParticipantRepository as Participant;
use DxlEvents\Classes\Repositories\LanSettingsRepository as Settings;

if( !class_exists('EventService') )
{
    class EventService
    {

        /**
         * removing participants from specific event
         *
         * @param int $event
         * @param array $participants
         * @return void
         */
        public function removeAttachedParticipants($event, $participants)
        {
            $participantRepository = new Participant();
            foreach($participants as $participant) 
            {
                // remove participant from event
                $removed = $participantRepository->removeFromEvent($participant->id, $event);
                if( $removed ){
                    continue;
                } else {
                    return false;
                }

            }
            return true;
        }

        /**
         * Configure event from given configuration data
         *
         * @param [type] $configuration
         * @return boolean
         */
        public function configureEvent(int $identifier, array $config): bool {
            $settings = new Settings();

            foreach($config as $c => $conf) {
                if( !empty($config[$c]) ) {
                    $configuration[$c] = $conf;
                }

                if( $c == "start_at" || $c == "end_at" ) {
                    $configuration[$c] = strtotime($conf);
                }

                if( $c == "participation_opening_date" || $c == "latest_participation_date" ) {
                    $configuration[$c] = strtotime($conf);
                }
            }

            $configured = $settings->update($configuration, (int) $identifier);

            return $configured ? true : false;
        }
    }
}

?>
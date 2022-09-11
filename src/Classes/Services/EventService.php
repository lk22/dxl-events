<?php 

namespace DxlEvents\Classes\Services;

use DxlEvents\Classes\Repositories\ParticipantRepository as Participant;

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
    }
}

?>
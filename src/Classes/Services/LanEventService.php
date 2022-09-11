<?php 
    namespace DxlEvents\Classes\Services;

    use DxlEvents\Classes\Repositories\LanRepository as Event;
    use DxlEvents\Classes\Repositories\LanSettingsRepository as Settings;
    use DxlEvents\Classes\Repositories\LanParticipantRepository as LanParticipant;

    if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    if( ! class_exists('LanEventService') )
    {
        class LanEventService extends EventService
        {

            public function createEvent(array $event) : bool
            {
                $newEvent = new Event();
                $created = $newEvent->create([
                    "title" => $event["title"],
                    "slug" => strtolower(str_replace(' ', '-', $event["title"])),
                    "is_draft" => 1,
                    "description" => $event["description"],
                    "extra_description" => $event['description_extra'],
                    "start" => strtotime($event['startdate']),
                    "end" => strtotime($event['enddate']),
                    "participants_count" => 0,
                    "tournaments_count" => 0,
                    "author" => $current_user->ID,
                    "created_at" => time(),
                    "seats_available" => $event['seats_available']
                ]);

                $this->createEventSettings($event, $created);

                return $created ? 1 : 0;
            }

            /**
             * create event settings
             *
             * @param array $event
             * @param integer $created
             * @return void
             */
            protected function createEventSettings(array $event, int $created) 
            {
                $setting = new Settings();
                $settings->create([
                    "event_id" => $created,
                    "event_location" => $event['location'],
                    "event_price" => 0,
                    "breakfast_friday_price" => 0,
                    "breakfast_saturday_price" => 0,
                    "lunch_saturday_price" => 0,
                    "dinner_saturday_price" => 0,
                    "breakfast_sunday_price" => 0,
                    "start_at" => 0, // timestamp
                    "end_at" => 0, // timestamp
                    "latest_participation_date" => 0, // timestamp
                    "participation_opening_date" => 0, // timestampe
                ]);
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
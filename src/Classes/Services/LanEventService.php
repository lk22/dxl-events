<?php 
    namespace DxlEvents\Classes\Services;

    use DxlEvents\Classes\Repositories\LanRepository as Event;
    use DxlEvents\Classes\Repositories\LanSettingsRepository as Settings;
    use DxlEvents\Classes\Repositories\LanParticipantRepository as LanParticipant;

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

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

            public function exportParticipants(array $participants, $event)
            {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A1', 'ID')->getColumnDimension('A')->setAutoSize(true);
                $sheet->setCellValue('B1', 'Name')->getColumnDimension('B')->setAutoSize(true);
                $sheet->setCellValue('C1', 'Gamertag')->getColumnDimension('C')->setAutoSize(true);
                $sheet->setCellValue("D1", "Betingelser")->getColumnDimension('D')->setAutoSize(true);
                $sheet->setCellValue("E1", "Medlemmer at sidde sammen med")->getColumnDimension("E")->setAutoSize(true);

                $row = 2;
                foreach ( $participants as $participant ) {
                    $sheet->setCellValue('A' . $row, $participant->id);
                    $sheet->setCellValue('B' . $row, $participant->name);
                    $sheet->setCellValue('C' . $row, $participant->gamertag);

                    // only show if terms are accepted
                    if ( $participant->event_terms_accepted ) {
                        $sheet->setCellValue('D' . $row, "Accepteret");
                    }

                    $seat_members = preg_replace('/\[\[(\w+)\[\]/' , '$1',  explode(",", $participant->seat_companions));
                    if (count($seat_members) > 0) {
                        $sheet->setCellValue('E' . $row, str_replace("[]", "", implode(", ", $seat_members)));
                    }

                    $row++;
                }

                $writer = new Xlsx($spreadsheet);

                $filename = ABSPATH . "wp-content/plugins/dxl-events/csv/lan_" . $event->title . "_participants_" . date("d_m_Y", strtotime('today')) . ".xlsx";
                $writer->save($filename);

                return str_replace(ABSPATH, '', $filename);
            }
        }
    }
?>
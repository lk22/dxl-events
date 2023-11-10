<?php 
    namespace DxlEvents\Classes\Services;

    use DxlEvents\Classes\Repositories\LanRepository as Event;
    use DxlEvents\Classes\Repositories\LanSettingsRepository as Settings;
    use DxlEvents\Classes\Repositories\LanParticipantRepository as LanParticipant;
    use DxlEvents\Classes\Repositories\ParticipantRepository;
    use DxlMembership\Classes\Repositories\MemberRepository;
    use DxlEvents\Classes\Repositories\EventWorkChoresRepository;

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    // get logger utility
    use Dxl\Classes\Utilities\Logger;

    if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    if( ! class_exists('LanEventService') )
    {
        class LanEventService extends EventService
        {

            public function __construct() 
            {
                $this->tournamentParticipantRepository = new ParticipantRepository();
                $this->eventWorkChoresRepository = new EventWorkChoresRepository();
            }

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

            public function initializeDefaultWorkChores() {
            
                return [
                  "friday" => [
                        "fields" => [
                          "participant-work-friday-setup" => [
                            "label" => "Opsætning (Fredag)"
                          ], 
                          "participant-work-friday-fireroute" => [
                            "label" => "Brand rundde (Fredag)"
                          ],
                          "participant-work-friday-trash" => [
                            "label" => "Affald - pant (Fredag)"
                          ],
                          "participant-work-friday-smoke-area" => [
                            "label" => "Ryge område (Fredag)"
                          ],
                          "participant-work-friday-bathroom" => [
                            "label" => "Toiletter (Fredag)"
                          ],
                          "participant-work-friday-coffee" => [
                            "label" => "Kaffe (Fredag)"
                          ],
                        ],
                      ],
                      "saturday" => [
                        "fields" => [
                          "participant-work-saturday-fireroute" => [
                            "label" => "Brand rundde (Lørdag)"
                          ],
                          "participant-work-saturday-trash" => [
                            "label"=> "Affald - pant (Lørdag)"
                          ],
                          "participant-work-saturday-cleaning" => [
                            "label" => "Oprydning (Lørdag)"
                          ],
                          "participant-work-saturday-smoke-area" => [
                            "label" => "Ryge område (Lørdag)"
                          ],
                          "participant-work-saturday-bathroom" => [
                            "label" => "Toiletter (Lørdag)"
                          ],
                          "participant-work-saturday-coffee" => [
                            "label" => "Kaffe (Lørdag)"
                          ]
                        ]
                      ],
                      "sunday" => [
                        "fields" => [
                          "participant-work-sunday-trash" => [
                            "label" => "Affald - pant (Søndag)"
                          ],
                          "participant-work-sunday-cleaning" => [
                            "label" => "Oprydning (Søndag)"
                          ],
                          "participant-work-sunday-smoke-area" => [
                            "label" => "Ryge område (Søndag)"
                          ],
                          "participant-work-sunday-bathroom" => [
                            "label" => "Toiletter (Søndag)"
                          ],
                          "participant-work-sunday-coffee" => [
                            "label" => "Kaffe (Søndag)"
                          ],
                          "participant-work-sunday-clearing" => [
                            "label" => "Afrigning (Søndag)"
                          ],
                          "participant-work-sunday-clearing-hall" => [
                            "label" => "Oprydning sovehaller (Søndag)"
                          ]
                        ]  
                      ]
                  ];
            }

            /**
             * Exporting participants to excel
             * exporting tournaments participants in seperate sheets
             *
             * @param array $participants
             * @param array $tournaments
             * @param Int $event
             * @return void
             */
            public function exportParticipants(array $participants, array $tournaments, $event)
            {
                global $wpdb;
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle('LAN Deltagere');
                $memberRepository = new MemberRepository();
                $logger = new Logger();
                
                if ( count($participants) ) {
                    $workChoresSheet = clone $spreadsheet->getActiveSheet();
                    $workChoresSheet->setTitle("Arbejdsopgaver");
                    $spreadsheet->addSheet($workChoresSheet);
                    
                    $workChoresSheet->setCellValue('A1', "Navn")->getColumnDimension('A')->setAutoSize(true);
                    $workChoresSheet->setCellValue('B1', "Gamertag")->getColumnDimension('B')->setAutoSize(true);

                    $workChoreSheetColumns = ["C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "Q", "R"];
                    $workchores = $this->eventWorkChoresRepository->select(["chores"])->where('event_id', $event)->get();
                    $mergedChores = array_merge(
                      json_decode($workchores[0]->chores)->friday,
                      json_decode($workchores[0]->chores)->saturday,
                      json_decode($workchores[0]->chores)->sunday
                    );

                    $choresFields = [];
                    foreach( $mergedChores as $index => $chore ) {
                      if ( isset($workChoreSheetColumns[$index]) ) {
                        $column = $workChoreSheetColumns[$index];
                        $workChoresSheet->getColumnDimension($column)->setAutoSize(true);
                        $choresFields[$column] = $chore->name;
                      }
                    }

                    foreach($choresFields as $key => $value) {
                        $workChoresSheet->setCellValue($key . "1", $value)->getColumnDimension($key)->setAutoSize(true);
                    }

                    $participantRow = 2;
                    foreach($participants as $participant) {
                        // $member = $memberRepository->select(["member_number"])->where("id", $participant->member_id)->get();
                        $workChoresSheet->setCellValue('A' . $participantRow, $participant->name);
                        $workChoresSheet->setCellValue('B' . $participantRow, $participant->gamertag);
                        
                        $workchores = preg_replace('/\[\[(\w+)\[\]/' , '$1',  explode(",", $participant->workchores));

                        $chores = [];

                        // adding chores fields as seperate chore field
                        foreach($choresFields as $key => $value) {
                            if ( count($workchores) ) {
                                foreach(json_decode($participant->workchores) as $chore) {
                                    if ( $chore->label == $value ) {
                                        $chores[] = $value;
                                        $workChoresSheet->setCellValue($key . $participantRow, $value);
                                    }
                                }
                            }
                        }
                        $participantRow++;
                    }
                }
                
                if ( count($tournaments) > 0) {
                    foreach ( $tournaments as $tournament ) {
                        // clone the sheet
                        $tournamentSheet = clone $spreadsheet->getActiveSheet();
                        $tournamentSheet->setTitle($tournament->title);
                        $spreadsheet->addSheet($tournamentSheet);
                        
                        $tournamentSheet->setCellValue('A1', 'navn')->getColumnDimension('A')->setAutoSize(true);
                        $tournamentSheet->setCellValue('B1', 'gamertag')->getColumnDimension('B')->setAutoSize(true);
                        
                        $tournamentParticipants = $this->tournamentParticipantRepository
                            ->select()
                            ->where('event_id', $tournament->id)
                            ->get();
                        
                        $tRow = 2;
                        foreach( $tournamentParticipants as $participant ) {
                            $tournamentSheet->setCellValue('A' . $tRow, $participant->name);
                            $tournamentSheet->setCellValue('B' . $tRow, $participant->gamertag);
                            $tRow++;
                        }
                    }
                }

                $sheet->setCellValue('A1', 'ID')->getColumnDimension('A')->setAutoSize(true);
                $sheet->setCellValue('B1', 'Name')->getColumnDimension('B')->setAutoSize(true);
                $sheet->setCellValue('C1', 'Gamertag')->getColumnDimension('C')->setAutoSize(true);
                $sheet->setCellValue("D1", "Betingelser")->getColumnDimension('D')->setAutoSize(true);
                $sheet->setCellValue("E1", "Medlemmer at sidde sammen med")->getColumnDimension("E")->setAutoSize(true);
                $sheet->setCellValue("F1", "Morgenmad (Lørdag)")->getColumnDimension("H")->setAutoSize(true);
                $sheet->setCellValue("G1", "Morgenmad (Søndag)")->getColumnDimension("I")->setAutoSize(true);

                $row = 2;
                foreach ( $participants as $participant ) {
                    $member = $wpdb->get_row("SELECT member_number FROM {$wpdb->prefix}members WHERE id = {$participant->member_id}");
                    // $member = $memberRepository->select(["member_number"])->where("id", $participant->member_id)->get();
                    $logger->log("member: " . $member->member_number);
                    $sheet->setCellValue('A' . $row, $participant->id);
                    $sheet->setCellValue('B' . $row, $participant->name);
                    $sheet->setCellValue('C' . $row, $participant->gamertag);

                    // only show if terms are accepted
                    if ( $participant->event_terms_accepted ) {
                        $sheet->setCellValue('D' . $row, "Accepteret");
                    }
                    
                    $seat_members = preg_replace('/\[\[(\w+)\[\]/' , '$1',  explode(",", $participant->seat_companions));
                    if (count($seat_members) > 0) {
                        $seats = [];
                    
                        foreach($seat_members as $member) {
                            $seats[] = $member;
                        }

                        $sheet->setCellValue('E' . $row, str_replace(array("[", "]", '"'), "", implode("\n", $seats)));
                    }

                    if ( $participant->has_saturday_breakfast ) {
                        $sheet->setCellValue('F' . $row, "bestilt");
                    }

                    if ( $participant->has_sunday_breakfast ) {
                        $sheet->setCellValue('G' . $row, "bestilt");
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
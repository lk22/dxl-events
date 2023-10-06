<?php 
    namespace DxlEvents\Classes\Services;

    use DxlEvents\Classes\Repositories\LanRepository as Event;
    use DxlEvents\Classes\Repositories\LanSettingsRepository as Settings;
    use DxlEvents\Classes\Repositories\LanParticipantRepository as LanParticipant;
    use DxlEvents\Classes\Repositories\ParticipantRepository;
    use DxlMembership\Classes\Repositories\MemberRepository;

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
                    $choresFields = [
                        "C" => "Opsætning (Fredag)",
                        "D" => "Ryge område (Fredag)",
                        "E" => "Kaffe (Fredag)",
                        "F" => "Toiletter (Fredag)",
                      	"G" => "Brand rundde (Fredag)",
                        "H" => "Oprydning (Lørdag)",
                        "I" => "Ryge område (Lørdag)",
                        "J" => "Kaffe (Lørdag)",
                        "K" => "Toiletter (Lørdag)",
                      	"L" => "Brand rundde (Lørdag)",
                        "M" => "Oprydning (Søndag)",
                        "N" => "Ryge område (Søndag)",
                        "O" => "Kaffe (Søndag)",
                        "P" => "Toiletter (Søndag)",
                        "Q" => "Nedpakning (Søndag)",
                        "R" => "Oprydning sovehaller (Søndag)"
                    ];
                    
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
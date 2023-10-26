<?php 
  namespace DxlEvents\Classes\Utilities;

  if ( ! defined('ABSTPATH') ) {
    exit;
  }

  if ( ! class_exists('WorkChoresUtility') ) {
    class WorkChoresUtility {
      public static $instance;

      public function getInstance(): WorkChoresUtility 
      {
        if ( ! self::$iinstance ) {
          self::$iinstance = new WorkChoresUtility();
        } 

        return self::$instance;
      }

      /**
       * initialize default work chores data
       *
       * @return array
       */
      public function initalizeDefaultWorkChores(): array
      {
        return [
          "workchores" => [
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
            ]
          ]
        ];
      }
    }
  }
?>
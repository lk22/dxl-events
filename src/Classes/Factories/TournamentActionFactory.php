<?php 
    namespace DxlEvents\Classes\Factories;

    use DxlEvents\Interfaces\TournamentFactoryInterface;


    use DxlEvents\Classes\Actions\TournamentPublishAction;
    use DxlEvents\Classes\Actions\TournamentUnpublishAction; 
    use DxlEvents\Classes\Actions\TournamentAttachGame;
    use DxlEvents\Classes\Actions\TournamentAttachLanEvent;
    use DxlEvents\Classes\Actions\TournamentUpdateDescription;
    use DxlEvents\Classes\Actions\TournamentSetMaxTeamSize;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentFactory') )
    {
        class TournamentActionFactory implements TournamentFactoryInterface
        {
            public function get($action)
            {
                switch($action) {
                    case "bulk-update-description":
                        return new TournamentUpdateDescription();
                    case "attach_game":
                        return new TournamentAttachGame();
                    case "publish-tournament":
                        return new TournamentPublishAction();
                    case "unpublish-tournament":
                        return new TournamentUnpublishAction();
                    case "attach-lan-event":
                        return new TournamentAttachLanEvent();
                    case "set_team_max_size":
                        return new TournamentSetMaxTeamSize();
                    default:
                        return null;
                }
            }
        }
    }
?>
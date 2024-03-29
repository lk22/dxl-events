<?php 
    namespace DxlEvents\Classes\Factories;

    use DxlEvents\Interfaces\TournamentFactoryInterface;
    use DxlEvents\Classes\Actions\TournamentPublishAction;
    use DxlEvents\Classes\Actions\TournamentUnpublishAction; 
    use DxlEvents\Classes\Actions\TournamentAttachGame;
    use DxlEvents\Classes\Actions\TournamentAttachLanEvent;
    use DxlEvents\Classes\Actions\TournamentBulkUpdateDescription;
    use DxlEvents\Classes\Actions\TournamentSetMaxTeamSize;
    use DxlEvents\Classes\Actions\TournamentSetHeldStatus;
    use DxlEvents\Classes\Actions\TournamentUpdateDetails;
    use Dxl\Classes\Utilities\Logger;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('TournamentFactory') )
    {
        class TournamentActionFactory implements TournamentFactoryInterface
        {
            public function get($action)
            {
                $logger = Logger::getInstance("calling {$action} action");
                switch($action) {
                    case 'update-tournament-details':
                        return new TournamentUpdateDetails();
                    case "bulk-update-description":
                        return new TournamentBulkUpdateDescription();
                    case "attach-game":
                        return new TournamentAttachGame();
                    case "publish-tournament":
                        return new TournamentPublishAction();
                    case "unpublish-tournament":
                        return new TournamentUnpublishAction();
                    case "attach-lan-event":
                        return new TournamentAttachLanEvent();
                    case "set_team_max_size":
                        return new TournamentSetMaxTeamSize();
                    case "set_held_status":
                        return new TournamentSetHeldStatus();
                    default:
                        return null;
                }
            }
        }
    }
?>
<?php 
    namespace DxlEvents\Classes\Factories;

    use Dxl\Interfaces\CronFactoryInterface;
    use DxlEvents\Classes\Cron\AutoChangeLanHeldStatus;
    use DxlEvents\Classes\Cron\ChangeTournamentHeldStatus;

    use Dxl\Classes\Utilities\Logger;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! class_exists('CronTasksFactory') )
    {
        class CronTasksFactory implements CronFactoryInterface
        {
            public function get($task)
            {
                Logger::getInstance()->logCronReport("calling CRON task {$task}");
                switch($task) {
                    case "SetTournamentHeldStatus":
                        return new ChangeTournamentHeldStatus();
                    case "AutoChangeLanHeldStatus":
                        return new AutoChangeLanHeldStatus();
                    default:
                        Logger::getInstance()->logCronReport("CRON task {$task} not found");
                        return null;
                }
            }
        }
    }

?>
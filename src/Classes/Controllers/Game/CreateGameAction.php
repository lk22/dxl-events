<?php 
namespace DxlEvents\Classes\Actions\Game;

use Dxl\Classes\Utilities\LoggerUtility as Logger;
use Dxl\Classes\Abstracts\AbstractAction as Action;

if( !defined('ABSPATH') ) exit;

if( ! class_exists('CreateGameAction') ) 
{
    class CreateGameAction extends Action
    {
        public $loggerUtility; 

        public function __construct() {
            $this->logger = new Logger();
        }

        public function create() {
            $this->logger->log("test");
            echo json_encode("test");
            wp_die();
        }
    }
}


?>
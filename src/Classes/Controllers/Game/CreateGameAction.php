<?php 
namespace DxlEvents\Classes\Actions\Game;

use Dxl\Classes\Utilities\LoggerUtility as Logger;

if( !defined('ABSPATH') ) exit;

if( ! class_exists('CreateGameAction') ) 
{
    class CreateGameAction
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
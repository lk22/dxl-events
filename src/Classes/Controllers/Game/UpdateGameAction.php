<?php 
namespace DxlEvents\Classes\Actions\Game;


if( !defined('ABSPATH') ) exit;

if( ! class_exists('UpdateGameAction') ) 
{
    class UpdateGameAction 
    {
        public function update() {
            echo json_encode("test");
            wp_die();
        }
    }
}


?>
<?php 
    namespace DxlEvents\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists("TournamentFactoryInterface")) 
    {
        interface TournamentFactoryInterface 
        {
            public function get($action);
        }
    }
?>
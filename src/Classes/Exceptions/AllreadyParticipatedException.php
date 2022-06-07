<?php 
    namespace DxlEvents\Classes\Exceptions;

    if( !class_exists('AllreadyParticipatedException') )
    {
        class AllreadyParticipatedException extends \Exception 
        {
            public function __construct() 
            {
                parent::__construct("Member allready participated this event", 1);
            }
        }
    }
?>
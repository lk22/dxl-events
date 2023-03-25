<?php

namespace DxlEvents\Classes\Factories;

use Dxl\Interfaces\TimeplanFactoryInterface;
use DxlEvents\Classes\Actions\CreateEventTimeplan;
use DxlEvents\Classes\Actions\UpdateEventTimeplan;
use DxlEvents\Classes\Actions\DeleteEventTimeplan;
use DxlEvents\Classes\Actions\PublishEventTimeplan;

use Dxl\Classes\Utilities\Logger;

if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('TimeplanFactory') ) {
  class TimeplanFactory implements TimeplanFactoryInterface
  {
    public function get($action) {
      Logger::getInstance()->log("Calling {$action} from TimeplanFactory");

      switch($action) {
        case "create":
          return new CreateEventTimeplan();
          break;
        case "update":
          return new UpdateEventTimeplan();
          break;
        case "delete":
          return new DeleteEventTimeplan();
          break;
        case "publish":
          return new PublishEventTimeplan();
          break;
      }
    }
  }
}
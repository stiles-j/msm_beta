<?php

/**
 * Simple class for writing messages to the log rather than re-creating the function every time it is needed.
 */
class Logger
{
  public function logError($message) {
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");
    error_log($message);
  } //end function logError

}
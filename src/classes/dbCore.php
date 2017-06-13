<?php

/**
 * dbCore handles the fundamentals of connecting to and accessing the database.  All classes that perform database
 * access should extend this class.  The class is declared abstract to prevent instantiation.
 */
abstract class dbCore
{

  //class login variables
  private $hostname, $username, $password, $database;

  protected function __construct()
  {
    //first get login credentials; USERS WILL NEED TO INSERT THEIR CREDENTIALS HERE

    $this->hostname = 'localhost';
    $this->username = 'test';
    $this->password = 'dbtest';
    $this->database = 'members';
  } // end function __construct

  protected function connect()
  {
    //NOTE: The calling function is responsible for closing the connection created by this function

    $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

    if ($conn->connect_errno)
    {
      die("Connection to DataBase failed: " . $conn->connect_error);
    }

    return $conn;

  } //end function connect

  protected function logError($db_conn, $message = '') {
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");
    $sqlError = $db_conn->error;
    error_log($message . " " . $sqlError);
  } //end function logError

  protected function sanitizeInput($input, $db_conn)
  {
    if(get_magic_quotes_gpc())
      $input = stripslashes($input);

    $input = $db_conn->escape_string($input);
    $input = strip_tags($input);
    $input = htmlentities($input, ENT_QUOTES);

    return $input;

  } // end function sanitizeInput

}
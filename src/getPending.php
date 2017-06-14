<?php

/*This script will access the database and return a list of pending classes or events in JSON format.  */


require_once 'classes/dbManager.php';
$db = new dbManager;

session_start();
$memberID = $_SESSION['lastMemberDisplayed'];


function logError($message) {
  ini_set("log_errors", 1);
  ini_set("error_log", "php-error.log");
  error_log($message);
} //end function logError


function generateJSON($dbResult) {
  $tmpArray = array();
  
  while($row = $dbResult->fetch_assoc()) {
            $tmpArray[] = $row;
    }
  echo json_encode($tmpArray);
} //end generateJSON



if (isset($_GET['class']) || isset($_POST['class'])) {
  $result = $db->getPendingClasses($memberID);
  generateJSON($result);  
}
else if (isset($_GET['event']) || isset($_POST['event'])) {
  $result = $db->getPendingEvents($memberID);
  generateJSON($result);
}

?>
<?php

require_once "classes/ReportManager.php";

$db = new ReportManager();

if (isset($_POST['startDate'])) {
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
} else {
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];
}

function generateJSON($dbResult) {
  $tmpArray = array();

  while($row = $dbResult->fetch_assoc()) {
    $tmpArray[] = $row;
  }
  echo json_encode($tmpArray);
} //end generateJSON


if (isset($_GET['class']) || isset($_POST['class'])) {
  $result = $db->getPriorClasses($startDate, $endDate);
  generateJSON($result);
}
else if (isset($_GET['event']) || isset($_POST['event'])) {
  $result = $db->getPriorEvents($startDate, $endDate);
  generateJSON($result);
}

?>
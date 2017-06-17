<?php

require_once "classes/ReportManager.php";

$rm = new ReportManager();

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
  $result = $rm->getPriorClasses($startDate, $endDate);
  if ($result) {
    generateJSON($result);
    return;
  }
  echo $result;
}
else if (isset($_GET['event']) || isset($_POST['event'])) {
  $result = $rm->getPriorEvents($startDate, $endDate);
  if ($result){
    generateJSON($result);
    return;
  }
  echo $result;
}

?>

















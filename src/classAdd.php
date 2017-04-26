<?php

require_once "classes/dbManager.php";
require_once "classes/UserManager.php";

$db = new dbManager();
if (isset($_POST['referenceNumber'])){
    $result = $db->addNewClass($_POST['referenceNumber'], $_POST['time']);
    $method = '_POST';
} else {
    $result = $db->addNewClass($_GET['referenceNumber'], $_GET['time']);
    $method = '_GET';
}

$um = new UserManager();

if (!$result) {
  $content = "Unable to add new class";
  $um->displayPopUp($content, "Error Adding New Class", 'smTest.php');
  exit();
}

$courseInfo = $db->getCourseInfo(${$method}['referenceNumber']);
$date = substr(${$method}['time'], 0, 10);
$time = substr(${$method}['time'], 11);

$content = "Added New Class: <p>$courseInfo[CourseName] on $date at $time</p>";
$um->displayPopUp($content, "Class Added", 'smTest.php');
exit();

?>
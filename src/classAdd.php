<?php

require_once "classes/dbManager.php";
require_once "classes/UserManager.php";

$db = new dbManager();

$result = $db->addNewClass($_GET['referenceNumber'], $_GET['time']);

$um = new UserManager();

if (!$result) {
  $content = "Unable to add new class";
  $um->displayPopUp($content, "Error Adding New Class", 'smTest.php');
  exit();
}

$courseInfo = $db->getCourseInfo($_GET['referenceNumber']);
$date = substr($_GET['time'], 0, 10);
$time = substr($_GET['time'], 11);

$content = "Added New Class: <p>$courseInfo[CourseName] on $date at $time</p>";
$um->displayPopUp($content, "Class Added", 'smTest.php');
exit();

?>
<?php

require_once "dbManager.php";
require_once "UserManager.php";

$db = new dbManager();

$result = $db->addNewClass($_POST['course'], $_POST['classDate']);

$um = new UserManager();

if (!$result) {
  $content = "Unable to add new class";
  $um->displayPopUp($content, "Error Adding New Class", 'smTest.php');
  exit();
}

$courseInfo = $db->getCourseInfo($_POST['course']);
$date = substr($_POST['classDate'], 0, 10);
$time = substr($_POST['classDate'], 11);

$content = "Added New Class: <p>$courseInfo[CourseName] on $date at $time</p>";
$um->displayPopUp($content, "Class Added", 'smTest.php');
exit();

?>
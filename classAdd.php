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


$content = "Added New Class: <p>$courseInfo[CourseName] on $_POST[classDate]</p>";
$um->displayPopUp($content, "Class Added", 'smTest.php');
exit();

?>
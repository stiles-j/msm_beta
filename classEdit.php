<?php

require_once "dbManager.php";
require_once "UserManager.php";

$db = new dbManager();
$oldClassInfo = $db->getClassInfo($_POST['classToEdit']);
$result = $db->updateClass($_POST['classToEdit'], $_POST['newClassDate']);

$um = new UserManager();
if (!$result) {
  $content = "Unable to update class";
  $um->displayPopUp($content, "Error Updating Class", "smTest.php");
  exit();
}


$content = "<p>$oldClassInfo[Name]</p><p>Originally scheduled for:<br /> $oldClassInfo[Date]</p><p>Has been moved to:<br /> $_POST[newClassDate]</p>";
$um->displayPopUp($content, "Class Updated", 'smTest.php');
exit();
?>
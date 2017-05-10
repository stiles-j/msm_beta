<?php

require_once "classes/dbManager.php";
require_once "classes/UserManager.php";

$db = new dbManager();
$oldClassInfo = $db->getPendingClassInfo($_POST['classToEdit']);
$result = $db->updateClass($_POST['classToEdit'], $_POST['newClassDate']);
$newDate = substr($_POST['newClassDate'], 0, 10);
$newTime = substr($_POST['newClassDate'], 11) . ":00";


$um = new UserManager();
if (!$result) {
  $content = "Unable to update class";
  $um->displayPopUp($content, "Error Updating Class", "smTest.php");
  exit();
}


$content = "<p>$oldClassInfo[Name]</p><p>Originally scheduled for:<br /> $oldClassInfo[Date]</p><p>Has been moved to:<br /> $newDate $newTime</p>";
$um->displayPopUp($content, "Class Updated", 'smTest.php');
exit();
?>
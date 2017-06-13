<?php

require_once "classes/dbManager.php";
require_once "classes/InterfaceManager.php";

$db = new dbManager();
$method = '_GET';
if (isset($_POST['referenceNumber'])) $method = "_POST";

$oldClassInfo = $db->getPendingClassInfo(${$method}['referenceNumber']);
$result = $db->updateClass(${$method}['referenceNumber'], ${$method}['time']);
$newDate = substr(${$method}['time'], 0, 10);
$newTime = substr(${$method}['time'], 11);


$um = new InterfaceManager();
if (!$result) {
  $content = "Unable to update class";
  $um->displayPopUp($content, "Error Updating Class", "smTest.php");
  exit();
}


$content = "<p>$oldClassInfo[Name]</p><p>Originally scheduled for:<br /> $oldClassInfo[Date]</p><p>Has been moved to:<br /> $newDate $newTime</p>";
$um->displayPopUp($content, "Class Updated", 'smTest.php');
exit();
?>
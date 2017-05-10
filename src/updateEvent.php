<?php


require_once "classes/dbManager.php";
require_once "classes/PopUpManager.php";

$location = '_GET';
if (isset($_POST['eventReferenceNumber'])) $location = '_POST';

$db = new dbManager();
$duration = ${$location}['hours'] . ":" . ${$location}['minutes'] . ":00";
$facilities = null;
if (isset(${$location}['eventFacilities'])) $facilities = ${$location}['eventFacilities'];


//attempt the update
$result = $db->updateEvent(${$location}['eventReferenceNumber'], ${$location}['eventName'], ${$location}['eventDate'], ${$location}['eventMemberFee'], ${$location}['eventNonMemberFee'], ${$location}['eventDescription'], $duration, $facilities);

$pm = new PopUpManager();
if ($result) {
  $content = "<p>Event " .  ${$location}['eventName']. " Has Been Updated</p>";
  $pm->createPopUp($content, "Update Success", "smTest.php");
  exit();
}

$content = "<p>Unable to Update ${$location}[eventName]</p>";
$pm->createPopUp($content, "Update Failed", "smTest.php");

?>
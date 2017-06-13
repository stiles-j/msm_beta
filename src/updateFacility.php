<?php

require_once "classes/dbManager.php";
require_once "classes/InterfaceManager.php";

$db = new dbManager();
$subFacilities = null;
if (isset($_POST['subFacilities'])) $subFacilities = $_POST['subFacilities'];

//attempt the update
$result = $db->updateFacility($_POST['facilityID'], $_POST['facilityName'] ,$_POST['facilityDescription'], $subFacilities);

$um = new InterfaceManager();

if ($result) {
  $content = "Facility $_POST[facilityName] has been updated";
  $um->displayPopUp($content, "Update Successful", "smTest.php");
  exit();
}

$content = "Unable to update facility $_POST[facilityName]";
$um->displayPopUp($content, "ERROR", "smTest.php");

?>
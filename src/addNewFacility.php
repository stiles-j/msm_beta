<?php

require_once "classes/dbManager.php";
require_once "classes/InterfaceManager.php";

$db = new dbManager();
$subFacilities = null;
if (isset($_POST['subFacilities'])) $subFacilities = $_POST['subFacilities'];

//attempt to add the facility record
$result = $db->addNewFacility($_POST['facilityName'], $_POST['facilityDescription'], $subFacilities);

//if we're good give the user a confirmation pop-up and re-direct back to the main dashboard
$um = new InterfaceManager();
if ($result) {
  $content = "Added new facility $_POST[facilityName]";
  $um->displayPopUp($content, "SUCCESS", "smTest.php");
  exit();
}

$content = "<p>Error while adding new facility.</p><p>Facility Not added.</p>";
$um->displayPopUp($content, "ERROR", "smTest.php");
?>
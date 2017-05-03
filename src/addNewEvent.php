<?php
/** Author: Justice Stiles
 * Date: 2017/05/01
 * Name addNewEvent.php
 * Description:  This script receives input via get and attempts to add a new event to the database
 */

require_once 'classes/dbManager.php';
require_once 'classes/UserManager.php';


$location = "_GET";
if (isset($_POST['eventName'])) {
    $location = "_POST";
}

//if we have facilities, store them in a separate variable
$facilities = null;
if (isset(${$location}['eventFacilities'])) {
    $facilities = ${$location}['eventFacilities'];
}
//try the insert
$db = new dbManager();
$duration = ${$location}['hours'] . ":" . ${$location}['minutes'] . ":00";
$courseID = $db->addNewEvent(${$location}['eventName'], ${$location}['eventDate'], ${$location}['eventMemberFee'], ${$location}['eventNonMemberFee'], ${$location}['eventDescription'], $duration, $facilities);

//if something goes wrong give 'em an error and punt
if (!$courseID) {
  $um = new UserManager();
  $content = "Unable to add new event.  Event Not added";
  $um->displayPopUp($content, "Error Adding Event", "smTest.php");
  exit();
}

//if we're good send 'em back to the main dashboard
header("Location: smTest.php");

?>
<?php
/* Author: Justice Stiles
 * Date: 2017/05/01
 * Name addNewEvent.php
 * Description:  This script receives input via post and attempts to add a new event to the database */

require_once 'classes/dbManager.php';
require_once 'classes/UserManager.php';

//try the insert
$db = new dbManager();
$duration = "$_POST[hours]:$_POST[minutes]";
$courseID = $db->addNewEvent($_POST['courseName'], $_POST['eventDate'], $_POST['courseMemberFee'], $_POST['courseNonMemberFee'], $_POST['courseDescription'], $duration, $_POST['courseFacilities']);

//if something goes wrong give 'em an error and punt
if (!$courseID) {
  $um = new UserManager();
  $content = "Unable to add new course.  Course Not added";
  $um->displayPopUp($content, "Error Adding Course", "smTest.php");
  exit();
}

//if we're good send 'em back to the main dashboard
header("Location: smTest.php");

?>
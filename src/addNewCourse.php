<?php
/* Author: Justice Stiles
 * Date: 2017/02/05
 * Name addNewCourse.php
 * Description:  This script receives input via post and attempts to add a new course to the database */

require_once 'classes/dbManager.php';
require_once 'classes/UserManager.php';

//try the insert
$db = new dbManager();
$duration = "$_POST[hours]:$_POST[minutes]";
$courseID = $db->addNewCourse($_POST['courseName'], $_POST['courseMemberFee'], $_POST['courseNonMemberFee'], $_POST['courseDescription'], $duration, $_POST['courseFacilities']);

//if something goes wrong give 'em an error and punt
if (!$courseID) {
  $um = new UserManager();
  $content = "Unable to add new course.  Course Not added";
  $um->displayPopUp($content, "Error Adding Course", "smTest.php");
  exit();
}

//add the certifications to the db if there are any
if (isset($_POST['courseCerts']) && count($_POST['courseCerts']) != 0) {
  $certs = $_POST['courseCerts'];
  foreach ($certs as $cert) {
    $db->addCourseCert($courseID, $cert);
  }
}

//if we're good send 'em back to the main dashboard
header("Location: smTest.php");

?>
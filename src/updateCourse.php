<?php

require_once 'classes/dbManager.php';
require_once 'classes/InterfaceManager.php';


$db = new dbManager();
$courseID = $_POST['courseID'];
$courseDuration = "$_POST[hours]:$_POST[minutes]";

//update the course information
$result = $db->updateCourse($_POST['courseID'], $_POST['courseName'], $courseDuration, $_POST['courseMemberFee'], $_POST['courseNonMemberFee'], $_POST['courseDescription'], $_POST['courseCerts'], $_POST['courseFacilities']);
checkForError($result);


//if we're good send 'em back to the main dashboard
header("Location: smTest.php");


/*------------------Functions------------------------------------------------*/
function checkForError ($result) {
  if (!$result) {
    $um = new InterfaceManager();
    $content = "Unable to update course";
    $um->displayPopUp($content, "Error Updating Course", "smTest.php");
    exit();
  } //end if
} //end function checkForError
?>
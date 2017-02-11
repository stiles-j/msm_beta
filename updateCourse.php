<?php

require_once 'dbManager.php';
require_once 'UserManager.php';


$db = new dbManager();
$courseID = $_POST['courseID'];



//update the course information
$result = $db->updateCourse($_POST['courseID'], $_POST['courseName'], $_POST['courseMemberFee'], $_POST['courseNonMemberFee'], $_POST['courseDescription']);
checkForError($result);


//If there are any certs for the course, update those also
if (isset($_POST['courseCerts']) && count($_POST['courseCerts']) != 0) {
  $certs = $_POST['courseCerts'];
  $db->deleteCourseCertifications($courseID);

  foreach($certs as $cert) {
    $result = $db->addCourseCert($courseID, $cert);
    checkForError($result);
  }
}

//if we're good send 'em back to the main dashboard
header("Location: smTest.php");


/*------------------Functions------------------------------------------------*/
function checkForError ($result) {
  if (!$result) {
    $um = new UserManager();
    $content = "Unable to update course";
    $um->displayPopUp($content, "Error Updating Course", "smTest.php");
    exit();
  } //end if
} //end function checkForError
?>
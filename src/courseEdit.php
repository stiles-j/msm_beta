<?php

/*Script to generate the edit course form*/

require_once 'classes/UserManager.php';
require_once 'classes/dbManager.php';
$db = new dbManager();
$um = new UserManager();
$courseID = $_POST['courseToEdit'];
$courseInfo = $db->getCourseInfo($courseID);
$courseCertifications = $db->getCourseCertifications($courseID);
$courseFacilities = $db->getCourseFacilities($courseID);
$facilityList = $db->getAllFacilities();
$certs = $db->getAllCertifications();

//produce the main body of the form
$content = <<<END
<form action="updateCourse.php" method="post" id="courseEditForm" name="courseEditForm">
  <div class="userInputFields">
    <h2>Edit Course Form</h2>
    <p><span class='label'>Course Name:</span></p>
    <p><input type='text' name='courseName' value='$courseInfo[CourseName]' autofocus='autofocus'></p>
    <p><span class='label'>Course Duration:</span></p>
    <p class='durationInput'>Hours:<input type='number' name='hours' value='$courseInfo[Hours]' /> Minutes:<input type='number' name='minutes' value='$courseInfo[Minutes]' /></p>
    <p><span class="label">Course Member Fee:</span> </p>
    <p><input type="number" name="courseMemberFee" value='$courseInfo[CourseMemberFee]' step="any"></p>
    <p><span class="label">Course NonMember Fee:</span> </p>
    <p><input type="number" step="any" name="courseNonMemberFee" value='$courseInfo[CourseNonMemberFee]'></p>
    <p><span class="label">Course Certifications:</span></p>

END;

//add the select box with the certifications
$content .= "<p><select name='courseCerts[]' multiple='multiple'>";

foreach ($certs as $cert) {
  if (in_array($cert, $courseCertifications)) {
    $content .= "<option value='$cert' selected='selected'>$cert</option>";
  }
  else {
    $content .= "<option value='$cert'>$cert</option>";
  }
}//end foreach
$content .= "</select></p>";

//add the select box with the facilities
$content .= "<p><span class=\"label\">Course Facilities:</span></p>";
$content .= "<p><select name='courseFacilities[]' multiple='multiple'>";
foreach ($facilityList as $facility) {
  $found = false;
  foreach ($courseFacilities as $courseFacility) {
    if ($courseFacility['FacilityID'] == $facility['FacilityID']) {
      $content .= "<option value='$facility[FacilityID]' selected='selected'>$facility[FacilityName]</option>";
      $found = true;
    }
  } //end inner foreach
  if (!$found) {
    $content .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
  }
} //end outer foreach


$content .= <<<END
    </select></p>
    <p><span class='label'>Course Description:</span></p>
    <p><textarea name="courseDescription">$courseInfo[CourseDescription]</textarea></p>
    <input type="submit" name="submit" class='sbutton'>
    <input type='hidden' name='courseID' value='$courseID'>
    </div></form>
END;

$um->displayWin($content);

?>
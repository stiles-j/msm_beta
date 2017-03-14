<?php
/**
 * This script generates the Add New Course form
 */

require_once 'classes/UserManager.php';
require_once 'classes/dbManager.php';
$db = new dbManager();
$um = new UserManager();
$certs = $db->getAllCertifications();
$facilityList = $db->getAllFacilities();
//get the main body of the form
$content = <<<END
<form action="addNewCourse.php" method="post" id="addCourseForm" name="addCourseForm">
  <div class="userInputFields">
    <h2>New Course Input Form</h2>
    <p><span class='label'>Course Name:</span></p>
    <p><input type='text' name='courseName' autofocus='autofocus'></p>
    <p><span class='label'>Course Duration:</span></p>
    <p class='durationInput'>Hours:<input type='number' name='hours'  /> Minutes:<input type='number' name='minutes' /></p>
    <p><span class="label">Course Member Fee:</span> </p>
    <p><input type="number" name="courseMemberFee" step="any"></p>
    <p><span class="label">Course NonMember Fee:</span> </p>
    <p><input type="number" step="any" name="courseNonMemberFee"></p>
    <p><span class="label">Course Certifications:</span></p>

END;

//add the select box with the certifications
$content .= "<p><select name='courseCerts[]' multiple='multiple'>";
foreach ($certs as $cert) {
  $content .= "<option value='$cert'>$cert</option>";
}
$content .= "</select></p>";

//add the select box with the facilities
$content .= "<p><span class=\"label\">Course Facilities:</span></p>";
$content .= "<p><select name='courseFacilities[]' multiple='multiple'>";
foreach ($facilityList as $facility) {
  $content .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
}

$content .= <<<END
    </select></p>
    <p><span class='label'>Course Description:</span></p>
    <p><textarea name="courseDescription"></textarea></p>
    <input type="submit" name="submit" class='sbutton'>
    </div></form>
END;

$um->displayWin($content);

?>
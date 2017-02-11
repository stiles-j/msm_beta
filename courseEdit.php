<?php

/*Script to generate the edit course form*/

require_once 'UserManager.php';
require_once 'dbManager.php';
$db = new dbManager();
$um = new UserManager();
$courseID = $_POST['courseToEdit'];
$courseInfo = $db->getCourseInfo($courseID);
$courseCertifications = $db->getCourseCertifications($courseID);
$certs = $db->getAllCertifications();

//produce the main body of the form
$content = <<<END
<form action="updateCourse.php" method="post" id="courseEditForm" name="courseEditForm">
  <div class="userInputFields">
    <h2>New Course Input Form</h2>
    <p><span class='label'>Course Name:</span></p>
    <p><input type='text' name='courseName' value='$courseInfo[CourseName]' autofocus='autofocus'></p>
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
}//end outer foreach

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
<?php

require_once "classes/dbManager.php";
require_once "classes/UserManager.php";

$db = new dbManager();

$facilities = $db->getAllFacilities();
$facilityInfo = $db->getFacilityInfo($_POST['facilityToEdit'])->fetch_assoc();
$subFacilities = $db->getSubFacilities($_POST['facilityToEdit']);

//generate the main body of the add facility form
$efForm = <<<END
    <form name="editFacilityForm" action="updateFacility.php" method='post'>
      <div class="userInputFields">
        <h2>Update Facility Form</h2>
        <p><span class="label">Facility Name: </span><input type="text" name="facilityName" value='$facilityInfo[FacilityName]' autofocus="autofocus" /></p>
        <p><span class="label">Facility Description: </span>
        <textarea name="facilityDescription" >$facilityInfo[FacilityDescription]</textarea></p>
END;

//generate the sub-facility select box
$efForm .="<p><span class='label'>Sub-Facilities: </span></p>";
$efForm .= "<p><select name='subFacilities[]' multiple='multiple'>";
foreach ($facilities as $facility) {
  $found = false;
  foreach ($subFacilities as $subFacility) {
    if ($facility['FacilityID'] == $subFacility['SubFacilityID']){
      $efForm .= "<option value='$facility[FacilityID]' selected='selected'>$facility[FacilityName]</option>";
      $found = true;
    }//end if
  }//end inner foreach

  if (!$found){
    $efForm .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
  }
} //end outer foreach
$efForm .= "</select></p>";
$efForm .= "<input type='hidden' name='facilityID' value='$_POST[facilityToEdit]'>";
$efForm .= "<p><input type=\"submit\" value=\"Submit\" /></p></div></form>";

$um = new UserManager();
$um->displayWin($efForm);


?>
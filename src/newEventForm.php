<?php
/**
 * This script generates the Add New Event form
 */

require_once 'classes/UserManager.php';
require_once 'classes/dbManager.php';
$db = new dbManager();
$um = new UserManager();
$facilityList = $db->getAllFacilities();

$content = <<<END
<form action="checkEventConflict.php" method="post" id="addEventForm" name="addEventForm">
  <div class="userInputFields">
    <h2>New Event Input Form</h2>
    <p><span class='label'>Event Name:</span></p>
    <p><input type='text' name='eventName' autofocus='autofocus'></p>
    <p><span class='label'>Event Date & Time</span></p>
    <p><input type='datetime-local' name='eventDate'></p>
    <p><span class='label'>Event Duration:</span></p>
    <p class='durationInput'>Hours:<input type='number' name='hours' value='1'  /> Minutes:<input type='number' name='minutes' value='00' /></p>
    <p><span class="label">Event Member Fee:</span> </p>
    <p><input type="number" name="eventMemberFee" step="any"></p>
    <p><span class="label">Event NonMember Fee:</span> </p>
    <p><input type="number" step="any" name="eventNonMemberFee"></p>

END;

//add the select box with the facilities
$content .= "<p><span class='label'>Event Facilities:</span></p>";
$content .= "<p><select name='eventFacilities[]' multiple='multiple'>";
foreach ($facilityList as $facility) {
  $content .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
}

$content .= <<<END
    </select></p>
    <p><span class='label'>Event Description:</span></p>
    <p><textarea name="eventDescription"></textarea></p>
    <input type="submit" name="submit" class='sbutton'>
    </div></form>
END;

$um->displayWin($content);

?>
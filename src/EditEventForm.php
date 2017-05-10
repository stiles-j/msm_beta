<?php
/**
 * This form must receive a valid EventReferenceNumber via Post or Get.  The form will pre-populate with the existing
 *data for this event.  Once submitted, the form will dispatch to checkEventConflict.php
 *
 */
require_once 'classes/dbManager.php';
require_once 'classes/UserManager.php';

$location = "_GET";
if (isset($_POST['eventReferenceNumber'])) {
  $location = "_POST";
}
$db = new dbManager();
$um = new UserManager();

$referenceNumber = ${$location}['eventReferenceNumber'];
$priorEventInfo = $db->getEventInfo($referenceNumber)->fetch_assoc();
$priorFacilities = $db->getEventFacilities($referenceNumber);
$facilityList = $db->getAllFacilities();
$hours = substr($priorEventInfo['Duration'], 0, 2);
$minutes = substr($priorEventInfo['Duration'], 3, 2);
$date = date_create_from_format('Y-m-d G:i:s', $priorEventInfo['EventDate']);
$date = $date->format("Y-m-d\TG:i");

$content = <<<END
<form action="checkEventConflict.php" method="post" id="editEventForm" name="editEventForm">
  <div class="userInputFields">
    <h2>Event Update Form</h2>
    <p><span class='label'>Event Name:</span></p>
    <p><input type='text' name='eventName' value='$priorEventInfo[EventName]' autofocus='autofocus'></p>
    <p><span class='label'>Event Date & Time</span></p>
    <p><input type='datetime-local' value='$date' name='eventDate'></p>
    <p><span class='label'>Event Duration:</span></p>
    <p class='durationInput'>Hours:<input type='number' value='$hours' name='hours' /> Minutes:<input type='number' value='$minutes' name='minutes' /></p>
    <p><span class="label">Event Member Fee:</span> </p>
    <p><input type="number" value='$priorEventInfo[EventMemberFee]' name="eventMemberFee" step="any"></p>
    <p><span class="label">Event NonMember Fee:</span> </p>
    <p><input type="number" value='$priorEventInfo[EventNonMemberFee]' step="any" name="eventNonMemberFee"></p>

END;

//add the select box with the facilities
$content .= "<p><span class='label'>Event Facilities:</span></p>";
$content .= "<p><select name='eventFacilities[]' multiple='multiple'>";
foreach ($facilityList as $facility) {
  $found = false;
  while ($priorFacility = $priorFacilities->fetch_assoc()) {
    if ($facility['FacilityID'] == $priorFacility['FacilityID']) {
      $content .= "<option value='$facility[FacilityID]' selected='selected'>$facility[FacilityName]</option>";
      $found = true;
    }
  } //end while

  if (!$found) {
    $content .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
  }
} //end foreach

$content .= <<<END
    </select></p>
    <p><span class='label'>Event Description:</span></p>
    <p><textarea name="eventDescription">$priorEventInfo[EventDescription]</textarea></p>
    <input type='hidden' name='update' value='update'>
    <input type='hidden' name='eventReferenceNumber' value='$referenceNumber'>
    <input type="submit" name="submit" class='sbutton'>
    </div></form>
END;

$um->displayWin($content);

?>
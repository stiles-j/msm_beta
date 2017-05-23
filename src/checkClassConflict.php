<?php

require_once 'classes/dbManager.php';
require_once 'classes/PopUpManager.php';

$db = new dbManager();
$conflicts = array();
$referenceNumber = $_POST['referenceNumber'];
$startTime = DateTime::createFromFormat('Y-m-d\TH:i', "$_POST[time]")->format('Y-m-d H:i:s');
$type = $_POST['type'];
$destination = "classAdd.php";
if (isset($_POST['update'])) {
  $destination = "classEdit.php";
  $classReferenceNumber = $referenceNumber;
  $referenceNumber = $db->getCourseID($referenceNumber);
}

$duration = $db->getCourseInfo($referenceNumber)['Duration'];

//check if the class requires any facilities
$facilities = $db->getFacilityList($referenceNumber, $type);

//if we have required facilities, check each one for conflicts
if (!empty($facilities)) {
  foreach ($facilities as $facility) {
    $conflict = $db->checkFacilityScheduleConflict($facility, $startTime, $duration);

    //if we find a conflict, grab the info and put an info string into the conflicts array
    if ($conflict) {
      $conflict = $conflict->fetch_assoc();

      if ($conflict['Type'] == "CLASS" || $conflict['Type'] == "class") {
        $conflictInfo = $db->getPendingClassInfo($conflict['ReferenceNumber']);
      } else {
        $conflictInfo = $db->getPendingEventInfo($conflict['ReferenceNumber']);
      }

      $facilityInfo = $db->getFacilityInfo($facility);
      $conflicts[] = "$conflict[Type] $conflictInfo[Name] on $conflictInfo[Date] requires" . $facilityInfo->fetch_assoc()['FacilityName'];

    } //end if conflict
  } //end foreach facility
} //end if facilities

/*if there is anything in the conflicts array, output a warning and give the user a chance to cancel before scheduling
the event/class*/
if (!empty($conflicts)) {
  $content = "There are previously scheduled events that conflict with this $type:";
  foreach ($conflicts as $issue) {
    $content .= "<p>$issue</p>";
  }

  if (isset($_POST['update'])) {
    $content .= "<input type='hidden' name='referenceNumber' value='$classReferenceNumber'>";
  } else {
    $content .= "<input type='hidden' name='referenceNumber' value='$referenceNumber'>";
  }

  $content .= "<input type='hidden' name='time' value='$startTime'>";
  $content .= "<p class='cancelButton'><a href='smTest.php'>Cancel</a></p>";

  $pm = new PopUpManager();
  $pm->createPopUp($content, "Scheduling Conflict!", $destination);
} else if (!isset($_POST['update'])){
    header("Location: " . $destination . "?referenceNumber=$referenceNumber&time=" . $startTime);
} else {
    header("Location: " . $destination . "?referenceNumber=$classReferenceNumber&time=" . $startTime);
}

?>
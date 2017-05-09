<?php
/**
 * Author: Justice Stiles
 * Date: 2017/05/01
 * Name CheckEventConflict.php
 * Description: Script to check facility conflicts for events
 */

require_once 'classes/dbManager.php';
require_once 'classes/PopUpManager.php';

$destination = 'addNewEvent.php';
if (isset($_POST['update'])) {
  $destination = 'updateEvent.php';
}

//if there are no facilities to check conflicts for, just send the data on to addNewEvent.php to be added to the db
if (!isset($_POST['eventFacilities']) || $_POST['eventFacilities'] == null) {
    header("Location: $destination?eventName=$_POST[eventName]&eventDate=$_POST[eventDate]&eventMemberFee=$_POST[eventMemberFee]&eventNonMemberFee=$_POST[eventNonMemberFee]&eventDescription=$_POST[eventDescription]&hours=$_POST[hours]&minutes=$_POST[minutes]");
    exit();
}

$db = new dbManager();

$facilityList = $_POST['eventFacilities'];
$total_facilities = $facilityList;
$duration = "$_POST[hours]:$_POST[minutes]:00";
$conflicts = array();

//get the sub facilities
foreach ($facilityList as $facility) {
    $sub_facilities = $db->getSubFacilities($facility);
    if ($sub_facilities) {
            foreach ($sub_facilities as $sub) {
                $total_facilities[] = $sub;
            }
        }
    } //end foreach facility

foreach ($total_facilities as $facility) {
    $conflict = $db->checkFacilityScheduleConflict($facility, $_POST['eventDate'], $duration);

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

/*if there is anything in the conflicts array, output a warning and give the user a chance to cancel before scheduling
the event*/
if (!empty($conflicts)) {
    $content = "There are previously scheduled events that conflict with this event:";
    foreach ($conflicts as $issue) {
        $content .= "<p>$issue</p>";
    }

    $content .= "<input type='hidden' name='eventName' value='$_POST[eventName]'>";
    $content .= "<input type='hidden' name='eventDate' value='$_POST[eventDate]'>";
    $content .= "<input type='hidden' name='eventMemberFee' value='$_POST[eventMemberFee]'>";
    $content .= "<input type='hidden' name='eventNonMemberFee' value='$_POST[eventNonMemberFee]'>";
    $content .= "<input type='hidden' name='eventDescription' value='$_POST[eventDescription]'>";
    $content .= "<input type='hidden' name='hours' value='$_POST[hours]'>";
    $content .= "<input type='hidden' name='minutes' value='$_POST[minutes]'>";
    foreach ($facilityList as $individual) {
        $content .= "<input type='hidden' name='eventFacilities[]' value='" . $individual . "'>";
    }

    $content .= "<p class='cancelButton'><a href='smTest.php'>Cancel</a></p>";

    $pm = new PopUpManager();
    $pm->createPopUp($content, "Scheduling Conflict!", 'addNewEvent.php');
} else {
    header("Location: $destination?eventName=$_POST[eventName]&eventDate=$_POST[eventDate]&eventMemberFee=$_POST[eventMemberFee]&eventNonMemberFee=$_POST[eventNonMemberFee]&eventDescription=$_POST[eventDescription]&hours=$_POST[hours]&minutes=$_POST[minutes]&" . http_build_query(array('eventFacilities' => $facilityList)));
}

?>




























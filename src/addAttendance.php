<?php

require_once 'classes/InterfaceManager.php';
require_once 'classes/dbManager.php';

$pm = new InterfaceManager();
$db = new dbManager();

//If the event isn't today, give 'em an error and punt
if ($_POST['eventDate'] != date('Y-m-d')) {
      $content = "<h3>Members cannot be marked present for events before the day they occur</h3>";
      $pm->displayProfile($_POST['memberID']);
      $pm->displayPopUp($content, "Attendance Not Added", 'smTest.php');
      exit();
    }

//add the record to CLASS_TAKEN
$result = $db->addAttendance($_POST['memberID'], $_POST['referenceNumber'], $_POST['type']);
if (!$result) {
  $content = "Unable to add attendance to member profile";
  $pm->displayPopUp($content, "Error", 'smTest.php');
}

//If this is a class get the list of certs associated with the class and add them to the member profile
if ($_POST['type'] == 'CLASS') {
  //get the list of certs if there are any
  $certs = $db->getClassCertifications($_POST['referenceNumber']);
  //if we have certs, add them to the member's record
  if ($certs) {
    foreach ($certs as $cert) {
      $db->addMemberCert($_POST['memberID'], $cert);
    } //end foreach
  } //end if
}
$memberName = $db->getUsername($_POST['memberID']);
$content = "<h3>$memberName has been marked in attendance for $_POST[eventName]</h3>";
$pm->displayProfile($_POST['memberID']);
$pm->displayPopUp($content, "Attendance Added", 'smTest.php');

?>
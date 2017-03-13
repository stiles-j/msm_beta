<?php
/*
Add volunteering script for Space Manager
Last Updated: 2016/05/16
Author: Justice Stiles
Description:  This script should be called to add a volunteering event to a member's profile in the database.  The script expects to recieve a member ID number, a date and a string containing the descritpion of the volunteering event via post.  
*/

require_once "dbManager.php";
require_once "PopUpManager.php";

//grab variables from the post array
$db = new dbManager;
$data = json_decode($_POST['eventData'], true);
$type = $data['type'];
$referenceNumber = $data['referenceNumber'];
$memberID = $_POST['memberID'];


//First check if we have a blank event name or are attempting to do an insert on an invalid member id
$memberName = $db->getUsername($memberID);
if ($memberID == 0 || !$memberName || $memberName == '')
{
  $popup = new PopUpManager;
  $content = "<h2>Attempted to add volunteering to an invalid member number.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();
}
if ($referenceNumber == '' || !$referenceNumber)
{
  $popup = new PopUpManager;
  $content = "<h2>Invalid volunteering event entered.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();  
}

/*attempt the insert.  If it fails, give the user an error message.  If it succeeds, redirect and display the profile with the updated volunteering*/

$success = false;
if ($type == 'CLASS') {
  $success = $db->addClassVolunteer($memberID, $referenceNumber);
}
else if ($type == 'EVENT') {
  $success = $db->addEventVolunteer($memberID, $referenceNumber);
}

if (!$success)
{
  $popup = new PopUpManager;
  $content = "<h2>Error adding new volunteering event to the database.  Volunteering event not added.</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();  
}

header("Location: smTest.php?display_member=$memberID");
exit();





























?>
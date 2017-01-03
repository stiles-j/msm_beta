<?php
/*
Add cert script for SpaceManager
Date Last Modified: 2016-05-16
Author: Justice Stiles
Description:  This script should receive a member id number and a string containing a cert name via post.  The script will attempt to add this information to the database.  On success, the script will return to the main window with the new cert displayed, or give the user an error message via popup on failure.  
*/

require_once "dbManager.php";
require_once "PopUpManager.php";
$db = new dbManager;

//grab the variables out of the post array
$MemberNumber = $_POST['MemberNumber'];
$certName = $_POST['newCertName'];

//First check if we have a blank cert name or are attempting to do an insert on an invalid member id
$memberName = $db->getUsername($MemberNumber);
if ($MemberNumber == 0 || !$memberName || $memberName == '')
{
  $popup = new PopUpManager;
  $content = "<h2>Attempted to add a certification to an invalid member number.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();  
}
if ($certName == '' || !$certName)
{
  $popup = new PopUpManager;
  $content = "<h2>Invalid certification name entered.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();
}

/*Attempt the inserti.  If it fails, give the user an error message.  If it succeeds, redirect and display the profile with the updated certification*/

$success = $db->addCert($MemberNumber, $certName);

if (!$success)
{
  $popup = new PopUpManager;
  $content = "<h2>Error adding new certification to database.  Certification not added.</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();
}//end if !success

header("Location: smTest.php?display_member=$MemberNumber");
exit();

?>
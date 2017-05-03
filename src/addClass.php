<?php
/*
Add class script for SpaceManager
Date Last Modified: 2016-05-16
Author: Justice Stiles
Description: This script should receive a date, a string containing the name of the class taken and a member id number via post.  The Script will attempt to add the new record to the database.
*/

require_once "classes/dbManager.php";
require_once "classes/PopUpManager.php";
$db = new dbManager;

//grab variables out of the post array
$MemberNumber = $_POST['MemberNumber'];
$date = $_POST['DateTaken'];
$className = $_POST['ClassName'];

//First check if we have a blank class name or are attempting to do an insert on an invalid member id
$memberName = $db->getUsername($MemberNumber);
if ($MemberNumber == 0 || !$memberName || $memberName == '')
{
  $popup = new PopUpManager;
  $content = "<h2>Attempted to add a class to an invalid member number.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();
}
if ($className == '' || !$className)
{
  $popup = new PopUpManager;
  $content = "<h2>Invalid class name entered.  Record not added.</h2>";
  $popup->createPopUp($content, "Error");
  exit();
}


/*attempt the insert.  if it fails, give the user an error message.  If it succeeds, redirect and display the profile with the updated class.*/  
$success = $db->addClassTaken($MemberNumber, $className, $date);

if (!$success)
{
  $popup = new PopUpManager;
  $content = "<h2>Error adding new class.  Class not added.</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();
}//end if !$success

header("Location: smTest.php?display_member=$MemberNumber");
exit();

?>
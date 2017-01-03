<?php
/*
Add donation script for SpaceManager
Last Updated: 2016/05/16
Author: Justice Stiles
Description:  This script should be called to add a new donation to the database.  No HTML is sent from this script, as a post/redirect/get is used.  
*/

require_once "dbManager.php";
require_once "PopUpManager.php";

$db = new dbManager;
$amount = $_POST['donationAmount'];
$MemberNumber = intval($_POST['MemberNumber']);

//verify we have a valid amount, give the user an error if not
if ($amount == 0 || !is_numeric($amount))
{
  $popup = new PopUpManager;
  $content = "<h2>Invalid donation amount.  Donation not added</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();
}

//attempt insert into db
$success = $db->addDonation($MemberNumber, $amount);

if (!$success)
{
  $popup = new PopUpManager;
  $content = "<h2>Error adding donation.  Donation not added</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();
}

//redirect and display the member profile with the newly added donation
header("Location: smTest.php?display_member=$MemberNumber");

?>
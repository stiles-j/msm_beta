<?php
/*
Add donation script for MakerSpaceManager
Last Updated: 2017/01/14
Author: Justice Stiles
Description:  This script should be called to add a new payment to the database.  No HTML is sent from this script if there are no errors adding the payment, as a post/redirect/get is used.  
*/

require_once "dbManager.php";
require_once "PopUpManager.php";

$db = new dbManager;
$amount = $_POST['paymentAmount'];
$MemberID = intval($_POST['MemberID']);
$reason = $_POST['reason'];
$paymentNote = NULL;
if (isset($_POST['paymentNote']))
  $paymentNote = $_POST['paymentNote'];

//verify we have a valid amount, give the user an error if not
if ($amount == 0 || !is_numeric($amount))
{
  $popup = new PopUpManager;
  $content = "<h2>Invalid payment amount.  Payment not added</h2>";
  $popup->createPopUp($content, "Error");
  exit();
}

//attempt insert into db
$success = $db->addPayment($MemberID, $amount, $reason);

if (!$success)
{
  $popup = new PopUpManager;
  $content = "<h2>Error adding payment.  Payment not added</h2>";
  
  $popup->createPopUp($content, "Error");
  exit();
}

//redirect and display the member profile with the newly added donation
header("Location: smTest.php?display_member=$MemberID");

?>
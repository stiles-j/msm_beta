<?php
/*
addPayment script for MakerSpaceManager
Last Updated: 2017/01/15
Author: Justice Stiles
Description:  This script should be called to add a new payment to the database.  No HTML is sent from this script if there are no errors adding the payment, as a post/redirect/get is used.  
*/

require_once "classes/UserManager.php";
require_once "classes/dbManager.php";

/*---Grab Post Data----------------------------------------------------*/

$db = new dbManager;
$amount = $_POST['paymentAmount'];
$memberID = intval($_POST['MemberID']);
$reason = $_POST['reason'];
$paymentNote = NULL;
if (isset($_POST['paymentNote']))
  $paymentNote = $_POST['paymentNote'];
$referenceNumber = NULL;
if (isset($_POST['referenceNumber']))
  $referenceNumber = $_POST['referenceNumber'];


/*-----------------Handle Payment Insert-------------------------------*/

//verify we have a valid amount, give the user an error if not
if (!is_numeric($amount))
{
  $popup = new UserManager();
  $content = "<h2>Invalid payment amount.  Payment not added</h2>";
  $popup->displayProfile($memberID);
  $popup->displayPopUp($content, "Error", 'smTest.php');
  exit();
}

//attempt insert into db
$success = $db->addPayment($memberID, $amount, $reason);

if (!$success)
{
  $popup = new UserManager();
  $content = "<h2>Error adding payment.  Payment not added</h2>";
  $popup->displayProfile($memberID);
  $popup->displayPopUp($content, "Error", 'smTest.php');
  exit();
}


/*-------------Handle Ancillary Effects of Payment--------------------*/

/*If this was a payment for a class or event, add the enrollment*/
if ($reason == "class"){
  addEnrollment($memberID, $referenceNumber, $db, "class");
}
if ($reason == "event") {
  addEnrollment($memberID, $referenceNumber, $db, "event");
}

/*If we have an "other" payment, add the payment note to the member's notes*/

//Only add the note if there is something to add
if ($reason == 'other' && isset($paymentNote)) {
  addPaymentNote($memberID, $paymentNote, $db);
}

/*-------------------------Finish--------------------------------------*/

//redirect and display the member profile with the newly added donation
header("Location: smTest.php?display_member=$memberID");



/*-------------------Here There Be Functions----------------------------*/

/*Function addEnrollment must be called immidately after a payment for a class or event is added so the payment data can be captured properly*/
function addEnrollment($memberID, $referenceNumber, $db, $type) {
  $payment = $db->getLastPayment($memberID);
  $paymentReferenceNumber = $payment['PaymentReferenceNumber'];
  
  if ($type == 'class'){
    $db->addClassEnrollment($memberID, $referenceNumber, $paymentReferenceNumber);
  } //end if class
  
  if ($type == 'event') {
    $db->addEventEnrollment($memberID, $referenceNumber, $paymentReferenceNumber);
  }//end if event
  
} //end addEnrollment


function addPaymentNote($memberID, $noteText, $db) {
  //Get the payment reference number
  $payment = $db->getLastPayment($memberID);
  $paymentReferenceNumber = $payment['PaymentReferenceNumber'];
  $noteText = "regarding payment $paymentReferenceNumber: " . $noteText;
  $db->recordNote($memberID, $noteText);
}


function logError($message) {
  ini_set("log_errors", 1);
  ini_set("error_log", "php-error.log");
  error_log($message);
}

?>

























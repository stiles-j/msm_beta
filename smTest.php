<?php
//Test harness for the SpaceManager program 

require_once 'UserManager.php';
require_once 'loginManager.php';
require_once 'dbManager.php';

/*TODO: All code containing HTML fragments needs to be devolved to the UserManager.php class.  This script should contain NO display code*/

/*LOGIN HANDLING SECTION__________________________________________________*/

/*valid is used to record if we got a bogus login so it can be dealt with properly.
The value defaults to true so that if the login code in the "if" block below is skipped,
the warning pop up does not appear*/
$valid = 1;

//if this is a login/logout process and redirect
if (isset($_POST['LoginMemberNumber']))
{
  $lm = new loginManager;
  $valid = $lm->login($_POST['LoginMemberNumber']);
  if ($valid == 1)
  {
    header("Location: " . $_SERVER['REQUEST_URI'] . "?display_member=$_POST[LoginMemberNumber]");
    exit();
  }//end if valid == 1

  if ($valid == 2) {
    header("Location: " . $_SERVER['REQUEST_URI'] . "?display_member=$_POST[LoginMemberNumber]&logout=true");
    exit();
  }
}//end if LoginMemberNumber


/*NOTE ADD SECTION__________________________________________*/
/*If a new note is being sent to us, add it to the database*/
if (isset($_POST['noteContent']))
{
  $memNum = $_POST['display_member'];
  $noteCont = $_POST['noteContent'];
  
  //if we got a blank note, or a note for the default profile just ignore it
  if ($noteCont == "" || $memNum == 0)
  {
    header("Location: " . $_SERVER['REQUEST_URI'] . "?display_member=$memNum");
    exit();
  }
  
  //Otherwise instantiate a new dbManager and use it to add the note, then redirect
  $db = new dbManager;
  $db->recordNote($memNum, $noteCont);
  
  header("Location: " . $_SERVER['REQUEST_URI'] . "?display_member=$memNum");
  exit();

}//end if noteContent


$um = new UserManager;

//check if we just had an invalid login attempt, and if so, give the user a warning
if (!$valid)
{
  $um->displayPopUp("Invalid User Number Entered", "Warning!");
}



/*Spawn Login Window Section___________________________________________*/
if (isset($_POST['spawnLogin']))
{
  $content = "Member ID Number:
<input type='text' name='LoginMemberNumber' autofocus />";
  
  $um->displayPopUp($content, "Member Login", 'smTest.php');
}//end if spawnLogin



/*New Member Entry Handling Section_________________________*/
if (isset($_POST['AddNewMember']))
{
  $nuForm = file_get_contents('newUserForm.html');
  $um->displayWin($nuForm);
  exit();
}//end if AddNewMember


/*Edit Member Section__________________________________________________*/

/*Check if the user clicked edit member from the members drop-down menu and spawn a pop-up window to get the member number if they did*/
if (isset($_POST['editMember']))
{
  $content = "Member ID Number:
<input type='text' name='editMemberNumber' autofocus />";
  
  $um->displayPopUp($content, "Edit Member");
}//end if editMember

/*Check if we have received a member number already for the edit member request, and if so, spawn the full edit member window*/
if (isset($_POST['editMemberNumber']))
{
  $um->editMember($_POST['editMemberNumber']);
  exit();
}
  

/*Quick Reports Section (View All x)___________________________________*/

//View all notes
if (isset($_POST['viewAllNotes']))
{
  $MemberNumber = $_POST['viewAllNotes'];
  $um->showAllNotes($MemberNumber);
  exit();
}//end if viewAllNotes

//View all enrollments
if (isset($_POST['viewAllEnrollments'])) {
  $memberID = $_POST['viewAllEnrollments'];
  $um->showAllEnrollments($memberID);
  //exit();
}

//Add Payment
if (isset($_POST['addPayment']))
{
  $memberID = $_POST['addPayment'];
  $um->addPayment($memberID);
}


//Add volunteering
if (isset($_POST['addVolunteering']))
{
  //grab the member ID number to be used in the form
  $memberID = $_POST['addVolunteering'];
  $um->addVolunteering($memberID);
}

//Add Certification
if (isset($_POST['addCert']))
{
  $memberID = $_POST['addCert'];
  $um->addCert($memberID);
}

//view dues payments
if (isset($_POST['showDuesPayments'])) {
  $memberID = $_POST['showDuesPayments'];
  $um->displayMemberDuesPayments($memberID);
}

//view non-dues payments
if (isset($_POST['showOtherPayments'])) {
  $memberID = $_POST['showOtherPayments'];
  $um->displayMemberOtherPayments($memberID);
}

/*FIND MEMBER SECTION__________________________________________________*/

/*If we get a findMember request, spawn a popup to get the members first and last name*/
if (isset($_POST['findMember']))
{
  $content = "First Name:
              <input type='text' name='firstName' autofocus>
              Last Name:
              <input type='text' name='lastName'>
              <input type='hidden' name='memberSearch'>";
  $um->displayPopUp($content, "Find Member", "findMember.php");
}

/*Once the popup returns with the search criteria, run the search and display the results.*/
if (isset($_GET['memberSearch']))
{
  //grab the variables from the post array
  $firstName = $_GET['firstName'];
  $lastName = $_GET['lastName'];
  
  //perform the search and output the results
  $um->memberSearch($firstName, $lastName);
  exit();
}

/*PROFILE DISPLAY HANDLING SECTION_____________________________________*/

/*memberID will cache the memberID of the currently displayed profile for use in other areas of the program*/
$memberID = null;

//start the session if it hasn't been already, we need it
if (session_status() == PHP_SESSION_NONE) session_start();

if (isset($_POST['display_member'])) $memberID = $_POST['display_member'];
else if (isset($_GET['display_member'])) $memberID = $_GET['display_member'];
if (isset($_GET['logout'])) {
  $db = new dbManager();
  $userName = $db->getUsername($memberID);
  $content = "<h2>$userName</h2> <h2>is now logged out</h2>";
  $um->displayPopUp($content, "Logout Successful", 'smTest.php');
}

//if we have a bogus memberID display the most recently logged in member, or if there are none, the default profile
if ($memberID == '' || $memberID == null || $memberID == ' ' || !$memberID) {

  //check if there are any current users
  if(isset($_SESSION['current_users']) && count($_SESSION['current_users']) != 0)
  {
    $memberID = $_SESSION['lastMemberDisplayed'];
    $um->displayProfile($memberID);

  }//end if current_users
  //if we have no users logged in, display the dummy profile
  else
  {
    $um->displayDefaultProfile();
  }
} //end if bogus memberID
//otherwise display the profile
else {
  //Record the last member displayed in the session array
  $_SESSION['lastMemberDisplayed'] = $memberID;
  $um->displayProfile($memberID);
} //end else

/*NOTE ENTRY SECTION___________________________________________________*/

/*If we received a request to add a new note, spawn a note entry window*/
if (isset($_POST['noteAdd']))
{
  $windowContent = "<textarea id='noteContent' name='noteContent' autofocus></textarea><input type='hidden' name='display_member' value='$memberID' />";
  
  $um->displayPopUp($windowContent, "Enter New Member Note");
}//end if noteAdd

/*EDIT COURSE SECTION________________________________________________________*/
if (isset($_POST['editCourse'])) {
  $um->getCourseToEdit();
}

/*ADD NEW CLASS SECTION______________________________________________________*/
if (isset($_POST['AddNewClass'])) {
  $um->addNewClass();
}

/*EDIT CLASS SECTION_________________________________________________________*/
if (isset($_POST['EditClass'])) {
  $um->editClass();
}

//session_destroy();

  
?>
<?php
//Test harness for the SpaceManager program 

require_once 'UserManager.php';
require_once 'loginManager.php';


/*LOGIN HANDLING SECTION__________________________________________________*/

/*valid is used to record if we got a bogus login so it can be dealt with properly.  The value defaults to true so that if the login code in the "if" block below is skipped, the warning pop up does not appear*/
$valid = 1;

//if this is a login/logout process and redirect
if (isset($_POST['LoginMemberNumber']))
{
  $lm = new loginManager;
  $valid = $lm->login($_POST['LoginMemberNumber']);
  if ($valid)
  {
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
  }//end if valid
}//end if LoginMemberNumber


/*NOTE ADD SECTION__________________________________________*/
/*If a new note is being sent to us, add it to the database*/
if (isset($_POST['noteContent']))
{
  require_once 'dbManager.php';
  
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
  $um->displayPopUp("<h2>Invalid User Number Entered</h2>", "Warning!");
}



/*Spawn Login Window Section___________________________________________*/
if (isset($_POST['spawnLogin']))
{
  $content = "<h2>Member ID Number: </h2>
<input type='text' name='LoginMemberNumber' autofocus />";
  
  $um->displayPopUp($content, "Member Login");
}//end if spawnLogin



/*New Meber Entry Handling Section_________________________*/
if (isset($_POST['AddNewMember']))
{
  $nuForm = file_get_contents('newUserForm.html');
  $um->displayWin($nuForm);
  exit();
}//end if AddNewMember


/*Edit Member Section__________________________________________________*/

/*Check if the user cliked edit member from the members dropdown menu and spawn a pop-up window to get the member number if they did*/
if (isset($_POST['editMember']))
{
  $content = "<h2>Member ID Number: </h2>
<input type='text' name='editMemberNumber' autofocus />";
  
  $um->displayPopUp($content, "Edit Member");
}//end if editMember

/*Check if we have recieved a member number already for the edit member request, and if so, spawn the full edit member window*/
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

//Add donation
if (isset($_POST['addDonation']))
{
  $MemberID = $_POST['addDonation'];
  $content = "<h2>Select Payment Type:<h2>
<select id='paymentType' autofocus>
  <option selected disabled hidden>Payment Type</option>
  <option value='classEnrollment'>Class Enrollment</option>
  <option value='eventEnrollment'>Event Enrollment</option>
  <option value='dues'>Dues</option>
  <option value='donation'>Donation</option>
  <option value='merchandise'>Merchandise</option>
  <option value='other'>Other Payment</option>
</select>
<script src='paymentSlider.js'></script>
<div id='slideContent'></div>
<input type='hidden' name='MemberID' id='MemberID' value='$MemberID' />";
  $um->displayPopUp($content, "Add Payment", "addPayment.php");  
}

//Add class
if (isset($_POST['addClass']))
{
  //grab the member ID number to be used in the form
  $MemberNumber = $_POST['addClass'];
  //get todays date to fill in as the default date
  $date = date("Y-m-d");
  $content = "<h2>Date class Completed:</h2>
              <input type='date' class='dateBox' name='DateTaken' value='$date'>
              <h2>Class Name:</h2>
              <input type='text' name='ClassName' autofocus>
              <input type='hidden' name='MemberNumber' value='$MemberNumber'>";
  //Spawn the pop-up window to get user input
  $um->displayPopUp($content, "Add New Class", "addClass.php");
}

//Add volunteering
if (isset($_POST['addVolunteering']))
{
  //grab the member ID number to be used in the form
  $MemberNumber = $_POST['addVolunteering'];
  //get todays date to fill in as the default date
  $date = date("Y-m-d");
  //generate the content for the add volunteering popup
  $content ="<h2>Date of volunteering:</h2>
              <input type='date' class='dateBox' name='volunteerDate' value='$date'>
              <h2>Volunteering event:</h2>
              <input type='text' name='volunteeringEvent' autofocus>
              <input type='hidden' name='MemberNumber' value='$MemberNumber'>";
  //spawn the popup window to get user input
  $um->displayPopUp($content, "Add Volunteering", "addVolunteering.php");
  
}

//Add Certification
if (isset($_POST['addCert']))
{
  //grab the member ID to be used in the form
  $MemberNumber = $_POST['addCert'];
  //generate teh contente for the add cert popup
  $content = "<h2>New Certification:</h2>
              <input type='text' name='newCertName' autofocus>
              <input type='hidden' name='MemberNumber' value='$MemberNumber'>";
  //spawn the popup window to get user input
  $um->displayPopUp($content, "Add Certification", "addCert.php");
}


/*FIND MEMBER SECTION__________________________________________________*/

/*If we get a findMember request, spawn a popup to get the members first and last name*/
if (isset($_POST['findMember']))
{
  $content = "<h2>First Name:</h2>
              <input type='text' name='firstName' autofocus>
              <h2>Last Name:</h2>
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

/*MemberNumber will cache the member id of the currently displayed profile for use in other areas of the program*/
$MemberNumber;

//if this is a display request, display the selected profile.  First check the POST array
if(isset($_POST['display_member']))
{
    $MemberNumber = $_POST['display_member'];
  
    if (!$_SESSION) session_start();
    //Record the last memeber displayed in the session array
    $_SESSION['lastMemberDisplayed'] = $MemberNumber;  

    $um->displayProfile($MemberNumber);
}//end if POST display_member
//Next check the GET array in case the display request came from a redirect
else if(isset($_GET['display_member']))
{
  $MemberNumber = $_GET['display_member'];
  
  if (!$_SESSION) session_start();
  //Record the last memeber displayed in the session array
  $_SESSION['lastMemberDisplayed'] = $MemberNumber;
  
  $um->displayProfile($MemberNumber);
}//end else if GET display_member
//otherwise display the most recently logged in member
else
{
  //check if there are any current users
  if(isset($_SESSION['current_users']))
  {
    $MemberNumber = end($_SESSION['current_users']);
    $um->displayProfile($MemberNumber);    
  }//end if current_users
  //if we have no users logged in, display the dummy profile
  else
  {
    $MemberNumber = null;
    $um->displayProfile($MemberNumber);
  }
  

  
}//end else


/*NOTE ENTRY SECTION___________________________________________________*/

/*If we recieved a request to add a new note, spawn a note entry window*/
if (isset($_POST['noteAdd']))
{
  $windowContent = "<textarea id='noteContent' name='noteContent' autofocus></textarea><input type='hidden' name='display_member' value='$MemberNumber' />";
  
  $um->displayPopUp($windowContent, "Enter New Member Note");
}//end if noteAdd

//session_destroy();

  
?>
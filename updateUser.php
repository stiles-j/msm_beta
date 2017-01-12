<?php
/*Script to handle updating member data*/

require_once "dbManager.php";
require_once "PopUpManager.php";

$db = new dbManager; 

$MemberNumber = $_POST['MemberNumber'];

/*Image handling section____________________________________*/

/*If a valid image file is set, move it to the internal storage, otherwise, skip to the rest of the member update processing.*/

if ($_FILES["picture"]["size"] > 0)
{ 
  $target_dir = "images/";
  $uploadOk = 1;
  $imageFileType = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
  $target_file = $target_dir . $MemberNumber . "." . $imageFileType;

  //Check if image file is an actual image or a fake image
  if (isset($_POST["submit"]))
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
  if ($check !== false)
    $uploadOk = 1;
  else
    $uploadOk = 0;

  //check file size
  if ($_FILES["picture"]["size"] > 2000000)
  {
    /*TODO: Logging this error may need to be removed after the beta period.*/
    logError("Filesize too large; image upload from updateUser.php prohibited. Attempted upload size is: " . $_FILES["picture"]["size"]);
    
    $popUp = new PopUpManager;
    $content = "<h2>Sorry, your image file is too large.  Max size is 2mb</h2>";
    $popUp->createPopUp($content, "Error");
    $uploadOk = 0;
    exit();
  }

  //Limit file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
  {
    $popUp = new PopUpManager; 
    $content = "<h2>Sorry, only .jpg, .jpeg, .png and .gif files are allowed as profile images </h2>";
  
    $popUp->createPopUp($content, "Error");
    $uploadOk = 0;
    exit();
  }

  //Check if $uploadOk is set to 0 by an error if everything is okay, try to upload the file
  if ($uploadOk == 1)
  {
    /*if the move fails, give the user an error message*/
    if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file))
    {
      $popUp = new PopUpManager;
      $content = "<h2>Sorry, there was an error uploading your image file.</h2>";
      $popUp->createPopUp($content, "Error");
      exit();
    }//end else
  }//end if uploadOk

}//end if picture
else $target_file = "images/default.jpg";
  


/*Add data to user database_________________________________*/

/*Grab all the submitted information from the $_POST array, and store it for use in the SQL insert*/

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$birthDate = $_POST['birthDate'];
$streetAddress = $_POST['streetAddress'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$homePhone = $_POST['homePhone'];
$cellPhone = $_POST['cellPhone'];
$email = $_POST['Email'];
$eContact = $_POST['emergencyContact'];
$referredBy = $_POST['referredBy'];
$membershipType = $_POST['membershipType'];
$userImage = $target_file;


/*Check if any required fields are blank and give the user an error message if they are*/
if($firstName == '' || $lastName == '' || $birthDate == '' || $email == '' || $eContact == '')
{
  $popUp = new PopUpManager;
  $content = "<h2>Required field left blank.  Please re-enter information</h2>";
  $popUp->createPopUp($content, "Missing Information");
  exit();
}


/*If we have everything we need, create the sql query and add the new record to the database.*/

/*If we got a valid image as an update, first update the image path in the database*/

if ($userImage != "images/default.jpg")
{
  //attempt to update the image path, to the new image
  $result = $db->updatePicture($userImage, $MemberNumber);
  
  //if the update fails, give the user an error message
  if (!$result)
  {
    $popUp = new PopUpManager;
    $content = "<h2>Error updating image.  Member not updated.</h2>";
    $popUp->createPopUp($content, "Image Update Error");
  }
}//end if userImage

$profileData = array();

array_push($profileData, $MemberNumber, $firstName, $lastName, $birthDate, $streetAddress, $city, $state, $zip, $homePhone, $cellPhone, $email, $eContact, $referredBy, $membershipType);

/*submit the profile and check for a valid insert*/
$result = $db->updateProfile($profileData);

if (!$result)
{
  $popUp = new PopUpManager;
  $content = "<h2>Error on updating member record.  Member Not updated</h2>";
  $popUp->createPopUp($content, "Profile Update Error");
}
/*If we got a good insert, return to the main screen and display the new member  profile*/
else
{
    header("Location: " . 'smTest.php' . "?display_member=$MemberNumber");
    exit();
}

//TODO: This function may need to be removed after the beta period
function logError($message) {
      ini_set("log_errors", 1);
      ini_set("error_log", "php-error.log");
      error_log($message);
  } //end function logError




















  
  

?>
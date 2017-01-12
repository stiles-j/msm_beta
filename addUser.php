<?php
/*Script to handle upload of data from the new user form*/

require_once "dbManager.php";
require_once "PopUpManager.php";

/*get new user id number*/
$db = new dbManager;
$MemberID = $db->getNewUserId();


/*Image handling section____________________________________*/

/*If a valid image file is set, move it to the internal storage, otherwise, skip to the rest of the new user processing.*/

if ($_FILES["picture"]["size"] > 0)
{
  $target_dir = "images/";
  $uploadOk = 1;
  $imageFileType = pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION);
  $target_file = $target_dir . $MemberID . "." . $imageFileType;

  //Check if image file is an actual image or a fake image
  if (isset($_POST["submit"]))
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
  if ($check !== false)
    $uploadOk = 1;
  else
    $uploadOk = 0;

  //Check if file already exists
  if (file_exists($target_file))
  {
    $popUp = new PopUpManager;
    $content = "<h2>Sorry, the image file already exists.</h2>";
    $popUp->createPopUp($content, "Error");
    $uploadOk = 0;
    exit();
  }

  //check file size
  if ($_FILES["picture"]["size"] > 2000000)
  {
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
//$joinDate = date("Y-m-d");
$streetAddress = $_POST['streetAddress'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$homePhone = $_POST['homePhone'];
$cellPhone = $_POST['cellPhone'];
$email = $_POST['Email'];
$eContact = $_POST['emergencyContact'];
$referredBy = $_POST['referredBy'];
$memberId = intval($MemberID);
$userImage = $target_file;
$level = $_POST['level'];


/*Check if any required fields are blank and give the user an error message if they are*/
if($firstName == '' || $lastName == '' || $birthDate == '' || $email == '' || $eContact == '')
{
  $popUp = new PopUpManager;
  $content = "<h2>Required field left blank.  Please re-enter information</h2>";
  $popUp->createPopUp($content, "Missing Information");
  exit();
}


/*If we have everything we need, create the sql query and add the new record to the database.*/

$profileData = array();

array_push($profileData, $firstName, $lastName, $birthDate, $streetAddress, $city, $state, $zip, $homePhone, $cellPhone, $email, $eContact, $referredBy, $userImage, $level, $MemberID);

/*submit the profile and check for a valid insert*/
$result = $db->addProfile($profileData);

/*TODO: This section currently provides some useful debugging information in the error window that pops up.  This will continue to be the case through the beta period, but the debugging info should be removed once the beta is complete.*/
if (!$result)
{
  //Delete the uploaded image if any
  if ($_FILES["picture"]["size"] > 0) {
    unlink($target_file);
  }
  
  //Capture user inputs for debugging purposes
  $dataString = "";
  foreach ($profileData as $dataPoint) 
  {
    $dataString = $dataString . " " . $dataPoint. ";";
  }
  
  $dataString = $dataString . "<p>Result returned from the database was:" . $result . "</p>";
    
  //display the error
  $popUp = new PopUpManager;
  $content = "<h2>Error on inserting new member record.  Member Not added</h2> <p>Supplied data: $dataString";
  $popUp->createPopUp($content, "Profile Creation Error");
}

/*If we got a good insert, return to the main screen and display the new member  profile*/
else
{
    header("Location: " . 'smTest.php' . "?display_member=$MemberID");
    exit();
}






















  
  

?>
<?php
/**
 * Created by PhpStorm.
 * User: justice
 * Date: 2/4/17
 * Time: 5:14 PM
 */

require_once 'dbManager.php';
require_once 'OutputManager.php';

$db = new dbManager();
$certName = $_POST['certName'];
$description = 'NULL';
if (isset($_POST['description']) && $_POST['description'] != '') $description = $_POST['description'];

$result = $db->addNewCert($certName, $description);

if (!$result) {
  $om = new OutputManager();
  $content = "Error adding new certification.  New cert not added.";
  $om->insertPopUp($content, "ERROR", "smTest.php");
  exit();
}

//all done so redirect back to the main page
header("Location: smTest.php");

?>
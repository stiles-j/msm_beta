<?php
/*find member script for SpaceManager*/

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

header("Location: smTest.php?memberSearch=true&firstName=$firstName&lastName=$lastName");

?>
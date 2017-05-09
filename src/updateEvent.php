<?php


require_once "classes/dbManager.php";
require_once "classes/PopUpManager.php";

$db = new dbManager();
$duration = $_POST['hours'] . ":" . $_POST['minutes'] . ":00";


?>
<?php
/**
 * User: justice
 * Date: 2/4/17
 * Time: 3:07 PM
 */

require_once 'classes/InterfaceManager.php';
$um = new InterfaceManager();

$content = file_get_contents("certAdd.html");
$um->displayWin($content);



?>
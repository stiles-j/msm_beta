<?php
/**
 * User: justice
 * Date: 2/4/17
 * Time: 3:07 PM
 */

require_once 'classes/UserManager.php';
$um = new UserManager();

$content = file_get_contents("certAdd.html");
$um->displayWin($content);



?>
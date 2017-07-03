<?php

$root = $_SERVER['DOCUMENT_ROOT'];

require_once "$root/src/classes/ReportManager.php";
require_once "$root/src/classes/InterfaceManager.php";

$rm = new ReportManager();

$classes = $rm->getPriorClasses($_POST['startDate'], $_POST['endDate']);
$attendance = $rm->classAttendanceByDateRange($_POST['startDate'], $_POST['endDate']);

if (!$classes) {
  $content = "<h2>No Classes For Specified Date Range</h2>";
  $im = new InterfaceManager();
  $im->displayWin($content);
  exit();
}


?>
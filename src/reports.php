<?php

require_once "classes/InterfaceManager.php";

$im = new InterfaceManager();

$content = <<<END
<script src="js/reportSlider.js"></script>
<div class="userInputFields">
  <h1>Reports</h1>
  <div class="reportContainer">
    <h2 class="reportCategoryLabel">Attendance Reports</h2>
    <div class="reportNamesContainer">

      <form name="classesByAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Classes by Attendance</h3>
        <div class="reportInputs">
          <p><span class="label">Start Date: </span><input type="date" name="startDate"></p>
          <p><span class="label">End Date: </span><input type="date" name="endDate"></p>
          <input type="submit" class="reportSubmit">
          <input type="hidden" name="reportType" value="classesByAttendance" />
        </div>
      </form>

      <form name="eventsByAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Events by Attendance</h3>
        <div class="reportInputs">
          <p><span class="label">Start Date: </span><input type="date" name="startDate"></p>
          <p><span class="label">End Date: </span><input type="date" name="endDate"></p>
          <input type="submit" class="reportSubmit">
          <input type="hidden" name="reportType" value="eventsByAttendance" />
        </div>
      </form>

      <form name="specificClassAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Specific Class Attendance</h3>
          <div class="reportInputs">
          <script src='js/classSelect.js'></script>
          <p>Show Classes in Timeframe:</p>
          <p><span class="label">Start Date: </span><input type="date" name="startDate"></p>
          <p><span class="label">End Date: </span><input type="date" name="endDate"></p>
          <div name='classSelect' id='classSelect'>
          
          </div>
          <input type="submit" class="reportSubmit">
          <input type="hidden" name="reportType" value="specificClassAttendance" />
        </div>
      </form>

      <h3 class="reportName">Specific Event Attendance</h3>


      <h3 class="reportName">Total Attendance by Date Range</h3>


    </div>

    <h2 class="reportCategoryLabel">Class Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Upcoming Classes</h3>
      <h3 class="reportName">Class Roster</h3>
      <h3 class="reportName">Class Attendance</h3>
    </div>

    <h2 class="reportCategoryLabel">Credential Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">All Credentials</h3>
      <h3 class="reportName">Credentials by Member</h3>
      <h3 class="reportName">Specific Member Credentials</h3>
    </div>

    <h2 class="reportCategoryLabel">Event Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Upcoming Events</h3>
      <h3 class="reportName">Event Roster</h3>
      <h3 class="reportName">Event Attendance</h3>
    </div>

    <h2 class="reportCategoryLabel">Facility Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Facility List</h3>
      <h3 class="reportName">Usage by Facility</h3>
      <h3 class="reportName">Specific Facility Usage</h3>
    </div>

    <h2 class="reportCategoryLabel">Member Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Full Membership Roster</h3>
      <h3 class="reportName">Member Lookup</h3>
      <h3 class="reportName">Member Payments</h3>
      <h3 class="reportName">Member Credentials</h3>
      <h3 class="reportName">Member Volunteering History</h3>
      <h3 class="reportName">Member Usage History</h3>
      <h3 class="reportName">Member Class History</h3>
      <h3 class="reportName">Member Event History</h3>
    </div>

    <h2 class="reportCategoryLabel">Revenue Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Classes by Revenue</h3>
      <h3 class="reportName">Events by Revenue</h3>
      <h3 class="reportName">Revenue by Date</h3>
      <h3 class="reportName">Specific Class Revenue</h3>
      <h3 class="reportName">Specific Event Revenue</h3>
      <h3 class="reportName">Total Revenue by Date Range</h3>
    </div>

    <h2 class="reportCategoryLabel">Volunteering Reports</h2>
    <div class="reportNamesContainer">
      <h3 class="reportName">Volunteering by Date Range</h3>
      <h3 class="reportName">Volunteering by Specific Event</h3>
      <h3 class="reportName">Volunteering by Member</h3>
    </div>

  </div>
</div>

END;

$im->displayWin($content);


?>
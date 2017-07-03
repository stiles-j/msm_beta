<?php

require_once "classes/InterfaceManager.php";
require_once "classes/ReportManager.php";
require_once "classes/dbManager.php";

$im = new InterfaceManager();
$rm = new ReportManager();
$db = new dbManager();

$timeframeInput = <<<END
  <p><span class="label">Timeframe to Report:</span></p>
  <p><span class="label">Start Date: </span><input type="date" name="startDate"></p>
  <p><span class="label">End Date: </span><input type="date" name="endDate"></p>
  <input type="submit" class="reportSubmit">
END;

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
          $timeframeInput
          <input type="hidden" name="reportType" value="classesByAttendance" />
        </div>
      </form>

      <form name="eventsByAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Events by Attendance</h3>
        <div class="reportInputs">
          $timeframeInput
          <input type="hidden" name="reportType" value="eventsByAttendance" />
        </div>
      </form>

      <form name="specificClassAttendance" id="specificClassAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Specific Class Attendance</h3>
        <div class="reportInputs">
          <script src='js/specificClassAttendanceSelect.js'></script>
          <p>Show Classes in Timeframe:</p>
          <p><span class="label">Start Date: </span><input type="date" name="startDate" id='classAttendanceStartDate'></p>
          <p><span class="label">End Date: </span><input type="date" name="endDate" id="classAttendanceEndDate"></p>
          <div name='classSelect' id='classSelect'>

          </div>

          <input type="hidden" name="reportType" value="specificClassAttendance" />
          <input type="hidden" name="class" value="class">
        </div>
      </form>
      <form name="specificEventAttendance" id="specificEventAttendance" action="getReport.php" method="post">
        <h3 class="reportName">Specific Event Attendance</h3>
        <div class="reportInputs">
          <script src='js/eventSelect.js'></script>
          <p>Show Events in Time-frame:</p>
          <p><span class="label">Start Date: </span><input type="date" name="startDate" id='eventAttendanceStartDate'></p>
          <p><span class="label">End Date: </span><input type="date" name="endDate" id="eventAttendanceEndDate"></p>
          <div name='eventSelect' id='eventSelect'>
          </div>
          <input type="hidden" name="reportType" value="specificEventAttendance" />
          <input type="hidden" name="event" value="event">
        </div>
      </form>

      <form name="totalAttendanceByDateRange" id="totalAttendanceByDateRange" action="getReport.php" method="post">
        <h3 class="reportName">Total Attendance by Date Range</h3>
        <div class="reportInputs">
          $timeframeInput
          <input type="hidden" name="reportType" value="totalAttendanceByDateRange" />
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Class Reports</h2>
    <div class="reportNamesContainer">
      <form name="upcomingClasses" id="upcomingClasses" action="getReport.php" method="post">
        <h3 class="reportName">Upcoming Classes</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="upcomingClasses" />
          <p><input type="submit" class="reportSubmit" value="Get Class Schedule" /></p>
        </div>
      </form>
END;

$pendingClasses = $db->getPendingClasses();
$classSelect = "<select name='classes' id='classes' multiple='multiple'>";
foreach ($pendingClasses as $class) {
  $classSelect .= "<option value='$class[ReferenceNumber]'>$class[Name] on $class[Date]</option>";
}
$classSelect .= "</select>";

$content .= <<<END
        <form name="classRoster" id="classRoster" action="getReport.php" method="post">
        <h3 class="reportName">Class Roster</h3>
        <div class="reportInputs">
          <p><span class="label selectLabel">Classes to get roster for:</span></p>
          <div id="reportInputs">
          $classSelect
          <input type="submit" class="reportSubmit" />
          <input type="hidden" name="reportType" value="classRoster" />
          </div>
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Credential Reports</h2>
    <div class="reportNamesContainer">
      <form name="getAllCredentials" id="getAllCredentials" action="getReport.php" method="post">
        <h3 class="reportName">All Credentials</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="getAllCredentials" />
          <input type="submit" class="reportSubmit" value="Show Credentials" />
        </div>
      </form>
END;

//create and populate the select box with all the members
$memberList = $rm->getAllMembers();
$memberSelect = "<select name='memberSelect[]' id='memberSelect' multiple='multiple'>";
foreach ($memberList as $individual) {
  $memberSelect .= "<option value='$individual[MemberID]'>$individual[FirstName] $individual[LastName]</option>";
}
$memberSelect .= "</select>";

$content .= <<<END
      <form name="credentialsByMember" id="credentialsByMember" action="getReport.php" method="post">
        <h3 class="reportName">Credentials by Member</h3>
        <div class="reportInputs">
          <p><span class="label selectLabel">Members to Report Credentials For:</span></p>
          <div id="memberSelectArea">
            $memberSelect
          </div>
          <p><input type="submit" class="reportSubmit"></p>
          <input type="hidden" name="reportType" value="credentialsByMember" /> 
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Event Reports</h2>
    <div class="reportNamesContainer">
      <form name="upcomingEvents" id="upcomingEvents" action="getReport.php" method="post">
        <h3 class="reportName">Upcoming Events</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="upcomingEvents" />
          <input type="submit" value="Show Upcoming Events" class="reportSubmit" />
        </div>
      </form>
            
END;

$pendingEvents = $db->getPendingEvents();
$eventSelect = "<select name='eventSelect[]' id='eventSelect' multiple='multiple'>";
foreach ($pendingEvents as $pendingEvent) {
  $eventSelect .= "<option value='$pendingEvent[ReferenceNumber]'>$pendingEvent[Name] on $pendingEvent[Date]</option>";
}
$eventSelect .= "</select>";

$content .= <<<END
      <form name="eventRoster" id="eventRoster" action="getReport.php" method="post">
        <h3 class="reportName">Event Roster</h3>
        <div class="reportInputs">
          $eventSelect
          <input type='hidden' name="reportType" value='eventRoster' />
          <input type='submit' class='reportSubmit' />
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Facility Reports</h2>
    <div class="reportNamesContainer">
      <form name="facilityList" id="facilityList" action="getReport.php" method="post">
        <h3 class="reportName">Facility List</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="facilityList" />
          <input type="submit" class="reportSubmit" value="Get Facility List" />
        </div>
      </form>
END;

$facilityList = $db->getAllFacilities();
$facilitySelect = "<select name='facilitySelect[]' id='facilitySelect' multiple='multiple'>";
foreach ($facilityList as $facility){
  $facilitySelect .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
}
$facilitySelect .= "</option>";

$content .= <<<END
      <form name="usageByFacility" id="usageByFacility" action="getReport.php" method="post">
        <h3 class="reportName">Usage by Facility</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="usageByFacility" />
          <p><span class="label selectLabel">Facilities to Report:</span></p>
          $facilitySelect
          <input type="submit" class="reportSubmit" />
        </div>
      </form>

    </div>

    <h2 class="reportCategoryLabel">Member Reports</h2>
    <div class="reportNamesContainer">
      <form name="fullMembershipRoster" id="fullMembershipRoster" action="getReport.php" method="post">
        <h3 class="reportName">Full Membership Roster</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="fullMembershipRoster"  />
          <input type="submit" class="reportSubmit" value="Get Roster" />
        </div>
      </form>

      <form name="memberLookup" id="memberLookup" action="getReport.php" method="post">
        <h3 class="reportName">Member Lookup</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="memberLookup" />
          <p><span class="label">First Name:</span>
          <input type="text" name="firstName"></p>
          <p><span class="label">Last Name:</span>
          <input type="text" name="lastName"></p>
          <input type="submit" class="reportSubmit" />
        </div>
      </form>

      <form name="memberPayments" id="memberPayments" action="getReport.php" method="post">
      <h3 class="reportName">Member Payments</h3>
      <div class="reportInputs">
        <input type="hidden" name="reportType" value="memberPayments">
        <p><span class="label selectLabel">Members to Report Payments for:</span> </p>
        $memberSelect
        <input type="submit" class="reportSubmit" />
      </div>
      </form>

      <form name="memberUsageHistory" id="memberUsageHistory" action="getReport.php" method="post">
        <h3 class="reportName">Member Usage History</h3>
        <div class="reportInputs">
          <input type="hidden" name="reportType" value="memberUsageHistory" />
          <p><span class="label selectLabel">Members to Report Usage History for:</span></p>
          $memberSelect
          <input type="submit" class="reportSubmit" />
        </div>
      </form>
      
      <form name="memberClassHistory" id="memberClassHistory" action="getReport.php" method="post">
        <h3 class="reportName">Member Class History</h3>
        <div class="reportInputs">
          <p><span class="label selectLabel">Members to Get Class History For:</span></p>
          $memberSelect 
          <input type="hidden" name="reportType" value="memberClassHistory" />
          <input type="submit" class='reportSubmit' />
        </div>
      </form>

      <form name="memberEventHistory" id="memberEventHistory" action="getReport.php" method="post">
        <h3 class="reportName">Member Event History</h3>
        <div class="reportInputs">
          <p><span class="label selectLabel">Member to Get Event History For:</span></p>
          $memberSelect
          <input type="submit" class="reportSubmit">
          <input type="hidden" name="reportType" value="memberEventHistory" />
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Revenue Reports</h2>
    <div class="reportNamesContainer">

      <form name="classesByRevenue" id="classesByRevenue" action="getReport.php" method="post">
        <h3 class="reportName">Classes by Revenue</h3>
        <div class="reportInputs">
          $timeframeInput
          <input type="hidden" name="reportType" value="classesByRevenue" />
        </div>
      </form>

      <form name="eventsByRevenue" id="eventsByRevenue" action="getReport.php" method="post">
        <h3 class="reportName">Events by Revenue</h3>
        <div class="reportInputs">
          $timeframeInput
          <input type="hidden" name="reportType" value="eventsByRevenue" />
        </div>
      </form>

      <form name="revenueByDate" id="revenueByDate" action="getReport.php" method="post">
        <h3 class="reportName">Revenue by Date</h3>
        <div class="reportInputs">
        $timeframeInput
        </div>
        <input type="hidden" name="reportType" value="revenueByDate" />
      </form>

      <form name="specificClassRevenue" id="specificClassRevenue" action="getReport.php" method="post">
        <h3 class="reportName">Specific Class Revenue</h3>
        <div class="reportInputs">
          <script src="js/specificClassRevenueSelect.js"></script>
          <p><span class="label">Timeframe to Select Classes From:</span></p>
          <p><span class="label">Start Date: </span>
            <input type="date" name="startDate" id="specificClassRevenueStartDate"></p>
          <p><span class="label">End Date: </span>
            <input type="date" name="endDate" id="specificClassRevenueEndDate"></p>
          <input type="hidden" name="class" value="class" />
          <input type="hidden" name="reportType" value="specificClassRevenue" />
          <div id="specificClassRevenueSelect">
          </div>
        </div>
      </form>

      <form name="specificEventRevenue" id="specificEventRevenue" action="getReport.php" method="post">
        <h3 class="reportName">Specific Event Revenue</h3>
        <div class="reportInputs">
          <script src='js/specificEventRevenueSelect.js'></script>
          <p><span class="label">Timeframe to Select Events From:</span></p>
          <p><span class="label">Start Date: </span>
            <input type="date" name="startDate" id="specificEventRevenueStartDate"></p>
          <p><span class="label">End Date: </span>
            <input type="date" name="endDate" id="specificEventRevenueEndDate"></p>
          <input type="hidden" name="event" value="event" />
          <input type="hidden" name="reportType" value="specificEventRevenue" />
          <div id="specificEventRevenueSelect">
          </div>
        </div>
      </form>
    </div>

    <h2 class="reportCategoryLabel">Volunteering Reports</h2>
    <div class="reportNamesContainer">

      <form name="volunteeringByDateRange" id="volunteeringByDateRange" action="getReport.php" method="post">
        <h3 class="reportName">Volunteering by Date Range</h3>
        <div class="reportInputs">
          $timeframeInput
          <input type="hidden" name="reportType" value="volunteeringByDateRange" />
        </div>
      </form>

      <form name="volunteeringBySpecificClass" id="volunteeringBySpecificClass" action="getReport.php" method="post">
        <h3 class="reportName">Volunteering by Specific Class</h3>
        <div class="reportInputs">
          <script src="js/volunteeringBySpecificClassSelect.js"></script>
          <p><span class="label">Timeframe to Select Classes From:</span></p>
          <p><span class="label">Start Date: </span>
            <input type="date" name="startDate" id="volunteeringBySpecificClassStartDate"></p>
          <p><span class="label">End Date: </span>
            <input type="date" name="endDate" id="volunteeringBySpecificClassEndDate"></p>
          <input type="hidden" name="class" value="class" />
          <input type="hidden" name="reportType" value="volunteeringBySpecificClass" />
          <div id="volunteeringBySpecificClassSelect">
          </div>
        </div>
      </form>

      <form name="volunteeringBySpecificEvent" id="volunteeringBySpecificEvent" action="getReport.php" method="post">
        <h3 class="reportName">Volunteering by Specific Event</h3>
        <div class="reportInputs">
          <script src="js/volunteeringBySpecificEventSelect.js"></script>
          <p><span class="label">Timeframe to Select Classes From:</span></p>

          <p><span class="label">Start Date: </span>
            <input type="date" name="startDate" id="volunteeringBySpecificEventStartDate"></p>

          <p><span class="label">End Date: </span>
            <input type="date" name="endDate" id="volunteeringBySpecificEventEndDate"></p>

          <input type="hidden" name="event" value="event" />
          <input type="hidden" name="reportType" value="volunteeringBySpecificEvent" />

          <div id="volunteeringBySpecificEventSelect">
          </div>
        </div>
      </form>
      
      <form name="volunteeringByMember" id="volunteeringByMember" action="getReport.php" method="post">
        <h3 class="reportName">Volunteering by Member</h3>
        <div class="reportInputs">
          <p><span class="label selectLabel">Select Member To Get Volunteering History For:</span></p>
          $memberSelect
          <input type="hidden" name="reportType" value="volunteeringByMember">
          <input type="submit" class="reportSubmit" />
        </div>

      </form>
    </div>

  </div>
</div>


END;


$im->displayWin($content);


?>
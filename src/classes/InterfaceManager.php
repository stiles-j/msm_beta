<?php

// InterfaceManager class for the SpaceManager program
//TODO: This class has become a swiss army knife.  Notes for reforming the class are listed in TODO notes.

class InterfaceManager{
  
  private $db, $om;

  /**
   * InterfaceManager constructor. No args
   */
  public function __construct()
  {
    require_once 'dbManager.php';
    require_once 'OutputManager.php';
    
    /*Session housekeeping.  Note that it is possible the session may already be started or an HTML header may have
    already been sent when the below functions are called.  If that happens the server will log a PHP error.  This
    error can safely be ignored, as the following lines of code function as a fail-safe to ensure the session is started
    if it hasn't been already. Yes, accessing session data from inside a class is icky.  We will work to get rid of this
    problem in a future revision of the software*/
    if (session_status() == PHP_SESSION_NONE) session_start(); //required for this class to work, so make sure it's started
    session_regenerate_id(); //to prevent fixation
        
    $this->db = new dbManager;
    $this->om = new OutputManager;
    
  } // end method __construct()

  /**
   * Method addMemberCert adds a record to the MEMBER_CERTIFICATION table
   *
   * @param $memberID: A valid MemberID number
   */
  public function addMemberCert($memberID) {
    $certs = $this->db->getAllCertifications();
    $content = "<h2>New Certification Type</h2><select name='newCertName'>";
    foreach ($certs as $cert) {
      $content .= "<option name='$cert'>$cert</option>";
    }
    $content .= "</select><input type='hidden' name='memberID' value='$memberID' />";
    $this->om->insertPopUp($content, "Add New Certification", "addMemberCert.php");
  } //end method addCert

  //TODO: Devolve this method to the CCEManager class and turn this into a wrapper
  /**
   * Method addNewClass will generate a pop up window to allow users to schedule new classes from existing courses.
   * The data is sent to checkClassConflict.php for validation and forwarded from there to classAdd.php to be added to the
   * CLASS table of the database.
   */
  public function addNewClass() {
    $courses = $this->db->getAllCourses();
    $content = "Course:";
    $content .= "<select name='referenceNumber'>";

    while ($course = $courses->fetch_assoc()) {
      $content .= "<option value='$course[CourseID]'>$course[CourseName]</option>";
    }
    $content .= "</select>";
    $content .= "Class Date:";
    $content .= "<input type='datetime-local' name='time' />";
    $content .= "<input type='hidden' name='type' value='course' />";

    $this->displayPopUp($content, 'Add New Class', 'checkClassConflict.php');

  } // end method addNewClass

  //TODO: Devolve this to the facilityManager class and turn this into a wrapper
  /**
   * addNewFacility generates and displays a Facility Input Form for adding new facilities to the FACILITY table in the
   * database.  The data is handled by addNewFacility.php
   */
  public function addNewFacility() {
    $subFacilities = $this->db->getAllFacilities();

    //generate the main body of the add facility form
    $nfForm = <<<END
    <form name="addFacilityForm" action="addNewFacility.php" method='post'>
      <div class="userInputFields">
        <h2>New Facility Input Form</h2>
        <p><span class="label">Facility Name: </span><input type="text" name="facilityName" autofocus="autofocus" /></p>
        <p><span class="label">Facility Description: </span>
        <textarea name="facilityDescription" ></textarea></p>
END;

    //generate the sub-facility select box
    $nfForm .="<p><span class='label'>Sub-Facilities: </span></p>";
    $nfForm .= "<p><select name='subFacilities[]' multiple='multiple'>";
    foreach ($subFacilities as $subFacility) {
      $nfForm .= "<option value='$subFacility[FacilityID]'>$subFacility[FacilityName]</option>";
    }
    $nfForm .= "</select></p>";
    $nfForm .= "<p><input type=\"submit\" value=\"Submit\" /></p></div></form>";

    $this->displayWin($nfForm);
  } //end method addNewFacility

  /**
   * addPayment generates a pop-up window allowing the user to add a payment of selectable type to a member account
   * this function includes a reference to paymentSlider.js which enables the ajax processing needed to allow the
   * payment window to function properly.  On submission, the data is handled by addPayment.php
   *
   * @param $memberID: A valid memberID number.
   */
  public function addPayment ($memberID) {
    $content = "Select Payment Type:
    <select id='paymentType' autofocus>
      <option selected disabled hidden>Payment Type</option>
      <option value='classEnrollment'>Class Enrollment</option>
      <option value='eventEnrollment'>Event Enrollment</option>
      <option value='dues'>Dues</option>
      <option value='donation'>Donation</option>
      <option value='merchandise'>Merchandise</option>
      <option value='other'>Other Payment</option>
    </select>
    <script src='js/paymentSlider.js'></script>
    <div id='slideContent'></div>
    <input type='hidden' name='MemberID' id='MemberID' value='$memberID' />";
    $this->displayPopUp($content, "Add Payment", "addPayment.php");

  } //end method addPayment

  /**
   * addVolunteering generates a pop-up window that allows a user to add volunteering to a member account.  The window
   * will have a select box populated only with events happening today.  For reasons of accountability and consistency
   * volunteering can only be added the day of the event.  On submission data is handled by addVolunteering.php to be
   * added to the VOLUNTEER_HISTORY table in the database.
   *
   * @param $memberID: A valid memberID number
   */
  public function addVolunteering($memberID) {
    $events = $this->db->getTodaysEvents();
    $content = "<select name='eventData'>";

    while($event = $events->fetch_assoc()) {
      $content .= "<option value='{ &quot;type&quot;: &quot;$event[Type]&quot;, &quot;referenceNumber&quot;: $event[ReferenceNumber] }'>$event[Name]</option>";
    }//end while

    $content .= "</select><input type='hidden' name='memberID' value='$memberID' />";
    $this->displayPopUp($content, "Add Volunteering", "addVolunteering.php");

  } //end method addVolunteering

  /**
   * displayProfile is a wrapper for the method of the same name in the outputManager class.  This method will display
   * the member profile belonging to the passed memberID number.
   *
   * @param $memberID: A valid memberID number
   */
  public function displayProfile($memberID)
  {
    //display the actual profile
    $profileInfo = $this->db->getProfile($memberID);
    
    $this->om->displayProfile($profileInfo); 
    
    //add the sidebar menus
    $this->displaySidebars();

  } //end method displayProfile

  /**
   * displayDefaultProfile is a wrapper for the method of the same name in the outputManager class.  This method
   * displays a blank user profile and should be used when no member profile can be displayed for some reason.
   * DO NOT create bogus profiles in the Database to fulfill this function!  Note, the wrapper
   */
  public function displayDefaultProfile() {
    $this->om->displayDefaultProfile();
    $this->displaySidebars();
  } //end method displayDefaultProfile

  /**
   * displayMemberDuesPayments will generate a pop-up window displaying up to
   * twelve months of prior dues payments for a member.
   *
   * @param $memberID: a valid member number
   */
  public function displayMemberDuesPayments ($memberID) {
    $dues = $this->db->getMemberPayments($memberID, 'dues');
    $duesPayment = null;
    $content = "";

    //limit result to one year of prior payments to prevent too long a popup window with senior members
    for ($i = 0; ($duesPayment = $dues->fetch_assoc()) && $i < 12; $i++) {
      $paymentDate = date("Y-m-d", strtotime($duesPayment['PaymentDate']));
      $content .= "<h3>$paymentDate: $duesPayment[Amount]</h3>";
    }
    $this->displayPopUp($content, "Dues Payments", "smTest.php");
  } //end method displayMemberDuesPayments

  /**
   * displayMemberOtherPayments generates a popup window displaying the last 12 non-dues payments a member has made.
   * Note that for more complete records of payments, the reporting module function should be used.
   *
   * @param $memberID: A valid memberID number indicating the member account whos history should be displayed
   */
  public function displayMemberOtherPayments ($memberID) {
    $payments = $this->db->getMemberPayments($memberID, "other");
    $payment = null;
    $content = "<h4><table><th>Date</th><th>Amount</th><th>Type</th><th>Name</th></h4>";

    //limit result to one year of prior payments to prevent an oversize popup window
    for ($i = 0; ($payment = $payments->fetch_assoc()) && $i < 12; $i++ ) {
      $paymentDate = date("Y-m-d", strtotime($payment['PaymentDate']));
      $eventName = "";
      if ($payment['Name'] != null) {
        $eventName = $payment['Name'];
      }
      $content .= "<tr><td>$paymentDate</td> <td>$payment[Amount]</td> <td>$payment[Reason]</td> <td>$eventName</td></tr>";
    }
    $content .= "</table>";
    $this->displayPopUp($content, "Prior Payments", "smTest.php");
  } //end method displayMemberOtherPayments

  /**
   * Function displayPopUp is a wrapper function for the function insertPopUp of the OutputManager class.
   * This allows client code access to the popup functionality through UserManager so a separate OutputManager object
   * does not need to be instantiated.
   *
   * @param $message: The main content of the popup window
   * @param string $header: The heading to appear in the highlighted area at the top of the popup window
   * @param string $action: The script to forward to when the user clicks "OK"
   */
  public function displayPopUp($message, $header = '', $action = '')
  {
    $this->om->insertPopUp($message, $header, $action); 
  }//end method displayPopUp

  /**
   * displayWin is a wrapper function for the displayWindow method of the outputManager class.  This allows access to
   * the function through a UserManager object without needing to instantiate a separate instance of the outputManager.
   * Additionally, this function adds the standard sidebars to complete the interface and should therefore be preferred
   * to calling displayWindow on the outputManger class directly in most cases.
   *
   * @param $content: Formatted HTML content to be displayed in the main window
   */
  public function displayWin($content)
  {
    $this->om->displayWindow($content);
    
    //add the sidebar menus
    $this->displaySidebars();
    
  }//end method displayWin

  //TODO: Devolve this function to the CCEManager class and turn this into a wrapper
  /**
   * editClass will generate a popup window allowing the user to select a previously scheduled class to be edited.
   * Because of various record keeping requirements, the only edit possible is changing a class date, classes cannot
   * be deleted entirely once scheduled.
   *
   * On submission, data is handled by classEdit.php
   */
  public function editClass() {
    //get a list of all pending classes
    $classes = $this->db->getPendingClasses();
    $content = "Select Class To edit: ";
    $content .= "<select name='referenceNumber'>";

    while ($class = $classes->fetch_assoc()) {
      $content .= "<option value='$class[ReferenceNumber]'>$class[Name] on $class[Date]</option>";
    }

    $content .= "</select>";
    $content .= "New Class Date: ";
    $content .= "<input type='datetime-local' name='time' />";
    $content .= "<input type='hidden' value='course' name='type' />";
    $content .= "<input type='hidden' value='true' name='update' />";

    $this->displayPopUp($content, "Edit Class", "checkClassConflict.php");

  } //end method editClass

  /**
   * getEventToEdit will display a pop-up dialog on the main dashboard populated with all pending events.
   * Once the user selects an event to edit from the list and clicks submit, the form redirects to
   * EditEventForm.php
   */
    public function getEventToEdit(){
        $events = $this->db->getPendingEvents();
        $content = 'Select Event To Edit';
        $content .= "<select name='eventReferenceNumber'>";

        while ($event = $events->fetch_assoc()) {
            $content .= "<option value='$event[ReferenceNumber]'>$event[Name] on $event[Date]</option>";
        }
        $content .= "</select>";

        $this->displayPopUp($content, "Edit Event", "EditEventForm.php");
    }

  /**
   * editMember will display the Edit Member form pre-populated with the data of the member account identified by the
   * passed memberID number.
   *
   * @param $memberID: A valid memberID number for the member account to be edited
   */
  public function editMember($memberID)
  {
    //get the full profile from the database
    $profile = $this->db->getPersonalInfo($memberID);
    $this->om->editMemberForm($profile);
    $this->displaySidebars();
    
  }//end function editMember

  //TODO: Devolve this function to the CCEManager class and turn this into a wrapper
  /**
   * getCourseToEdit generates a popup window with a select populated with all available courses.  The user can select
   * a course and will be redirected to the Edit Course form pre-populated with the data of the course they selected.
   *
   *On submission data is handled by courseEdit.php
   */
  public function getCourseToEdit() {
    $courses = $this->db->getAllCourses();
    $content = "Select Course To Edit";
    $content .= "<select name='courseToEdit'>";

    //add each course to the select
    while ($course = $courses->fetch_assoc()) {
      $content .= "<option value='$course[CourseID]'>$course[CourseName]</option>";
    }
    $content .= "</select>";
    $this->displayPopUp($content, "Select Course", "courseEdit.php");
  } //end method getCourseToEdit

  //TODO: Devolve this method to the facilityManager class and turn this into a wrapper
  /**
   * getFacilityToEdit generates a popup window with a select box listing all existing facilities.  On selection the user
   * is redirected to the Edit Facility form which is pre-populated with the data from the facility they selected.
   *
   *On submission, data is handled by facilityEdit.php
   */
  public function getFacilityToEdit() {
    $facilities = $this->db->getAllFacilities();
    $content = "Select Facility To Edit";
    $content .= "<select name='facilityToEdit'>";

    foreach ($facilities as $facility) {
      $content .= "<option value='$facility[FacilityID]'>$facility[FacilityName]</option>";
    }
    $content .= "</select>";
    $this->displayPopUp($content, "Select Facility", "facilityEdit.php");
  } //end method getFacilityToEdit

  //TODO: Devolve this function to the ReportsManager class and replace all usages
  /**
   * memberSearch queries the database to find all possible matches for the first or last name of a member.  Results
   * are displayed in the main window of the user interface as clickable links.  Clicking on the links will display the
   * profile of the selected member.
   *
   * @param $firstName: The first name of the member being searched for.  Normal capitalization applies.
   * @param $lastName: The last name of the member being searched for.  Normal capitalization applies.
   */
  public function memberSearch($firstName, $lastName)
  {
    //Get the search results from the database
    $result = $this->db->findMember($firstName, $lastName);
    
    //content will be used to contain the final output
    $content = '';
    
    //check for empty result set
    if ($result->num_rows == 0)
    {
      $content .= "No Results<br /><br /><br /><br /><br /><br />";
    }
    else
    {
      while ($row = $result->fetch_assoc())
      {
        $name = $this->prepName($row['MemberID']);
        $content .= $name . "<br />";
      }//end while
      
      $content .= "<br /><br /><br /><br /><br /><br />";
    }
    
    $this->displayWin($content);
    
  }//end method memberSearch

  /**
   * Function recordManagerNote is a wrapper function for the function recordNote of the dbManager class.  This allows
   * client code access to the recordNote function without instantiating another dbManager instance.
   *
   * @param $memberID: A valid memberID number representing the member account this note should be added to
   * @param $note: The text of the note to be added to the member account
   */
  public function recordManagerNote($memberID, $note)
  {
    $this->db->recordNote($memberID, $note);
  }//end function recordManagerNote

  /**
   * showAllNotes will display every note in a member account in the main window of the interface
   *
   * @param $memberID: A valid memberID number representing a member account to retrieve the notes from
   */
  public function showAllNotes($memberID)
  {
    //$content will hold the formatted notes to be displayed onscreen
    $content = '';
    
    //get notes from database, format and store in $content
    $notes = $this->db->getAllNotes($memberID);
    while($row = $notes->fetch_assoc())
    {
      $content .= "<p><strong>" . $row['NoteTime'] . ":</strong>" . $row['NoteText'] . "</p>";
    }
    
    $content .= "<br /><br /><br /><br /><br /><br />";
    $notes->close();
    
    /*call displayWin to output the notes*/
    $this->displayWin($content);
  }//end method showAllNotes

  /**
   * showAllEnrollments will display all pending enrollments from a member account in the main window of the interface
   *
   * @param $memberId: a valid memberID number representing a member account to display the enrollments for
   */
  public function showAllEnrollments($memberId) {
    //$content will hold the formatted notes to be displayed onscreen
    $content = '';

    //get notes from database, format and store in $content
    $enrollments = $this->db->getPendingEnrollments($memberId);
    while($row = $enrollments->fetch_assoc())
    {
      $content .= "<p><strong>" . $row['Date'] . ": </strong>" . $row['Name'] . "</p>";
    }

    $content .= "<br /><br /><br /><br /><br /><br />";
    $enrollments->close();

    /*call displayWin to output the notes*/
    $this->displayPopUp($content, "All Enrollments");
  } //end method showAllEnrollments


  /*Private Functions*/

  /**
   * prepName is a helper function that turns a memberID number into a clickable button displaying the member's name.
   * The button redirects to smTest.php where it will be processed to display the member's profile.
   *
   * @param $memberID: A valid memberID representing a member account
   * @return string: the prepped HTML form to be displayed as a clickable button.
   */
  private function prepName($memberID)
  {
    $userName = $this->db->getUserName($memberID);
    $name = "<form action='smTest.php' method='post'>
    <input type='hidden' name='display_member' value='$memberID' />
    <input type='submit' name='submit' id='memberButton' value='$userName' /></form>";

    return $name;
  } //end method prepName

  /**
   * displayCurrentUsers generates a side-bar in the interface displaying the names of all members logged into the
   * space who have not yet logged out.  Names are prepped to be clickable links that will display the related profile.
   */
  private function displayCurrentUsers()
  {
    //array to build our output list
    $currentUsers = array();

    //first check if there are any current users
    if (isset($_SESSION['current_users']))
    {
      foreach($_SESSION['current_users'] as $user)
      {
        //get the name and make it clickable then add to the array
        $userName = $this->prepName($user);
        $currentUsers[] = $userName;
      }//end foreach
    }//end if

    //create the "Members On Site" div using the currentUsers list
    $this->om->insertDiv("rightPannel", $currentUsers, "Members On Site");

  } //end method displayCurrentUsers

  /**
   * displayRecentUsers generates a side-bar in the interface displaying the last twenty members who have logged into
   * the space.  Note this differs from displayCurrentUsers which does not display members who have logged out.
   */
  private function displayRecentUsers()
  {
    /*array in which to build a human readable list of recent visitors*/
    $recentUsers = array();

    //first make sure there are members in the array
    if (isset($_SESSION['recent_visitors']))
    {
      //keep the recent visitors array to a maximum of 20 entries
      if (count($_SESSION['recent_visitors']) > 20)
        array_shift($_SESSION['recent_visitors']);

      //build a human readable array of recent users

      foreach($_SESSION['recent_visitors'] as $visitor)
      {
        $visitorName = $this->prepName($visitor);
        //use array_unshift so more recent visitors are at top of list
        array_unshift($recentUsers, $visitorName);
      }//end foreach

    }//end if

    //construct the recent visitors div using the new array
    $this->om->insertDiv('recentVisitors', $recentUsers, 'Recent Visitors');
  } //end method displayRecentUsers

  /**
   * displaySidebars is a convenience function that will call displayCurrentUsers and displayRecentUsers in order to
   * generate the standard display.  This function should be preferred to calling the individual functions separately.
   */
  private function displaySidebars()
  {
    $this->displayCurrentUsers();
    $this->displayRecentUsers();

  } //end method displaySidebars
}; //end class UserManager



































?>
<?php

// UserManager class for the SpaceManager program
// class UserManager manages all user data in memory, but does not make changes to the database directly which is the job of the dbManager class.

class UserManager{
  
  private $db, $om;
  
  public function __construct()
  {
    require_once 'dbManager.php';
    require_once 'OutputManager.php';
    
    /*Session housekeeping.  Note that it is possible the session may already be started or an HTML header may have already been sent when the below functions are called.  If that happens the server will log a PHP error.  This error can safely be ignored, as the following lines of code function as a fail-safe to ensure the session is started if it hasn't been already.*/
    if (session_status() == PHP_SESSION_NONE) session_start(); //required for this class to work, so make sure it's started
    session_regenerate_id(); //to prevent fixation
        
    $this->db = new dbManager;
    $this->om = new OutputManager;
    
  } // end function __construct()

  public function addCert($memberID) {
    $certs = $this->db->getAllCertifications();
    $content = "<h2>New Certification Type</h2><select name='newCertName'>";
    foreach ($certs as $cert) {
      $content .= "<option name='$cert'>$cert</option>";
    }
    $content .= "</select><input type='hidden' name='memberID' value='$memberID' />";
    $this->om->insertPopUp($content, "Add New Certification", "addMemberCert.php");
  } //end addCert

  public function addNewClass() {
    $courses = $this->db->getAllCourses();
    $content = "Course:";
    $content .= "<select name='course'>";

    while ($course = $courses->fetch_assoc()) {
      $content .= "<option value='$course[CourseID]'>$course[CourseName]</option>";
    }
    $content .= "</select>";
    $content .= "Class Date:";
    $content .= "<input type='date' name='classDate' />";

    $this->displayPopUp($content, "Add New Class", 'classAdd.php');

  } // end function addNewClass

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
    <script src='paymentSlider.js'></script>
    <div id='slideContent'></div>
    <input type='hidden' name='MemberID' id='MemberID' value='$memberID' />";
    $this->displayPopUp($content, "Add Payment", "addPayment.php");

  }

  public function addVolunteering($memberID) {
    $events = $this->db->getTodaysEvents();
    $content = "<select name='eventData'>";

    while($event = $events->fetch_assoc()) {
      $content .= "<option value='{ &quot;type&quot;: &quot;$event[Type]&quot;, &quot;referenceNumber&quot;: $event[ReferenceNumber] }'>$event[Name]</option>";
    }//end while

    $content .= "</select><input type='hidden' name='memberID' value='$memberID' />";
    $this->displayPopUp($content, "Add Volunteering", "addVolunteering.php");

  } //end addVolunteering

  public function displayProfile($MemberNumber)
  {
    //display the actual profile
    $profileInfo = $this->db->getProfile($MemberNumber);
    
    $this->om->displayProfile($profileInfo); 
    
    //add the sidebar menus
    $this->displaySidebars();

  } //end function displayProfile

  public function displayDefaultProfile() {
    $this->om->displayDefaultProfile();
    $this->displaySidebars();
  }
  
  /*Function displayPopUp is a wrapper function for the function insertPopUp of the OutputManager class.  This allows client code access to the popup functionality through UserManager so a separate OutputManager object does not need to be instantiated.*/
  public function displayPopUp($message, $header = '', $action = '')
  {
    $this->om->insertPopUp($message, $header, $action); 
  }//end function displayPopUp
  
  /*displayWin is a wrapper function for the displayWindow method of the outputManager class.  This allows access to the function through a UserManager object without needing to instantiate a separate instance of the outputManager*/
  public function displayWin($content)
  {
    $this->om->displayWindow($content);
    
    //add the sidebar menus
    $this->displaySidebars();
    
  }//end function displayWin

  public function editClass() {
    //get a list of all pending classes
    $classes = $this->db->getPendingClasses();
    $content = "Select Class To edit: ";
    $content .= "<select name='classToEdit'>";

    while ($class = $classes->fetch_assoc()) {
      $content .= "<option value='$class[ReferenceNumber]'>$class[Name] on $class[Date]</option>";
    }

    $content .= "</select>";
    $content .= "New Class Date: ";
    $content .= "<input type='date' name='newClassDate' />";

    $this->displayPopUp($content, "Edit Class", "classEdit.php");

  } //end function editClass

  public function editMember($MemberNumber)
  {
    //get the full profile from the database
    $profile = $this->db->getPersonalInfo($MemberNumber);
    //only send the editable fields to the outputmanager
    $this->om->editMemberForm($profile);
    $this->displaySidebars();
    
  }//end function editMember

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
  }

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

  /*Function recordManagerNote is a wrapper function for the function recordNote of the dbManager class.  This allows client code access to the recordNote function without instantiating another dbManager instance, as dbManager should only be instantiated by the UserManager class*/
  public function recordManagerNote($MemberNumber, $note)
  {
    $this->db->recordNote($MemberNumber, $note);
  }//end function recordManagerNote
  
  public function showAllNotes($MemberNumber)
  {
    //$content will hold the formatted notes to be displayed onscreen
    $content = '';
    
    //get notes from database, format and store in $content
    $notes = $this->db->getAllNotes($MemberNumber);
    while($row = $notes->fetch_assoc())
    {
      $content .= "<p><strong>" . $row['NoteTime'] . ":</strong>" . $row['NoteText'] . "</p>";
    }
    
    $content .= "<br /><br /><br /><br /><br /><br />";
    $notes->close();
    
    /*call displayWin to output the notes*/
    $this->displayWin($content);
  }//end method showAllNotes

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
  }




  /*Private Functions*/

  private function prepName($memberID)
  {
    $userName = $this->db->getUserName($memberID);
    $name = "<form action='smTest.php' method='post'>
    <input type='hidden' name='display_member' value='$memberID' />
    <input type='submit' name='submit' id='memberButton' value='$userName' /></form>";

    return $name;
  }

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

  } //end function displayCurrentUsers

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
  } //end function displayRecentUsers

  private function displaySidebars()
  {
    $this->displayCurrentUsers();
    $this->displayRecentUsers();

  }
}; //end class UserManager



































?>
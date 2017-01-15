<?php

// UserManager class for the SpaceManager program
// class UserManager manages all user data in memory, but does not make changes to the database directly which is the job of the dbManager class.

class UserManager{
  
  private $db, $om;
  
  public function __construct()
  {
    require_once 'dbManager.php';
    require_once 'OutputManager.php';
    
    /*Session housekeeping.  Note that it is possible the session may already be started or an HTML header may have already been sent when the below functions are called.  If that happens the server will log a PHP error.  This error can safely be ignored, as the following lines of code function as a failsafe to ensure the session is started if it hasn't been already.*/
    session_start(); //required for this class to work, so make sure it's started
    session_regenerate_id(); //to prevent fixation
        
    $this->db = new dbManager;
    $this->om = new OutputManager;
    
  } // end function __construct()
  
  public function displayProfile($MemberNumber)
  {
    //display the actual profile
    $profileInfo = $this->db->getProfile($MemberNumber);
    
    $this->om->displayProfile($profileInfo); 
    
    //add the sidebar menus
    $this->displaySidebars();

  } //end function displayProfile
  
  /*Function displayPopUp is a wrapper function for the function insertPopUp of the OutputManager class.  This allows client code access to the popup functionality thorugh UserManager so a seperate OutputManager object does not need to be instantiated.*/
  public function displayPopUp($message, $header = '', $action = '')
  {
    $this->om->insertPopUp($message, $header, $action); 
  }//end function displayPopUp
  
  /*displayWin is a wrapper function for the displayWindow method of the outputManager class.  This allows access to the fucntion through a UserManager object without needing to instantiate a seperate instance of the outputManager*/
  public function displayWin($content)
  {
    $this->om->displayWindow($content);
    
    //add the sidebar menus
    $this->displaySidebars();
    
  }//end function displayWin
  
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
    /*array in which to build a human readable list of recent vistiors*/
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
        $recentUsers[] = $visitorName;
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
  
  public function editMember($MemberNumber)
  {
    //get the full profile from the database
    $profile = $this->db->getPersonalInfo($MemberNumber);
    //only send the editable fields to the outputmanager
    $this->om->editMemberForm($profile);
    $this->displaySidebars();
    
  }//end function editMember
  
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
  
  
  private function prepName($MemberNumber)
  {
    $userName = $this->db->getUserName($MemberNumber);
    $name = "<form action='smTest.php' method='post'>
    <input type='hidden' name='display_member' value='$MemberNumber' />
    <input type='submit' name='submit' id='memberButton' value='$userName' /></form>";
    
    return $name;
  }
  
  /*Function recordManagerNote is a wrapper function for the function recordNote of the dbManager class.  This allows client code acces to the recordNote function without instantiating another dbManager instance, as dbManager should only be instantiated by the UserManager class*/
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
    while($row = $notes->fetch_row())
    {
      $content .= "<p><strong>$row[0]:</strong> $row[1]</p>";
    }
    
    $content .= "<br /><br /><br /><br /><br /><br />";
    $notes->close();
    
    /*call displayWin to output the notes*/
    $this->displayWin($content);
    
  }//end method showAllNotes
  
}; //end class UserManager



































?>
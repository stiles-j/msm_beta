<?php

/* loginManager class for the SpaceManager program This class contains all the data processing functions of the UserManager class without any display methods and without sending any HTML*/
// class UserManager manages all user data in memory, but does not make changes to the database directly which is the job of the dbManager class.

class loginManager{
  
  private $db, $om;
  
  public function __construct()
  {
    require_once 'dbManager.php';
    
    $this->db = new dbManager;
    
    //session housekeeping
    session_start(); //required for this class to work, so make sure it's started
    session_regenerate_id(); //to prevent fixation
    
  } // end function __construct()
  
  
  public function login($MemberNumber)
  {
    //first check to ensure the meber number is valid, if not, do not record the login
    $result = $this->db->getUsername($MemberNumber);
    /*If our result is null, it was an invalid login so punt*/
    if (!$result)
    {
      return 0;
    }//end if
    
    //boolean to store if this is really a new login or not
    $newUser = 1;
    
    if (isset($_SESSION['current_users']))
    {
      /*go through current_users and see if this member number is already in the array.  If it is, set newUser to false (0)*/
      foreach ($_SESSION['current_users'] as $user)
      {
        if ($user == $MemberNumber)
          $newUser = 0;
      } // end foreach loop
    }//end if
      
    //if this is a new user, log them in
    if ($newUser)
    {
      $_SESSION['current_users'][] = $MemberNumber;
      
      //record the login in the database for future use
      $this->db->recordLogin($MemberNumber);
      //Add the member to the "Recent Visitors" div
      $_SESSION['recent_visitors'][] = $MemberNumber;
      return 1;
    } //end if
    //otherwise log them out
    else
    {
      $this->logout($MemberNumber);
      return 1;
    }//end else

  } // end function login
  
  /*logout if private so the UserManager class can ensure logins and
  logouts happen properly.  Client code simply calls login()*/
  private function logout($MemberNumber)
  { 
    //first make sure this isnt a bogus logout
    if (isset($_SESSION['current_users']))
    {
      //remove the user from the session array of current users
      for ($i = 0; $i < count($_SESSION['current_users']); ++$i)
      {
        /*check that the user is actually in the current_users array and unset if so */
        if ($_SESSION['current_users'][$i] == $MemberNumber)
        {
          unset($_SESSION['current_users'][$i]);
          //reorder the array to prevent holes
          $_SESSION['current_users'] = array_values($_SESSION['current_users']);
          //record the logout in the database
          $this->db->recordLogout($MemberNumber);
        } //end if i == MemberNumber
      } // end for loop
    }//end if current_users
  } //end function logout
  
}; //end class loginManager

?>
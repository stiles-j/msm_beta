<?php
// Database Manager class for SpaceManager system

class dbManager{
  
  //class login variables
  private $hostname, $username, $password, $database;
  
  public function __construct()
  {
    //first get login credentials
    require 'login.php';
    
    $this->hostname = $db_hostname;
    $this->username = $db_username;
    $this->password = $db_password;
    $this->database = $db_database;   
  } // end function __construct
  
  /*addProfile will insert provided information into the database.  The required argument is a numeric array of user data in the following format: firstName, lastName, birthdate, joindate, addresss, homephone,cellphone, email, emergency contact, medical provider, referred by, member id number, user image, level.  Null values should be  used in place of any missing information. The function will return true on a successful insert or false on a failed insert*/
  public function addProfile($profileData)
  {
    //handle blank ReferredBy field
    if ($profileData[11] == '') $profileData[11] = 0;
    
    $sql = "INSERT INTO MEMBER (FirstName, LastName, BirthDate, StreetAddress, City, State, Zip, HomePhone, CellPhone, Email, EmergencyContact, ReferredBy, Picture, MembershipType, MemberID) VALUES ('$profileData[0]', '$profileData[1]', '$profileData[2]', '$profileData[3]', '$profileData[4]', '$profileData[5]', '$profileData[6]', '$profileData[7]', '$profileData[8]', '$profileData[9]', '$profileData[10]', $profileData[11], '$profileData[12]', '$profileData[13]', '$profileData[14]')";
    
    $db_conn = $this->connect();
    
    $result = $db_conn->query($sql);

    //Log MySQL errors if we get a null result from the SQL query
    if (!$result) {
      $this->logError($db_conn);
    }
    
    $db_conn->close();
    return $result;
  }//end function addProfile
  
  private function connect()
  {
    //NOTE: The calling function is responsible for closing the connection created by this function
        
    $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    
    if ($conn->connect_errno)
    {
      die("Connection to DataBase failed: " . $conn->connect_error);
    }
    
    return $conn;
    
  } //end function connect
  
  private function sanitizeInput($input, $db_conn)
  {
    if(get_magic_quotes_gpc())
      $input = stripslashes($input);
    
    $input = $db_conn->escape_string($input);
    $input = strip_tags($input);
    $input = htmlentities($input, ENT_QUOTES);
    
    return $input;
    
  } // end function sanitizeInput
  

  public function addCert($MemberID, $certName)
  {
    //connect to database and sanitize inputs
    $db_conn = $this->connect();
    $MemberID = $this->sanitizeInput($MemberID, $db_conn);
    $certName = $this->sanitizeInput($certName, $db_conn);
    
    //generate SQL and attempt insert
    $sql = "INSERT INTO MEMBER_CERTIFICATION (MemberID, CertName) VALUES ($MemberID, '$certName')";
    
    $result = $db_conn->query($sql);
    
    //log SQL errors if we get a bad result
    if (!$result)
      $this->logError($db_conn);
    
    return $result;
    
  }//end function addCert
  
  /*Function addDonation records member donations in the database.  The function takes a member id number and donation amount as arguments and returns boolean indicating whether the insert of record was successful or not; true for success, false for failure.*/
  public function addPayment($MemberID, $amount, $reason = '')
  {
    //connect to database and sanitize inputs
    $db_conn = $this->connect();
    $MemberID = $this->sanitizeInput($MemberID, $db_conn);
    $amount = $this->sanitizeInput($amount, $db_conn);
    
    //generate sql and attempt query
    $sql = "INSERT INTO PAYMENT (Amount, MemberID, Reason) VALUES ('$amount', '$MemberID', '$reason')";
    
    $result = $db_conn->query($sql);
    
    //log the sql error if there is one
    if (!$result)
      $this->logError($db_conn);
    
    $db_conn->close();
    
    return $result;
    
  }//end method addDonation
 
  /*Function addClass attempts to add a new class to the database's "ClassesTaken" table.  The function requires three arguments, a member number as an int, a string containing the class name and a string in the form yyyy-mm-dd for the date the class was completed.  The function returns true on a successful insert or false on a failed insert.*/
  public function addClass($MemberID, $classReferenceNumber, $loginReferenceNumber)
  {
    //connect and sanitize inputs
    $db_conn = $this->connect();
    $MemberID = $this->sanitizeInput($MemberID, $db_conn);
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    $loginReferenceNumber = $this->sanitizeInput($loginReferenceNumber, $db_conn);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO CLASS_TAKEN (MemberID, ClassReferenceNumber, LoginReferenceNumber) VALUES ($MemberID, '$classReferenceNumber', '$loginReferenceNumber')";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error on insert to CLASS_TAKEN");
    
    $db_conn->close();
    
    return $result;
  }//end method addClass
  
  
  public function addEventVolunteer($memberID, $eventReferenceNumber)
  {
    //establish connection to database and sanatize inputs
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $eventReferenceNumber = $this->sanitizeInput($eventReferenceNumber, $db_conn);
    
    //First, log the member in
    $loginReferenceNumber = $this->recordLogin($MemberID);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO EVENT_VOLUNTEER (MemberID, LoginReferenceNumber, EventReferenceNumber) VALUES ('$memberID', '$loginReferenceNumber', '$eventReferenceNumber')";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in addEventVolunteer: ");
    
    $db_conn->close();
    
    return $result;
    
  }//end method addEventVolunteer
  
  
  public function addClassVolunteer($memberID, $classReferenceNumber) 
  {
    //establish db connection and sanitize our inputs
        $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    
    //Log the member in 
    $loginReferenceNumber = $this->recordLogin($MemberID);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO CLASS_VOLUNTEER (MemberID, ClassReferenceNumber, LoginReferenceNumber) VALUES ('$memberID', '$classReferenceNumber', '$loginReferenceNumber')";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in addClassVolunteer: ");
    
    $db_conn->close();
    return $result;
    
  } //end function addClassVolunteer
  
  public function findMember($firstName, $lastName)
  {
    //connect to database and sanatize inputs
    $db_conn = $this->connect();
    $firstName = $this->sanitizeInput($firstName, $db_conn);
    $lastName = $this->sanitizeInput($lastName, $db_conn);
    
    /*generate sql, query database and return the result to the calling function*/
    $sql = "SELECT FirstName, LastName, MemberID FROM MEMBER WHERE FirstName='$firstName' OR LastName='$lastName'";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in findMember: ");
    
    return $result;
    
  }//end method findMember
  
  
  /*Function getAllNotes does exactly what it says on the tin, returning all member notes for a given member ID number.  The function requires a valid MemberID as an input and retrns an SQL result to the calling code*/
  public function getAllNotes($memberID)
  {
    //establish connection and sanitze input
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($MemberID, $db_conn);
    
    //retrive all notes for the relevant user and return
    $sql = "SELECT * from NOTES WHERE MemberID=$memberID ORDER BY NoteTime DESC";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in getAllNotes: ");
    $db_conn->close();
    
    return $result;
    
  }//end method getAllNotes
  
  public function getNewUserId()
  {
    /*The new member id number will be 17 greater than the highest number currently in the database*/
    $MemberNumber = 17;
    
    /*connect to the db and query*/
    $db_conn = $this->connect();
    $sql = "SELECT MemberID from MEMBER ORDER BY MemberID DESC LIMIT 1";
    $result = $db_conn->query($sql);
    
    /*If we got no result, leave the member number at 17, as there are no members in the database yet.  Otherwise, proceed as planned*/
    if ($result) {
        /*Convert the result to an associative array, add it to MemberNumber and return the final total*/
        $result = $result->fetch_assoc();
        $MemberNumber = 17 + (intval($result["MemberID"]));
    }
        
    $db_conn->close();
    
    return $MemberNumber;
  }
  
  public function getUsername($memberID)
  {
    //variables
    $nameString = '';
    
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    $sql = "SELECT FirstName, LastName FROM MEMBER WHERE MemberID = $memberID";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in getUserName: ");
    
    $db_conn->close();
        
    if ($result)
    {
      
      foreach($result->fetch_array(MYSQLI_NUM) as $row)
      {
        $nameString .= "$row ";
      } // end foreach loop
      
      return $nameString;
      
    } // end if
    else
      return null;
  } // end function getUsername
  
  public function getPersonalInfo($memberID)
  {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    $sql = "SELECT FirstName, LastName, BirthDate, StreetAddress, City, State, Zip, HomePhone, CellPhone, Email, EmergencyContact, ReferredBy, Picture, MembershipType, MemberID FROM MEMBER WHERE MemberID = $memberID";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in getPersonalInfo: ");
    $db_conn->close();
    
    return $result;
    
  }//end method getPersonalInfo
  
  public function getProfile($memberID)
  {
    //Variables
    $image;
    $profile;
    $classesTaken;
    $certs;
    $payments;
    $visits;
    $volunteering;
    $notes;
    $output;
    $db_conn = $this->connect();
    
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    //collect all info for the profile screen
    $sql = "SELECT Picture FROM MEMBER WHERE MemberID = $memberID";
    $image = $db_conn->query($sql);
    
    if (!$image)
      $this->logError($db_conn, "getProfile unable to retrieve Picture: ");
    
    $sql = "SELECT FirstName, LastName, JoinDate, BirthDate, MembershipType, TIMESTAMPDIFF(YEAR, BirthDate, CURDATE()) AS Age, MemberID FROM MEMBER WHERE MemberID=$memberID";
    $profile = $db_conn->query($sql);
    
    if (!$profile)
      $this->logError($db_conn, "getProfile unable to retrieve profile data: ");
    
    $sql = "SELECT CourseName, ClassDate FROM MEMBER_CLASS_HISTORY WHERE MemberID = $memberID ORDER BY ClassDate DESC LIMIT 5";
    $classesTaken = $db_conn->query($sql);
    
    if (!$classesTaken)
      $this->logError($db_conn, "getProfile unable to get classesTaken: ");
    
    $sql = "SELECT CertName FROM MEMBER_CERTIFICATION WHERE MemberID=$memberID";
    $certs = $db_conn->query($sql);
    
    if (!$certs)
      $this->logError($db_conn, "getProfile unable to get certs: ");
    
    $sql = "SELECT PaymentDate, Amount FROM PAYMENT WHERE MemberID=$memberID ORDER BY PaymentDate DESC LIMIT 1";
    $payments = $db_conn->query($sql);
    
    if (!$payments)
      $this->logError($db_conn, "getProfile unable to get payments: ");
    
    $sql = "SELECT LoginTime FROM LOGIN WHERE MemberID=$memberID ORDER BY LoginTime DESC Limit 5";
    $visits = $db_conn->query($sql);
    
    if (!$visits)
      $this->logError($db_conn, "getProfile unable to get visits: ");
    
    $sql = "SELECT Date, Name FROM VOLUNTEER_HISTORY WHERE MemberID=$memberID ORDER BY Date DESC LIMIT 5";
    $volunteering = $db_conn->query($sql);
    
    if (!$volunteering)
      $this->logError($db_conn, "getProfile unable to get volunteering: ");
    
    $sql = "SELECT NoteTime, NoteText FROM NOTES WHERE MemberID = $memberID ORDER BY NoteTime DESC LIMIT 5";
    $notes = $db_conn->query($sql);
    
    if (!$notes)
      $this->logError($db_conn, "getProfile unable to get notes: ");
    
    $db_conn->close();
    
    $output = array($image, $profile, $classesTaken, $certs, $payments, $visits, $volunteering, $notes, $memberID);
    
    return $output; 
    
  } // end function getProfile
  
  public function recordLogin($MemberID)
  {
    $db_conn = $this->connect();
    $MemberID = $this->sanitizeInput($MemberID, $db_conn);
    
    //Just insert memberID because the table will auto fill login time with the current time
    $sql = "INSERT INTO LOGIN (MemberID) VALUES ($MemberID)";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error inserting login: ");
    
    //Grab the reference number so it can be returned
    $sql = "SELECT LoginReferenceNumber FROM LOGIN WHERE MemberID = $MemberID ORDER BY LoginTime DESC LIMIT 1";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error retrieveing LoginReferenceNumber after login insert: ");
    
    //convert to an associative array for use
    $result = $result->fetch_assoc();
    
    $loginReferenceNumber = intval($result["LoginReferenceNumber"]);
    
    $db_conn->close();
    return $loginReferenceNumber;
    
  } //end function recordLogin
  
  public function recordLogout($MemberID)
  {
    $db_conn = $this->connect();
    $MemberID = $this->sanitizeInput($MemberID, $db_conn);
    
    $sql = "UPDATE LOGIN SET LogoutTime = NOW() Where MemberID = $MemberID ORDER BY LoginTime DESC LIMIT 1";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error recording logout: ");
    
    $db_conn->close();
    
  } //end function recordLogout
  
  public function recordNote($memberID, $note)
  {
    $db_conn = $this->connect();
    
    //First sanitize all inputs
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $note = $this->sanitizeInput($note, $db_conn);
    
    //generate query and insert into database
    $sql = "INSERT INTO NOTES (MemberID, NoteText) VALUES ($memberID, '$note')";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "recordNote unable to insert new note: ");
    
    $db_conn->close();
    
  }//end function recordNote
  
  public function updateProfile($data)
  {
    //connect to db and sanitize all input
    $db_conn = $this->connect();
    foreach ($data as $input)
    {
      $input = $this->sanitizeInput($input, $db_conn);
    }
    
    //Handle an empty ReferredBy field
    if ($data[12] == '') $data[12] = 0;
    
    //generate sql query, and attempt update
    $sql = "UPDATE MEMBER set FirstName='$data[1]', LastName='$data[2]', BirthDate='$data[3]', StreetAddress='$data[4]', City='$data[5]', State='$data[6]', Zip='$data[7]', HomePhone='$data[8]', CellPhone='$data[9]', Email='$data[10]', EmergencyContact='$data[11]',  ReferredBy='$data[12]', MembershipType='$data[13]' WHERE MemberID=$data[0]";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "updateProfile unable to update: ");
    
    return $result;
    
  }//end method updateProfile
  
  public function updatePicture($imagePath, $memberID)
  {
    $db_conn = $this->connect();
    $imagePath = $this->sanitizeInput($imagePath, $db_conn);
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    $sql = "UPDATE MEMBER SET Picture='$imagePath' WHERE MemberID=$memberID";
    
    $result = $db_conn->query($sql);
    
    if (!$result) $this->logError($db_conn, "Unable to update profile picture: ");
    
    $db_conn->close();
    
    return $result;
  }//end function updateImage
  
  
  public function getPendingClasses($memberID) 
  {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    /*First check if we have a member or non-member so we can return the the appropriate fees*/
    $memberType = $this->getMemberType($memberID);
    
    if ($memberType == 'Non-Member') {
      $sql = "SELECT ReferenceNumber, Date, Name, NonMemberFee AS Fee FROM PENDING_CLASSES";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "In getPendingClasses (Non-Member).  Unable to retrieve pending classes: ");
      $db_conn->close();
      return $result;
    }
    else {
      $sql = "SELECT ReferenceNumber, Date, Name, MemberFee AS Fee FROM PENDING_CLASSES";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "In getPendingClasses (Member).  Unable to retrieve pending classes: ");
      $db_conn->close();
      return $result;
    }
    
  } //end getPendingClasses
  
  
  public function getPendingEvents($memberID)
  {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
   
    /*Check if we have a member or non-member so we can return appropriate fees*/
    $memberType = $this->getMemberType($memberID);
    
    if ($memberType == 'Non-Member') {
      $sql = "SELECT ReferenceNumber, Date, Name, NonMemberFee AS Fee FROM PENDING_EVENTS";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "Unable to retrieve Non-Member pending events: ");
      $db_conn->close();
      return $result;
    }
    else {
      $sql = "SELECT ReferenceNumber, Date, Name, MemberFee AS Fee FROM PENDING_EVENTS";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "Unable to retrieve Non-Member pending events: ");
      $db_conn->close();
      return $result;
    }
    
  } //end getPendingEvents
  
  
  private function logError($db_conn, $message = '') {
      ini_set("log_errors", 1);
      ini_set("error_log", "php-error.log");
      $sqlError = $db_conn->error;
      error_log($message . " " . $sqlError);
  } //end function logError
  
  
  private function getMemberType ($MemberID) {
    $db_conn = $this->connect();
    $sql = "SELECT MembershipType FROM MEMBER WHERE MemberID = $MemberID";
    $MemberType = $db_conn->query($sql);
    
    if (!$MemberType) $this->logError($db_conn, "In getMemberType: Unable to retrieve MembershipType: ");
    
    $MemberType = $MemberType->fetch_assoc();
    $MemberType = $MemberType['MembershipType'];
    $db_conn->close();
    
    return $MemberType;
  }
  
}; //end class dbManager 





























?>
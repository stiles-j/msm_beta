<?php
// dbManager class for SpaceManager system

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
    $sql = "INSERT INTO Profile (FirstName, LastName, BirthDate, JoinDate, Address, HomePhone, CellPhone, Email, EmergencyContact, MedicalProvider, ReferredBy, MemberNumber, Picture, Level) VALUES ('$profileData[0]', '$profileData[1]', '$profileData[2]', '$profileData[3]', '$profileData[4]', '$profileData[5]', '$profileData[6]', '$profileData[7]', '$profileData[8]', '$profileData[9]', '$profileData[10]', $profileData[11], '$profileData[12]', '$profileData[13]')";
    
    $db_conn = $this->connect();
    
    $result = $db_conn->query($sql);
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
    $input = $db_conn->escape_string($input);
    
    if(get_magic_quotes_gpc())
      $input = stripslashes($input);
    $input = htmlentities($input);
    $input = strip_tags($input);
    
    return $input;
    
  } // end function sanitizeInput
  

  public function addCert($MemberNumber, $certName)
  {
    //connect to database and sanitize inputs
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    $certName = $this->sanitizeInput($certName, $db_conn);
    
    //generate SQL and attempt insert
    $sql = "INSERT INTO SafetyCerts (MemberNumber, CertName) VALUES ($MemberNumber, '$certName')";
    
    $result = $db_conn->query($sql);
    
    return $result;
    
  }//end function addCert
  
  /*Function addDonation records member donations in the database.  The function takes a member id number and donation amount as arguments and returns boolean indicating whether the insert of record was successful or not; true for success, false for failure.*/
  public function addDonation($MemberNumber, $amount)
  {
    //connect to database and sanitize inputs
    $db_conn = $this->connect();
    $this->sanitizeInput($MemberNumber, $db_conn);
    $this->sanitizeINput($amount, $db_conn);
    
    //generate sql and attempt query
    $sql = "INSERT INTO DonationHistory (Amount, MemberNumber) VALUES ('$amount', '$MemberNumber')";
    
    $result = $db_conn->query($sql);
    $db_conn->close();
    
    return $result;
    
  }//end method addDonation
 
  /*Function addClass attempts to add a new class to the database's "ClassesTaken" table.  The function requires three arguments, a member number as an int, a string containing the class name and a string in the form yyyy-mm-dd for the date the class was completed.  The function returns true on a successful insert or false on a failed insert.*/
  public function addClass($MemberNumber, $className, $dateCompleted)
  {
    //connect and sanitize inputs
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    $className = $this->sanitizeInput($className, $db_conn);
    $dateCompleted = $this->sanitizeInput($dateCompleted, $db_conn);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO ClassesTaken (MemberNumber, ClassName, DateTaken) VALUES ($MemberNumber, '$className', '$dateCompleted')";
    $result = $db_conn->query($sql);
    $db_conn->close();
    
    return $result;
  }//end method addClass
  
  
  public function addVolunteering($MemberNumber, $event, $date)
  {
    //establish connection to database and sanatize inputs
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    $event = $this->sanitizeInput($event, $db_conn);
    $date = $this->sanitizeInput($date, $db_conn);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO VolunteeringHistory (EventDate, Event, MemberNumber) VALUES ('$date', '$event', '$MemberNumber')";
    $result = $db_conn->query($sql);
    $db_conn->close();
    
    return $result;
    
  }//end method addVolunteering
  
  public function findMember($firstName, $lastName)
  {
    //connect to database and sanatize inputs
    $db_conn = $this->connect();
    $firstName = $this->sanitizeInput($firstName, $db_conn);
    $lastName = $this->sanitizeInput($lastName, $db_conn);
    
    /*generate sql, query database and return the result to the calling function*/
    $sql = "SELECT FirstName, LastName, MemberNumber FROM Profile WHERE FirstName='$firstName' OR LastName='$lastName'";
    
    $result = $db_conn->query($sql);
    
    return $result;
    
  }//end method findMember
  
  
  /*Function getAllNotes does exactly what it says on the tin, returning all member notes for a given member ID number.  The function requires a valid MemberID as an input and retrns an SQL result to the calling code*/
  public function getAllNotes($MemberNumber)
  {
    //establish connection and sanitze input
    $db_conn = $this->connect();
    $this->sanitizeInput($MemberNumber, $db_conn);
    
    //retrive all notes for the relevant user and return
    $sql = "SELECT * from ManagerNotes WHERE MemberNumber=$MemberNumber ORDER BY NoteTime DESC";
    $result = $db_conn->query($sql);
    $db_conn->close();
    return $result;
    
  }//end method getAllNotes
  
  public function getNewUserId()
  {
    /*The new member id number will be one greater than the highest number currently in the database*/
    $MemberNumber = 1;
    
    /*connect to the db and query*/
    $db_conn = $this->connect();
    $sql = "SELECT MemberNumber from Profile ORDER BY MemberNumber DESC LIMIT 1";
    $result = $db_conn->query($sql);
    
    /*Convert the result to an associative array, add it to MemberNumber and return the final total*/
    $result = $result->fetch_assoc();
    $MemberNumber += intval($result["MemberNumber"]);
    
    $db_conn->close();
    
    return $MemberNumber;
  }
  
  public function getUsername($MemberNumber)
  {
    //variables
    $nameString = '';
    
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    
    $sql = "SELECT FirstName, LastName FROM Profile WHERE MemberNumber = $MemberNumber";
    
    $result = $db_conn->query($sql);
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
  
  public function getPersonalInfo($MemberNumber)
  {
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    
    $sql = "SELECT FirstName, LastName, BirthDate, Address, HomePhone, CellPhone, Email, EmergencyContact, MedicalProvider, ReferredBy, Picture, Level, MemberNumber FROM Profile WHERE MemberNumber = $MemberNumber";
    
    $result = $db_conn->query($sql);
    $db_conn->close();
    
    return $result;
    
  }//end method getPersonalInfo
  
  public function getProfile($MemberNumber)
  {
    //Variables
    $image;
    $profile;
    $classesTaken;
    $certs;
    $donations;
    $visits;
    $volunteering;
    $notes;
    $output;
    $db_conn = $this->connect();
    
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    
    //collect all info for the profile screen
    $sql = "SELECT Picture FROM Profile WHERE MemberNumber = $MemberNumber";
    $image = $db_conn->query($sql);
    
    $sql = "SELECT FirstName, LastName, JoinDate, BirthDate, Level, TIMESTAMPDIFF(YEAR, BirthDate, CURDATE()) AS Age, MemberNumber FROM Profile WHERE MemberNumber=$MemberNumber";
    $profile = $db_conn->query($sql);
    
    $sql = "SELECT ClassName, DateTaken FROM ClassesTaken WHERE MemberNumber = $MemberNumber ORDER BY DateTaken DESC LIMIT 5";
    $classesTaken = $db_conn->query($sql);
    
    $sql = "SELECT CertName FROM SafetyCerts WHERE MemberNumber=$MemberNumber";
    $certs = $db_conn->query($sql);
    
    $sql = "SELECT Date, Amount FROM DonationHistory WHERE MemberNumber=$MemberNumber ORDER BY Date DESC LIMIT 1";
    $donations = $db_conn->query($sql);
    
    $sql = "SELECT LoginTime FROM LoginHistory WHERE MemberNumber=$MemberNumber ORDER BY LoginTime DESC Limit 5";
    $visits = $db_conn->query($sql);
    
    $sql = "SELECT EventDate, Event FROM VolunteeringHistory WHERE MemberNumber=$MemberNumber ORDER BY EventDate DESC LIMIT 5";
    $volunteering = $db_conn->query($sql);
    
    $sql = "SELECT NoteTime, Note FROM ManagerNotes WHERE MemberNumber = $MemberNumber ORDER BY NoteTime DESC LIMIT 5";
    $notes = $db_conn->query($sql);
    
    $db_conn->close();
    
    $output = array($image, $profile, $classesTaken, $certs, $donations, $visits, $volunteering, $notes, $MemberNumber);
    
    return $output; 
    
  } // end function getProfile
  
  public function recordLogin($MemberNumber)
  {
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    
    //Just insert member number because the table will auto fill login time with the current time
    $sql = "INSERT INTO LoginHistory (MemberNumber) VALUES ($MemberNumber)";
    $db_conn->query($sql);
    
    $db_conn->close();
  } //end function recordLogin
  
  public function recordLogout($MemberNumber)
  {
    $db_conn = $this->connect();
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    
    $sql = "UPDATE LoginHistory SET LogoutTime = NOW() Where MemberNumber = $MemberNumber LIMIT 1";
    $db_conn->query($sql);
    $db_conn->close();
    
  } //end function recordLogout
  
  public function recordNote($MemberNumber, $note)
  {
    $db_conn = $this->connect();
    
    //First sanitize all inputs
    $MemberNumber = $this->sanitizeInput($MemberNumber, $db_conn);
    $note = $this->sanitizeInput($note, $db_conn);
    
    //generate query and insert into database
    $sql = "INSERT INTO ManagerNotes (MemberNumber, Note) VALUES ($MemberNumber, '$note')";
    $result = $db_conn->query($sql);
    
    $db_conn->close();
    
  }//end function recordNote
  
  public function updateProfile($data)
  {
    //connect to db and sanitize all input
    $db_conn = $this->connect();
    foreach ($data as $input)
    {
      $this->sanitizeInput($input, $db_conn);
    }
    
    //generate sql query, and attempt update
    $sql = "UPDATE Profile set FirstName='$data[1]', LastName='$data[2]', BirthDate='$data[3]', Address='$data[4]', HomePhone='$data[5]', CellPhone='$data[6]', Email='$data[7]', EmergencyContact='$data[8]', MedicalProvider='$data[9]', ReferredBy='$data[10]', Level='$data[11]' WHERE MemberNumber=$data[0]";
    
    $result = $db_conn->query($sql);
    
    return $result;
    
  }//end method updateProfile
  
  public function updatePicture($imagePath, $MemberNumber)
  {
    $db_conn = $this->connect();
    $this->sanitizeInput($imagePath, $db_conn);
    $this->sanitizeInput($MemberNumber, $db_conn);
    
    $sql = "UPDATE Profile SET Picture='$imagePath' WHERE MemberNumber=$MemberNumber";
    
    $result = $db_conn->query($sql);
    $db_conn->close();
    
    return $result;
  }//end function updateImage
  
}; //end class dbManager 





























?>
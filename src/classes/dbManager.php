<?php
/*Database Manager class for SpaceManager system.  All database interactions
are handled through this class only.*/

class dbManager{
  
  //class login variables
  private $hostname, $username, $password, $database;
  
  public function __construct()
  {
    //first get login credentials; USERS WILL NEED TO INSERT THEIR CREDENTIALS HERE
    
    $this->hostname = 'localhost';
    $this->username = 'test';
    $this->password = 'dbtest';
    $this->database = 'members';
  } // end function __construct

  public function addAttendance ($memberID, $referenceNumber, $type) {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $referenceNumber = $this->sanitizeInput($referenceNumber, $db_conn);
    $type = $this->sanitizeInput($type, $db_conn);
    $result = null;
    $loginReferenceNumber = $this->getLastLogin($memberID);
    //determine where we need to handle the insert
    if ($type == 'CLASS') {
      $sql = "INSERT INTO CLASS_TAKEN (ClassReferenceNumber, MemberID, LoginReferenceNumber) VALUES ($referenceNumber, $memberID, $loginReferenceNumber)";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "addAttendance was unable to insert into CLASS_TAKEN: ");
    }
    else {
      $sql = "INSERT INTO EVENT_ATTENDED (EventReferenceNumber, MemberID, LoginReferenceNumber) VALUES ($referenceNumber, $memberID, $loginReferenceNumber)";
      $result = $db_conn->query($sql);
      if (!$result) $this->logError($db_conn, "addAttendance was unable to insert into EVENT_ATTENDED: ");
    }

    $db_conn->close();
    return $result;
  } //end function addAttendance

  public function addNewCert ($certName, $description) {
    $db_conn = $this->connect();
    $certName = $this->sanitizeInput($certName, $db_conn);
    $description = $this->sanitizeInput($description, $db_conn);
    $sql = "INSERT INTO CERTIFICATION VALUES ('$certName', '$description')";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "addNewCert was unable to insert a certification: ");
    $db_conn->close();
    return $result;
  }

  public function addNewClass ($courseID, $classDate) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $classDate = $this->sanitizeInput($classDate, $db_conn);
    $sql = "INSERT INTO CLASS (ClassDate, CourseID) VALUES ('$classDate', $courseID)";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "addNewClass was unable to insert a new record: ");
    $db_conn->close();
    return $result;
  } //end function addNewClass

  /*addNewCourse will add a new course to the database and return the courseID number.  Returns false if the
  attempt to insert fails*/
  public function addNewCourse ($courseName, $courseMemberFee, $courseNonMemberFee, $courseDescription, $courseDuration ='1:00:00', $courseFacilities = null) {
    //sanitize our inputs
    $db_conn = $this->connect();
    $courseName = $this->sanitizeInput($courseName, $db_conn);
    $courseNonMemberFee = $this->sanitizeInput($courseNonMemberFee, $db_conn);
    $courseMemberFee = $this->sanitizeInput($courseMemberFee, $db_conn);
    $courseDescription = $this->sanitizeInput($courseDescription, $db_conn);
    $courseDuration = $this->sanitizeInput($courseDuration, $db_conn);
    if ($courseFacilities != null) {
      foreach ($courseFacilities as &$courseFacility) {
        $courseFacility = $this->sanitizeInput($courseFacility, $db_conn);
      } //end foreach
    } //end if courseFacilities
    $errors = array();

    //attempt to insert the course
    $db_conn->begin_transaction();
    $sql = "INSERT INTO COURSE (CourseName, CourseDescription, CourseMemberFee, CourseNonMemberFee, Duration) VALUE ('$courseName', '$courseDescription', '$courseMemberFee', '$courseNonMemberFee', '$courseDuration')";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "addNewCourse was unable to insert into the database: ");
      array_push($errors, "addNewCourse was unable to insert into the database: ");
    }

    //get the courseID to return
    $id = $db_conn->insert_id;

    //attempt to add the facility requirements to COURSE_FACILITY
    if ($courseFacilities != null) {
      foreach ($courseFacilities as $facility) {
        $sql = "INSERT INTO COURSE_FACILITY (CourseID, FacilityID) VALUES ($id, $facility)";
        $result = $db_conn->query($sql);
        if (!$result) {
          $this->logError($db_conn, "addNewCourse was unable to insert a record into COURSE_FACILITY");
          array_push($errors, "addNewCourse was unable to insert a record into COURSE_FACILITY");
        } //end if !result
      } //end foreach
    } //end if courseFacilities

    //if we have no errors commit the transaction and return the course id
    if (empty($errors)) {
      $db_conn->commit();
      return $id;
    }

    //otherwise return false because the add failed
    return false;

  } //end method addNewCourse

  /**
   * addNewFacility attempts to add a record to the FACILITY table of the database.
   * If subFacilities are passed, it will additionally attempt to add those records to
   * the SUB_FACILITY table.
   *
   * @param $name: Name of the new facility
   * @param $description: A description of the facility. Use this to clarify potential ambiguities
   * @param null $subFacilities: Optional parameter, an array of subFacility FacilityID numbers
   * @return bool: True if the transaction is successful, false if not.
   */
  public function addNewFacility($name, $description, $subFacilities = null) {
    $db_conn = $this->connect();
    $name = $this->sanitizeInput($name, $db_conn);
    $description = $this->sanitizeInput($description, $db_conn);
    $errors = array();
    if ($subFacilities != null) {
      foreach ($subFacilities as &$subFacility) {
        $subFacility = $this->sanitizeInput($subFacility, $db_conn);
      }
    }

    $db_conn->begin_transaction();
    $sql = "INSERT INTO FACILITY (FacilityName, FacilityDescription) VALUES ('$name', '$description')";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "Unable to add new facility to database: ");
      array_push($errors, "Error in query adding facility to database");
    }
    $facilityID = $db_conn->insert_id;

    //add subFacilities if we have them
    if ($subFacilities != null) {
      foreach ($subFacilities as $sub) {
        $sql = "INSERT INTO SUB_FACILITY (PrimaryFacilityID, SubFacilityID) VALUES ($facilityID, $sub)";
        $result = $db_conn->query($sql);
        if (!$result) {
          $this->logError($db_conn, "Unable to add new SubFacility to database: ");
          array_push($errors, "Error in query adding subFacility to database");
        } //end if !$result
      } //end foreach subFacilities
    } //end if subFacilities

    //if we encountered no errors, commit the transaction
    if (empty($errors)) {
      $db_conn->commit();
      $db_conn->close();
      return true;
    }

    //otherwise roll it back
    $db_conn->rollback();
    $db_conn->close();
    return false;

  } //end function addNewFacility

  /*addProfile will insert provided information into the database.  The required argument is a numeric array of user data in the following format: firstName, lastName, birthDate, joinDate, address, homePhone, cellphone, email, emergency contact, medical provider, referred by, member id number, user image, level.  Null values should be  used in place of any missing information. The function will return true on a successful insert or false on a failed insert*/
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

  public function addCourseCert ($courseID, $cert) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $cert = $this->sanitizeInput($cert, $db_conn);
    $sql = "INSERT INTO COURSE_CERTIFICATION (CourseID, CertName) VALUES ($courseID, '$cert')";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "addCourseCert was unable to add a new record: ");
    $db_conn->close();
    return $result;
  } //end function addCourseCert

  public function addMemberCert($MemberID, $certName)
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
  
  /*Function addPayment records member donations in the database.  The function takes a member id number and donation amount as arguments and returns boolean indicating whether the insert of record was successful or not; true for success, false for failure.*/
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
    
  }//end method addPayment

  /**
   * Function addClassTaken attempts to add a new class to the database's "ClassesTaken" table.  The function requires three arguments, a member
   * number as an int, a string containing the class name and a string in the form yyyy-mm-dd for the date the class was completed.  The function
   * returns true on a successful insert or false on a failed insert.
   *
   * @param $MemberID
   * @param $classReferenceNumber
   * @param $loginReferenceNumber
   * @return bool|mysqli_result
   */
  public function addClassTaken($MemberID, $classReferenceNumber, $loginReferenceNumber)
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

  public function addClassEnrollment($memberID, $classReferenceNumber, $paymentReferenceNumber) {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    $paymentReferenceNumber = $this->sanitizeInput($paymentReferenceNumber, $db_conn);
    
    $sql = "INSERT INTO CLASS_ENROLLMENT (MemberID, ClassReferenceNumber, PaymentReferenceNumber) VALUES ($memberID, $classReferenceNumber, $paymentReferenceNumber)";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "Unable to add new class enrollment: ");
    $db_conn->close();
    return $result;
  }

  public function addEventEnrollment($memberID, $eventReferenceNumber, $paymentReferenceNumber) {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $eventReferenceNumber = $this->sanitizeInput($eventReferenceNumber, $db_conn);
    $paymentReferenceNumber = $this->sanitizeInput($paymentReferenceNumber, $db_conn);
    
    $sql = "INSERT INTO EVENT_ENROLLMENT (MemberID, EventReferenceNumber, PaymentReferenceNumber) VALUES ($memberID, $eventReferenceNumber, $paymentReferenceNumber)";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "Unable to add new event enrollment: ");
    $db_conn->close();
    return $result;
  }

  public function addEventVolunteer($memberID, $eventReferenceNumber)
  {
    //establish connection to database and sanatize inputs
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $eventReferenceNumber = $this->sanitizeInput($eventReferenceNumber, $db_conn);

    //Get the most recent login reference number (can't enter volunteering unless the member is logged in)
    $loginReferenceNumber = $this->getLastLogin($memberID);
    
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
    
    //Get the most recent login reference number (can't enter volunteering unless the member is logged in)
    $loginReferenceNumber = $this->getLastLogin($memberID);
    
    //generate SQL and attempt query
    $sql = "INSERT INTO CLASS_VOLUNTEER (MemberID, ClassReferenceNumber, LoginReferenceNumber) VALUES ('$memberID', '$classReferenceNumber', '$loginReferenceNumber')";
    
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in addClassVolunteer: ");
    
    $db_conn->close();
    return $result;
    
  } //end function addClassVolunteer

  /**
   * Method checkFacilityScheduleConflict searches for potential schedule conflicts in facilities.
   * The method requires a date, start time, end time and the facilityID you want to check for potential conflicts.
   * The method will return a mysqli result containing data on conflicting schedule items if conflicts exists,
   * or false if they do not.
   *
   * @param $facilityID: a valid facility ID number
   * @param $startTime: the start of the time period to check for conflicts in the format yyyy/mm/dd hh:mm:ss
   * @param $duration: the duration of the event in the format hh:mm:ss
   * @return bool|mysqli_result: mysqli_result containing data on conflicting events if they exist, false if no conflicts
   */
  public function checkFacilityScheduleConflict ($facilityID, $startTime, $duration) {
    $db_conn = $this->connect();
    $facilityID = $this->sanitizeInput($facilityID, $db_conn);
    $startTime = $this->sanitizeInput($startTime, $db_conn);
    $duration = $this->sanitizeInput($duration, $db_conn);

    $sql = "SELECT * FROM FACILITY_SCHEDULE WHERE FacilityID = $facilityID AND StartTime BETWEEN '$startTime' AND ADDTIME('$startTime', '$duration') OR FacilityID = $facilityID AND EndTime BETWEEN '$startTime' AND ADDTIME('$startTime', '$duration') OR '$startTime' BETWEEN StartTime AND EndTime";
    $result = $db_conn->query($sql);
    $db_conn->close();
    if ($result->num_rows == 0) return false;
    return $result;
  }

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

  /*Function getAllNotes does exactly what it says on the tin, returning all member notes for a given member ID number.  The function requires a valid MemberID as an input and returns an SQL result to the calling code*/
  public function getAllNotes($memberID)
  {
    //establish connection and sanitze input
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    //retrive all notes for the relevant user and return
    $sql = "SELECT * from NOTES WHERE MemberID=$memberID ORDER BY NoteTime DESC";
    $result = $db_conn->query($sql);
    
    if (!$result)
      $this->logError($db_conn, "Error in getAllNotes: ");
    $db_conn->close();
    
    return $result;
    
  }//end method getAllNotes

  public function getAllCertifications() {
    $db_conn = $this->connect();
    $sql ="SELECT CertName FROM CERTIFICATION";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "Unable to retrieve list of certifications from database: ");
    $db_conn->close();

    //turn the sql result into an array
    $output = array();
    while ($name = $result->fetch_array()) {
      $output[] = $name['CertName'];
    }

    return $output;
  }

  public function getAllCourses() {
    $db_conn = $this->connect();
    $sql = "SELECT CourseID, CourseName FROM COURSE ORDER BY CourseName";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getAllCourses was unable to retrieve course list: ");
    $db_conn->close();
    return $result;
  }

  /**
   * getAllFacilities returns a mysqli result containing all columns of all records in the FACILITY table
   *
   * @return bool|mysqli_result
   */
  public function getAllFacilities() {
    $db_conn = $this->connect();
    $sql = "SELECT * FROM FACILITY ORDER BY FacilityName";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getAllFacilities was unable to retrieve facility list from the database: ");
    $db_conn->close();
    return $result;
  }

  /*getClassCertifications returns an array of all the certifications associated with a class by
  looking at the underlying course information*/
  public function getClassCertifications($classReferenceNumber) {
    $db_conn = $this->connect();
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    $sql = "SELECT CourseID FROM CLASS WHERE ClassReferenceNumber = $classReferenceNumber";

    //find the CourseID
    $courseID = $db_conn->query($sql);
    if (!$courseID) $this->logError($db_conn, "getClassCertifications was unable to retrieve CourseID: ");
    $courseID = $courseID->fetch_assoc()['CourseID'];

    //get the certs associated with this course
    $output = $this->getCourseCertifications($courseID);
    $db_conn->close();
    return $output;

  } //end function getClassCertifications

  /*getCourseCertification returns all certifications associated with a course as an array*/
  public function getCourseCertifications($courseID) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $output = array();

    //get the certs associated with this course
    $sql = "SELECT CertName FROM COURSE_CERTIFICATION WHERE CourseID = $courseID";
    $certs = $db_conn->query($sql);
    if (!$certs) $this->logError($db_conn, "getClassCertification was unable to get the list of certs: ");

    //package the sql result into the output and return
    if ($certs->num_rows == 0) return false;

    foreach($certs as $cert) {
      $output[] = $cert['CertName'];
    }

    $db_conn->close();
    return $output;

  } //end function getCourseCertification

  /**
   * getCourseFacilities returns a mysqli result containing the CourseID, FacilityID and FacilityName
   * for all facilities associated with a course
   *
   *TODO: SHOULD THIS FUNCTION BE DEPRECATED AND REPLACED WITH getFacilityList($refNumber, $type)?
   *
   * @param $courseID: a valid CourseID number
   * @return mysqli_result|bool: A mysqli result containing the listed information from the database if the
   * query is a success, or false if the query fails.
   */
  public function getCourseFacilities($courseID) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $sql = "SELECT * FROM COURSE_FACILITY_WITH_NAME WHERE CourseID = $courseID";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getCourseFacilities was unable to retrieve facility list: ");
    $db_conn->close();
    return $result;
  } //end function getCourseFacilities

  public function getCourseInfo($courseID) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $sql = "SELECT CourseID, CourseName, CourseDescription, CourseMemberFee, CourseNonMemberFee, Duration FROM COURSE WHERE CourseID = $courseID";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getCourseInfo was unable to retrieve information on course: ");
    $db_conn->close();

    //Turn the result into an associative array and send that back since the function only returns results for one course
    $result = $result->fetch_assoc();
    return $result;
  } //end function getCourseInfo

  public function getEventInfo($eventReferenceNumber) {
    $db_conn = $this->connect();
    $eventReferenceNumber = $this->sanitizeInput($eventReferenceNumber, $db_conn);
    $sql = "SELECT * FROM EVENT WHERE EventReferenceNumber = $eventReferenceNumber";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getEventInfo was unable to retrieve information on an event: ");
    $db_conn->close();
    $result = $result->fetch_assoc();
    return $result;
  }

  /**
   * getFacilityInfo returns a mysqli result containing FacilityID, FacilityName and FacilityDescription
   * for a single facility if the query succeeds or false if the query fails.
   *
   * @param $facilityID: a valid FacilityID number
   * @return bool|mysqli_result: mysqli_result if the query succeeds, false if it fails.
   */
  public function getFacilityInfo($facilityID) {
    $db_conn = $this->connect();
    $facilityID = $this->sanitizeInput($facilityID, $db_conn);
    $sql = "SELECT * FROM FACILITY WHERE FacilityID = $facilityID";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getFacilityInfo was unable to retrieve a record: ");
    $db_conn->close();
    return $result;
  }

  /**
   * Method getFacilityList will return an array of FacilityID numbers for facilities and sub-facilities required for
   * either a course or event
   *
   * @param $refNumber: A valid CourseID or EventReferenceNumber
   * @param $type: a string literal. Valid inputs are "course" or "event".  The method will default to event in the
   *               case of an invalid input.
   * @return array|bool: An array of FacilityID numbers for all required facilities and associated sub-facilities if
   *                     there are any associated with the course or event.  False if there are none.
   */
  public function getFacilityList($refNumber, $type) {
    $db_conn = $this->connect();
    $refNumber = $this->sanitizeInput($refNumber, $db_conn);
    $type = $this->sanitizeInput($type, $db_conn);
    $output = array();

    //get the list of facilities
    if ($type == "course") {
      $sql = "SELECT FacilityID FROM COURSE_FACILITY WHERE CourseID = $refNumber";
    } else {
      $sql = "SELECT FacilityID FROM EVENT_FACILITY WHERE EventReferenceNumber = $refNumber";
    }
    $facilities = $db_conn->query($sql);

    //package the results into the output array
    foreach ($facilities as $facility) {
      $output[] = $facility['FacilityID'];
    }

    //check for sub-facilities
    if ($facilities != null) {
      foreach ($facilities as $facility) {
        $subFacilities = $this->getSubFacilities($facility['FacilityID']);
        //if we found sub-facilities, package them into the output array
        if ($subFacilities != null) {
          foreach ($subFacilities as $subFacility) {
            $output[] = $subFacility;
          }//end foreach subFacilities
        } //end if subFacilities
      } //end foreach facilities
    } //end if facilities
    $db_conn->close();

    if (!empty($output)) return $output;
    return false;

} //end function getFacilityList

  public function getLastPayment($memberID) {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);

    $sql = "SELECT * FROM PAYMENT WHERE MemberID = $memberID ORDER BY PaymentReferenceNumber DESC LIMIT 1";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getLastPayment received an invalid response from the database: ");
    $db_conn->close();
    $result = $result->fetch_assoc();
    return $result;
  }

  /**
   * getMemberPayments returns all payment records in the database of the type specified in the $type parameter.
   *
   * @param $memberID: A valid MemberID number
   * @param $type: an optional parameter to specify the type of payments returned.  Valid inputs are 'dues' and 'other'.
   * A value of 'dues' will return only payments tagged with the reason 'dues' in the database.  A value of 'other' will
   * return all payments NOT tagged 'dues' in the database.  Any other value (or not passing the parameter at all) will
   * return all payments regardless of type.
   * @return bool|mysqli_result: A mysqli result consisting of all the the relevant records if the query is successful.
   *  false if the query fails.  If you need to limit the number of records displayed, this will need to be handled in
   *  client code.
   */
  public function getMemberPayments($memberID, $type = 'all') {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $sql = null;

    if ($type == 'dues') {
      $sql = "SELECT * FROM PAYMENT_WITH_NAME WHERE MemberID = $memberID AND Reason = 'dues' ORDER BY PaymentDate DESC";
    }
    else if ($type == 'other') {
      $sql = "SELECT * FROM PAYMENT_WITH_NAME WHERE MemberID = $memberID AND Reason != 'dues' ORDER BY PaymentDate DESC";
    }
    else {
      $sql = "SELECT * FROM PAYMENT_WITH_NAME WHERE MemberID = $memberID ORDER BY PaymentDate DESC";
    }

    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getMemberPayments was unable to retrieve records: ");
    $db_conn->close();
    return $result;
  } //end function getMemberDuesPayments

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
  } // end function getNewUserId
  
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
    $image = null;
    $profile = null;
    $enrollments = null;
    $certs = null;
    $otherPayments = null;
    $visits = null;
    $volunteering = null;
    $notes = null;
    $output = null;
    $db_conn = $this->connect();
    
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    
    //collect all info for the profile screen
    $sql = "SELECT Picture FROM MEMBER WHERE MemberID = $memberID";
    $image = $db_conn->query($sql);
    
    if (!$image)
      $this->logError($db_conn, "getProfile unable to retrieve Picture: ");
    
    $sql = "SELECT FirstName, LastName, DATE(JoinDate) AS JoinDate, BirthDate, MembershipType, TIMESTAMPDIFF(YEAR, BirthDate, CURDATE()) AS Age, MemberID FROM MEMBER WHERE MemberID=$memberID";
    $profile = $db_conn->query($sql);
    
    if (!$profile)
      $this->logError($db_conn, "getProfile unable to retrieve profile data: ");
    
    $sql = "SELECT MemberID, ReferenceNumber, Name, DATE(Date) as Date, Type FROM PENDING_ENROLLMENTS WHERE MemberID = $memberID ORDER BY Date LIMIT 5";
    $enrollments = $db_conn->query($sql);
    
    if (!$enrollments)
      $this->logError($db_conn, "getProfile unable to get enrollments: ");
    
    $sql = "SELECT CertName FROM MEMBER_CERTIFICATION WHERE MemberID=$memberID";
    $certs = $db_conn->query($sql);
    
    if (!$certs)
      $this->logError($db_conn, "getProfile unable to get certs: ");
    
    $sql = "SELECT PaymentDate, Amount FROM PAYMENT WHERE MemberID=$memberID AND Reason != 'dues' ORDER BY PaymentDate DESC LIMIT 1";
    $otherPayments = $db_conn->query($sql);
    
    if (!$otherPayments)
      $this->logError($db_conn, "getProfile unable to get payments: ");

    $sql = "SELECT PaymentDate, Amount FROM PAYMENT WHERE MemberID=$memberID AND Reason = 'dues' ORDER BY PaymentDate DESC LIMIT 1";
    $duesPayments = $db_conn->query($sql);
    if (!$duesPayments) $this->logError($db_conn, "getProfile was unable to retrieve last dues payment: ");


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
    
    $output = array($image, $profile, $enrollments, $certs, $otherPayments, $visits, $volunteering, $notes, $memberID, $duesPayments);
    
    return $output; 
    
  } // end function getProfile

  /**
   * Function getPendingClassInfo returns pertinent information on a class
   *
   * @param $classReferenceNumber a valid classReferenceNumber
   * @return array|bool an associative array containing the class ReferenceNumber, Date, Name, MemberFee
   * and NonMemberFee if the query is successful, or false if it is not
   */
  public function getPendingClassInfo ($classReferenceNumber) {
    $db_conn = $this->connect();
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    $sql = "SELECT * FROM PENDING_CLASSES WHERE ReferenceNumber = $classReferenceNumber";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "getPendingClassInfo was unable to retrieve class data: ");
      $db_conn->close();
      return $result;
    }
    $db_conn->close();
    $result = $result->fetch_assoc();
    return $result;
  }

  public function getPendingClasses($memberID = 0)
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

  public function getPendingEventInfo($eventReferenceNumber) {
    $db_conn = $this->connect();
    $eventReferenceNumber = $this->sanitizeInput($eventReferenceNumber, $db_conn);
    $sql = "SELECT * FROM PENDING_EVENTS WHERE ReferenceNumber = $eventReferenceNumber";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getEventInfo was unable to retrieve information on an event: ");
    $db_conn->close();
    $result = $result->fetch_assoc();
    return $result;
  }

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
      if (!$result) $this->logError($db_conn, "Unable to retrieve Member pending events: ");
      $db_conn->close();
      return $result;
    }
    
  } //end getPendingEvents

  public function getPendingEnrollments($memberID) {
    $db_conn = $this->connect();
    $memberID = $this->sanitizeInput($memberID, $db_conn);
    $sql = "SELECT * FROM PENDING_ENROLLMENTS WHERE MemberID = $memberID";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "Unable to retrieve pending enrollments: ");
    $db_conn->close();
    return $result;
  } //end getPendingEnrollments

  /**
   * getSubFacilities returns an array containing the SubFacilityID of all sub-facilities associated with a
   * given single PrimaryFacility.  Results are checked recursively, so the sub-facilities of sub-facilities will be
   * returned properly.
   *
   * @param $facilityID: a valid FacilityID
   * @return bool|array False if there are no sub-facilities, an array containing a list of FacilityIDs if there
   * are sub-facilities
   */
  public  function getSubFacilities($facilityID) {

    $db_conn = $this->connect();
    $facilityID = $this->sanitizeInput($facilityID, $db_conn);
    $output = array();

    $sql = "SELECT * FROM SUB_FACILITY WHERE PrimaryFacilityID = $facilityID";
    $results = $db_conn->query($sql);
    $db_conn->close();

    if ($results->num_rows == 0) {
        return false;
      }

    //package the list of subFacilityIDs into the output array
    foreach ($results as $result) {
      $output[] = $result['SubFacilityID'];
    }

    //get and sub-facilities that the sub-facilities themselves have
    $subSub = false;
    foreach ($output as $sub) {
      $subSub = $this->getSubFacilities($sub);
      //add the additional sub-facilities to the output
      if ($subSub){
        foreach ($subSub as $additional) {
          $output[] = $additional;
        } //end foreach subSub
      } //end if subSub
    } //end foreach output as sub

    return $output;

  } //end method getSubFacilities

  public function getTodaysEvents() {
    $db_conn = $this->connect();
    $sql = "SELECT * FROM PENDING_ALL WHERE DATE(Date) = CURDATE()";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "Unable to retrieve todays events from database: ");
    $db_conn->close();
    return $result;
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

    if ($result && mysqli_num_rows($result) != 0)
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

  public function updateClass($classReferenceNumber, $newClassDate) {
    $db_conn = $this->connect();
    $classReferenceNumber = $this->sanitizeInput($classReferenceNumber, $db_conn);
    $newClassDate = $this->sanitizeInput($newClassDate, $db_conn);
    $sql = "UPDATE CLASS SET ClassDate = '$newClassDate' WHERE ClassReferenceNumber = $classReferenceNumber";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "updateClass was unable to modify a record: ");
    $db_conn->close();
    return $result;
  } //end function updateClass

  public function updateCourse ($courseID, $courseName, $courseDuration, $courseMemberFee, $courseNonMemberFee, $courseDescription, $courseCerts = null, $courseFacilities = null) {
    $db_conn = $this->connect();
    $courseID = $this->sanitizeInput($courseID, $db_conn);
    $courseName = $this->sanitizeInput($courseName, $db_conn);
    $courseMemberFee = $this->sanitizeInput($courseMemberFee, $db_conn);
    $courseNonMemberFee = $this->sanitizeInput($courseNonMemberFee, $db_conn);
    $courseDescription = $this->sanitizeInput($courseDescription, $db_conn);
    if ($courseCerts != null) {
      foreach ($courseCerts as &$courseCert) {
        $courseCert = $this->sanitizeInput($courseCert, $db_conn);
      }
    }
    if ($courseFacilities != null) {
      foreach ($courseFacilities as &$courseFacility) {
        $courseFacility = $this->sanitizeInput($courseFacility, $db_conn);
      }
    }
    $errors = array();

    $db_conn->begin_transaction();

    //first update the base course info
    $sql = "UPDATE COURSE SET CourseName = '$courseName', Duration = '$courseDuration', CourseMemberFee = $courseMemberFee, CourseNonMemberFee = $courseNonMemberFee, CourseDescription = '$courseDescription' WHERE CourseID = $courseID";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "updateCourse was unable to update a record: ");
      array_push($errors, "updateCourse was unable to update a record: ");
    }

    //update the course certs
    //delete the old certs
    $sql = "DELETE FROM COURSE_CERTIFICATION WHERE CourseID = $courseID";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "updateCourse was unable to remove certification records: ");
      array_push($errors, "updateCourse was unable to remove certification records: ");
    }

    if ($courseCerts != null) {
      //add the new certs
      foreach ($courseCerts as $courseCert) {
        $sql = "INSERT INTO COURSE_CERTIFICATION (CourseID, CertName) VALUES ($courseID, '$courseCert')";
        $result = $db_conn->query($sql);
        if (!$result) {
          $this->logError($db_conn, "updateCourse was unable to add a record to COURSE_CERTIFICATION: ");
          array_push($errors, "updateCourse was unable to add a record to COURSE_CERTIFICATION: ");
        } //end if !$result
      } //end foreach courseCerts
    } //end if courseCerts

    //update the facilities
    //delete the old course facilities
    $sql = "DELETE FROM COURSE_FACILITY WHERE CourseID = $courseID";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "updateCourse was unable to delete records from COURSE_FACILITY: ");
      array_push($errors, "updateCourse was unable to delete records from COURSE_FACILITY: ");
    }
    //add new course facilities if we have them
    if ($courseFacilities != null) {
      //add the new course facilities
      foreach ($courseFacilities as $facility) {
        $sql = "INSERT INTO COURSE_FACILITY (CourseID, FacilityID) VALUES ($courseID, $facility)";
        $result = $db_conn->query($sql);
        if (!$result) {
          $this->logError($db_conn, "updateCourse was unable to insert a new record into COURSE_FACILITY: ");
          array_push($errors, "updateCourse was unable to insert a new record into COURSE_FACILITY: ");
        }
      } //end foreach courseFacilities
    } //end update course facilities

    if (empty($errors)) {
      $db_conn->commit();
      $db_conn->close();
      return true;
    }

    $db_conn->rollback();
    $db_conn->close();
    return false;
  } //end function updateCourse

  public function updateFacility($facilityID, $facilityName, $facilityDescription, $subFacilities = null) {
    $db_conn = $this->connect();
    $facilityID = $this->sanitizeInput($facilityID, $db_conn);
    $facilityName = $this->sanitizeInput("$facilityName", $db_conn);
    $facilityDescription = $this->sanitizeInput("$facilityDescription", $db_conn);
    if ($subFacilities) {
      foreach ($subFacilities as &$subFacility) {
        $subFacility = $this->sanitizeInput("$subFacility", $db_conn);
      }
    }
    $errors = array();

    $db_conn->begin_transaction();
    $sql = "UPDATE FACILITY SET FacilityName = '$facilityName', FacilityDescription = '$facilityDescription' WHERE FacilityID = $facilityID";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "updateFacility was unable to update information in the FACILITY table: ");
      $errors[] = "updateFacility was unable to update information in the FACILITY table: ";
    }

    //delete subFacilities
    $sql = "DELETE FROM SUB_FACILITY WHERE PrimaryFacilityID = $facilityID";
    $result = $db_conn->query($sql);
    if (!$result) {
      $this->logError($db_conn, "updateFacility was unable to delete records from the SUB_FACILITY table: ");
      $errors[] = "updateFacility was unable to delete records from the SUB_FACILITY table: ";
    }

    //add new subFacilities if there are any
    if ($subFacilities) {
      foreach ($subFacilities as $sub) {
        $sql = "INSERT INTO SUB_FACILITY (PrimaryFacilityID, SubFacilityID) VALUES ($facilityID, $sub)";
        $result = $db_conn->query($sql);
        if (!$result) {
          $this->logError($db_conn, "updateFacility was unable to insert a new record into the SUB_FACILITY table");
          $errors[] = "updateFacility was unable to insert a new record into the SUB_FACILITY table";
        }
      } //end foreach subFacilities
    }//end if subFacilities

    if (empty($errors)) {
      $db_conn->commit();
      $db_conn->close();
      return true;
    }

    $db_conn->rollback();
    $db_conn->close();
    return false;

  } //end function updateFacility

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


  /*Private Functions*/
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

  private function getLastLogin($memberID) {
    $db_conn = $this->connect();
    $sql = "SELECT LoginReferenceNumber FROM LOGIN WHERE MemberID = $memberID ORDER BY LoginReferenceNumber DESC LIMIT 1";
    $result = $db_conn->query($sql);
    if (!$result) $this->logError($db_conn, "getLastLogin was unable to get members last login reference number: ");
    $loginReferenceNumber = $result->fetch_assoc()['LoginReferenceNumber'];
    $db_conn->close();
    return $loginReferenceNumber;
  }

  private function logError($db_conn, $message = '') {
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");
    $sqlError = $db_conn->error;
    error_log($message . " " . $sqlError);
  } //end function logError

  private function sanitizeInput($input, $db_conn)
  {
    if(get_magic_quotes_gpc())
      $input = stripslashes($input);

    $input = $db_conn->escape_string($input);
    $input = strip_tags($input);
    $input = htmlentities($input, ENT_QUOTES);

    return $input;

  } // end function sanitizeInput



  
}; //end class dbManager 





























?>
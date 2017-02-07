<?php
// Output Manager class for the SpaceManager program

class OutputManager{
  
  private $popUp;
  
  public function __construct()
  {
    require_once "PopUpManager.php";
    echo file_get_contents("header.html");
    echo file_get_contents("nav.html");
    
    $this->popUp = new PopUpManager; 
  } //end function __construct
  
  public function __destruct()
  {
    $close = <<<_END
    </div>
  </body>
</html>
_END;

    echo $close;
  } // end function __destruct
  
  public function insertDiv($divClass, $contents, $header = '')
  {
    
    echo "<div class='$divClass'>";
    if($header != '')
      echo "<h3>$header</h3>";
    
    foreach ($contents as $item)
      echo "$item <br />";
    
    
    echo "</div>";
    
  } // end method insertDiv

  public function displayProfile($profile)
  {
    echo "<div class='profileWindow'>";
    
    //display profile pic
    $image = mysqli_fetch_assoc($profile[0]);
    if ($image['Picture'] == NULL)
    {
      echo "<img src='images/default.jpg' class='profilePic' />";
    } // end if
    else
    {
      echo "<img src='$image[Picture]' class='profilePic' />";
    } //end else
    
    
    //display basic member info
    $basics = mysqli_fetch_assoc($profile[1]);
    echo "<div class='profileElement'>";
    echo "<h3>Basic Info</h3>";
    echo "<p>Member Name:<br /> $basics[FirstName] $basics[LastName] </p>";
    echo "<p>DOB:<br /> $basics[BirthDate] <br />";
    if ($basics['Age'] < 18)
      echo "<font color='red'>AGE: $basics[Age]</font></p>";
    else
      echo "<font color='green'>AGE: $basics[Age]</font></p>";
    echo "<p>Member Since:<br /> $basics[JoinDate]</p> <p>Membership Type:<br /> $basics[MembershipType] </p>"; 
    echo "<p>Member Number:<br /> $profile[8] </p>";
    echo "</div>";
    
    
    //display enrollments and certs
    echo "<div class='profileElement'>";
    echo "<h3>Enrollments and Certifications</h3>";

    //ENROLLMENTS
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='viewAllEnrollments' value='$profile[8]'><input type='hidden' name='display_member' value='$profile[8]'><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Enrollments:</strong></a></form></p>";

    if ($profile[2]->num_rows != 0) {
      $memberEnrollments = $this->prepEnrollment($profile[2]);
      foreach ($memberEnrollments as $memberEnrollment) {
        echo $memberEnrollment;
      } //end foreach
    } //end if

    //CERTIFICATIONS
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addCert' value='$profile[8]'><input type='hidden' name='display_member' value='$profile[8]'><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Certifications:</strong></a></form></p>";
    foreach ($profile[3] as $cert)
      echo "<p>$cert[CertName]</p>";
    echo "</div>"; //end enrollments and certs div
    
    
    //display payments, visits, volunteering (recent activity div)
    echo "<div class='profileElement'>";
    echo "<h3>Recent Activity</h3>";
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addPayment' value='$profile[8]'><input type='hidden' name='display_member' value='$profile[8]'><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Last Payment:</strong></a></form></p>";
    $payment = mysqli_fetch_array($profile[4]);
    //convert donation date to readable format
    $paymentDate = date("Y-m-d", strtotime($payment['PaymentDate']));
    //check for a bogus date and blank it out if bogus
    if ($paymentDate == "1969-12-31")
      $paymentDate = '';
    
    /*If last payment is more than 30 days ago, display it in red*/
    if (strtotime($paymentDate) < strtotime('-30 days')) {
      echo "<p><font color='red'>$paymentDate: \$$payment[Amount]</font></p>";
    } else {
      echo "<p>$paymentDate: \$$payment[Amount]</p>";      
    }

    echo "<p><strong>Recent Visits:</strong></p>";
    foreach ($profile[5] as $visit)
      echo "<p>$visit[LoginTime]</p>";
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addVolunteering' value='$profile[8]'><input type='hidden' name='display_member' value='$profile[8]'><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Volunteering:</strong></a></form></p>";
    foreach ($profile[6] as $event)
      echo "<p>$event[Date]: <br /> $event[Name]</p>";
    echo "</div>"; // end recent activity div
    
    
    //display Manager Notes
    
    /*Pull the member id number out of the profile array so it can be used in the form below*/
    $MemberNumber = $profile[8];
    
    echo "<div class='notes'>";
    /*The HTML below turns the "NOTES" header into a CSS powered drop-down list with embedded forms in each menu item.  The forms feed information to the popup system so the relevant information can be either collected or displayed via pop-ups.*/
    
    /*TODO: This is an (almost) entirely server-side solution and will eventually be replaced with a JavaScript solution.  The replacement will be more responsive on the user's end. Any advantage gained by handling everything server side is not worth the performance hit for the user.*/
    echo "<nav>
            <ul>
              <li class='dropdown' id='noteMenu'><a><h3>Notes</h3></a>
                <ul class='dropdown-content'>
                  <li>
                    <form id='addNote' action='smTest.php' method='post'>
                      <input type='hidden' name='noteAdd' value='noteAdd' /> 
                      <input type='hidden' name='display_member' value='$MemberNumber' /> 
                      <a href='#' onclick='this.parentNode.submit(); return false;'>Add Note</a>
                    </form>
                  </li>
                  <li>
                    <form action='smTest.php' method='post'>
                      <input type='hidden' name='viewAllNotes' value='$MemberNumber'> 
                      <a href='#' onclick='this.parentNode.submit(); return false;'>View All</a>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>";

    foreach ($profile[7] as $note)
      echo "<p><strong>$note[NoteTime]:</strong> $note[NoteText]</p>";
    echo "</div>"; // end manager note div
    
    echo "</div>"; //end profile window div

  } // end function displayProfile 
  
  public function displayDefaultProfile() {
    echo "<div class='profileWindow'>";

    //display profile pic
    echo "<img src='images/default.jpg' class='profilePic' />";

    //display basic member info
    echo "<div class='profileElement'>";
    echo "<h3>Basic Info</h3>";
    echo "<p>Member Name:<br /> </p>";
    echo "<p>DOB:<br /> <br />";
    echo "<p>Member Since:<br /> </p> <p>Membership Type:<br /> </p>";
    echo "<p>Member Number:<br /> </p>";
    echo "</div>";


    //display enrollments and certs
    echo "<div class='profileElement'>";
    echo "<h3>Enrollments and Certifications</h3>";

    //ENROLLMENTS
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='viewAllEnrollments' value=''><input type='hidden' name='display_member' value=''><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Enrollments:</strong></a></form></p>";
    echo "<p> </p>";

    //CERTIFICATIONS
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addCert' value=''><input type='hidden' name='display_member' value=''><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Certifications:</strong></a></form></p>";
    echo "<p> </p>";
    echo "</div>"; //end enrollments and certs div


    //display payments, visits, volunteering (recent activity div)
    echo "<div class='profileElement'>";
    echo "<h3>Recent Activity</h3>";
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addDonation' value=''><input type='hidden' name='display_member' value=''><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Last Payment:</strong></a></form></p>";
    echo "<p> </p>";


    echo "<p><strong>Recent Visits:</strong></p>";
      echo "<p> </p>";
    echo "<p><form action='smTest.php' method='post'><input type='hidden' name='addVolunteering' value=''><input type='hidden' name='display_member' value=''><a href='#' class='dashButton' onclick='this.parentNode.submit(); return false;'><strong>Volunteering:</strong></a></form></p>";
    echo "<p> <br /> </p>";
    echo "</div>"; // end recent activity div


    //display Manager Notes

    echo "<div class='notes'>";

    echo "<nav>
            <ul>
              <li class='dropdown' id='noteMenu'><a><h3>Notes</h3></a>
                <ul class='dropdown-content'>
                  <li>
                    <form id='addNote' action='smTest.php' method='post'>
                      <input type='hidden' name='noteAdd' value='noteAdd' /> 
                      <input type='hidden' name='display_member' value='' /> 
                      <a href='#' onclick='this.parentNode.submit(); return false;'>Add Note</a>
                    </form>
                  </li>
                  <li>
                    <form action='smTest.php' method='post'>
                      <input type='hidden' name='viewAllNotes' value=''> 
                      <a href='#' onclick='this.parentNode.submit(); return false;'>View All</a>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>";

    echo "<p><strong> </p>";
    echo "</div>"; // end manager note div

    echo "</div>"; //end profile window div


  } //end displayDefaultProfile

  /*display window will display the passed content where the profile window would usually appear.  The passed value must be complete HTML*/
  public function displayWindow($content)
  {
    echo "<div class='profileWindow'>";
    echo "$content";
    echo "</div>";
  }//end function displayWindow
  
  /*Function insertPopUp is a wrapper function for the createPopUp function of the PopUpManager class.  This allows client code to access the popup windowing system without the need to instantiate a new PopUpManager object.*/
  public function insertPopUp($contents, $header = '', $action = 'smTest.php')
  {
    $this->popUp->createPopUp($contents, $header, $action);
  }//end function insertPopUp

  public function editMemberForm($profile)
  {
    //formContent will hold the HTML for the member update form
    $formContent = '';
    
    //convert the mysqli result to a useable form
    $profile = $profile->fetch_assoc();
    
    /*store all the results in individual variables as trying to pull them out of the associative array doesn't work with the heredoc*/
    $firstName = $profile['FirstName'];
    $lastName = $profile['LastName'];
    $birthDay = $profile['BirthDate'];
    $membershipType = $profile['MembershipType'];
    $memberID = $profile['MemberID'];
    $streetAddress = $profile['StreetAddress'];
    $city = $profile['City'];
    $state = $profile['State'];
    $zip = $profile['Zip'];
    $homePhone = $profile['HomePhone'];
    $cellPhone = $profile['CellPhone'];
    $email = $profile['Email'];
    $eContact = $profile['EmergencyContact'];
    $referredBy = $profile['ReferredBy'];
    $picture = $profile['Picture'];
    
    //use the sql result in $profile to pre-populate the edit member form
$formContent .= <<<_END
<form action='updateUser.php' method='post' enctype='multipart/form-data'>
  <div class='userInputFields'>
    <h2>Edit Member</h2>
  
    <input type='hidden' name='MemberNumber' value='$memberID' />
    
    <p><span class='label'>*First Name:</span><input type='text' name='firstName' value='$firstName' autofocus='autofocus'></p>
    
    <p><span class='label'>*Last Name:</span><input type='text' name='lastName' value='$lastName' /></p>
    
    <p><span class='label'>*Birth Date:</span><input type='date' name ='birthDate' class='dateBox' value='$birthDay' /></p>
  
    <p><span class='label'>Street Address:</span><input type='text' name ='streetAddress' value='$streetAddress' /></p>  
    
    <p><span class='label'>City:</span><input type='text' name ='city' value='$city' /></p>  
    
    <p><span class='label'>State:</span><input type='text' name ='state' value='$state' /></p>  
    
    <p><span class='label'>Zip Code:</span><input type='text' name ='zip' value='$zip' /></p>  
    
    <p><span class='label'>Home Phone:</span><input type='tel' name ='homePhone' value='$homePhone' /></p> 
    
    <p><span class='label'>Cell Phone:</span><input type='tel' name ='cellPhone' value='$cellPhone' /></p>
    
    <p><span class='label'>*E-mail:</span><input type='email' name ='Email' value='$email' /></p>
    
    <p><span class='label'>*Emergency Contact:</span><input type='text' name ='emergencyContact' value='$eContact' /></p>
    
_END;
    
    //This section sets the membership type at the right level
    if ($membershipType == 'Non-Member')
    {
      $formContent .= <<<_END
      <p><span class='label'>Membership Type:</span><select name ='membershipType'>
      <option value='Non-Member' selected>Non-Member</option>
      <option value='Student'>Student</option>
      <option value='Standard'>Standard</option>
      <option value='Voting'>Voting</option>
      </select></p>
_END;
    }//end if Non-Member
    else if ($membershipType == "Student")
    {
      $formContent .= <<<_END
      <p><span class='label'>Membership Type:</span><select name ='membershipType'>
      <option value='Non-Member'>Non-Member</option>
      <option value='Student' selected>Student</option>
      <option value='Standard'>Standard</option>
      <option value='Voting'>Voting</option>
      </select></p>
_END;
    }//end if Student
    else if ($membershipType == "Standard")
    {
      $formContent .= <<<_END
      <p><span class='label'>Membership Type:</span><select name ='membershipType'>
      <option value='Non-Member'>Non-Member</option>
      <option value='Student'>Student</option>
      <option value='Standard' selected>Standard</option>
      <option value='Voting'>Voting</option>
      </select></p>
_END;
    } //end if Standard
    else if ($membershipType == "Voting")
    {
      $formContent .= <<<_END
      <p><span class='label'>Membership Type:</span><select name ='membershipType'>
      <option value='Non-Member'>Non-Member</option>
      <option value='Student'>Student</option>
      <option value='Standard'>Standard</option>
      <option value='Voting' selected>Voting</option>
      </select></p>
_END;
    } //end if Voting
    else
    {
      $formContent .= <<<_END
      <p><span class='label'>Membership Type:</span><select name ='membershipType'>
      <option value='Non-Member'>Non-Member</option>
      <option value='Student'>Student</option>
      <option value='Standard'>Standard</option>
      <option value='Voting'>Voting</option>
      </select></p>
_END;
    }
    
    $formContent .= <<<_END
    <p><span class='label'>Referred By:</span><input type='text' name='referredBy' value='$referredBy' /></p>
    
    <p><span class='label'>Picutre:</span><label for='picture' class='fileLabel'>Select a File</label><input class='inputFile' type='file' name='picture' id='picture' size='600' />
    </p>

    <input type="submit" name="submit" class='sbutton'>
    
    <p class='footnote'><span>Fields marked with an * are required</span></p>
  </div>
</form>
_END;
    
    //output the form to the main window
    $this->displayWindow($formContent);
    
  }//end function editMemberForm




  /*Private functions*/

  private function prepEnrollment($enrollments) {

    $output = array();

    foreach ($enrollments as $enrollment) {

      $event = "<form action='addAttendance.php' method='post'>
      <input type='hidden' name='memberID' value='$enrollment[MemberID]' />
      <input type='hidden' name='type' value='$enrollment[Type]' />
      <input type='hidden' name='referenceNumber' value='$enrollment[ReferenceNumber]' />
      <input type='hidden' name='eventDate' value='$enrollment[Date]' />
      <input type='hidden' name='eventName' value='$enrollment[Name]' />
      <button type='submit' class='dashButton'>$enrollment[Date]:<br />$enrollment[Name]</button>
    </form>";

      $output[] = $event;

    } //end foreach

    return $output;

  } //end function prepEnrollment
  
}; //end class OutputManager 

?>
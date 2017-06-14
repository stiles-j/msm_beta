<?php

require_once "dbCore.php";

class ReportManager extends dbCore
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * getPriorClasses takes start and end dates in the format yyyy-mm-dd as arguments and returns
   * a list of all classes including their reference numbers, dates and course names in a mysqli
   * result
   *
   * @param $startDate: The earliest date to search for classes formatted as described above
   * @param $endDate: The last date to search for classes formatted as described above
   * @return bool|mysqli_result: mysqli_result containing all matches if successful, false otherwise
   */
  public function getPriorClasses($startDate, $endDate) {
    $db_conn = $this->connect();
    $startDate = $this->sanitizeInput($startDate, $db_conn);
    $endDate = $this->sanitizeInput($endDate, $db_conn);

    $sql = "SELECT * from CLASS_WITH_COURSE_NAME WHERE ClassDate BETWEEN '$startDate' AND '$endDate'";
    $result = $db_conn->query($sql);
    $db_conn->close();
    if ($result->num_rows == 0 || !$result) return false;
    return $result;
  }

  /**
   * getPriorEvents will return a mysqli result containing the EventReferenceNumber, EventDate, EventName,
   * EventDescription, EventMemberFee, EventNonMemberFee, and Duration of all events between the passed
   * Start and End dates.  Dates must be formatted as yyyy-mm-dd
   *
   * @param $startDate: a date string formatted as described above indicating the earliest event date to search for
   * @param $endDate: a date string formatted as described above indicating the latest event date to search for
   * @return bool|mysqli_result: mysqli result containing all relevant records if successful, false otherwise
   */
  public function getPriorEvents($startDate, $endDate) {
    $db_conn = $this->connect();
    $startDate = $this->sanitizeInput($startDate, $db_conn);
    $endDate = $this->sanitizeInput($endDate, $db_conn);

    $sql = "SELECT * FROM EVENT WHERE EventDate BETWEEN '$startDate' AND '$endDate'";
    $result = $db_conn->query($sql);
    $db_conn->close();
    if ($result->num_rows == 0 || !$result) return false;
    return $result;
  }

}











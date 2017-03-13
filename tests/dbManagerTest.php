<?php

use PHPUnit\Framework\TestCase;
class dbManagerTest extends TestCase {


  /**
   * function to see if the results returned from the getFacilityList method are as expected.
   */
  public function testGetFacilityList() {
    $db = new dbManager();
    $facilityList = $db->getFacilityList(14, "course"); //should get back a single response of "1"
    foreach ($facilityList as $facility) {
      $this->assertEquals($facility, 1);
    }

    //test with a result that should return both primary and sub facilities
    $facilityList = $db->getFacilityList(2, 'course');
    $expected = array(5, 9, 15, 16, 17, 18, 19);
    foreach ($facilityList as $facility) {
      $this->assertContains($facility, $expected, "GetFacilityList contains all expected values");
    }

  } //end testGetFacilityList

}

?>
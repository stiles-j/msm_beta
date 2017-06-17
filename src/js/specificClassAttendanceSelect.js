/**
 * classSelect.js handles the AJAX request for the Specific Class Attendance report
 * allowing the user to input a range of dates to select class from rather than needing
 * to know the specific ClassReferenceNumber for the class they are interested in.
 */

 $(document).ready(function() {
   var $selectArea = $('#classSelect');
   $selectArea.hide();
   var $endDateBox = $('#classAttendanceEndDate');

   //fire this event when the end date box is filled and blurred
   $endDateBox.blur(function() {
     var $form = $('#specificClassAttendance');
     var $formContent = $form.serialize();

     $.getJSON('getPrior.php', $formContent, function(data) {

       //populate the select box with the returned data
       var selectBox = "<select name='classes[]' id='classes' multiple='multiple'>";
       for (var i = 0; i < data.length; ++i){
         var record = data[i];
         selectBox += "<option value='" + record.ClassReferenceNumber + "'>" + record.CourseName + " on " + record.ClassDate + "</option>";
       }
       selectBox += "</select>";

       $selectArea.html(selectBox);
       $selectArea.fadeIn(500);
       $selectArea.append("<input type='submit' class='reportSubmit' />");

     }).error(errorHandler); //end getJSON

   }); //end $endDateBox.blur

   function errorHandler(){
     $('#classSelect').html("<p class='warning'>No data for specified date range</p>").fadeIn();
   }

 }); //end ready




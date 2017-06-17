/**
 * eventSelect.js handles the AJAX request for the Specific Event Attendance report
 * allowing the user to input a range of dates to select an event from rather than needing
 * to know the specific EventReferenceNumber for the event they are interested in.
 */

$(document).ready(function() {
  var $selectArea = $('#eventSelect');
  $selectArea.hide();
  var $endDateBox = $('#eventAttendanceEndDate');

  //fire this event when the end date box is filled and blurred
  $endDateBox.blur(function() {
    var $form = $('#specificEventAttendance');
    var $formContent = $form.serialize();

    $.getJSON('getPrior.php', $formContent, function(data) {

      //populate the select box with the returned data
      var selectBox = "<select name='events[]' id='events' multiple='multiple'>";
      for (var i = 0; i < data.length; ++i){
        var record = data[i];
        selectBox += "<option value='" + record.EventReferenceNumber + "'>" + record.EventName + " on " + record.EventDate + "</option>";
      }
      selectBox += "</select>";

      $selectArea.html(selectBox);
      $selectArea.fadeIn(500);
      $selectArea.append("<input type='submit' class='reportSubmit' />");

    }).error(errorHandler); //end getJSON

  }); //end $endDateBox.blur

  function errorHandler(){
    $('#eventSelect').html("<p class='warning'>No data for specified date range</p>").fadeIn();
  }

}); //end ready

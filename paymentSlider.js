

var dbResult;
var reason;

function showContent(content) {
  content += "<div id='fadeContent'></div><input type='hidden' id='reason' name='reason' value='" + reason +"' />";
  $('#slideContent').html(content).hide().slideDown();
}


function addContent(content) {
  $('#fadeContent').html(content).hide().fadeIn();
}


function eventPrice(refNumber) {
  //find the fee for the passed reference number
  var fee = 0.00;
  $.each(dbResult, function (oNum, values) {
    if (values.ReferenceNumber == refNumber) 
      fee = values.Fee;
  }); //end each
  
  //generate the HTML for the payment box and add it to the popup
  var outputHTML = "<p>Payment Amount:</p><input type='number' step='any' value=" + fee + " id='paymentAmount' name='paymentAmount' autofocus />";
  
  addContent(outputHTML);
}


/*
Function processPending takes the returned JSON object from the getPending.php script creates a select box from it, and stores the object in the dbResult variable for later use.
*/
function processPending(data) {  
  var outputHTML = '<select id="pending" name="pending" onchange="eventPrice(this.value)"><option selected disabled hidden>Select Event</option>';
  
  $.each(data, function (refNumber, values) {
    outputHTML = outputHTML + "<option value=" + values.ReferenceNumber + ">" + values.Name + " " + values.Date + "</option>";
  });
  
  outputHTML = outputHTML + "</select>";
  
  //Cache the data for later use
  dbResult = data;
  
  showContent(outputHTML);
} //end funciton processPending



$('#paymentType').change(function () {
  var $type = $('#paymentType option:selected').text();
  
  switch ($type) {
      
    case 'Class Enrollment':
      reason = "class";
      $.getJSON('getPending.php', "class", processPending);
      break;
      
    case 'Event Enrollment':
      reason = "event";
      $.getJSON('getPending.php', 'event', processPending);
      break;
      
    case 'Dues':
      reason = 'dues';
      var paymentFields = "<p>Dues Payment Amount:</p><input type='number' step='any' id='paymentAmount' name='paymentAmount' autofocus />";
      showContent(paymentFields);
      break;
      
    case 'Donation':
      reason = 'donation';
      var paymentFields = "<p>Donation Amount:</p><input type='number' step='any' id='paymentAmount' name='paymentAmount' autofocus />";
      showContent(paymentFields);
      break;
      
    case 'Merchandise':
      reason = 'merchandise';
      var paymentFields = "<p>Merchandise Total:</p><input type='number' step='any' id='paymentAmount' name='paymentAmount' autofocus />";
      showContent(paymentFields);
      break; 
      
    default:
      reason = 'other';
      var paymentFields = "<p>Other Payment Total:</p><input type='number' step='any' id='paymentAmount' name='paymentAmount' autofocus /><p>Payment Note:</p><input type='text' id='paymentNote' name='paymentNote' />";
      showContent(paymentFields);
      break; 
      
  } //end switch

}); //end change paymentType




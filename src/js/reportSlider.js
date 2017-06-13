/**
 * reportSlider is used to manage the display of various report controls on the reports page
 * Because the script relies on the reportStyle.css stylesheet, it injects it into the pages
 * head before any other code executes.
 */

$(document).ready(function(){
  //ensure reportStyle.css is included
  $('head').append('<link rel="stylesheet" href="css/reportStyle.css" type="text/css" />');

  $('.reportNamesContainer').hide();
  $('.reportInputs').hide();

  $('.reportContainer h2').click(function() {
    var $reportSuite = $(this).next('.reportNamesContainer');
    if ($reportSuite.is(':hidden')){
      $reportSuite.slideDown();
    } else {
      $reportSuite.slideUp();
    }
  }); //end h2.click

  $('.reportName').click(function() {
    var $controls = $(this).next('.reportInputs');
    if ($controls.is(':hidden')){
      $controls.slideDown();
    } else {
      $controls.slideUp();
    }
  });
}); //end ready


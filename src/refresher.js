/**
 * Created by justice on 2/3/17.
 * This script will keep the session from timing out thus preventing loss of data by sending an AJAX
 * request every ten minutes.
 */
var refreshTime = 600000; // every 10 minutes in milliseconds
window.setInterval( function() {
  $.ajax({
    cache: false,
    type: "GET",
    url: "refreshSession.php"
  });
}, refreshTime );
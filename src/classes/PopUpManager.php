<?php

/*Popup window manager class for SpaceManager system*/

class PopUpManager{
  
  public function __construct()
  {
    echo "<head><link rel='stylesheet' type='text/css' href='../dashboard.css'></head>";
  }//end constructor

  /*Method createPopUp Takes three arguments, two of which are optional.  The first argument $contents is the contents of the popup window.  If the popup is to be a form, or to include any HTML formatting, all HTML tags should be included in the argument.  The second argument $header is the header that will appear in the top section of the popup window.  The header will automatically be tagged as an h1 heading by the function if one is supplied.  The third argument "action" is the form action, i.e. the script that is called when the user clicks the "ok" button on the popup window.  $action defaults to the main script in the SpaceManager system smTest.php.  Note that the popup window itself is a form.*/
  public function createPopUp($contents, $header = '', $action = 'smTest.php')
  {
    echo "<div class='popUp'><form action='$action' method='post'>";
    if($header != '')
      echo "<h1>$header</h1>";
    echo "<h2>$contents</h2>";
    echo "<input type='submit' value='OK' autofocus>";
    echo "</form></div>";
  }

}//end class PopupManager

?>
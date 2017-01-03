<?php
echo file_get_contents("header.html");
echo file_get_contents("nav.html");
echo file_get_contents("newUserForm.html");


    $close = <<<_END
    </div>
  </body>
</html>
_END;

    echo $close;

?>
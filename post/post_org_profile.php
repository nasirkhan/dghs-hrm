<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
$org_code = $_SESSION['org_code'];

$pk = $_POST['pk'];
$name = $_POST['name'];
$value = $_POST['value'];

if ($pk== $org_code){
    
}

/*
  You will get 'pk', 'name' and 'value' in $_POST array.
 */


/*
  Check submitted value
 */
if (!empty($value)) {
    /*
      If value is correct you process it (for example, save to db).
      In case of success your script should not return anything, standard HTTP response '200 OK' is enough.

      for example:
      $result = mysql_query('update users set '.mysql_escape_string($name).'="'.mysql_escape_string($value).'" where user_id = "'.mysql_escape_string($pk).'"');
     */

    //here, for debug reason we just return dump of $_POST, you will see result in browser console
    print_r($_POST);
} else {
    /*
      In case of incorrect value or error you should return HTTP status != 200.
      Response body will be shown as error message in editable form.
     */

    header('HTTP 400 Bad Request', true, 400);
    echo "This field is required!";
}
?>
<?php
require_once '../configuration.php';

$sql = "SELECT
       staff_govt_quater.govt_quater,staff_govt_quater.id
          FROM
       staff_govt_quater";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['govt_quater'],
        'value' => $row['id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

<?php
require_once '../configuration.php';

$sql = "SELECT
          staff_designation_type.designation_type,staff_designation_type.designation_type_id
            FROM
          staff_designation_type";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['designation_type'],
        'value' => $row['designation_type_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

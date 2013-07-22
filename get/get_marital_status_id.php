<?php
require_once '../configuration.php';

$sql = "SELECT
            staff_marital_status.marital_status, staff_marital_status.marital_status_id
            FROM
            staff_marital_status";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['marital_status'],
        'value' => $row['marital_status_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

<?php
require_once '../configuration.php';

$sql = "SELECT staff_working_status.working_status_name,staff_working_status.working_status_id
            FROM
            staff_working_status order by working_status_name";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['working_status_name'],
        'value' => $row['working_status_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

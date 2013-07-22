<?php
require_once '../configuration.php';

$sql = "SELECT staff_tribal.tribal_value,staff_tribal.tribal_id
            FROM
            staff_tribal";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['tribal_value'],
        'value' => $row['tribal_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

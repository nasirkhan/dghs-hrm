<?php
require_once '../configuration.php';

$sql = "SELECT staff_freedom_fighter.freedom_fighter_name,staff_freedom_fighter.freedom_fighter_id
                FROM
                staff_freedom_fighter";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['freedom_fighter_name'],
        'value' => $row['freedom_fighter_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

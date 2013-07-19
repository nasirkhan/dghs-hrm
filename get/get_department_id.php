<?php
require_once '../configuration.php';

$sql = "SELECT
            very_old_departments.department_id,
            very_old_departments.`name`
            FROM
            very_old_departments
            ORDER BY
            very_old_departments.name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['name'],
        'value' => $row['department_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

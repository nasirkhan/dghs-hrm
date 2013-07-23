<?php
require_once '../configuration.php';

$sql = "SELECT staff_draw_salaray_place.draw_salaray_place,staff_draw_salaray_place.draw_salary_id
            FROM
            staff_draw_salaray_place";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['draw_salaray_place'],
        'value' => $row['draw_salary_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

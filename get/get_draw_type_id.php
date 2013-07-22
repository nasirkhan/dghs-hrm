<?php
require_once '../configuration.php';

$sql = "SELECT
            staff_salary_draw_type.salary_draw_type_name,staff_salary_draw_type.salary_draw_type_id
            FROM
            staff_salary_draw_type order by salary_draw_type_name";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['salary_draw_type_name'],
        'value' => $row['salary_draw_type_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

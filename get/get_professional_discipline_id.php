<?php
require_once '../configuration.php';

$sql = "SELECT
          staff_profesional_discipline.discipline_name,staff_profesional_discipline.discipline_id
            FROM
          staff_profesional_discipline order by discipline_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['discipline_name'],
        'value' => $row['discipline_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

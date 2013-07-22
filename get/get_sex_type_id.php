<?php
require_once '../configuration.php';

$sql = "SELECT staff_sex.sex_name,staff_sex.sex_type_id
            FROM
            staff_sex order by sex_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['sex_name'],
        'value' => $row['sex_type_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

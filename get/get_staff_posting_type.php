<?php
require_once '../configuration.php';
//get_staff_posting_type
$sql = "SELECT
        staff_posting_type.staff_posting_type_id,
        staff_posting_type.staff_posting_type_name
        FROM
        staff_posting_type
        GROUP BY
        staff_posting_type.staff_posting_type_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_staff_posting_type:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['staff_posting_type_name'],
        'value' => $row['staff_posting_type_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

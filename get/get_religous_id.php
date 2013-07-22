<?php
require_once '../configuration.php';

$sql = "SELECT staff_religious_group.religious_group_name,staff_religious_group.religious_group_id
            FROM
            staff_religious_group order by religious_group_name ";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['religious_group_name'],
        'value' => $row['religious_group_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

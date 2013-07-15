<?php
require_once '../configuration.php';

$sql = "SELECT `org_level_code`, `org_level_name` FROM `org_level` ORDER BY org_level_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>org_level_code:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_level_name'],
        'value' => $row['org_level_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

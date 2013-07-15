<?php
require_once '../configuration.php';

$sql = "SELECT `org_organizational_functions_code`, `org_organizational_functions_name` FROM `org_organizational_functions` ORDER BY org_organizational_functions_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>org_organizational_functions_code:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_organizational_functions_name'],
        'value' => $row['org_organizational_functions_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

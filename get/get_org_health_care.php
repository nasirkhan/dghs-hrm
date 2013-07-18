<?php
require_once '../configuration.php';

$sql = "SELECT
org_healthcare_levels.healthcare_code,
org_healthcare_levels.healthcare_name
FROM
org_healthcare_levels ORDER BY healthcare_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_health_care:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['healthcare_name'],
        'value' => $row['healthcare_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

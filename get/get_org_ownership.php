<?php
require_once '../configuration.php';

$sql = "SELECT
org_ownership_authority.org_ownership_authority_code,
org_ownership_authority.org_ownership_authority_name
FROM
org_ownership_authority ORDER BY org_ownership_authority_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_ownership:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_ownership_authority_name'],
        'value' => $row['org_ownership_authority_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

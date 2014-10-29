<?php
require_once '../configuration.php';

$sql = "SELECT
       org_physical_structure.physical_structure_value,org_physical_structure.id
          FROM
       org_physical_structure";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['physical_structure_value'],
        'value' => $row['id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

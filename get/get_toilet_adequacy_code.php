<?php
require_once '../configuration.php';

$sql = "SELECT `toilet_adequacy_name`, `toilet_adequacy_code` FROM `org_toilet_adequacy`";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['toilet_adequacy_name'],
        'value' => $row['toilet_adequacy_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

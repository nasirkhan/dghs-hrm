<?php
require_once '../configuration.php';

$sql = "SELECT
              staff_professional_category_type.professional_type_id,staff_professional_category_type.professional_type_name
            FROM
              staff_professional_category_type order by professional_type_name";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['professional_type_name'],
        'value' => $row['professional_type_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

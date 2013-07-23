<?php
require_once '../configuration.php';

$sql = "SELECT staff_educational_qualification.educational_qualification,staff_educational_qualification.educational_qualifiaction_Id
            FROM
         staff_educational_qualification order by educational_qualification asc";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['educational_qualification'],
        'value' => $row['educational_qualifiaction_Id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

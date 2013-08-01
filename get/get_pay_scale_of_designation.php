<?php
require_once '../configuration.php';

$sql = "SELECT staff_pay_scale.pay_scale,staff_pay_scale.pay_scale_id
            FROM
            staff_pay_scale order by pay_scale";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['pay_scale'],
        'value' => $row['pay_scale_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

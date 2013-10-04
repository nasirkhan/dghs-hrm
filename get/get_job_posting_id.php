<?php
require_once '../configuration.php';

$sql = "SELECT staff_job_posting.job_posting_name,staff_job_posting.job_posting_id
            FROM
            staff_job_posting order by job_posting_name"; 

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['job_posting_name'],
        'value' => $row['job_posting_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

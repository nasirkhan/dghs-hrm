<?php

require_once '../configuration.php';

$div_code = mysql_real_escape_string(trim($_POST['div_code']));

$sql = "SELECT
            district_bbs_code,
            district_name
        FROM
            `admin_district`
        WHERE
            division_bbs_code = $div_code
        AND active LIKE 1
        ORDER BY
            district_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_districts:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
$data[] = array(
    'text' => "__ Select District __",
    'value' => 0
);
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['district_name'],
        'value' => $row['district_bbs_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

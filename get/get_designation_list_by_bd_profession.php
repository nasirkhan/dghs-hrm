<?php

require_once '../configuration.php';

$bd_professional_category = (int) mysql_real_escape_string(trim($_POST['bd_professional_category']));

$sql = "SELECT
                sanctioned_post_designation.designation_code,
                sanctioned_post_designation.designation,
                sanctioned_post_designation.designation_group_code,
                sanctioned_post_designation.group_code,
                sanctioned_post_designation.ranking,
                sanctioned_post_designation.bangladesh_professional_category_code,
                sanctioned_post_designation.who_occupation_group_code
        FROM
                `sanctioned_post_designation`
        WHERE
                bangladesh_professional_category_code = '$bd_professional_category'
        GROUP BY
                designation_group_code";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list_by_bd_profession:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//echo "$sql";
$data = array();
$data[] = array(
    'text' => "Select Designation",
    'value' => 0
);

while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['designation'],
        'value' => $row['designation_group_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>

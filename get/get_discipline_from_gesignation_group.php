<?php

require_once '../configuration.php';

$designation_group_code = (int) mysql_real_escape_string($_POST['designation_group']);


$sql = "SELECT
                sanctioned_post_designation.designation_group_name,
                sanctioned_post_designation.group_code,
                sanctioned_post_designation.designation_discipline
        FROM
                `sanctioned_post_designation`
        WHERE
                group_code = 100457
        AND designation_discipline != ''
        ORDER BY
                designation_discipline";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_discipline_from_gesignation_group:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
$data[] = array(
    'text' => "> Select Discipline",
    'value' => 0
);
while ($row = mysql_fetch_array($result)) {
  $data[] = array(
      'text' => $row['designation_discipline'],
      'value' => $row['designation_discipline']
  );
}
$json_data = json_encode($data);

print_r($json_data);
?>

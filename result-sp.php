<?php

require_once 'configuration.php';

if ($_REQUEST["designation"]) {
    $designation = $_REQUEST['designation'];
//   echo $designation;
}

$org_code = $_SESSION['org_code'];
$staff_id = $_POST['id'];

$sql = "SELECT
total_manpower_imported_sanctioned_post_copy.id,
total_manpower_imported_sanctioned_post_copy.type_of_post,
total_manpower_imported_sanctioned_post_copy.pay_scale,
total_manpower_imported_sanctioned_post_copy.class,
total_manpower_imported_sanctioned_post_copy.first_level_id,
total_manpower_imported_sanctioned_post_copy.first_level_name,
total_manpower_imported_sanctioned_post_copy.second_level_id,
total_manpower_imported_sanctioned_post_copy.second_level_name,
total_manpower_imported_sanctioned_post_copy.staff_id,
total_manpower_imported_sanctioned_post_copy.discipline
FROM total_manpower_imported_sanctioned_post_copy
WHERE id =$staff_id LIMIT 1";
$sanctioned_post_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

//$total_rows= mysql_num_rows($sanctioned_post_list_result);
while ($data_list = mysql_fetch_assoc($sanctioned_post_list_result)) {
    $data[] = array(
        "sanctioned_post_id" => $data_list['id'],
        "type_of_post" => $data_list['type_of_post'],
        "pay_scale" => $data_list['pay_scale'],
        "first_level_name" => $data_list['first_level_name'],
        "second_level_name" => $data_list['second_level_name'],
        "class" => $data_list['class'],
        "discipline" => $data_list['discipline'],
        "staff_id" => $data_list['staff_id']
    );
}


print json_encode($data);
?>
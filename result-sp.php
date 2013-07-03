<?php

require_once 'configuration.php';

if ($_REQUEST["designation"]) {
    $designation = $_REQUEST['designation'];
//   echo $designation;
}

$org_code = $_SESSION['org_code'];
$staff_id = $_POST['id'];

$sql = "SELECT
total_manpower_imported_sanctioned_post.id,
total_manpower_imported_sanctioned_post.type_of_post,
total_manpower_imported_sanctioned_post.pay_scale,
total_manpower_imported_sanctioned_post.class,
total_manpower_imported_sanctioned_post.first_level_id,
total_manpower_imported_sanctioned_post.first_level_name,
total_manpower_imported_sanctioned_post.second_level_id,
total_manpower_imported_sanctioned_post.second_level_name
FROM total_manpower_imported_sanctioned_post
WHERE org_code =$org_code LIMIT 1";
$sanctioned_post_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$total_rows= mysql_num_rows($sanctioned_post_list_result);
while ($data_list = mysql_fetch_assoc($sanctioned_post_list_result)){
    $data[] = array(
    "sanctioned_post_id" => $data_list['id'],
    "class" => $data_list['class'],
    "total" => $total_rows
);
}


print json_encode($data);
?>
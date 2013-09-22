<?php
/*
 * get_match_staff_sp_code_list
 * 
 */

require_once '../configuration.php';

$designation = mysql_real_escape_string(trim($_REQUEST['designation']));
$org_code = (int) mysql_real_escape_string($_REQUEST['org_code']);

//$sql = "SELECT
//            total_manpower_imported_sanctioned_post_copy.id,
//            total_manpower_imported_sanctioned_post_copy.staff_id,
//            total_manpower_imported_sanctioned_post_copy.designation
//        FROM
//            total_manpower_imported_sanctioned_post_copy
//        WHERE
//                designation LIKE \"".$designation."\"
//            AND 
//                org_code =$org_code
//            AND 
//                staff_id_2 = 0";
$sql = "SELECT
            total_manpower_imported_sanctioned_post_copy.id,
            total_manpower_imported_sanctioned_post_copy.staff_id,
            total_manpower_imported_sanctioned_post_copy.designation
        FROM
            total_manpower_imported_sanctioned_post_copy
        WHERE
                
                org_code =$org_code
            AND 
                staff_id_2 = 0
        ORDER BY designation";
$result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>get_match_staff_sp_code_list:1</b></p><p>Query:<br />___<br />$sql</p>");
$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['designation'],
        'value' => $row['id']
    );
}
$json_data = json_encode($data);

//echo "<pre>$sql";
print_r($json_data);
?>

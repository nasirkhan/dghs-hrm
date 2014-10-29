<?php

//get_org_union_name

require_once '../configuration.php';

$upa_name = mysql_real_escape_string($_GET['upa_name']);
$dis_name = mysql_real_escape_string($_GET['dis_name']);

if ($upa_name != "" && $dis_name != "") {
    $sql = "SELECT
                    admin_upazila.upazila_name, admin_upazila.upazila_bbs_code, admin_upazila.upazila_district_code
            FROM
                    admin_upazila
            LEFT JOIN admin_district ON admin_district.district_bbs_code = admin_upazila.upazila_district_code
            WHERE admin_upazila.upazila_name LIKE \"$upa_name\" and admin_district.district_name = \"$dis_name\"";
    $result = mysql_query($sql) or die(mysql_error() . "\n\nCode:<b>get_org_union_name:1\n\nQuery:</b><br />___<br />$sql<br />");
    $data = mysql_fetch_assoc($result);
    $upazila_bbs_code = $data['upazila_bbs_code'];
    $district_bbs_code = $data['upazila_district_code'];
}

if ($upazila_bbs_code > 0 && $district_bbs_code > 0) {
    $sql = "SELECT * FROM `admin_union` WHERE upazila_code = '$upazila_bbs_code' AND district_code = '$district_bbs_code';";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_union_name:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = array();
    while ($row = mysql_fetch_array($result)) {
        $data[] = array(
            'text' => $row['union_name'],
            'value' => $row['union_code']
        );
    }
    $json_data = json_encode($data);

    print_r($json_data);
}

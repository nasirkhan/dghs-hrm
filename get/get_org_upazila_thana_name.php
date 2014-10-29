<?php

//get_org_upazila_thana_name

require_once '../configuration.php';

$name = mysql_real_escape_string($_GET['name']);

if ($name != "") {
    $sql = "SELECT admin_district.district_bbs_code FROM admin_district WHERE district_name LIKE \"$name\"";
    $result = mysql_query($sql) or die(mysql_error() . "\n\nCode:<b>get_org_upazila_thana_name:1\n\nQuery:</b><br />___<br />$sql<br />");
    $data = mysql_fetch_assoc($result);
    $dis_bbs_code = $data['district_bbs_code'];
}

if ($dis_bbs_code > 0) {
    $sql = "SELECT * FROM admin_upazila WHERE upazila_district_code = '$dis_bbs_code'";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_upazila_thana_name:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = array();
    while ($row = mysql_fetch_array($result)) {
        $data[] = array(
            'text' => $row['upazila_name'],
            'value' => $row['upazila_bbs_code']
        );
    }
    $json_data = json_encode($data);

    print_r($json_data);
}

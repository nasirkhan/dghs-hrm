<?php

//get_search_result
require_once '../configuration.php';

$type = mysql_real_escape_string($_POST['type']);
$username = mysql_real_escape_string($_POST['searchUser']);

$query_key = mysql_real_escape_string($_POST['searchOrg']);

if ($query_key == "" && $username == ""){
    echo "Please enter an search word.";
    die();
}

if ($type == "user") {
    $sql = "SELECT 
                username, org_code
            FROM 
                `user` 
            WHERE 
                username LIKE \"%$username%\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//    echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Staff(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
            echo "<li>";
            echo $data_list['username'] . " | " . getOrgNameFormOrgCode($data_list['org_code']) . " (Org Code:" . $data_list['org_code'] . ")";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Staff found. \"";
    }
} 
else if ($type == "org") {
    $sql = "SELECT
            organization.org_name,
            organization.org_code
        FROM
            organization
        WHERE
            organization.org_code = \"$query_key\"
                OR
            organization.org_name LIKE \"%$query_key%\"
            ORDER BY org_name";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    //echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Organization(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
            echo "<li>";
            echo "<a href=\"org_profile.php?org_code=" . $data_list['org_code'] . "\" target=\"_blank\">";
            echo $data_list['org_name'] . " (Org Code:" . $data_list['org_code'] . ")";
            echo "</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Organization found. \"";
    }
} 
else if ($type == "staff_org") {
    $sql = "SELECT
            organization.org_name,
            organization.org_code,
            organization.email_address1
        FROM
            organization
        WHERE
            organization.org_code = \"$query_key\"
                OR
            organization.org_name LIKE \"%$query_key%\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//    echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Organization(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
            echo "<li>";
            echo "<a href=\"org_profile.php?org_code=" . $data_list['org_code'] . "\" target=\"_blank\">";
            echo $data_list['org_name'] . " (Org Code:" . $data_list['org_code'] . ")";
            echo "</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Staff Organization found. \"";
    }
}
?>

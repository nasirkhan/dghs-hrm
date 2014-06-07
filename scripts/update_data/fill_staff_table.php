<?php

/**
 * Database connection configuration
 *
 */
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = '';

mysql_select_db($dbname, mysql_connect($dbhost, $dbuser, $dbpass)) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

require_once '../../include/config_variables.php';
require_once '../../include/functions_app_specific.php';
require_once '../../include/functions_generic.php';


//  Limit the maximum execution time
set_time_limit(123456);

/** ----------------------------------------------------------------------------
 *  
 * Function Call
 * 
 * -----------------------------------------------------------------------------
 */
echo "<pre>";

/**
 * staff_job_posting array
 */
$code = 'job_posting_id';	
$value = 'job_posting_name';
$table = 'staff_job_posting';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_job_posting = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_job_posting [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * staff_job_class array
 */
$code = 'job_class_id';	
$value = 'job_class_name';
$table = 'staff_job_class';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_job_class = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_job_class [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * staff_professional_category_type array
 */
$code = 'professional_type_id';	
$value = 'professional_type_name';
$table = 'staff_professional_category_type';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_professional_category_type = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_professional_category_type [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * sanctioned_post_designation_code array
 */
$code = 'id';	
$value = 'designation_code';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$sanctioned_post_designation = array();

while ($data = mysql_fetch_assoc($r)) {
    $sanctioned_post_designation [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * sanctioned_post_designation_name array
 */
$code = 'id';	
$value = 'designation_name';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$sanctioned_post_designation_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $sanctioned_post_designation_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * freedom_fighter array
 */
$code = 'freedom_fighter_id';	
$value = 'freedom_fighter_name';
$table = 'staff_freedom_fighter';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_freedom_fighter = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_freedom_fighter [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * staff_tribal array
 */
$code = 'tribal_id';	
$value = 'tribal_name';
$table = 'staff_tribal';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_tribal = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_tribal [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * staff_post_type array
 */
$code = 'post_type_id';	
$value = 'post_type_name';
$table = 'staff_post_type';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_post_type = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_post_type [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * staff_draw_salaray_place array
 */
$code = 'draw_salary_id';	
$value = 'draw_salaray_place';
$table = 'staff_draw_salaray_place';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_draw_salaray_place = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_draw_salaray_place [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}



/**
 * staff_designation_type array
 */
$code = 'designation_type_id';	
$value = 'designation_type';
$table = 'staff_designation_type';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_designation_type = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_designation_type [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * staff_job_posting array
 */
$code = 'job_posting_id';	
$value = 'job_posting_name';
$table = 'staff_job_posting';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_job_posting = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_job_posting [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


















/** * ***************************************************************************
 *  
 * Function definitions 
 * 
 * *****************************************************************************
 */

function update_staff_data ($code_field_name, $code, $value_field_name, $value, $show_query){
    if (!$code > 0){
        return FALSE;
    }
    $sql = "UPDATE `old_tbl_staff_organization` SET `$value_field_name`=\"$value\" WHERE (`$code_field_name`='$code')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "<br />$value_field_name | $sql";
    }
}
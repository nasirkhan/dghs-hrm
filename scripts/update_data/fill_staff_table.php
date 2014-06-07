<?php

/**
 * Database connection configuration
 *
 */
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = 'root';

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
//print_r($sanctioned_post_designation);

/**
 * sanctioned_post_designation_name array
 */
$code = 'id';	
$value = 'designation';
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
$value = 'tribal_value';
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

/**
 * staff_working_status array
 */
$code = 'working_status_id';	
$value = 'working_status_name';
$table = 'staff_working_status';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_working_status = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_working_status [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
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
 * staff_sex array
 */
$code = 'sex_type_id';	
$value = 'sex_name';
$table = 'staff_sex';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_sex = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_sex [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * staff_marital_status array
 */
$code = 'marital_status_id';	
$value = 'marital_status';
$table = 'staff_marital_status';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_marital_status = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_marital_status [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * staff_religious_group array
 */
$code = 'religious_group_id';	
$value = 'religious_group_name';
$table = 'staff_religious_group';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_religious_group = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_religious_group [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}



/**
 * staff_profesional_discipline array
 */
$code = 'discipline_id';	
$value = 'discipline_name';
$table = 'staff_profesional_discipline';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:1</b><br />___<br />$sql</p>");

$staff_profesional_discipline = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_profesional_discipline [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * staff_educational_qualification array
 */
$code = 'educational_qualifiaction_Id';	
$value = 'educational_qualification';
$table = 'staff_educational_qualification';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:staff_educational_qualification</b><br />___<br />$sql</p>");

$staff_educational_qualification = array();

while ($data = mysql_fetch_assoc($r)) {
    $staff_educational_qualification [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}




/** 
 * -----------------------------------------------------------------------------
 * 
 * Staff table update 
 * 
 * -----------------------------------------------------------------------------
 */

$sql = "SELECT * FROM `old_tbl_staff_organization`";
$staff_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllSanctionedPost:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$show_query = TRUE;
$query_string = "";
$row_count = 0;

while ($data = mysql_fetch_assoc($staff_result)) {
    $row_count++;
    
    $query_string .= "`designation`=\"" . $designation[$sp_data['designation_code']] . "\",";
    
    
    
    $sql = "UPDATE `old_tbl_staff_organization` SET "
            . " $query_string "
            . "WHERE (`staff_id`=\"" . $sp_data['id'] . "\")";
    $sql = "UPDATE `old_tbl_staff_organization` "
            . "SET `staff_posting_name` = \"" . $staff_job_posting[$data['staff_posting']] . "\", "
            . "`staff_job_class_name` = \"" . $staff_job_class[$data['staff_job_class']] . "\", "
            . "`staff_professional_category_name` = \"" . $staff_professional_category_type[$data['staff_professional_category']] . "\", "
            . "`designation_code` = \"" . $sanctioned_post_designation[$data['designation_id']] . "\", "
            . "`designation_name` = \"" . $sanctioned_post_designation_name[$data['designation_id']] . "\", "
            . "`freedom_fighter_name` = \"" . $staff_freedom_fighter[$data['freedom_fighter_id']] . "\", "
            . "`tribal_name` = \"" . $staff_tribal[$data['tribal_id']] . "\", "
            . "`post_type_name` = \"" . $staff_post_type[$data['post_type_id']] . "\", "
            . "`draw_type_name` = \"" . $staff_draw_salaray_place[$data['draw_type_id']] . "\", "
            . "`designation_type_name` = \"" . $staff_designation_type[$data['designation_type_id']] . "\", "
            . "`job_posting_name` = \"" . $staff_job_posting[$data['job_posting_id']] . "\", "
            . "`working_status_name` = \"" . $staff_working_status[$data['working_status_id']] . "\", "
            . "`draw_salary_name` = \"" . $staff_draw_salaray_place[$data['draw_salary_id']] . "\", "
            . "`sex_name` = \"" . $staff_sex[$data['sex']] . "\", "
            . "`marital_status_name` = \"" . $staff_marital_status[$data['marital_status']] . "\", "
            . "`religion_name` = \"" . $staff_religious_group[$data['religion']] . "\", "
            . "`professional_discipline_of_current_designation_name` = \"" . $staff_profesional_discipline[$data['professional_discipline_of_current_designation']] . "\", "
            . "`type_of_educational_qualification_name` = \"" . $staff_educational_qualification[$data['type_of_educational_qualification']] . "\" "
            . "WHERE  "
            . "(`staff_id` = '" . $data['staff_id'] . "')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "\n\r$row_count | Staff ID:" . $data['staff_id'] . " | " . $data['staff_name'] . " \n\r | $sql";
    }
}

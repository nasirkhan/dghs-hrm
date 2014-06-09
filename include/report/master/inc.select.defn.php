<?php
/**
 * select item definitions
 */
$singleSelectItems = array('division_code', 'district_code', 'upazila_id'); // put the input field names for single selection dropdowns. Input filed name must be same as table filed name
$multiSelectItems = array('agency_code', 'org_type_code', 'org_level_code', 'org_healthcare_level_code', 'org_location_type', 'ownership_code', 'posting_status',
    'department_id','staff_posting','staff_job_class','staff_professional_category','tribal_id', 'post_type_id', 'job_posting_id', 'working_status_id', 'draw_salary_id', 'sex', 'marital_status', 'religion',
    'professional_discipline_of_current_designation', 'type_of_educational_qualification', 'govt_quarter',
    'designation', 'group_code', 'bangladesh_professional_category_code', 'who_occupation_group_code', 'who_isco_occupation_name_code', 'pay_scale', 'class', 'type_of_code',
    'first_level_code', 'second_level_code'); // put the input field names for multiple selection dropdowns. Input filed name must be same as table filed name

$tableFieldMap = array();
/*
 * From organization base table
 */
$tableFieldMap['division_code'] = $organizationsBaseTable['tableNameAlias'] . ".division_code";
$tableFieldMap['district_code'] = $organizationsBaseTable['tableNameAlias'] . ".district_code";
$tableFieldMap['upazila_id'] = $organizationsBaseTable['tableNameAlias'] . ".upazila_id";
$tableFieldMap['agency_code'] = $organizationsBaseTable['tableNameAlias'] . ".agency_code";
$tableFieldMap['org_type_code'] = $organizationsBaseTable['tableNameAlias'] . ".org_type_code";
$tableFieldMap['org_level_code'] = $organizationsBaseTable['tableNameAlias'] . ".org_level_code";
$tableFieldMap['org_healthcare_level_code'] = $organizationsBaseTable['tableNameAlias'] . ".org_healthcare_level_code";
$tableFieldMap['org_location_type'] = $organizationsBaseTable['tableNameAlias'] . ".org_location_type";
$tableFieldMap['ownership_code'] = $organizationsBaseTable['tableNameAlias'] . ".ownership_code";
/*
 * From staff base table
 */
$tableFieldMap['department_id'] = $staffsBaseTable['tableNameAlias'] . ".division_code";
$tableFieldMap['staff_posting'] = $staffsBaseTable['tableNameAlias'] . ".staff_posting";
$tableFieldMap['staff_job_class'] = $staffsBaseTable['tableNameAlias'] . ".staff_job_class";
$tableFieldMap['staff_professional_category'] = $staffsBaseTable['tableNameAlias'] . ".staff_professional_category";
$tableFieldMap['posting_status'] = $staffsBaseTable['tableNameAlias'] . ".posting_status";
$tableFieldMap['tribal_id'] = $staffsBaseTable['tableNameAlias'] . ".tribal_id";
$tableFieldMap['post_type_id'] = $staffsBaseTable['tableNameAlias'] . ".post_type_id";
$tableFieldMap['job_posting_id'] = $staffsBaseTable['tableNameAlias'] . ".job_posting_id";
$tableFieldMap['working_status_id'] = $staffsBaseTable['tableNameAlias'] . ".working_status_id";
$tableFieldMap['draw_salary_id'] = $staffsBaseTable['tableNameAlias'] . ".draw_salary_id";
$tableFieldMap['sex'] = $staffsBaseTable['tableNameAlias'] . ".sex";
$tableFieldMap['marital_status'] = $staffsBaseTable['tableNameAlias'] . ".marital_status";
$tableFieldMap['religion'] = $staffsBaseTable['tableNameAlias'] . ".religion";
$tableFieldMap['professional_discipline_of_current_designation'] = $staffsBaseTable['tableNameAlias'] . ".professional_discipline_of_current_designation";
$tableFieldMap['type_of_educational_qualification'] = $staffsBaseTable['tableNameAlias'] . ".type_of_educational_qualification";
$tableFieldMap['govt_quarter'] = $staffsBaseTable['tableNameAlias'] . ".govt_quarter";
/*
 * From post base table
 * 'designation', 'designation_group_code', 'bangladesh_professional_category_code', 'who_occupation_group_code', 'pay_scale', 'class', 'type_of_code',
  'first_level_code', 'second_level_code'
 */
$tableFieldMap['designation'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".designation";
$tableFieldMap['group_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".group_code";
$tableFieldMap['bangladesh_professional_category_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".bangladesh_professional_category_code";
$tableFieldMap['who_occupation_group_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".who_occupation_group_code";
$tableFieldMap['who_isco_occupation_name_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".who_isco_occupation_name_code";
$tableFieldMap['pay_scale'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".pay_scale";
$tableFieldMap['class'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".class";
$tableFieldMap['type_of_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".type_of_code";
$tableFieldMap['first_level_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".first_level_code";
$tableFieldMap['second_level_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".second_level_code";

?>
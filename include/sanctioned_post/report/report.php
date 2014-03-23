<?php
$fields = array (
		"division",
		"district",
		"upazila",
		"area",
		"union",
		"institute_code",
		"org_name",
		"org_name1",
		"org_type",
		"group",
		"discipline",
		"designation",
		"type_of_post",
		"sanctioned_post",
		"sanctioned_post_group_code",
		"bangladesh_professional_category_code",
		"who_occupation_group_code",
		"who_isco_occupation_name_code",
		"post_created_year",
		"recruitment_rule_code",
		"existing_male",
		"existing_female",
		"existing_total", 
		"vacant_post",
		"pay_scale",
		"class",
		"group_code",
		"type_of_code",
		"extra",
		"remarks",
		"first_level_id",
		"first_level_name",
		"second_level_id",
		"second_level_name",
		"sanctioned_post_count",
		"org_code",
		"org_id",
		"designation_id",
		"designation_code",
		"staff_id",
		"staff_id_2",
		"match",
		"type_of_post_code",
		"type_of_post_name",
		"designation_code",
		"designation",
		"payscale",
		"class",
		"designation_group_code",
		"group_code",
		"ranking",
		"bangladesh_professional_category_code",
		"who_occupation_group_code",
		"bangladesh_professional_category_code",
		"bangladesh_professional_category_name",
		"who_health_professional_group_code",
		"who_health_professional_group_name",
		"who_isco_occopation_code",
		"who_isco_occopation_group_code",
		"who_isco_occopation_group_name",
		"isco_code",
		"isco_occupationa_name",
		"definition",
		"example",
		"note"
);

$sql = "SELECT
total_manpower_imported_sanctioned_post_copy.id,
total_manpower_imported_sanctioned_post_copy.division,
total_manpower_imported_sanctioned_post_copy.district,
total_manpower_imported_sanctioned_post_copy.upazila,
total_manpower_imported_sanctioned_post_copy.area,
total_manpower_imported_sanctioned_post_copy.`union`,
total_manpower_imported_sanctioned_post_copy.institute_code,
total_manpower_imported_sanctioned_post_copy.org_name,
total_manpower_imported_sanctioned_post_copy.org_name1,
total_manpower_imported_sanctioned_post_copy.org_type,
total_manpower_imported_sanctioned_post_copy.group,
total_manpower_imported_sanctioned_post_copy.discipline,
total_manpower_imported_sanctioned_post_copy.designation,
total_manpower_imported_sanctioned_post_copy.type_of_post,
total_manpower_imported_sanctioned_post_copy.sanctioned_post,
total_manpower_imported_sanctioned_post_copy.sanctioned_post_group_code,
total_manpower_imported_sanctioned_post_copy.bangladesh_professional_category_code,
total_manpower_imported_sanctioned_post_copy.who_occupation_group_code,
total_manpower_imported_sanctioned_post_copy.who_isco_occupation_name_code,
total_manpower_imported_sanctioned_post_copy.post_created_year,
total_manpower_imported_sanctioned_post_copy.recruitment_rule_code,
total_manpower_imported_sanctioned_post_copy.existing_male,
total_manpower_imported_sanctioned_post_copy.existing_female,
total_manpower_imported_sanctioned_post_copy.existing_total,
total_manpower_imported_sanctioned_post_copy.vacant_post,
total_manpower_imported_sanctioned_post_copy.pay_scale,
total_manpower_imported_sanctioned_post_copy.class,
total_manpower_imported_sanctioned_post_copy.group_code,
total_manpower_imported_sanctioned_post_copy.type_of_code,
total_manpower_imported_sanctioned_post_copy.extra,
total_manpower_imported_sanctioned_post_copy.remarks,
total_manpower_imported_sanctioned_post_copy.first_level_id,
total_manpower_imported_sanctioned_post_copy.first_level_name,
total_manpower_imported_sanctioned_post_copy.second_level_id,
total_manpower_imported_sanctioned_post_copy.second_level_name,
total_manpower_imported_sanctioned_post_copy.sanctioned_post_count,
total_manpower_imported_sanctioned_post_copy.org_code,
total_manpower_imported_sanctioned_post_copy.org_id,
total_manpower_imported_sanctioned_post_copy.designation_id,
total_manpower_imported_sanctioned_post_copy.designation_code,
total_manpower_imported_sanctioned_post_copy.staff_id,
total_manpower_imported_sanctioned_post_copy.staff_id_2,
total_manpower_imported_sanctioned_post_copy.`match`,
total_manpower_imported_sanctioned_post_copy.active,
total_manpower_imported_sanctioned_post_copy.updated_by,
total_manpower_imported_sanctioned_post_copy.updated_datetime,
sanctioned_post_type_of_post.id,
sanctioned_post_type_of_post.type_of_post_code,
sanctioned_post_type_of_post.type_of_post_name,
sanctioned_post_type_of_post.updated_datetime,
sanctioned_post_type_of_post.updated_by,
sanctioned_post_type_of_post.active,
sanctioned_post_designation.id,
sanctioned_post_designation.designation_code,
sanctioned_post_designation.designation,
sanctioned_post_designation.payscale,
sanctioned_post_designation.class,
sanctioned_post_designation.designation_group_code,
sanctioned_post_designation.group_code,
sanctioned_post_designation.ranking,
sanctioned_post_designation.bangladesh_professional_category_code,
sanctioned_post_designation.who_occupation_group_code,
sanctioned_post_bangladesh_professional_category.id,
sanctioned_post_bangladesh_professional_category.bangladesh_professional_category_code,
sanctioned_post_bangladesh_professional_category.bangladesh_professional_category_name,
sanctioned_post_who_health_professional_group.id,
sanctioned_post_who_health_professional_group.who_health_professional_group_code,
sanctioned_post_who_health_professional_group.who_health_professional_group_name,
sanctioned_post_who_isco_occopation_name.id,
sanctioned_post_who_isco_occopation_name.who_isco_occopation_code,
sanctioned_post_who_isco_occopation_name.who_isco_occopation_group_code,
sanctioned_post_who_isco_occopation_name.who_isco_occopation_group_name,
sanctioned_post_who_isco_occopation_name.isco_code,
sanctioned_post_who_isco_occopation_name.isco_occupationa_name,
sanctioned_post_who_isco_occopation_name.definition,
sanctioned_post_who_isco_occopation_name.example,
sanctioned_post_who_isco_occopation_name.note
FROM
total_manpower_imported_sanctioned_post_copy
LEFT JOIN sanctioned_post_type_of_post ON total_manpower_imported_sanctioned_post_copy.type_of_post = sanctioned_post_type_of_post.type_of_post_code
LEFT JOIN sanctioned_post_designation ON total_manpower_imported_sanctioned_post_copy.sanctioned_post_group_code = sanctioned_post_designation.group_code
LEFT JOIN sanctioned_post_bangladesh_professional_category ON total_manpower_imported_sanctioned_post_copy.bangladesh_professional_category_code = sanctioned_post_bangladesh_professional_category.bangladesh_professional_category_code
LEFT JOIN sanctioned_post_who_health_professional_group ON total_manpower_imported_sanctioned_post_copy.who_occupation_group_code = sanctioned_post_who_health_professional_group.who_health_professional_group_code
LEFT JOIN sanctioned_post_who_isco_occopation_name ON total_manpower_imported_sanctioned_post_copy.who_isco_occupation_name_code = sanctioned_post_who_isco_occopation_name.isco_code
WHERE total_manpower_imported_sanctioned_post_copy.org_code='".$_SESSION[org_code]."'
";
$sanctioned_post_list_result = mysql_query ( $sql ) or die ( mysql_error () . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />" );
$rows = mysql_fetch_rowsarr ( $sanctioned_post_list_result );

$fieldsToShowCount = count ( $fields );

$headingNameMap=array();
$headingNameMap['division']='Division';
$headingNameMap['district']='District';
$headingNameMap['upazila']='Upazila';
$headingNameMap['area']='Area';
$headingNameMap['union']='Union';
$headingNameMap['institute_code']='Institute Code';
$headingNameMap['org_name']='Org Name';
$headingNameMap['org_name1']='Org Name1';
$headingNameMap['org_type']='Org Type';
$headingNameMap['group']='Group';
$headingNameMap['discipline']='Discipline';
$headingNameMap['designation']='Designation';
$headingNameMap['type_of_post']='Type Of Post';
$headingNameMap['sanctioned_post']='Sanctioned Post';
$headingNameMap['sanctioned_post_group_code']='Sanctioned Post Group Code';
$headingNameMap['bangladesh_professional_category_code']='Bangladesh Professional Category Code';
$headingNameMap['who_occupation_group_code']='Who Occupation Group Code';
$headingNameMap['who_isco_occupation_name_code']='Who Isco Occupation Name Code';
$headingNameMap['post_created_year']='Post Created Year';
$headingNameMap['recruitment_rule_code']='Recruitment Rule Code';
$headingNameMap['existing_male']='Existing Male';
$headingNameMap['existing_female']='Existing Female';
$headingNameMap['existing_total']='Existing Total';
$headingNameMap['vacant_post']='Vacant Post';
$headingNameMap['pay_scale']='Pay Scale';
$headingNameMap['class']='Class';
$headingNameMap['type_of_code']='Type Of Code';
$headingNameMap['extra']='Extra';
$headingNameMap['remarks']='Remarks';
$headingNameMap['first_level_id']='First level Id';
$headingNameMap['first_level_name']='First Level Name';
$headingNameMap['second_level_id']='Second Level Id';
$headingNameMap['second_level_name']='Second Level Name';
$headingNameMap['sanctioned_post_count']='Sanctioned Post Count';
$headingNameMap['org_code']='Org Code';
$headingNameMap['org_id']='Org Id';
$headingNameMap['designation_id']='Designation Id';
$headingNameMap['designation_code']='Designation Code';
$headingNameMap['staff_id']='Staff Id';
$headingNameMap['staff_id_2']='Staff Id-2';
$headingNameMap['match']='Match';
$headingNameMap['type_of_post_code']='Type Of Post Code';
$headingNameMap['type_of_post_name']='Type Of Post Name';
$headingNameMap['designation_code']='Designation Code';
$headingNameMap['designation']='Designation';
$headingNameMap['payscale']='Payscale';
$headingNameMap['class']='Class';
$headingNameMap['designation_group_code']='Designation Group Code';
$headingNameMap['ranking']='Ranking';
$headingNameMap['bangladesh_professional_category_code']='Bangladesh Professional Category Code';
$headingNameMap['who_occupation_group_code']='Who Occupation Group Code';
$headingNameMap['bangladesh_professional_category_code']='Bangladesh Professional Category Code';
$headingNameMap['bangladesh_professional_category_name']='Bangladesh Professional Category Name';
$headingNameMap['who_health_professional_group_code']='Who Health Professional Group Code';
$headingNameMap['who_health_professional_group_name']='Who Health Professional Group Name';
$headingNameMap['who_isco_occopation_code']='Who Isco Occopation Code';
$headingNameMap['who_isco_occopation_group_name']='Who Isco Occopation Group Name';
$headingNameMap['isco_code']='Isco Code';
$headingNameMap['isco_occupationa_name']='Isco Occupationa Name';
$headingNameMap['definition']='Definition';
$headingNameMap['example']='Example';
$headingNameMap['note']='Note';
?>
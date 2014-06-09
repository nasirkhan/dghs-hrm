<?php
$staffsBaseTable['tableName'] = "old_tbl_staff_organization";
$staffsBaseTable['tableNameAlias'] = "s";
$organizationsBaseTable['tableName'] = "organization";
$organizationsBaseTable['tableNameAlias'] = "o";
$sanctionedpostsBaseTable['tableName'] = "total_manpower_imported_sanctioned_post_copy";
$sanctionedpostsBaseTable['tableNameAlias'] = "p";

/**
 * Selection criteria to get all columns for related tables
 */
$allColSelection = " WHERE TABLE_SCHEMA = '$dbname' AND ( TABLE_NAME = '" . $staffsBaseTable['tableName'] . "' OR TABLE_NAME = '" . $organizationsBaseTable['tableName'] . "' OR TABLE_NAME = '" . $sanctionedpostsBaseTable['tableName'] . "') ";
/**
 * Default fields to show
 */
if ($t == 'staff') {
  $showFields = array("staff_name", "staff_id", "father_name", "contact_no", "sex_name", "org_name", "org_type_name", "division_name", "district_name", "upazila_thana_name", "designation", "group", "class", "first_level_name", "second_level_name");

  /**
   * Tables and Joins
   */
  $tableName = $staffsBaseTable['tableName'] . " AS " . $staffsBaseTable['tableNameAlias'] . "
LEFT JOIN " . $organizationsBaseTable['tableName'] . " AS " . $organizationsBaseTable['tableNameAlias'] . " ON " . $staffsBaseTable['tableNameAlias'] . ".org_code = " . $organizationsBaseTable['tableNameAlias'] . ".org_code
LEFT JOIN " . $sanctionedpostsBaseTable['tableName'] . " AS " . $sanctionedpostsBaseTable['tableNameAlias'] . " ON " . $staffsBaseTable['tableNameAlias'] . ".staff_id = " . $sanctionedpostsBaseTable['tableNameAlias'] . ".staff_id_2
";

  /*
   *    SQL ORDER BY
   */
  $order_by = "s.staff_name";
  $order_sort = "ASC";
} else {
  $t = "post";
  $rTitle = "post";
  $showFields = array("designation", "group", "class", "first_level_name", "second_level_name", "staff_name", "staff_id", "father_name", "contact_no", "sex_name", "org_name", "org_type_name", "division_name", "district_name", "upazila_thana_name");

  /**
   * Tables and Joins
   */
  $tableName = $sanctionedpostsBaseTable['tableName'] . " AS " . $sanctionedpostsBaseTable['tableNameAlias'] . "
LEFT JOIN " . $staffsBaseTable['tableName'] . " AS " . $staffsBaseTable['tableNameAlias'] . " ON " . $sanctionedpostsBaseTable['tableNameAlias'] . ".staff_id_2 = " . $staffsBaseTable['tableNameAlias'] . ".staff_id
  LEFT JOIN " . $organizationsBaseTable['tableName'] . " AS " . $organizationsBaseTable['tableNameAlias'] . " ON " . $sanctionedpostsBaseTable['tableNameAlias'] . ".org_code = " . $organizationsBaseTable['tableNameAlias'] . ".org_code
";

  /*
   *    SQL ORDER BY
   */
  $order_by = "p.designation ";
  $order_sort = "ASC";
}

?>
<?php
require_once 'configuration.php';
if ($_SESSION['logged'] != true) {
  header("location:login.php");
}
$t = $_REQUEST['t']; // $t = report type 'staff','post'
/**
 * Config
 */
$rTitle = $_REQUEST['t']; // report title

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
  LEFT JOIN " . $organizationsBaseTable['tableName'] . " AS " . $organizationsBaseTable['tableNameAlias'] . " ON " . $staffsBaseTable['tableNameAlias'] . ".org_code = " . $organizationsBaseTable['tableNameAlias'] . ".org_code
";

  /*
   *    SQL ORDER BY
   */
  $order_by = "p.designation ";
  $order_sort = "ASC";
}




/**
 * select item definitions
 */
$singleSelectItems = array('division_code', 'district_code', 'upazila_id'); // put the input field names for single selection dropdowns. Input filed name must be same as table filed name
$multiSelectItems = array('agency_code', 'org_type_code', 'org_level_code', 'org_healthcare_level_code', 'org_location_type', 'ownership_code', 'posting_status',
    'tribal_id', 'post_type_id', 'job_posting_id', 'working_status_id', 'draw_salary_id', 'sex', 'marital_status', 'religion',
    'professional_discipline_of_current_designation', 'type_of_educational_qualification', 'govt_quarter',
    'designation', 'group', 'bangladesh_professional_category_code', 'who_occupation_group_code', 'who_isco_occupation_name_code', 'pay_scale', 'class', 'type_of_code',
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
$tableFieldMap['designation_group_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".designation_group_code";
$tableFieldMap['bangladesh_professional_category_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".bangladesh_professional_category_code";
$tableFieldMap['who_occupation_group_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".who_occupation_group_code";
$tableFieldMap['who_isco_occupation_name_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".who_isco_occupation_name_code";
$tableFieldMap['pay_scale'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".pay_scale";
$tableFieldMap['class'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".class";
$tableFieldMap['type_of_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".type_of_code";
$tableFieldMap['first_level_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".first_level_code";
$tableFieldMap['second_level_code'] = $sanctionedpostsBaseTable['tableNameAlias'] . ".second_level_code";


// checks for value inconsistency
$DBvalidation = FALSE;
if ($_REQUEST['highlight_empty_cell'] == 'true') { // checks for empty cells
  $DBvalidation = TRUE;
}

// just to easily create readable names from db field names. this is a lame feature anyway :) but it helps reduce the column width
$replaceUnderScoreWithSpace = FALSE;
if ($_REQUEST['tableheader_without_underscore'] == 'true') {
  $replaceUnderScoreWithSpace = TRUE;
}

// forms submission
if (isset($_REQUEST['submit'])) {

  if (strlen(trim($_REQUEST['rTitle']))) {
    $rTitle = trim($_REQUEST['rTitle']);
  }

  $parameterized_query = " WHERE 1 "; // default parameter query
  //$selection_string = "";


  foreach ($singleSelectItems as $singleSelectItem) {
    if (strlen($_REQUEST[$singleSelectItem]) && $_REQUEST[$singleSelectItem] > 0) {
      $parameterized_query.=" AND '$tableFieldMap[$singleSelectItem]' = '" . mysql_real_escape_string(trim($_REQUEST[$singleSelectItem])) . "' ";
    }
  }

  $csvs = array();
  foreach ($multiSelectItems as $multiSelectItem) {
    if (count($_REQUEST[$multiSelectItem])) {
      $csvs[$multiSelectItem] = "'" . implode("','", $_REQUEST[$multiSelectItem]) . "'";
      $parameterized_query.=" AND '$tableFieldMap[$multiSelectItem]' in (" . $csvs[$multiSelectItem] . ")  ";
      //$selection_string .= " Agency: <strong>" . getAgencyNameFromAgencyCode($agency_code) . "</strong>";
    }
  }

  if (strlen($_REQUEST['search_field']) && strlen($_REQUEST['search_criteria']) && strlen($_REQUEST['search_value'])) {
    if (in_array($_REQUEST['search_criteria'], array('=', '<', '<=', '>', '>='))) {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " " . $_REQUEST['search_value'] . "  ";
    } else if ($_REQUEST['search_criteria'] == "LIKE") {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " '%" . $_REQUEST['search_value'] . "%'  ";
    }
  }

  if (strlen(trim($_REQUEST['SQLSelect']))) {
    $parameterized_query.= " AND " . trim(($_REQUEST['SQLSelect']));
  }

  $SQLWhereStatement = $parameterized_query;
  //echo "<pre>$SQLWhereStatement</pre>"; //debug

  /*
   *    SQL GROUP BY
   */
  $countField = "";
  if (strlen(trim($_REQUEST['SQLGroup']))) {
    $group_by = trim($_REQUEST['SQLGroup']);
    $parameterized_query .= " GROUP BY $group_by ";
    $countField = ",COUNT(*) as total";
  }


  /**
   * Show fields
   */
  $TableFields = getTableFieldNamesFrmMultipleTables(array($staffsBaseTable['tableName'], $organizationsBaseTable['tableName'], $sanctionedpostsBaseTable['tableName']));

  //myprint_r($TableFields);

  if (count($_REQUEST['f'])) {
    $showFields = $_REQUEST['f'];
  }
  $showFieldsCsv = implode(',', $showFields);

  /*   * **************** */

  /*   * **
   * If order is set then it over rides the f[]
   */
  if (strlen(trim($_REQUEST['ColOrder']))) {

    $showFieldsCsv = str_replace(" ", '', trim($_REQUEST['ColOrder'], " ,"));
    $showFields = explode(',', $showFieldsCsv);
  }
  if (strlen(trim($_REQUEST['ColAlias']))) {

    $colAliasCsv = trim($_REQUEST['ColAlias']);
    $colAlias = explode(',', $colAliasCsv);
    if (count($showFields) != count($colAlias)) {
      echo "Column Alias must have same number of column";
      exit();
    }
  }



  if (strlen(trim($_REQUEST['order_by'])) && strlen(trim($_REQUEST['order_sort']))) {
    $order_by = trim($_REQUEST['order_by']);
    $order_sort = trim($_REQUEST['order_sort']);

    $orderByParam = " ORDER BY $order_by $order_sort ";
  }

  if (strlen(trim($_REQUEST['orderbyfull']))) {
    $orderByParam = " ORDER BY " . trim($_REQUEST['orderbyfull']);
  }


  $parameterized_query .= $orderByParam;
  /*   * *********** */



  $sql = "SELECT * $countField FROM $tableName $parameterized_query";

  $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
  $count = mysql_num_rows($result);

  //
  $fieldNameAlias = array();
  assignAliasForDbFieldNames();
  $sexCountArray = getSexGroupedCount();
  $filledPostCountArray = getFilledPostCount();

  //echo "<pre>" . count($sexCountArray) . "</pre>";
  //myprint_r($sexCountArray);

  /*
    //easy create $fieldNameAlias by printing
    $fieldNames = getTableFieldNames('organization');
    foreach ($fieldNames as $fieldName) {
    echo '$fieldNameAlias[\'' . $fieldName . '\'] =\'' . $fieldName . '\'' . ";<br/>";
    }

   */
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Report</title>
    <?php
    include_once 'include/header/header_css_js.inc.php';
    include_once 'include/header/header_ga.inc.php';
    ?>
    <link href="assets/css/report.css" rel="stylesheet"/>
  </head>
  <body>
    <?php include_once 'include/header/header_top_menu.inc.php'; ?>
    <div class="container">
      <h4 style="text-transform: uppercase">Report : <?php echo $rTitle; ?></h4>
      <?php if ($_REQUEST['HideFilter'] != 'true') { ?>

        <div id="showHide" style="cursor: pointer">
          <span id="showHideBtn" >[ - ] Hide Filters</span>
          <script type="text/javascript">
            $('#showHide').click(function() {
              //alert('test');
              $('#filter').toggle(function() {
                var text = "Show";
                if ($('div#filter').is(":visible")) {
                  text = "[ - ] Hide Filters";
                } else {
                  text = "[+]Show Filters";
                }
                $('span#showHideBtn').html(text);
              });

            });</script>

        </div>

        <div class = "filter" id = "filter">
          <form class = "form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "get" style = "padding: 0px; margin: 0px;">
            <table id = "">
              <tr>
                <td style = "vertical-align: top">
                  <b>Select Administrative Unit</b><br/>
                  <table>
                    <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_division_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                      <tr>
                        <td style="width: 170px;"><input name="f_division_code" value="1" checked="checked" type="checkbox"/> <b>Division</b></td>
                        <td><?php createSelectOptions('admin_division', 'division_bbs_code', 'division_name', $customQuery, $_REQUEST['division_code'], "division_code", " id='admin_division'  class='pull-left' style='width:80px'", $optionIdField)
                      ?></td>
                      </tr>
                    <?php } ?>
                    <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_district_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                      <tr>
                        <td><input name="f_district_code" value="1" checked="checked" type="checkbox" /> <b>District</b></td>
                        <td><?php createSelectOptions('admin_district', 'district_bbs_code', 'district_name', " WHERE division_bbs_code='" . $_REQUEST['division_code'] . "'", $_REQUEST['district_code'], "district_code", " id='admin_district' class='pull-left' style='width:80px' ", $optionIdField); ?></td>
                      </tr>
                    <?php } ?>
                    <?php if ((isset($_REQUEST['submit']) && $_REQUEST['admin_upazila'] == '1') || !isset($_REQUEST['submit'])) { ?>
                      <tr>
                        <td><input name="admin_upazila" value="1" checked="checked" type="checkbox"/> <b>Upazila</b></td>
                        <td><?php createSelectOptions('admin_upazila', 'id', 'upazila_name', " WHERE upazila_district_code='" . $_REQUEST['district_code'] . "'", $_REQUEST['upazila_id'], "upazila_id", " id='admin_upazila'  class='pull-left' style='width:80px;' ", $optionIdField); ?></td>
                      </tr>
                    <?php } ?>
                  </table>
                  <?php
                  $checked = "";
                  if ($_REQUEST['noDatatable'] == 'true') {
                    $checked = " checked='checked' ";
                  }
                  ?>
                  <input type="checkbox" name="noDatatable" value="true" <?= $checked ?>/> Optimize loading
                </td>
                <td style="vertical-align: top">
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_agency_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_agency_code" value="1" checked="checked" type="checkbox"/> <b>Agency</b><br/>

                    <?php
                    createMultiSelectOptions('org_agency_code', 'org_agency_code', 'org_agency_name', $customQuery, $csvs['agency_code'], "agency_code[]", " id='agency_code'  class='multiselect' ");
                    echo "<br/>";
                  }
                  ?>
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_level_code" value="1" checked="checked" type="checkbox"/> <b>Org Level</b>
                    <?php
                    createMultiSelectOptions('org_level', 'org_level_code', 'org_level_name', $customQuery, $csvs['org_level_code'], "org_level_code[]", " id='org_level_code' class='multiselect' ");
                    echo "<br/>";
                  }
                  ?>
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_type_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_type_code" value="1" checked="checked" type="checkbox"/> <b>Org Type</b><br/>
                    <?php
                    createMultiSelectOptions('org_type', 'org_type_code', 'org_type_name', $customQuery, $csvs['org_type_code'], "org_type_code[]", " id='type_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                </td>
                <td style="vertical-align: top">
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_healthcare_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_healthcare_level_code" value="1" checked="checked" type="checkbox"/> <b>Healthcare Level</b><br/>
                    <?php
                    createMultiSelectOptions('org_healthcare_levels', 'healthcare_code', 'healthcare_name', $customQuery, $csvs['org_healthcare_level_code'], "org_healthcare_level_code[]", " id='org_healthcare_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_location_type'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_location_type" value="1" checked="checked" type="checkbox"/>
                    <b>Location Type</b><br/>
                    <?php
                    createMultiSelectOptions('org_location_type', 'org_location_type_code', 'org_location_type_name', $customQuery, $csvs['org_location_type'], "org_location_type[]", " id='org_location_type'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?><?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_ownership_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_ownership_code" value="1" checked="checked" type="checkbox"/>
                    <b>Ownership</b><br/>
                    <?php
                    createMultiSelectOptions('org_ownership_authority', 'org_ownership_authority_code', 'org_ownership_authority_name', $customQuery, $csvs['ownership_code'], "ownership_code[]", " id='ownership_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
                </td>

                <td style="vertical-align: top">
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_department_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_department_id" value="1" checked="checked" type="checkbox"/>
                    <b>Department</b><br/>
                    <?php
                    createMultiSelectOptions('very_old_departments', 'department_id', 'name', $customQuery, $csvs['department_id'], "department_id[]", " id='department_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_posting'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_posting" value="1" checked="checked" type="checkbox"/>
                    <b>Posting type</b><br/>
                    <?php
                    createMultiSelectOptions('staff_posting_type', 'staff_posting_type_id', 'staff_posting_type_name', $customQuery, $csvs['staff_posting'], "staff_posting[]", " id='staff_posting'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_posting_status'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_posting_status" value="1" checked="checked" type="checkbox"/>
                    <b>Posting Status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_job_posting', 'job_posting_id', 'job_posting_name', $customQuery, $csvs['posting_status'], "posting_status[]", " id='posting_status'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_job_class'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_job_class" value="1" checked="checked" type="checkbox"/>
                    <b>Job Class</b><br/>
                    <?php
                    createMultiSelectOptions('staff_job_class', 'job_class_id', 'job_class_name', $customQuery, $csvs['staff_job_class'], "staff_job_class[]", " id='staff_job_class'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_professional_category'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_professional_category" value="1" checked="checked" type="checkbox"/>
                    <b>Prof category</b><br/>
                    <?php
                    createMultiSelectOptions('staff_professional_category_type', 'professional_type_id', 'professional_type_name', $customQuery, $csvs['staff_professional_category'], "staff_professional_category[]", " id='staff_professional_category'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
                </td>

                <td style="vertical-align: top">

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_tribal_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_tribal_id" value="1" checked="checked" type="checkbox"/>
                    <b>Tribal</b><br/>
                    <?php
                    createMultiSelectOptions('staff_tribal', 'tribal_id', 'tribal_value', $customQuery, $csvs['tribal_id'], "tribal_id[]", " id='tribal_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_working_status_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_working_status_id" value="1" checked="checked" type="checkbox"/>
                    <b>Working status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_working_status', 'working_status_id', 'working_status_name', $customQuery, $csvs['working_status_id'], "working_status_id[]", " id='working_status_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_draw_salary_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_draw_salary_id" value="1" checked="checked" type="checkbox"/>
                    <b>Salary place</b><br/>
                    <?php
                    createMultiSelectOptions('staff_draw_salaray_place', 'draw_salary_id', 'draw_salaray_place', $customQuery, $csvs['draw_salary_id'], "draw_salary_id[]", " id='draw_salary_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_sex'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_sex" value="1" checked="checked" type="checkbox"/>
                    <b>Sex</b><br/>
                    <?php
                    createMultiSelectOptions('staff_sex', 'sex_type_id', 'sex_name', $customQuery, $csvs['sex'], "sex[]", " id='sex'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_marital_status'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_marital_status" value="1" checked="checked" type="checkbox"/>
                    <b>Marital status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_marital_status', 'marital_status_id', 'marital_status', $customQuery, $csvs['marital_status'], "marital_status[]", " id='marital_status'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_religion'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_religion" value="1" checked="checked" type="checkbox"/>
                    <b>Religious group</b><br/>
                    <?php
                    createMultiSelectOptions('staff_religious_group', 'religious_group_id', 'religious_group_name', $customQuery, $csvs['religion'], "religion[]", " id='religion'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                </td>
                <td style="vertical-align: top">


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_professional_discipline_of_current_designation'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_professional_discipline_of_current_designation" value="1" checked="checked" type="checkbox"/>
                    <b>Prof Discipline</b><br/>
                    <?php
                    createMultiSelectOptions('staff_profesional_discipline', 'discipline_id', 'discipline_name', $customQuery, $csvs['professional_discipline_of_current_designation'], "professional_discipline_of_current_designation[]", " id='professional_discipline_of_current_designation'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_type_of_educational_qualification'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_type_of_educational_qualification" value="1" checked="checked" type="checkbox"/>
                    <b>Edu qualification</b><br/>
                    <?php
                    createMultiSelectOptions('staff_educational_qualification', 'educational_qualifiaction_Id', 'educational_qualification', $customQuery, $csvs['type_of_educational_qualification'], "type_of_educational_qualification[]", " id='type_of_educational_qualification'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_govt_quarter'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_govt_quarter" value="1" checked="checked" type="checkbox"/>
                    <b>Govt. Quarter</b><br/>
                    <?php
                    createMultiSelectOptions('staff_govt_quater', 'govt_quater_id', 'govt_quater', $customQuery, $csvs['govt_quarter'], "govt_quarter[]", " id='govt_quarter'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
                </td>

                <td style="vertical-align: top">

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_designation'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_designation" value="1" checked="checked" type="checkbox"/>
                    <b>Designation</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'designation', 'designation', $customQuery, $csvs['designation'], "designation[]", " id='designation'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_group'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_designation" value="1" checked="checked" type="checkbox"/>
                    <b>Designation Group</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'designation_group_name', 'designation_group_name', $customQuery, $csvs['group'], "group[]", " id='group'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_bangladesh_professional_category_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_bangladesh_professional_category_code" value="1" checked="checked" type="checkbox"/>
                    <b>BD Prof Cat</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_bangladesh_professional_category', 'bangladesh_professional_category_code', 'bangladesh_professional_category_name', $customQuery, $csvs['bangladesh_professional_category_code'], "bangladesh_professional_category_code[]", " id='bangladesh_professional_category_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_who_occupation_group_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_who_occupation_group_code" value="1" checked="checked" type="checkbox"/>
                    <b>WHO group</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_who_health_professional_group', 'who_health_professional_group_code', 'who_health_professional_group_name', $customQuery, $csvs['who_occupation_group_code'], "who_occupation_group_code[]", " id='who_occupation_group_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_who_isco_occopation_group_name'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_who_isco_occopation_group_name" value="1" checked="checked" type="checkbox"/>
                    <b>WHO ISCO</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_who_isco_occopation_name', 'who_isco_occopation_group_code', 'who_isco_occopation_group_name', $customQuery, $csvs['who_isco_occupation_name_code'], "who_isco_occupation_name_code[]", " id='who_isco_occupation_name_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_pay_scale'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_pay_scale" value="1" checked="checked" type="checkbox"/>
                    <b>Pay scale</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'payscale', 'payscale', $customQuery, $csvs['pay_scale'], "pay_scale[]", " id='pay_scale'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_class'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_class" value="1" checked="checked" type="checkbox"/>
                    <b>Class</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'class', 'class', $customQuery, $csvs['class'], "class[]", " id='class'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_type_of_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_type_of_code" value="1" checked="checked" type="checkbox"/>
                    <b>Type</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_type_of_post', 'type_of_post_code', 'type_of_post_name', $customQuery, $csvs['type_of_code'], "type_of_code[]", " id='type_of_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_first_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_first_level_code" value="1" checked="checked" type="checkbox"/>
                    <b>First Level</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_first_level', 'first_level_code', 'first_level_name', $customQuery, $csvs['first_level_code'], "first_level_code[]", " id='first_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_second_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_second_level_code" value="1" checked="checked" type="checkbox"/>
                    <b>Second Level</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_second_level', 'second_level_code', 'second_level_name', $customQuery, $csvs['second_level_code'], "second_level_code[]", " id='second_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                </td>
                <td style="vertical-align:top;">
                  <?php include_once './include/report/inc.mysql_fields.php'; ?>
                </td>
              </tr>
            </table>
            <table>
              <tr>
                <td>
                  <div class="btn-group">
                    <button name="submit" type="submit" class="btn btn-success" style="text-transform: uppercase">Generate Report</button>
                    <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn" style="text-transform: uppercase">Reset</a>
                    <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;text-transform: uppercase"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                  </div>
                </td>
            </table>
            <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_advancedOptions'] == '1') || !isset($_REQUEST['submit'])) { ?>
              <input name="f_advancedOptions" value="1" checked="checked" type="checkbox"/> <b>Advanced Options</b> <br/>
              <table id="advancedOptions">
                <tr>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['show_sql'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="show_sql" value="true" <?= $checked ?>/> Show SQL query
                  </td>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['highlight_empty_cell'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="highlight_empty_cell" value="true" <?= $checked ?>/>Highlight empty cell
                  </td>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['tableheader_without_underscore'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="tableheader_without_underscore" value="true" <?= $checked ?>/>Remove '_' from table header
                    <?php
                    $checked = "";
                    if ($_REQUEST['HideFilter'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="HideFilter" value="true" <?= $checked ?>/>Hide filters
                  </td>
                </tr>
              </table>
            <?php } ?>
          </form>
        </div>
        <?php
        if (strlen($sql) && $_REQUEST['show_sql'] == 'true') {
          echo "<pre class='pull-left'>$sql</pre>";
        }
      }
      if (isset($_REQUEST['submit'])) {
        ?>
        <blockquote class="pull-left"><?php echo "$selection_string"; ?></blockquote>
        <blockquote class="pull-left">
          Total <strong><em><?= $count ?></em></strong> result(s) found.<br />
        </blockquote>

        <?php
        if ($_REQUEST['noDatatable'] == 'true') {
          $param = "";
        } else {
          $param = " id='datatable' ";
        }
        ?>
        <table class="table table-condensed table-bordered" <?= $param ?>>
          <thead>
            <tr>
              <?php
              //myprint_r($showFields);
              $i = 0;
              foreach ($showFields as $fieldName) {
                if (in_array($fieldName, $TableFields)) {
                  ?>
                  <th id="<?= $fieldName ?>"><strong><a href="#" title="<?= $fieldName ?>">
                        <?php
                        if (strlen($fieldNameAlias[$fieldName])) {
                          if ($replaceUnderScoreWithSpace) {
                            $fieldName = str_replace('_', ' ', $fieldNameAlias[$fieldName]);
                          } else {
                            $fieldName = $fieldNameAlias[$fieldName];
                          }
                        } else {
                          if ($replaceUnderScoreWithSpace) {
                            $fieldName = str_replace('_', ' ', $fieldName);
                          }
                        }
                        if (strlen($colAlias[$i])) {
                          $fieldName = $colAlias[$i];
                          $i++;
                        }
                        echo $fieldName;
                        ?>
                      </a>
                    </strong>
                  </th>
                  <?php
                }
              }
              if (strlen($countField)) {
                echo "<th><b>Total $t</b></th>";
              }
              if ($sexCountArray) {
                echo "<th><b>Male</b></th>";
                echo "<th><b>Female</b></th>";
                echo "<th><b>Filled up</b></th>";
                echo "<th><b>Vacant</b></th>";
              }
              ?>

            </tr>
          </thead>
          <tbody>
            <?php
            $subTotal = 0;
            //echo "<pre>group_by $group_by </pre>"; //debug
            $group_by_array = getGroupByArrayWoutPrefix($group_by);
            //myprint_r($group_by_array); // debug
            while ($data = mysql_fetch_assoc($result)) {
              ?>
              <tr>
                <?php
                $totalFields = count($showFields);
                $filledFields = 0;
                foreach ($showFields as $fieldName) {
                  if (in_array($fieldName, $TableFields)) {
                    if ($DBvalidation == TRUE) {
                      $tdClass = "";
                      if (!strlen($data[$fieldName])) {
                        $filledFields++;
                        $tdClass = "bgRed";
                      } else {

                        //  }
                      }
                    }
                    ?>
                    <td class="<?= $tdClass ?>"><?php echo $data[$fieldName]; ?></td>
                    <?php
                  }
                }
                if (strlen($countField)) {
                  $subTotal+=$data['total'];
                  echo "<td>" . $data['total'] . "</td>";
                }
                if ($sexCountArray) {
                  $stringTok = "";
                  foreach ($group_by_array as $ga) {
                    $stringTok .= $data[$ga] . "|";
                  }
                  //echo $sexCountArray[]."|".]
                  $maleCount = 0;
                  if (strlen($sexCountArray[$stringTok . "Male|"])) {
                    $maleCount = $sexCountArray[$stringTok . "Male|"];
                  }
                  $femaleCount = 0;
                  if (strlen($sexCountArray[$stringTok . "Female|"])) {
                    $femaleCount = $sexCountArray[$stringTok . "Female|"];
                  }
                  $filledupTotal = $maleCount + $femaleCount;
                  $vacantTotal = $data['total'] - $filledupTotal;

                  echo "<td>$maleCount</td>";
                  echo "<td>$femaleCount</td>";
                  echo "<td>$filledupTotal</td>";
                  echo "<td>$vacantTotal</td>";
                }
                ?>

              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php
      }
      if (strlen($countField)) {
        echo "<h4 class='pull-right'>SUBTOTAL " . $subTotal . "</h4><br/>";
      }
      ?>
      <?php if (strlen($showFieldsCsv)) { ?>
        <div class="clearfix"></div>
        <h5>TABLE FIELD NAMES</h5>
        <pre>
          <?php echo trim($showFieldsCsv, ", "); ?>
        </pre>
      <?php } ?>
    </div>

    <!-- Footer
    ================================================== -->
    <?php include_once 'include/footer/footer.inc.php'; ?>
    <?php include_once 'include/report/report_org_list/report_org_list.js.php'; ?>
  </body>
</html>
<?php

function assignAliasForDbFieldNames() {
  global $fieldNameAlias;
  $fieldNameAlias['id'] = 'id';
  $fieldNameAlias['org_name'] = 'Organization name';
  $fieldNameAlias['org_code'] = 'org_code';
  $fieldNameAlias['org_type_code'] = 'org_type_code';
  $fieldNameAlias['org_type_name'] = 'org_type_name';
  $fieldNameAlias['agency_code'] = 'agency_code';
  $fieldNameAlias['agency_name'] = 'agency_name';
  $fieldNameAlias['org_function_code'] = 'org_function_code';
  $fieldNameAlias['org_level_code'] = 'org_level_code';
  $fieldNameAlias['org_level_name'] = 'org_level_name';
  $fieldNameAlias['org_healthcare_level_code'] = 'org_healthcare_level_code';
  $fieldNameAlias['special_service_code'] = 'special_service_code';
  $fieldNameAlias['year_established'] = 'year_established';
  $fieldNameAlias['org_location_type'] = 'org_location_type';
  $fieldNameAlias['division_code'] = 'division_code';
  $fieldNameAlias['division_name'] = 'division_name';
  $fieldNameAlias['division_id'] = 'division_id';
  $fieldNameAlias['district_code'] = 'district_code';
  $fieldNameAlias['district_name'] = 'district_name';
  $fieldNameAlias['district_id'] = 'district_id';
  $fieldNameAlias['upazila_thana_code'] = 'upazila_thana_code';
  $fieldNameAlias['upazila_thana_name'] = 'upazila_thana_name';
  $fieldNameAlias['upazila_id'] = 'upazila_id';
  $fieldNameAlias['union_code'] = 'union_code';
  $fieldNameAlias['union_name'] = 'union_name';
  $fieldNameAlias['union_id'] = 'union_id';
  $fieldNameAlias['ward_code'] = 'ward_code';
  $fieldNameAlias['village_code'] = 'village_code';
  $fieldNameAlias['house_number'] = 'house_number';
  $fieldNameAlias['latitude'] = 'latitude';
  $fieldNameAlias['longitude'] = 'longitude';
  $fieldNameAlias['org_photo'] = 'org_photo';
  $fieldNameAlias['financial_revenue_code'] = 'financial_revenue_code';
  $fieldNameAlias['ownership_code'] = 'ownership_code';
  $fieldNameAlias['mailing_address'] = 'mailing_address';
  $fieldNameAlias['land_phone1'] = 'land_phone1';
  $fieldNameAlias['land_phone2'] = 'land_phone2';
  $fieldNameAlias['land_phone3'] = 'land_phone3';
  $fieldNameAlias['mobile_number1'] = 'mobile_number1';
  $fieldNameAlias['mobile_number2'] = 'mobile_number2';
  $fieldNameAlias['mobile_number3'] = 'mobile_number3';
  $fieldNameAlias['email_address1'] = 'email_address1';
  $fieldNameAlias['email_address2'] = 'email_address2';
  $fieldNameAlias['email_address3'] = 'email_address3';
  $fieldNameAlias['fax_number1'] = 'fax_number1';
  $fieldNameAlias['fax_number2'] = 'fax_number2';
  $fieldNameAlias['fax_number3'] = 'fax_number3';
  $fieldNameAlias['website_address'] = 'website_address';
  $fieldNameAlias['facebook_page'] = 'facebook_page';
  $fieldNameAlias['google_plus_page'] = 'google_plus_page';
  $fieldNameAlias['twitter_page'] = 'twitter_page';
  $fieldNameAlias['youtube_page'] = 'youtube_page';
  $fieldNameAlias['source_of_electricity_main_code'] = 'source_of_electricity_main_code';
  $fieldNameAlias['source_of_electricity_alternate_code'] = 'source_of_electricity_alternate_code';
  $fieldNameAlias['source_of_water_supply_main_code'] = 'source_of_water_supply_main_code';
  $fieldNameAlias['source_of_water_supply_alternate_code'] = 'source_of_water_supply_alternate_code';
  $fieldNameAlias['toilet_type_code'] = 'toilet_type_code';
  $fieldNameAlias['toilet_adequacy_code'] = 'toilet_adequacy_code';
  $fieldNameAlias['fuel_source_code'] = 'fuel_source_code';
  $fieldNameAlias['laundry_code'] = 'laundry_code';
  $fieldNameAlias['autoclave_code'] = 'autoclave_code';
  $fieldNameAlias['waste_disposal_code'] = 'waste_disposal_code';
  $fieldNameAlias['sanctioned_office_equipment'] = 'sanctioned_office_equipment';
  $fieldNameAlias['sanctioned_vehicles'] = 'sanctioned_vehicles';
  $fieldNameAlias['sanctioned_bed_number'] = 'sanctioned_bed_number';
  $fieldNameAlias['other_miscellaneous_issues'] = 'other_miscellaneous_issues';
  $fieldNameAlias['permission_approval_license_info_code'] = 'permission_approval_license_info_code';
  $fieldNameAlias['permission_approval_license_info_date'] = 'permission_approval_license_info_date';
  $fieldNameAlias['permission_approval_license_type'] = 'permission_approval_license_type';
  $fieldNameAlias['permission_approval_license_aithority'] = 'permission_approval_license_aithority';
  $fieldNameAlias['permission_approval_license_number'] = 'permission_approval_license_number';
  $fieldNameAlias['permission_approval_license_next_renewal_date'] = 'permission_approval_license_next_renewal_date';
  $fieldNameAlias['permission_approval_license_conditions'] = 'permission_approval_license_conditions';
  $fieldNameAlias['land_info_code'] = 'land_info_code';
  $fieldNameAlias['land_size'] = 'land_size';
  $fieldNameAlias['land_mouza_name'] = 'land_mouza_name';
  $fieldNameAlias['land_mouza_geo_code'] = 'land_mouza_geo_code';
  $fieldNameAlias['land_jl_number'] = 'land_jl_number';
  $fieldNameAlias['land_functional_code'] = 'land_functional_code';
  $fieldNameAlias['land_rs_dag_number'] = 'land_rs_dag_number';
  $fieldNameAlias['land_ss_dag_number'] = 'land_ss_dag_number';
  $fieldNameAlias['land_kharian_number'] = 'land_kharian_number';
  $fieldNameAlias['land_other_info'] = 'land_other_info';
  $fieldNameAlias['land_mutation_number'] = 'land_mutation_number';
  $fieldNameAlias['additional_chcp_name'] = 'additional_chcp_name';
  $fieldNameAlias['additional_chcp_contact'] = 'additional_chcp_contact';
  $fieldNameAlias['additional_community_group_info'] = 'additional_community_group_info';
  $fieldNameAlias['additional_chairnam_name'] = 'additional_chairnam_name';
  $fieldNameAlias['additional_chairman_contact'] = 'additional_chairman_contact';
  $fieldNameAlias['additional_chairman_community_support_info'] = 'additional_chairman_community_support_info';
  $fieldNameAlias['additional_csg_1_name'] = 'additional_csg_1_name';
  $fieldNameAlias['additional_csg_1_contact'] = 'additional_csg_1_contact';
  $fieldNameAlias['additional_csg_2_name'] = 'additional_csg_2_name';
  $fieldNameAlias['additional_csg_2_contact'] = 'additional_csg_2_contact';
  $fieldNameAlias['org_functions'] = 'org_functions';
  $fieldNameAlias['uploaded_file'] = 'uploaded_file';
  $fieldNameAlias['updated_by'] = 'updated_by';
  $fieldNameAlias['active'] = 'active';
  $fieldNameAlias['updated_datetime'] = 'updated_datetime';
  $fieldNameAlias['organization_id'] = 'organization_id';
  $fieldNameAlias['monthly_update'] = 'monthly_update';
  $fieldNameAlias['monthly_update_datetime'] = 'monthly_update_datetime';
  $fieldNameAlias['upload_datetime'] = 'upload_datetime';
  $fieldNameAlias['uploaded_by'] = 'uploaded_by';
}

function getTableFieldNamesFrmMultipleTables($tableNames) {

  global $dbname;
  $fieldNames = array();

  $i = 0;
  foreach ($tableNames as $tableName) {
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tableName'";
    //echo $sql;
    $r = mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);

      foreach ($a as $fieldName) {
        $fieldNames[$i++] = $fieldName['COLUMN_NAME'];
      }
    }
  }

  return $fieldNames;
}

function getSexGroupedCount($additionalWheres = " AND s.sex_name in('Male','Female')") {
  global $tableName;
  global $SQLWhereStatement;
  global $group_by;
  global $orderByParam;

  if (strlen(trim($group_by))) {

    $sql = "SELECT $group_by,s.sex_name, count(*) as total FROM $tableName $SQLWhereStatement $additionalWheres GROUP BY $group_by,s.sex_name $orderByParam";
    //echo "<pre>$sql</pre>"; //debug

    $r = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);
      $countStore = array();

      $group_by_array = explode(',', $group_by);

      foreach ($a as $row) {
        $numberOfCol = count($group_by_array);
        $str = "";
        for ($i = 0; $i <= $numberOfCol; $i++) {
          $str.=$row[$i] . "|";
        }
        $countStore[$str] = $row[$i];
      }
      if (count($countStore)) {
        return $countStore;
      }
    }
  }
  return FALSE;
  //myprint_r($countStore);
}

function getFilledPostCount($additionalWheres = " AND p.staff_id_2>0 ") {
  global $tableName;
  global $SQLWhereStatement;
  global $group_by;
  global $orderByParam;

  if (strlen(trim($group_by))) {

    $sql = "SELECT $group_by, count(*) as total FROM $tableName $SQLWhereStatement $additionalWheres GROUP BY $group_by,s.sex_name $orderByParam";
    //echo "<pre>$sql</pre>"; //debug

    $r = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);
      $countStore = array();

      $group_by_array = explode(',', $group_by);

      foreach ($a as $row) {
        $numberOfCol = count($group_by_array);
        $str = "";
        for ($i = 0; $i <= $numberOfCol; $i++) {
          $str.=$row[$i] . "|";
        }
        $countStore[$str] = $row[$i];
      }
      if (count($countStore)) {
        return $countStore;
      }
    }
  }
  return FALSE;
  //myprint_r($countStore);
}

function getColNameWoutDot($str) {
  $str = trim($str, ". ");
  if (strlen($str)) {
    if (strstr($str, ".")) {
      $a = array();
      $a = explode('.', $str);
      return $a[1];
    }
  }
  return $str;
}

function getGroupByArrayWoutPrefix($groupbyWithTblPrefix) {
  if (strlen($groupbyWithTblPrefix)) {
    $a = explode(',', $groupbyWithTblPrefix);
    $temp = array();
    for ($i = 0; $i < count($a); $i++) {
      $temp[$i] = getColNameWoutDot($a[$i]);
    }
    return $temp;
  }
}

//myprint_r(explode(",", "abcde,123,"));
?>
<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
  header("location:login.php");
}

$DBvalidation = FALSE;
if ($_REQUEST['highlight_empty_cell'] == 'true') {
  $DBvalidation = TRUE;
}

$replaceUnderScoreWithSpace = FALSE;
if ($_REQUEST['tableheader_without_underscore'] == 'true') {
  $replaceUnderScoreWithSpace = TRUE;
}


if (isset($_REQUEST['submit'])) {

  $parameterized_query = " WHERE 1 ";
  //$selection_string = "";

  $singleSelectItems = array('division_code', 'district_code', 'upazila_id');

  foreach ($singleSelectItems as $singleSelectItem) {
    if (strlen($_REQUEST[$singleSelectItem]) && $_REQUEST[$singleSelectItem] > 0) {
      $parameterized_query.=" AND $singleSelectItem = '" . mysql_real_escape_string(trim($_REQUEST[$singleSelectItem])) . "' ";
      //$selection_string .= " Division: <strong>" . getDivisionNamefromCode($div_code) . "</strong> ";
    }
  }

  $multiSelectItems = array('agency_code', 'org_type_code', 'org_level_code', 'org_healthcare_level_code', 'org_location_type', 'ownership_code', 'source_of_electricity_main_code', 'source_of_electricity_alternate_code', 'source_of_water_supply_main_code', 'source_of_water_supply_alternate_code');
  $csvs = array();
  foreach ($multiSelectItems as $multiSelectItem) {
    if (count($_REQUEST[$multiSelectItem])) {
      $csvs[$multiSelectItem] = "'" . implode("','", $_REQUEST[$multiSelectItem]) . "'";
      $parameterized_query.=" AND $multiSelectItem in (" . $csvs[$multiSelectItem] . ")  ";
      //$selection_string .= " Agency: <strong>" . getAgencyNameFromAgencyCode($agency_code) . "</strong>";
    }
  }

  if (strlen($_REQUEST['search_field']) && strlen($_REQUEST['search_criteria']) && strlen($_REQUEST['search_value'])) {
    if ($_REQUEST['search_criteria'] == "=") {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " '" . $_REQUEST['search_value'] . "'  ";
    } else if ($_REQUEST['search_criteria'] == "LIKE") {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " '%" . $_REQUEST['search_value'] . "%'  ";
    }
  }


  $parameterized_query .= " ORDER BY org_name ";

  $sql = "SELECT * FROM organization $parameterized_query";
  $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
  $count = mysql_num_rows($result);

  $fieldNames = getTableFieldNames('organization');
  $fieldNameAlias = array();
  // easy create $fieldNameAlias by printing
  /*
    foreach ($fieldNames as $fieldName) {
    echo '$fieldNameAlias[\'' . $fieldName . '\'] =\'' . $fieldName . '\'' . ";<br/>";
    }
   *
   */

  $fieldNameAlias['id'] = 'id';
  $fieldNameAlias['org_name'] = 'org_name';
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
    <style>
      select, input, textarea{
        font-size: 12px;
        width: 150px;
      }
      select,input{width: 150px; line-height: 25px; height: 25px; margin: 0px; padding: 3px;}
      .form-horizontal .control-group{margin-bottom: 5px;}
      .btn{font-weight: bold}
      table.dataTable tbody th, table.dataTable tbody td {
        padding: 3px 3px; margin: 0px; border: 0px;
      }
      label, input, button, select, textarea {font-size: 12px;}
      #datatable_filter .datatable_filter{width: 60%;}
      .table tr, .table tr td{padding: 3px; margin: 0px;}
      .table th, .table td{line-height: 16px;}
      .blockquote{margin-left: 5px; }
      * {font-family: "Segoe UI"; font-size: 9px; }
      .bgRed{background-color: #FFCCCC; color: black;}
    </style>



  </head>

  <body>
    <?php include_once 'include/header/header_top_menu.inc.php'; ?>
    <div class="container">
      <div class="">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="padding: 0px; margin: 0px;">
          <h4 style="text-transform: uppercase">Report : Organization List</h4>
          <table id="">
            <tr>
              <td style="vertical-align: top">
                <b>Select Administrative Unit</b><br/>
                <table>
                  <tr>
                    <td><b>Division</b></td>
                    <td><?php createSelectOptions('admin_division', 'division_bbs_code', 'division_name', $customQuery, $_REQUEST['division_code'], "division_code", " id='admin_division'  class='pull-left' ", $optionIdField) ?></td>
                  </tr>
                  <tr>
                    <td><b>District</b></td>
                    <td><?php createSelectOptions('admin_district', 'district_bbs_code', 'district_name', " WHERE division_bbs_code='" . $_REQUEST['division_code'] . "'", $_REQUEST['district_code'], "district_code", " id='admin_district' class='pull-left' ", $optionIdField); ?></td>
                  </tr>
                  <tr>
                    <td><b>Upazila</b></td>
                    <td><?php createSelectOptions('admin_upazila', 'id', 'upazila_name', " WHERE upazila_district_code='" . $_REQUEST['district_code'] . "'", $_REQUEST['upazila_id'], "upazila_id", " id='admin_upazila'  class='pull-left' ", $optionIdField); ?></td>
                  </tr>
                </table>
              </td>
              <td style="vertical-align: top">
                <b>Agency</b><br/>
                <?php //createMultiSelectOptions($dbtableName, $dbtableIdField, $dbtableValueField, $customQuery, $selectedIdCsv, $name, $params); ?>
                <?php createMultiSelectOptions('org_agency_code', 'org_agency_code', 'org_agency_name', $customQuery, $csvs['agency_code'], "agency_code[]", " id='agency_code'  class='multiselect' "); ?><br/>
                <b>Org Level</b><br/>
                <?php createMultiSelectOptions('org_level', 'org_level_code', 'org_level_name', $customQuery, $csvs['org_level_code'], "org_level_code[]", " id='org_level_code' class='multiselect' "); ?>
              </td>
              <td style="vertical-align: top">
                <b>Org Type</b><br/>
                <?php createMultiSelectOptions('org_type', 'org_type_code', 'org_type_name', $customQuery, $csvs['org_type_code'], "org_type_code[]", " id='type_code'  class='multiselect'"); ?>
                <br/><b>Healthcare Level</b><br/>
                <?php createMultiSelectOptions('org_healthcare_levels', 'healthcare_code', 'healthcare_name', $customQuery, $csvs['org_healthcare_level_code'], "org_healthcare_level_code[]", " id='org_healthcare_level_code'  class='multiselect'"); ?>
              </td>
              <td style="vertical-align: top">
                <b>Location Type</b><br/>
                <?php createMultiSelectOptions('org_location_type', 'org_location_type_code', 'org_location_type_name', $customQuery, $csvs['org_location_type'], "org_location_type[]", " id='org_location_type'  class='multiselect'"); ?>
                <br/><b>Ownership</b><br/>
                <?php createMultiSelectOptions('org_ownership_authority', 'org_ownership_authority_code', 'org_ownership_authority_name', $customQuery, $csvs['ownership_code'], "ownership_code[]", " id='ownership_code'  class='multiselect'"); ?>
              </td>

              <td style="vertical-align: top">
                <b>Main Electricity</b><br/>
                <?php createMultiSelectOptions('org_source_of_electricity_main', 'electricity_source_code', 'electricity_source_name', $customQuery, $csvs['source_of_electricity_main_code'], "source_of_electricity_main_code[]", " id='source_of_electricity_main_code'  class='multiselect'"); ?>
                <br/><b>Alternate Electricity</b><br/>
                <?php createMultiSelectOptions('org_source_of_electricity_alternate', 'electricity_source_code', 'electricity_source_name', $customQuery, $csvs['source_of_electricity_alternate_code'], "source_of_electricity_alternate_code[]", " id='source_of_electricity_alternate_code'  class='multiselect'"); ?>
              </td>
              <td style="vertical-align: top">
                <b>Main water supply</b><br/>
                <?php createMultiSelectOptions('org_source_of_water_supply_main', 'water_supply_source_code', 'water_supply_source_name', $customQuery, $csvs['source_of_water_supply_main_code'], "source_of_water_supply_main_code[]", " id='source_of_water_supply_main_code'  class='multiselect'"); ?>
                <br/><b>Alternate water supply</b><br/>
                <?php createMultiSelectOptions('org_source_of_water_supply_alternate', 'water_supply_source_code', 'water_supply_source_name', $customQuery, $csvs['source_of_water_supply_alternate_code'], "source_of_water_supply_alternate_code[]", " id='source_of_water_supply_alternate_code'  class='multiselect'"); ?>
              </td>

              <td style="vertical-align: top">
                <b>View Columns</b><br/>
                <?php
                $showFields = getTableFieldNames('organization');
                $showFieldsCsv = implode(',', $showFields);
                if (count($_REQUEST['f'])) {
                  $showFields = $_REQUEST['f'];
                } else {
                  $showFields = array("id", "org_name", "org_code", "org_type_name", "org_type_code", "agency_name", "org_function_code", "org_level_name", "org_division_name", "org_district_name", "upazila_thana_name", "union_name",);
                }
                $showFieldsCsv = implode(',', $showFields);

                createMultiSelectOptions("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME", "COLUMN_NAME", "WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'organization'", $showFieldsCsv, "f[]", " class='multiselect' ")
                ?>
              </td>
              <td style="vertical-align: top">

              </td>
              <td>
                <b>Field query</b><br/>
                <table>
                  <tr>
                    <td><b>Field</b></td>
                    <td><?php createSelectOptions('INFORMATION_SCHEMA.COLUMNS', 'COLUMN_NAME', 'COLUMN_NAME', "WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'organization'", $_REQUEST['search_field'], "search_field", " id='search_field'  class='pull-left' ", $optionIdField) ?></td>
                  </tr>
                  <tr>
                    <td><b>Criteria</b></td>
                    <td><?php
                      $listArray = array('=', 'LIKE');
                      createSelectOptionsFrmArray($listArray, $_REQUEST['search_criteria'], 'search_criteria', $params = "");
                      ?></td>
                  </tr>
                  <tr>
                    <td><b>Value</b></td>
                    <td><input class='' name="search_value" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;" value="<?php echo addEditInputField('search_value'); ?>" /></td>
                  </tr>
                </table>
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
              </td>
            </tr>
          </table>
        </form>
      </div>
      <?php
      if (strlen($sql) && $_REQUEST['show_sql'] == 'true') {
        echo "<pre>$sql</pre>";
      }
      if (isset($_REQUEST['submit'])) {
        ?>
        <blockquote class="pull-left"><?php echo "$selection_string"; ?></blockquote>
        <blockquote class="pull-left">
          Total <strong><em><?= $count ?></em></strong> organization found.<br />
        </blockquote>


        <table class="table table-condensed table-bordered" id="datatable">
          <thead>
            <tr>
              <?php
              foreach ($fieldNames as $fieldName) {
                if (in_array($fieldName, $showFields)) {
                  ?>
                  <td id="<?= $fieldName ?>"><strong><a href="#" title="<?= $fieldName ?>">
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
                        echo $fieldName;
                        ?>
                      </a>
                    </strong>
                  </td>
                  <?php
                }
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysql_fetch_assoc($result)) { ?>
              <tr>
                <?php
                $totalFields = count($fieldNames);
                $filledFields = 0;
                foreach ($fieldNames as $fieldName) {
                  if (in_array($fieldName, $showFields)) {
                    if ($DBvalidation == TRUE) {
                      $tdClass = "";
                      if (!strlen($data[$fieldName])) {
                        $filledFields++;
                        $tdClass = "bgRed";
                      } else {

                      }
                    }
                    ?>
                    <td class="<?= $tdClass ?>"><?php echo $data[$fieldName]; ?></td>
                    <?php
                  }
                }
                ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>

    <!-- Footer
    ================================================== -->
    <?php include_once 'include/footer/footer.inc.php'; ?>

    <script type="text/javascript">
      // load division
      $('#admin_division').change(function() {
        $("#loading_content").show();
        var div_code = $('#admin_division').val();
        $.ajax({
          type: "POST",
          url: 'get/get_districts.php',
          data: {div_code: div_code},
          dataType: 'json',
          success: function(data)
          {
            $("#loading_content").hide();
            var admin_district = document.getElementById('admin_district');
            admin_district.options.length = 0;
            for (var i = 0; i < data.length; i++) {
              var d = data[i];
              admin_district.options.add(new Option(d.text, d.value));
            }
          }
        });
      });
      // load district
      $('#admin_district').change(function() {
        var dis_code = $('#admin_district').val();
        $("#loading_content").show();
        $.ajax({
          type: "POST",
          url: 'get/get_upazilas.php',
          data: {dis_code: dis_code, key: 'id'},
          dataType: 'json',
          success: function(data)
          {
            $("#loading_content").hide();
            var admin_upazila = document.getElementById('admin_upazila');
            admin_upazila.options.length = 0;
            for (var i = 0; i < data.length; i++) {
              var d = data[i];
              admin_upazila.options.add(new Option(d.text, d.value));
            }
          }
        });
      });</script>
    <script type="text/javascript">
      var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function(s) {
                  return window.btoa(unescape(encodeURIComponent(s)))
                }
        , format = function(s, c) {
          return s.replace(/{(\w+)}/g, function(m, p) {
            return c[p];
          })
        }
        return function(table, name) {
          if (!table.nodeType)
            table = document.getElementById(table)
          var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
          window.location.href = uri + base64(format(template, ctx))
        }
      })()
    </script>

    <script type="text/javascript">
      $('table#datatable').dataTable({
        //"bJQueryUI": true,
        "bPaginate": false,
        "sPaginationType": "full_numbers",
        "aaSorting": [[0, "desc"]],
        "iDisplayLength": 25,
        "bStateSave": true,
        "bInfo": true,
        "bProcessing": true,
		"dom": 'T<"clear">lfrtip',
        	"tableTools": {
           	"sSwfPath": "assets/datatable/TableTools/media/swf/copy_csv_xls_pdf.swf"
        	}
      });</script>
    <script type="text/javascript">
      $('.multiselect').multiselect({
        includeSelectAllOption: true,
        maxHeight: 200,
      });</script>
  </body>
</html>


<?php

function getTableFieldNames($tableName) {

  global $dbname;

  $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tableName'";
  //echo $sql;
  $r = mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");
  if (mysql_num_rows($r)) {
    $a = mysql_fetch_rowsarr($r);
    $fieldNames = array();
    $i = 0;
    foreach ($a as $fieldName) {
      $fieldNames[$i++] = $fieldName['COLUMN_NAME'];
    }
    return $fieldNames;
  } else {
    return false;
  }
}
?>
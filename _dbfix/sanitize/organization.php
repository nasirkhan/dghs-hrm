<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
  header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
  $org_code = (int) mysql_real_escape_string($_GET['org_code']);
  $org_name = getOrgNameFormOrgCode($org_code);
  $org_type_name = getOrgTypeNameFormOrgCode($org_code);
  $echoAdminInfo = " | Administrator";
  $isAdmin = TRUE;
}

/* * *
 *
 * POST
 */
//print_r($_REQUEST);
$div_code = (int) mysql_real_escape_string(trim($_REQUEST['admin_division']));
$admin_district = $dis_code = (int) mysql_real_escape_string(trim($_REQUEST['admin_district']));
$upa_code = (int) mysql_real_escape_string(trim($_REQUEST['admin_upazila']));
$agency_code = (int) mysql_real_escape_string(trim($_REQUEST['org_agency']));
$type_code = (int) mysql_real_escape_string(trim($_REQUEST['org_type']));
$form_submit = (int) mysql_real_escape_string(trim($_REQUEST['form_submit']));

$selection_string = "";
if ($div_code > 0) {
  $selection_string .= " Division: <strong>" . getDivisionNamefromCode($div_code) . "</strong> ";
}
if ($dis_code > 0) {
  $selection_string .= " District: <strong>" . getDistrictNamefromCode($dis_code) . "</strong> ";
}
if ($upa_code > 0) {
  $selection_string .= " Upazila: <strong>" . getUpazilaNamefromBBSCode($upa_code, $dis_code) . "</strong>";
}
if ($agency_code > 0) {
  $selection_string .= " Agency: <strong>" . getAgencyNameFromAgencyCode($agency_code) . "</strong>";
}
if ($type_code > 0) {
  $selection_string .= " Org Type: <strong>" . getOrgTypeNameFormOrgTypeCode($type_code) . "</strong>";
}


if ($form_submit == 1 && isset($_GET['form_submit'])) {

  /*
   *
   * query builder to get the organizatino list
   */
  $query_string = "";
  if ($div_code > 0 || $dis_code > 0 || $upa_code > 0 || $agency_code > 0 || $type_code > 0) {
    $query_string .= " WHERE ";

    if ($agency_code > 0) {
      $query_string .= "organization.agency_code = $agency_code";
    }
    if ($upa_code > 0) {
      if ($agency_code > 0) {
        $query_string .= " AND ";
      }
      $query_string .= "organization.upazila_thana_code = $upa_code";
    }
    if ($dis_code > 0) {
      if ($upa_code > 0 || $agency_code > 0) {
        $query_string .= " AND ";
      }
      $query_string .= "organization.district_code = $dis_code";
    }
    if ($div_code > 0) {
      if ($dis_code > 0 || $upa_code > 0 || $agency_code > 0) {
        $query_string .= " AND ";
      }
      $query_string .= "organization.division_code = $div_code";
    }
    if ($type_code > 0) {
      if ($div_code > 0 || $dis_code > 0 || $upa_code > 0 || $agency_code > 0) {
        $query_string .= " AND ";
      }
      $query_string .= "organization.org_type_code = $type_code";
    }
  }

  $query_string .= " ORDER BY org_name";

  $sql = "SELECT * FROM organization $query_string";
  $org_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

  $org_list_result_count = mysql_num_rows($org_list_result);

  if ($org_list_result_count) {
    $show_result = TRUE;
  }
//echo "<pre>$sql</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $org_name . " | " . $app_name; ?></title>
    <?php
    include_once 'include/header/header_css_js.inc.php';
    include_once 'include/header/header_ga.inc.php';
    ?>
    <style>
      select, input, textarea{
        font-size: 12px;
        width: 150px;
      }
      select{width: 150px; line-height: 25px; height: 25px; margin: 0px; padding: 3px;}
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
    </style>
  </head>

  <body>
    <?php include_once 'include/header/header_top_menu.inc.php'; ?>
    <div class="container">
      <div class="">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="padding: 0px; margin: 0px;">
          <h3>Organization List</h3>
          <table>
            <tr>
              <td><b>Division</b></td>
              <td><b>District</b></td>
              <td><b>Upazila</b></td>
              <td><b>Agency</b></td>
              <td><b>Org Type</b></td>
            </tr>
            <tr>
              <td><?php createSelectOptions('admin_division', 'division_bbs_code', 'division_name', $customQuery, $_REQUEST['admin_division'], "admin_division", " id='admin_division' ", $optionIdField) ?></td>
              <td><?php
                if ($_REQUEST['admin_district']) {
                  createSelectOptions('admin_district', 'district_bbs_code', 'district_name', $customQuery, $_REQUEST['admin_district'], "admin_district", " id='admin_district' ", $optionIdField);
                } else {
                  echo "<select id=\"admin_district\" name=\"admin_district\">";
                  echo "<option value=\"0\">Select District</option>";
                  echo "</select>";
                }
                ?></td>
              <td><?php
                if ($_REQUEST['admin_upazila']) {
                  createSelectOptions('admin_upazila', 'upazila_bbs_code', 'upazila_name', $customQuery, $_REQUEST['admin_upazila'], "admin_upazila", " id='admin_upazila' ", $optionIdField);
                } else {
                  echo "<select id=\"admin_upazila\" name=\"admin_upazila\">";
                  echo "<option value=\"0\">Select Upazila</option>";
                  echo "</select>";
                }
                ?></td>
              <td><?php createSelectOptions('org_agency_code', 'org_agency_code', 'org_agency_name', $customQuery, $_REQUEST['org_agency'], "org_agency", " id='org_agency' ", $optionIdField); ?></td>
              <td><?php createSelectOptions('org_type', 'org_type_code', 'org_type_name', $customQuery, $_REQUEST['org_type'], "org_type", " id='org_type' ", $optionIdField); ?></td>
            </tr>
          </table>
          <?php
//          "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tableName'"
          createMultiSelectOptions("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME", "COLUMN_NAME", "WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'organization'", $selectedIdCsv, "table_fields[]", " class='' ")
          ?>
          <input name="form_submit" value="1" type="hidden" />
          <div class="control-group">
            <div class="btn-group">
              <button id="btn_show_org_list" type="submit" class="btn btn-success">Show Report</button>
              <a href="report_org_list.php" class="btn">Reset</a>
              <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
            </div>
          </div>
        </form>
      </div>
      <?php if ($_REQUEST['form_submit']) { ?>
        <blockquote class="pull-left"><?php echo "$selection_string"; ?></blockquote>
        <blockquote class="pull-left">
          Total <strong><em><?php echo mysql_num_rows($org_list_result); ?></em></strong> organization found.<br />
        </blockquote>

        <?php
        $datatable = "";
        if (mysql_num_rows($org_list_result) < 5000) {
          $datatable = "datatable";
        } else {
          echo "<blockquote class='pull-left'>Advanced search and sorting is disable due to large number of data.</blockquote>";
        }
        $fieldNames = getTableFieldNames('organization');
        ?>

        <table class="table table-striped table-bordered" id="<?= $datatable ?>">
          <thead>
            <tr>
              <?php foreach ($fieldNames as $fieldName) { ?>
                <td><strong><?php echo $fieldName; ?></strong></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysql_fetch_assoc($org_list_result)): ?>
              <tr>
                <?php foreach ($fieldNames as $fieldName) { ?>
                  <td><?php echo $data[$fieldName]; ?></td>
                <?php } ?>
              </tr>
            <?php endwhile; ?>
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
          data: {dis_code: dis_code},
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
      });
    </script>
              <script type="text/javascript">
    var tableToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                      , base64 = function(s){
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
                                        "bProcessing": true
                                });
    </script>
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
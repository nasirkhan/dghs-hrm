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

/**
 * search result
 */
$admin_division = (int) mysql_real_escape_string(trim($_GET['admin_division']));
$admin_district = (int) mysql_real_escape_string(trim($_GET['admin_district']));
$org_type = (int) mysql_real_escape_string(trim($_GET['org_type']));
$designation_group_code = (int) mysql_real_escape_string(trim($_GET['designation_group_code']));
$designation_group_name = getDesignationGroupNameformCode($designation_group_code);
$discipline = mysql_real_escape_string(trim($_GET['discipline']));

$query_string = "";
$error_message = "";
if ($designation_group_code > 0){
    $query_string .= " sanctioned_post_designation.designation_group_code = $designation_group_code ";
} else {
    $error_message .= "<br>No 'Designation Group' selected.";
}
if (isset($_GET['discipline']) && $_GET['discipline'] != "0") {
    $query_string .= " AND total_manpower_imported_sanctioned_post_copy.discipline LIKE '$discipline' ";
} 
if ($org_type > 0) {
    $query_string .= " AND organization.org_type_code = $org_type ";
}
if ($admin_district > 0) {
    $query_string .= " AND organization.district_code = $admin_district ";
}
if ($admin_division > 0) {
    $query_string .= " AND organization.division_code = $admin_division ";
}


if (isset($_GET['discipline'])) {
    $showInfo = TRUE;
}

if ($error_message == "" && $designation_group_code > 0) {
    $sql = "SELECT
                    old_tbl_staff_organization.staff_id,
                    old_tbl_staff_organization.staff_name,
                    old_tbl_staff_organization.staff_pds_code,
                    old_tbl_staff_organization.birth_date,
                    old_tbl_staff_organization.posting_status,
                    old_tbl_staff_organization.staff_posting,
                    old_tbl_staff_organization.job_posting_id,
                    old_tbl_staff_organization.contact_no,
                    organization.org_name,
                    sanctioned_post_designation.designation_group_code,
                    staff_job_posting.job_posting_name,
                    total_manpower_imported_sanctioned_post_copy.designation,
                    total_manpower_imported_sanctioned_post_copy.discipline
            FROM
                    old_tbl_staff_organization
            LEFT JOIN total_manpower_imported_sanctioned_post_copy ON total_manpower_imported_sanctioned_post_copy.staff_id_2 = old_tbl_staff_organization.staff_id
            LEFT JOIN organization ON old_tbl_staff_organization.org_code = organization.org_code
            LEFT JOIN sanctioned_post_designation ON old_tbl_staff_organization.designation_id = sanctioned_post_designation.designation_code
            LEFT JOIN staff_job_posting ON staff_job_posting.job_posting_id = old_tbl_staff_organization.job_posting_id
            WHERE
                    $query_string
                AND old_tbl_staff_organization.active LIKE '1'
                AND old_tbl_staff_organization.sp_id_2 > 0";
//    echo "<pre>$sql</pre>"; die();
    $result_data = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>report_staff_list_by_designation_group_with_descipline:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data_count = mysql_num_rows($result_data);
    
    if ($data_count > 0) {
        $showReport = TRUE;
    }
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
    </head>

    <body>

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo $org_name . $echoAdminInfo; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- Docs nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <?php if (hasPermission('report_staff_list_by_designation_group_with_descipline', 'view', getLoggedUserName())) : ?>
                        <section id="report">
                            <div class="row-fluid">
                                <div class="span12">
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                        <h3>Staff list by designation group report with discipline</h3>
                                        <div class="control-group">
                                            <select id="admin_division" name="admin_division">
                                                <option value="0">__ Select Division __</option>
                                                <?php
                                                $sql = "SELECT admin_division.division_name, admin_division.division_bbs_code FROM admin_division";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($rows['division_bbs_code'] == $_REQUEST['admin_division'])
                                                        echo "<option value=\"" . $rows['division_bbs_code'] . "\" selected='selected'>" . $rows['division_name'] . "</option>";
                                                    else
                                                        echo "<option value=\"" . $rows['division_bbs_code'] . "\">" . $rows['division_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <?php
                                            if ($_REQUEST['admin_district']) {
                                                $sql = "SELECT
                                                            district_bbs_code,
                                                            old_district_id,
                                                            district_name
                                                    FROM
                                                            `admin_district`";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_district_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                echo "<select id=\"admin_district\" name=\"admin_district\">";
                                                echo "<option value=\"0\"'> __ Select District __</option>";
                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($_REQUEST['admin_district'] == $rows['district_bbs_code']) {
                                                        echo "<option value=\"" . $rows['district_bbs_code'] . "\" selected='selected'>" . $rows['district_name'] . "</option>";
                                                    } else {
                                                        echo "<option value=\"" . $rows['district_bbs_code'] . "\"'>" . $rows['district_name'] . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                            } else {
                                                echo "<select id=\"admin_district\" name=\"admin_district\">";
                                                echo "<option value=\"0\">Select District</option>";
                                                echo "</select>";
                                            }
                                            ?>
                                            <select id="org_type" name="org_type">
                                                <option value="0">Select Org Type</option>
                                                <?php
                                                $sql = "SELECT
                                                        org_type.org_type_code,
                                                        org_type.org_type_name
                                                    FROM
                                                        org_type
                                                    ORDER BY
                                                        org_type.org_type_name ASC";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadorg_type:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($rows['org_type_code'] == $_REQUEST['org_type']) {
                                                        echo "<option value=\"" . $rows['org_type_code'] . "\" selected='selected'>" . $rows['org_type_name'] . "</option>";
                                                    } else {
                                                        echo "<option value=\"" . $rows['org_type_code'] . "\">" . $rows['org_type_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="control-group">
                                            <select id="designation_group_code" name="designation_group_code">
                                                <option value="0">__ Select Designation Group __</option>
                                                <?php
                                                $sql = "SELECT
                                                                sanctioned_post_designation_group.designation_group_name,
                                                                sanctioned_post_designation_group.designation_group_code
                                                        FROM
                                                                `sanctioned_post_designation_group`
                                                        WHERE
                                                                active LIKE 1";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($rows['designation_group_code'] == $_REQUEST['designation_group_code'])
                                                        echo "<option value=\"" . $rows['designation_group_code'] . "\" selected='selected'>" . $rows['designation_group_name'] . "</option>";
                                                    else
                                                        echo "<option value=\"" . $rows['designation_group_code'] . "\">" . $rows['designation_group_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <select id="discipline" name="discipline">
                                                <option value="0">__ Select Discipline __</option>
                                                <?php
                                                $sql = "SELECT discipline FROM `total_manpower_imported_sanctioned_post_copy` WHERE discipline not LIKE \"\" GROUP BY discipline";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($rows['discipline'] == $_REQUEST['discipline'])
                                                        echo "<option value=\"" . $rows['discipline'] . "\" selected='selected'>" . $rows['discipline'] . "</option>";
                                                    else
                                                        echo "<option value=\"" . $rows['discipline'] . "\">" . $rows['discipline'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="control-group">
                                            <button id="btn_show_org_list" type="submit" class="btn btn-info">Show Report</button>
                                            <a href="report_staff_list_by_designation_group_with_descipline.php" class="btn btn-default" > Reset</a>
                                            <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                        </div>
                                    </form> <!-- /form -->
                                </div> <!-- /span12 -->
                            </div> <!-- /row search box div-->

                            <?php if ($showInfo): ?>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="alert alert-info">
                                            <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="btn btn-primary btn-small pull-right">
                                            Selected values are:
                                            <?php
                                            if ($designation_group_code > 0) {
                                                echo "<br> Designation Group:<strong> $designation_group_name" . "</strong>";
                                            }
                                            if ($discipline != '0') {
                                                echo " & Discipline: <strong>" . $discipline . "</strong>";
                                            }                                            
                                            
                                            if ($admin_division > 0) {
                                                echo " & Division: <strong>" . getDivisionNamefromCode($admin_division) . "</strong>";
                                            }
                                            if ($admin_district > 0) {
                                                echo " & District: <strong>" . getDistrictNamefromCode($admin_district) . "</strong>";
                                            }
                                            if ($org_type > 0) {
                                                echo " & Organization Type: <strong>" . getOrgTypeNameFormOrgTypeCode($org_type) . "</strong>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <?php if ($showReport): ?>
                                        <div class="alert alert-info">
                                            Total <?php echo $data_count; ?> result(s) found. 
                                        </div>
                                        <table class="table table-bordered table-hover" id="testTable">
                                            <thead>
                                                <tr>
                                                    <td><strong>#</strong></td>
                                                    <td><strong>Name (ID)</strong></td>
                                                    <td><strong>Code</strong></td>
                                                    <td><strong>Date of Birth</strong></td>
                                                    <td><strong>Posting Status</strong></td>
                                                    <td><strong>Place of Posting</strong></td>
                                                    <td><strong>Mobile No.</strong></td>
                                                    <td><strong>Discipline</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $row_count = 1;
                                                while ($data = mysql_fetch_assoc($result_data)):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row_count; ?></td>
                                                        <td><a href="employee.php?staff_id=<?php echo $data['staff_id']; ?>" target="_blank"><?php echo $data['staff_name']; ?></a></td>
                                                        <td><?php echo $data['staff_pds_code']; ?></td>
                                                        <td><?php echo $data['birth_date']; ?></td>
                                                        <td><?php echo $data['job_posting_name']; ?></td>
                                                        <td><?php echo $data['org_name']; ?></td>
                                                        <td><?php echo $data['contact_no']; ?></td>
                                                        <td><?php echo $data['discipline']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $row_count++;
                                                endwhile;
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <?php if ($showInfo): ?>
                                            <div class="alert alert-warning">
                                                No result found.
                                                <?php echo $error_message; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div> <!-- /span12 -->
                            </div> <!-- /row result display div-->
                        </section> <!-- /report-->
                    <?php else: ?>
                        <h3> You Do not have the permission to view this report. </h3>
                    <?php endif; ?>    
                </div>
            </div>

        </div>

        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        <script type="text/javascript">             // load division
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
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
		</script>
    </body>
</html>
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
$designation_code = (int) mysql_real_escape_string(trim($_GET['designation_code']));

$query_string = "";
$error_message = "";


if ($designation_code > 0) {
    $query_string .= " AND total_manpower_imported_sanctioned_post_copy.designation_code =  $designation_code ";
}


if ($error_message == "" && isset($_REQUEST['designation_code'])) {
    $sql = "SELECT
                old_tbl_staff_organization.staff_id,
                old_tbl_staff_organization.sp_id_2,
                old_tbl_staff_organization.org_code,
                old_tbl_staff_organization.org_name,
                old_tbl_staff_organization.staff_posting,
                old_tbl_staff_organization.staff_posting_name,
                old_tbl_staff_organization.posting_status,
                old_tbl_staff_organization.posting_status_name,
                old_tbl_staff_organization.staff_pds_code,
                old_tbl_staff_organization.staff_name,
                old_tbl_staff_organization.birth_date,
                old_tbl_staff_organization.contact_no,
                old_tbl_staff_organization.post_type_id,
                old_tbl_staff_organization.post_type_name,
                old_tbl_staff_organization.job_posting_id,
                old_tbl_staff_organization.job_posting_name,
                total_manpower_imported_sanctioned_post_copy.designation_code
            FROM
                    `old_tbl_staff_organization`
            LEFT JOIN total_manpower_imported_sanctioned_post_copy ON old_tbl_staff_organization.sp_id_2 = total_manpower_imported_sanctioned_post_copy.id
            WHERE
                    total_manpower_imported_sanctioned_post_copy.active LIKE '1'
                    $query_string";

    $result_all = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>report_staff_list_by_designation_group_with_descipline:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data_count = mysql_num_rows($result_all);
    
    if ($data_count > 0) {
        $showReport = TRUE;
        $showInfo = TRUE;
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
                    <?php if (hasPermission('report_designation_summary', 'view', getLoggedUserName())) : ?>
                        <section id="report">
                            <div class="row-fluid">
                                <div class="span12">
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                        <h3>Designation Wise Report</h3>
                                        
                                        <div class="control-group">
                                            
                                            <select id="designation_code" class="input-xxlarge" name="designation_code">
                                                <option value="0">Select Designation</option>
                                                <?php
                                                $sql = "SELECT
                                                                sanctioned_post_designation.designation_code,
                                                                sanctioned_post_designation.designation,
                                                                sanctioned_post_designation.payscale,
                                                                sanctioned_post_designation.class
                                                        FROM
                                                                `sanctioned_post_designation`
                                                        ORDER BY
                                                                payscale,
                                                                ranking";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadorg_type:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($rows['designation_code'] == $_REQUEST['designation_code']) {
                                                        echo "<option value=\"" . $rows['designation_code'] . "\" selected='selected'>" . $rows['designation'] . "," . $rows['payscale'] . "," . "" . $rows['class'] . "" . "</option>";
                                                    } else {
                                                        echo "<option value=\"" . $rows['designation_code'] . "\">" . $rows['designation'] . ", Payscale:" . $rows['payscale'] . ", " . "Class:" . $rows['class'] . "" . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="control-group">
                                            <button id="btn_show_org_list" type="submit" class="btn btn-info">Show Report</button>
                                            <a href="report_designation_wise.php" class="btn btn-default" > Reset</a>
                                            <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                        </div>
                                    </form> <!-- /form -->
                                </div> <!-- /span12 -->
                            </div> <!-- /row search box div-->

                            <?php if ($showInfo): ?>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="alert alert-info">
                                            <input type="button" onclick="tableToExcel('reportTable', 'W3C Example Table')" value="Export to Excel" class="btn btn-primary btn-small pull-right">
                                            Report for : <strong><?php echo getDesignationNameformCode($designation_code); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row-fluid">
                                <div class="span12">
                                    <?php if ($showReport): ?>
                                    <table id="reportTable" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><strong>#</strong></th>
                                                    <th><strong>Staff Id</strong></th>
                                                    <th><strong>PDS Code</strong></th>
                                                    <th><strong>Name</strong></th>
                                                    <th><strong>Date of birth</strong></th>
                                                    <th><strong>Posting Status</strong></th>
                                                    <th><strong>Place of posting</strong></th>
                                                    <th><strong>Mobile No.</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $row_count = 0;
                                                while ($data = mysql_fetch_assoc($result_all)) :
                                                    $row_count ++;
                                                ?>
                                                <tr>
                                                    <td><?= $row_count ?></td>
                                                    <td><?= $data['staff_id']; ?></td>
                                                    <td><?= $data['staff_pds_code']; ?></td>
                                                    <td><a href="employee.php?staff_id=<?= $data['staff_id']; ?>" target="_blank"><?= $data['staff_name']; ?></a></td>
                                                    <td><?= $data['birth_date']; ?></td>
                                                    <td><?= $data['job_posting_name']; ?></td>
                                                    <td><?= getOrgNameFormOrgCode($data['org_code']); ?></td>
                                                    <td><?= $data['contact_no']; ?></td>
                                                </tr>
                                                
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                            <div class="alert alert-warning">
                                                No result found.
                                                <?php echo $error_message; ?>
                                            </div>
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
            
            
            function loadOrgList(){
                var div_code = $('#admin_division').val();
                var dis_code = $('#admin_district').val();
                var upa_code = $('#admin_upazila').val();
                var org_type = $('#org_type').val();                
                
                $("#loading_content").show();
                
                $.ajax({
                    type: "POST",
                    url: 'get/get_org_list_json.php',
                    data: {div_code:div_code, dis_code: dis_code, upa_code:upa_code, org_type:org_type},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var org_code = document.getElementById('org_code');
                        org_code.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            org_code.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            }
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
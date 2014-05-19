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
$admin_upazila = (int) mysql_real_escape_string(trim($_GET['admin_upazila']));

$query_string = "";
$error_message = "";


if ($admin_division > 0) {
    $query_string .= " AND organization.division_code = $admin_division ";
}
if ($admin_district > 0) {
    $query_string .= " AND organization.district_code = $admin_district ";
}
if ($admin_upazila > 0) {
    $query_string .= " AND organization.upazila_thana_code = $admin_upazila ";
}


if ($error_message == "" && isset($_REQUEST['show_report'])) {
    $sql = "SELECT
                    MONTHNAME(
                            STR_TO_DATE(
                                    EXTRACT(
                                            MONTH
                                            FROM
                                                    old_tbl_staff_organization.retirement_date
                                    ),
                                    '%m'
                            )
                    ) AS MONTH,
                    old_tbl_staff_organization.staff_name AS NAME,
                    sanctioned_post_designation.designation AS Designation,
                    organization.org_name AS 'Place of Posting',
                    staff_job_posting.job_posting_name AS 'Posting Status',
                    old_tbl_staff_organization.birth_date AS 'Date Of Birth',
                    old_tbl_staff_organization.retirement_date AS 'Retirement Date',
                    old_tbl_staff_organization.staff_pds_code AS CODE,
                    old_tbl_staff_organization.contact_no AS Mobile
            FROM
                    old_tbl_staff_organization
            LEFT JOIN sanctioned_post_designation ON old_tbl_staff_organization.designation_id = sanctioned_post_designation.designation_code
            LEFT JOIN organization ON organization.org_code = old_tbl_staff_organization.org_code
            LEFT JOIN staff_job_posting ON staff_job_posting.job_posting_id = old_tbl_staff_organization.job_posting_id
            WHERE
                 retirement_date BETWEEN '2014-01-01' AND '2014-12-31'
                 $query_string
            ORDER BY
                    retirement_date";
    $result_data = mysql_query($sql) or die(mysql_error() . "<p>Query___</p><p>$sql</p><p>___</p>");
    
    $data_count = mysql_num_rows($result_data);
    
    if ($data_count > 0) {
        $showReport = TRUE;
        $showInfo = TRUE;
    }
}
if (isset($_REQUEST['show_report'])){
    $showInfo = TRUE;
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
                    <?php if (hasPermission('report_lpr', 'view', getLoggedUserName())) : ?>
                        <section id="report">
                            <div class="row-fluid">
                                <div class="span12">
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                        <h3>LPR Report</h3>
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
                                            <?php
                                            if ($_REQUEST['admin_upazila']) {
                                                $sql = "SELECT
                                                            upazila_bbs_code,                                                            
                                                            upazila_name
                                                    FROM
                                                            `admin_upazila`
                                                    WHERE `upazila_district_code` = $admin_district";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_upazila_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                echo "<select id=\"admin_district\" name=\"admin_district\">";
                                                echo "<option value=\"0\"'> __ Select District __</option>";
                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    if ($_REQUEST['admin_upazila'] == $rows['upazila_bbs_code']) {
                                                        echo "<option value=\"" . $rows['upazila_bbs_code'] . "\" selected='selected'>" . $rows['upazila_name'] . "</option>";
                                                    } else {
                                                        echo "<option value=\"" . $rows['upazila_bbs_code'] . "\"'>" . $rows['upazila_name'] . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                            } else {
                                                echo "<select id=\"admin_upazila\" name=\"admin_upazila\">";
                                                echo "<option value=\"0\">Select Upazila</option>";
                                                echo "</select>";
                                            }
                                            ?>                                            
                                        </div>                                        
                                        <div class="control-group">
                                            <input name="show_report" type="hidden" value="true" />
                                            <button id="btn_show_org_list" type="submit" class="btn btn-info">Show Report</button>
                                            <a href="report_lpr.php" class="btn btn-default" > Reset</a>
                                            <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                        </div>
                                    </form> <!-- /form -->
                                </div> <!-- /span12 -->
                            </div> <!-- /row search box div-->

                            <?php if ($showInfo): ?>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="alert alert-info">
                                            Selected values are:
                                            <?php
                                            if ($admin_division > 0) {
                                                echo " Division: <strong>" . getDivisionNamefromCode($admin_division) . "</strong>";
                                            }
                                            if ($admin_district > 0) {
                                                echo " & District: <strong>" . getDistrictNamefromCode($admin_district) . "</strong>";
                                            }
                                            if ($admin_upazila > 0) {
                                                echo " & Upazila: <strong>" . getUpazilaNamefromBBSCode($admin_upazila, $admin_district) . "</strong>";
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
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="btn btn-primary">
                                            <br/>
                                            <table class="table table-bordered table-hover table-responsive" id="testTable">
                                                <thead>
                                                    <tr>
                                                        <td><strong>#</strong></td>
                                                        <td><strong>Month</strong></td>
                                                        <td><strong>Name</strong></td>
                                                        <td><strong>Code</strong></td>
                                                        <td><strong>Designation</strong></td>
                                                        <td><strong>Place of Posting</strong></td>
                                                        <td><strong>Posting Status</strong></td>
                                                        <td><strong>Date of Birth</strong></td>
                                                        <td><strong>Retirement Date</strong></td>
                                                        <td><strong>Mobile Number</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $row_count = 0;
                                                    
                                                    while($data = mysql_fetch_assoc($result_data)):
                                                        $row_count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row_count; ?></td>
                                                        <td><?php echo $data['MONTH']; ?></td>
                                                        <td><?php echo $data['NAME']; ?></td>
                                                        <td><?php echo $data['CODE']; ?></td>
                                                        <td><?php echo $data['Designation']; ?></td>
                                                        <td><?php echo $data['Place of Posting']; ?></td>
                                                        <td><?php echo $data['Posting Status']; ?></td>
                                                        <td><?php echo $data['Date Of Birth']; ?></td>
                                                        <td><?php echo $data['Retirement Date']; ?></td>
                                                        <td><?php echo $data['Mobile']; ?></td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
                        <h3> You do not have the permission to view this report. </h3>
                    <?php endif; ?>    
                </div>
            </div>
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
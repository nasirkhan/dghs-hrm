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

    $sql = "SELECT organization.org_name, organization.org_code FROM organization $query_string";
    $org_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    
    $org_list_result_count = mysql_num_rows($org_list_result);
    
    if ($org_list_result_count){
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
                    <section id="report">

                        <div class="row">
                            <div class="">
                                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                    <p class="lead">Organization List</p>
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
                                        <select id="org_agency" name="org_agency">
                                            <option value="0">Select Agency</option>
                                            <?php
                                            $sql = "SELECT
                                                    org_agency_code.org_agency_code,
                                                    org_agency_code.org_agency_name
                                                FROM
                                                    org_agency_code
                                                ORDER BY
                                                    org_agency_code.org_agency_code";
                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadorg_agency:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                            while ($rows = mysql_fetch_assoc($result)) {
                                                if ($rows['org_agency_code'] == $_POST['org_agency'])
                                                    echo "<option value=\"" . $rows['org_agency_code'] . "\" selected='selected'>" . $rows['org_agency_name'] . "</option>";
                                                else
                                                    echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                            }
                                            ?>
                                        </select>

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
                                                if ($rows['org_type_code'] == $_POST['org_type'])
                                                    echo "<option value=\"" . $rows['org_type_code'] . "\" selected='selected'>" . $rows['org_type_name'] . "</option>";
                                                else
                                                    echo "<option value=\"" . $rows['org_type_code'] . "\">" . $rows['org_type_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input name="form_submit" value="1" type="hidden" />
                                    <div class="control-group">
                                        <button id="btn_show_org_list" type="submit" class="btn btn-info">Show Report</button>
                                        <a href="report_org_list.php" class="btn btn-warning">Reset</a>

                                        <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                    </div>  
                                </form>
                            </div>
                            <?php if ($show_result) : ?>
                                <div class="alert alert-success"> 
                                    Report displaying form:<br>
                                    <?php
                                    $echo_string = "";
                                    if ($div_code > 0) {
                                        $echo_string .= " Division: <strong>" . getDivisionNamefromCode($div_code) . "</strong><br>";
                                    }
                                    if ($dis_code > 0) {
                                        $echo_string .= " District: <strong>" . getDistrictNamefromCode($dis_code) . "</strong><br>";
                                    }
                                    if ($upa_code > 0) {
                                        $echo_string .= " Upazila: <strong>" . getUpazilaNamefromBBSCode($upa_code, $dis_code) . "</strong><br>";
                                    }
                                    if ($agency_code > 0) {
                                        $echo_string .= " Agency: <strong>" . getAgencyNameFromAgencyCode($agency_code) . "</strong><br>";
                                    }
                                    if ($type_code > 0) {
                                        $echo_string .= " Org Type: <strong>" . getOrgTypeNameFormOrgTypeCode($type_code) . "</strong><br>";
                                    }
                                    echo "$echo_string";
                                    ?>
                                    <br />
                                    <blockquote>
                                        Total <strong><em><?php echo mysql_num_rows($org_list_result); ?></em></strong> organization found.<br />
                                    </blockquote>
                                </div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td><strong>Organization Name</strong></td>
                                            <td><strong>Organization Code</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($data = mysql_fetch_assoc($org_list_result)): ?>
                                            <tr>
                                                <td><a href="org_profile.php?org_code=<?php echo $data['org_code']; ?>" target="_blank"><?php echo $data['org_name']; ?></a></td>
                                                <td><?php echo $data['org_code']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>

                    </section>

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
    </body>
</html>

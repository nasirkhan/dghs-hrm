<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$user_name = $_SESSION['username'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
}
if ($_SESSION['user_type'] == "admin") {
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}
/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051) {
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])) {
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}
$org_name = getOrgNameFormOrgCode($org_code);



if (isset($_GET['q'])) {
    $q = mysql_real_escape_string(trim($_GET['q']));

    $data = getStaffDetails($q);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo $org_name; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- Docs nav
            ================================================== -->
            <div class="row-fluid">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Search main div
                    ================================================== -->
                    <section id="search_main">

                        <div class="text-center alert alert-info">
                            Search by Staff ID/PDS Code/ Mobile no
                            <form class="form-search" action="transfer.php" method="get">
                                <input type="text" name="q" placeholder="Staff ID/PDS Code/ Mobile no">
                                <button type="submit" class="btn">Search Staff</button>
                            </form>
                        </div>

                        <div class="row-fluid">
                            <?php if ($data['staff_id'] > 0): ?>
                            
                                <div class="span6">
                                    <p class="text-left">Current Information</p>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td><?php echo $data['staff_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>PDS Code</td>
                                                <td><?php echo $data['staff_pds_code']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Staff ID</td>
                                                <td><?php echo $data['staff_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td><?php echo $data['designation']; ?> (Code:<?php echo $data['designation_id']; ?>)</td>
                                            </tr>
                                            <tr>
                                                <td>Posting Status</td>
                                                <td><?php echo $data['posting_status']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Place of Posting</td>
                                                <td><?php echo $data['org_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Number</td>
                                                <td><?php echo $data['contact_no']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>      
                            <div class="span6">
                                <p class="text-left">Transfer Information</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Select Agency</td>
                                            <td>
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
                                                        echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select Division</td>
                                            <td>
                                                <select id="admin_division" name="admin_division">
                                                    <option value="0">__ Select Division __</option>
                                                    <?php
                                                    /**
                                                     * @todo change old_visision_id to division_bbs_code
                                                     */
                                                    $sql = "SELECT admin_division.division_name, admin_division.division_bbs_code FROM admin_division";
                                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                    while ($rows = mysql_fetch_assoc($result)) {
                                                        echo "<option value=\"" . $rows['division_bbs_code'] . "\">" . $rows['division_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select District</td>
                                            <td>
                                                <select id="admin_district" name="admin_district">
                                                    <option value="0">__ Select District __</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select Upazila</td>
                                            <td>
                                                <select id="admin_upazila" name="admin_upazila">
                                                    <option value="0">__ Select Upazila __</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select Organization</td>
                                            <td>
                                                <select id="org_list" name="org_list">
                                                    <option value="0">Select Organization</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select Designation</td>
                                            <td>
                                                <select id="sanctioned_post" name="sanctioned_post">
                                                    <option value="0">Select Designation</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Posted As</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Select Division</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Select District</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Select Upazila</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Select Organization</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Select Designation</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                                <div class="span12">
                                    <div class="alert alert-warning">
                                        No result found, please search again. 
                                    </div>
                                </div>
                            <?php endif; ?>                                

                        </div>
                        
                        <div class="row-fluid">
                            <div class="span12">
                                <form>
                                    <input type="hidden" name="staff_id" />
                                    <input type="hidden" name="from_org_code" />
                                    <input type="hidden" name="from_working_org_code" />
                                    <input type="hidden" name="to_org_code" />
                                    <input type="hidden" name="to_working_org_code" />
                                    <input type="hidden" name="to_designation_code" />
                                    <input type="hidden" name="to_posted_as" />
                                    <button type="submit" class="btn btn-success">Select Staff</button>
                                </form>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <script>
            // load district
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

            // load upazila
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

            // load organization
            $('#admin_upazila').change(function() {
                $("#loading_content").show();
                var div_code = $('#admin_division').val();
                var dis_code = $('#admin_district').val();
                var upa_code = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organizations.php',
                    data: {
                        div_code: div_code,
                        dis_code: dis_code,
                        upa_code: upa_code,
                        agency_code: agency_code
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var org_list = document.getElementById('org_list');
                        org_list.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            org_list.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load designation
            $('#org_list').change(function() {
                var organization_code = $('#org_list').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_designations.php',
                    data: { organization_code: organization_code },
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var sanctioned_post = document.getElementById('sanctioned_post');
                        sanctioned_post.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            sanctioned_post.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });
        </script>
    </body>
</html>

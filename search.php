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
if ($org_code == "") {
    $org_code = "99999999";
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


// GET
$seach_type = mysql_real_escape_string($_GET['type']);


if ($seach_type == "staff_name") {
    $name = mysql_real_escape_string(trim($_GET['name']));
//    header("location:search.php");
}
if ($seach_type == "staff_father_name") {
    $name = mysql_real_escape_string(trim($_GET['name']));
//    header("location:search.php");
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
                        $active_menu = "search";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Search main div
                    ================================================== -->
                    <section id="search_main">

                        <!-- search options -->
                        <?php if ($seach_type == ""): ?>
                            <div id="search_options">
                                <div class="row-fluid">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="search.php?type=org" class="btn btn-large btn-warning">
                                                        <i class="icon-hospital icon-2x pull-left"></i> Search Organization
                                                    </a>
                                                </td>
                                                <td>Search an organization using the organization name organization code, organization type or find it form the administrative divisions.</td>
                                            </tr>
                                            <!--
                                            <tr>
                                                <td>
                                                    <a href="search.php?type=staff" class="btn btn-large btn-info">
                                                        <i class="icon-user-md icon-2x pull-left"></i> Search Employee
                                                    </a>
                                                </td>
                                                <td>Find an individual staff from an organization, search by his name or staff id.</td>
                                            </tr>
                                            -->
                                            <tr>
                                                <td>
                                                    <a href="search.php?type=user" class="btn btn-large btn-primary">
                                                        <i class="icon-user icon-2x pull-left"></i> Search HRM Users
                                                    </a>
                                                </td>
                                                <td>Find an HRM organization user, search by username or organization name.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?> <!-- /search options -->

                        <!-- search organization -->
                        <?php if ($seach_type == "org"): ?>
                            <h3>Search Organization</h3>
                            <div id="search_org_main">
                                <div  id="search_org">
                                    <!-- Search Organization by Organization name or code -->
                                    <div class="row-fluid">
                                        <div class="span12 alert">
                                            <div class="control-group">
                                                <p class="lead">Search By Organization Name or Organization Code</p>
                                                <div class="controls input-append">
                                                    <input type="text" id="searchOrg" class="input-xlarge" placeholder="Enter Organization Name or Code" autofocus="">
                                                    <button id="btn_search_org" class="btn btn-info" type="button">Find Organization(s)</button>
                                                    <button id="btn_reset" class="btn" type="button">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Search Organization by administrative location -->
                                    <div class="row-fluid">
                                        <div class="span12 alert">
                                            <div class="">
                                                <p class="lead">Find Organization(s) from the administrative requin, agency type or organization type</p>
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
                                                            echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="control-group">
                                                    <select id="admin_division" name="admin_division">
                                                        <option value="0">Select Division</option>
                                                        <?php
                                                        /**
                                                         * @todo change old_visision_id to division_bbs_code
                                                         */
                                                        $sql = "SELECT admin_division.division_name, admin_division.old_division_id FROM admin_division";
                                                        $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                        while ($rows = mysql_fetch_assoc($result)) {
                                                            echo "<option value=\"" . $rows['old_division_id'] . "\">" . $rows['division_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <select id="admin_district" name="admin_district">
                                                        <option value="0">Select District</option>
                                                    </select>
                                                    <select id="admin_upazila" name="admin_upazila">
                                                        <option value="0">Select Upazila</option>
                                                    </select>
                                                </div>

                                                <div class="control-group">

                                                    <select id="org_type" name="org_type[]" class="multiselect" multiple="multiple">
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
                                                            echo "<option value=\"" . $rows['org_type_code'] . "\">" . $rows['org_type_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <!--
                                                        <select id="org_list" name="org_list">
                                                            <option value="0">Select Organization</option>
                                                        </select>
                                                        <select id="sanctioned_post" name="org_list">
                                                            <option value="0">Select Designation</option>
                                                        </select>
                                                    -->
                                                </div>
                                                </select>
                                                <div class="control-group">
                                                    <button id="btn_show_org_list" type="button" class="btn btn-info">Show Organization(s) List</button>

                                                    <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                                </div>
                                            </div>
                                            <div id="org_list_display"></div>
                                        </div>

                                    </div>
                                </div> <!-- /search_org -->
                            </div>

                        <?php endif; ?>

                        <!-- search user -->
                        <?php if ($seach_type == "user"): ?>
                            <h3>Search User</h3>
                            <div id="search_user_main" class="row-fluid">
                                <div id="search_user_by_name" class="">
                                    <div class="row-fluid">
                                        <div class="span12 alert alert-info">
                                            <div class="control-group">
                                                <p class="lead">Search By User Name</p>
                                                <div class="controls input-append">
                                                    <input type="text" id="searchUser" class="input-xlarge" placeholder="Enter User Name">
                                                    <button id="btn_search_user_name" class="btn btn-info" type="button">Find user(s)</button>
                                                    <button id="btn_reset" class="btn" type="button">Reset</button>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <p class="lead">Search By Organization Name or Organization Code</p>
                                                <div class="controls input-append">
                                                    <input type="text" id="searchOrg" class="input-xlarge" placeholder="Enter Organization Name or Code">
                                                    <button id="btn_user_search_org" class="btn btn-info" type="button">Find Organization(s)</button>
                                                    <button id="btn_reset" class="btn" type="button">Reset</button>
                                                </div>
                                            </div>
                                            <div id="user_list_display"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- search staff by name -->
                        <?php 
                        if ($seach_type == "staff_name"): 
                            $sql = "SELECT staff_id, staff_name, father_name, org_code FROM `old_tbl_staff_organization` WHERE staff_name LIKE \"%$name%\" AND active LIKE '1'";
                            $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:search staff by name:1</p><p>Query:</b></p>___<p>$sql</p>");                            
                            $result_count = mysql_num_rows($result);
                            ?>
                        <p class="alert alert-info">
                            Search result for : <em><?php echo $name; ?></em><br />
                            Total result found: <?php echo $result_count; ?>
                        </p>
                            <?php if($result_count): ?>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>Name</strong></th>
                                            <th><strong>Father's Name</strong></th>
                                            <th><strong>Organization</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $row_count = 0;
                                        while($data = mysql_fetch_assoc($result)): 
                                            $row_count++; ?>
                                            <tr>
                                                <td><?php echo $row_count; ?></td>
                                                <td><?php echo $data['staff_name']; ?></td>
                                                <td><?php echo $data['father_name']; ?></td>
                                                <td><?php echo getOrgNameFormOrgCode($data['org_code']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                            <!--                            
                            <h3>Search Staff</h3>
                            <div id="staff_user_main" class="row-fluid">
                                <div id="staff_user_by_name" class="">
                                    <div class="row-fluid">
                                        <div class="span12 alert alert-info">
                                            
                                            <div class="control-group">
                                                <p class="lead">Search By Staff Name</p>
                                                <div class="controls input-append">
                                                    <input type="text" id="searchStaff" class="input-xlarge" placeholder="Enter Staff Name" autofocus="">
                                                    <button id="btn_search_staff" class="btn btn-info" type="button">Find Staff(s)</button>
                                                    <button id="btn_reset" class="btn" type="button">Reset</button>
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label" for="searchStaff">Search Keyword</label>
                                                <div class="controls">
                                                    <input type="text" id="searchStaff" class="input-xlarge" placeholder="Enter Staff Name" autofocus="">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="searchStaffType">Search Type</label>
                                                <div class="controls">
                                                    <select id="searchStaffType" name="searchStaffType" class="input-xlarge">
                                                        <option id="searchStaffType_name" value="searchStaffType_name">Search By Name</option>
                                                        <option id="searchStaffType_mobile" value="searchStaffType_mobile">Search By Mobile Number</option>
                                                        <option id="searchStaffType_email" value="searchStaffType_email">Search By Email</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button id="btn_search_staff" class="btn btn-info" type="button">Find Staff(s)</button>
                                                    <button id="btn_reset" class="btn" type="button">Reset</button>
                                                </div>
                                            </div>

                                            <div id="staff_list_display"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
                        <?php endif; ?>
                            
                        <!-- search staff by Father's name -->
                        <?php 
                        if ($seach_type == "staff_father_name"): 
                            $sql = "SELECT staff_id, staff_name, org_code, father_name FROM `old_tbl_staff_organization` WHERE father_name LIKE \"%$name%\" AND active LIKE '1'";
                            $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:search staff by father_name:1</p><p>Query:</b></p>___<p>$sql</p>");                            
                            $result_count = mysql_num_rows($result);
                            ?>
                        <p class="alert alert-info">
                            Search result for : <em><?php echo $name; ?></em><br />
                            Total result found: <?php echo $result_count; ?>
                        </p>
                            <?php if($result_count): ?>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><strong>#</strong></th>
                                        <th><strong>Name</strong></th>
                                        <th><strong>Father's Name</strong></th>
                                        <th><strong>Organization</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $row_count = 0;
                                    while($data = mysql_fetch_assoc($result)): 
                                        $row_count++; ?>
                                        <tr>
                                            <td><?php echo $row_count; ?></td>
                                            <td><?php echo $data['staff_name']; ?></td>
                                            <td><?php echo $data['father_name']; ?></td>
                                            <td><?php echo getOrgNameFormOrgCode($data['org_code']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        <?php endif; ?>    

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        <script type="text/javascript">
            $('.multiselect').multiselect({
                maxHeight: 200,
                includeSelectAllOption: true,
                nonSelectedText: "Select Organization Types"
            });
        </script>

        <script type="text/javascript">
            // load division
            $('#admin_division').change(function() {
                $("#loading_content").show();
                var div_id = $('#admin_division').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_district_list.php',
                    data: {div_id: div_id},
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
                var dis_id = $('#admin_district').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_upazila_list.php',
                    data: {dis_id: dis_id},
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
            $('#btn_show_org_list').click(function() {
                var div_id = $('#admin_division').val();
                var dis_id = $('#admin_district').val();
                var upa_id = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                var type_code = $('#org_type').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_org_list.php',
                    data: {
                        div_id: div_id,
                        dis_id: dis_id,
                        upa_id: upa_id,
                        agency_code: agency_code,
                        type_code: type_code
                    },
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        $("#org_list_display").html("");
                        $("#org_list_display").html(data);
                    }
                });
            });

            // Search organization
            $('#btn_search_org').click(function() {
                $("#loading_content").show();
                var searchOrg = $('#searchOrg').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_search_result.php',
                    data: {type: "org", searchOrg: searchOrg},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#org_list_display").html("");
                        $("#org_list_display").html(data);
                    }
                });
            });

            // Search user
            $('#btn_search_user_name').click(function() {
                $("#loading_content").show();
                var searchUser = $('#searchUser').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_search_result.php',
                    data: {type: "user", searchUser: searchUser},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#user_list_display").html("");
                        $("#user_list_display").html(data);
                    }
                });
            });

            // Search staff
            $('#btn_search_staff').click(function() {
                $("#loading_content").show();
                var searchStaff = $('#searchStaff').val();
                var searchStaffType = $('#searchStaffType').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_search_result.php',
                    data: {type: "staff", searchStaff: searchStaff, searchStaffType: searchStaffType},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#staff_list_display").html("");
                        $("#staff_list_display").html(data);
                    }
                });
            });

            // Search user by org
            $('#btn_user_search_org').click(function() {
                $("#loading_content").show();
                var searchOrg = $('#searchOrg').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_search_result.php',
                    data: {type: "staff_org", searchOrg: searchOrg},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#user_list_display").html("");
                        $("#user_list_display").html(data);
                    }
                });
            });

            //reset search field
            $("#btn_reset").click(function() {
                $('#searchOrg').val("");
                $("#org_list_display").html("");
                $("#staff_list_display").html("");
            });
        </script>
    </body>
</html>

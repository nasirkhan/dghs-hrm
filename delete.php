<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';

/**
 * Reassign org_code and enable edit permission for Upazila and below
 * 
 * Upazila users can edit the organizations under that UHC. 
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051){  
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
    
    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);
    
    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])){
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


// GET
$seach_type = mysql_real_escape_string($_GET['type']);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="library/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">


        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- favicon and touch icons -->
        <?php include_once 'include/header/header_icon.inc.php'; ?>

        <!--Google analytics code-->
        <?php include_once 'include/header/header_ga.inc.php'; ?>

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
                        
                        <!-- search options -->
                        <?php if ($seach_type == ""): ?>
                        <div id="search_options">
                            <div class="row-fluid">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="delete.php?type=org" class="btn btn-large btn-warning">
                                                    <i class="icon-hospital icon-2x pull-left"></i> Search Organization
                                                </a>
                                            </td>
                                            <td>Search an organization using the organization name organization code, organization type or find it form the administrative divisions.</td>
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
                        
                        <!-- search staff -->
                        <?php if ($seach_type == "staff"): ?>
                        <h3>Search Staff</h3>
                        <div id="staff_user_main" class="row-fluid">
                            <div id="staff_user_by_name" class="">
                                <div class="row-fluid">
                                    <div class="span12 alert alert-info">
<!--                                        <div class="control-group">
                                            <p class="lead">Search By Staff Name</p>
                                            <div class="controls input-append">
                                                <input type="text" id="searchStaff" class="input-xlarge" placeholder="Enter Staff Name" autofocus="">
                                                <button id="btn_search_staff" class="btn btn-info" type="button">Find Staff(s)</button>
                                                <button id="btn_reset" class="btn" type="button">Reset</button>
                                            </div>
                                        </div>-->
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
                                                    <!--<option id="searchStaffType_email" value="searchStaffType_email">Search By Email</option>-->
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
                        <?php endif; ?>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

        <script src="library/bootstrap-editable/js/bootstrap-editable.min.js"></script>

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
                    url: 'get/get_search_result_for_delete.php',
                    data: {type:"org", searchOrg: searchOrg},
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
                    data: {type:"user", searchUser: searchUser},
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
                    data: {type:"staff", searchStaff: searchStaff, searchStaffType:searchStaffType},
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
                    data: {type:"staff_org", searchOrg: searchOrg},
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

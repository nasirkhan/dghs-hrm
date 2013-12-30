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
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}
if ($org_code == "") {
    $org_code = "99999999";
}

// admin check 
if ($_SESSION['user_type'] != "admin") {
    header("location:home.php?org_code=$org_code");
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
                        <li class="active"><a href="admin_home.php"><i class="icon-home"></i> Admin Homepage</a>
                        <li><a href="search.php?type=org"><i class="icon-search"></i> Search</a></li>
                        <li><a href="add_new.php"><i class="icon-plus"></i> Add New</a>
                        <li class="level2"><a href="add_new.php"><i class="icon-plus"></i> Add New</a>
                        <li class="level3"><a href="add_new.php"><i class="icon-plus"></i> Add New</a>
                        <li><a href="transfer_approval.php?org_code=<?php echo $org_code; ?>"><i class="icon-random"></i> Transfer Approval</a></li>
                        <li><a href="report/index.php?org_code=<?php echo $org_code; ?>"><i class="icon-calendar"></i> Reports</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- admin home
                    ================================================== -->
                    <section id="admin_home_main">
                        <h3>Admin Dashboard</h3>

                        <div class="row-fluid">

                            <a href="search.php" class="btn btn-large btn-warning">
                                <i class="icon-search pull-left icon-3x"></i> Search
                            </a>

                            <a href="add_new.php" class="btn btn-large btn-info">
                                <i class="icon-plus pull-left icon-3x"></i> Add New
                            </a>

                            <a href="transfer.php" class="btn btn-large">
                                <i class="icon-exchange pull-left icon-3x"></i> Transfer
                            </a>

                            <a href="delete.php" class="btn btn-danger btn-large">
                                <i class="icon-trash pull-left icon-3x"></i> Delete
                            </a>

                            <a href="update_sanctioned_post.php" class="btn btn-large">
                                <i class="icon-group pull-left icon-3x"></i> Update sanctioned Post
                            </a>

                            <a href="admin_edit_org.php" class="btn btn-large">
                                <?php
                                $sql = "SELECT * FROM `organization_requested` WHERE active LIKE 1;";
                                $new_org_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:sql:1<br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                $new_org_result_count = mysql_num_rows($new_org_result);
                                ?>
                                <i class="icon-hospital pull-left icon-3x"></i>
                                Org Approval Queue
                                <?php if ($new_org_result_count > 0): ?>
                                    <br />
                                    <span class="badge badge-warning">Total <?php echo "$new_org_result_count"; ?> pending</span>
                                <?php endif; ?>

                            </a>

                        </div>



                    </section> <!-- /admin_home_main -->
                </div>
            </div>

        </div>
        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
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
                    data: {searchOrg: searchOrg},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#org_list_display").html("");
                        $("#org_list_display").html(data);
                    }
                });
            });

            //reset search field
            $("#btn_reset").click(function() {
                $('#searchOrg').val("");
                $("#org_list_display").html("");
            });
        </script>

    </body>
</html>

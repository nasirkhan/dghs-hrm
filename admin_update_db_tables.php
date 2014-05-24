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
//
//if ($org_code == "") {
//    $org_code = "99999999";
//}
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
        <?php if(!orgSelected() && $_SESSION['admin_home_hint_status']!='closed'){?>
        <div class="homepageHint" style="margin: 0 auto;
             opacity: 0.7;
             position: absolute;
             text-align: center;
             top: -25px;
             width: 100%;
             z-index: 10000;">
            <img src="assets/img/org_selection_handwriting_hint.png"/>
        </div>
        <script>
            $('.homepageHint').click(function(){
                $(this).fadeOut('slow');
                $('#rightContainerMain').css('padding-top','0px');
            });
        </script>
        <?php } ?>

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <!--        <header class="jumbotron subhead" id="overview">
                    <div class="container">
                        <h1><?php echo $org_name; ?></h1>
                        <p class="lead"><?php echo "$org_type_name"; ?></p>
                    </div>
                </header>-->


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

                <div id="rightContainerMain" class="span9" <?php if(!orgSelected()&& $_SESSION['admin_home_hint_status']!='closed'){echo " style='padding-top:100px'";}?>>
                    <!-- admin home
                    ================================================== -->
                    <section id="admin_home_main">
                        <h3>Update Database Tables</h3>
                        
                        <div class="row-fluid">
                            
                            <?php if (hasPermission('mod_system_configuration', 'view', getLoggedUserName())): ?>
                            
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <td>
                                        <a href="admin_designations.php"> Designations</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="admin_sanctioned_post_first_level.php">First Level Names</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="admin_sanctioned_post_second_level.php">Second Level Names</a>
                                    </td>
                                </tr>
                            </table>
                            <?php else: ?>
                            
                            <p class="lead alert alert-Warnign">
                                You do not have the permission to view this content. 
                            </p>
                            
                            <?php endif; ?>

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
<?php
$_SESSION['admin_home_hint_status']='closed';
?>

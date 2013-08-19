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

$add_new_type = mysql_real_escape_string($_GET['type']);

$new_type = "";
if ($add_new_type == "org") {
    $new_type = "Organization";
} else if ($add_new_type == "user") {
    $new_type = "User";
}

if (isset($_POST['new_post_type']) && $_POST['new_post_type']== "org"){
    $new_org_name = mysql_real_escape_string($_POST['new_org_name']);
    $new_org_code = mysql_real_escape_string($_POST['new_org_code']);
    $new_established_year = mysql_real_escape_string($_POST['new_established_year']);
    $admin_division = mysql_real_escape_string($_POST['admin_division']);
    $admin_district = mysql_real_escape_string($_POST['admin_district']);
    $admin_upazila = mysql_real_escape_string($_POST['admin_upazila']);
    $new_ownarship_info = mysql_real_escape_string($_POST['new_ownarship_info']);
    
    //@TODO change the division, district ID to Code
    $sql = "INSERT INTO `organization` (
            `org_name`, 
            `org_code`,
            `year_established`,
            `division_id`,
            `district_id`,
            `upazila_id`,
            `ownership_code`) 
        VALUES (
            \"$new_org_name\",
            '$new_org_code',
            \"$new_established_year\",
            '$admin_division',
            '$admin_district',
            '$admin_upazila',
            '$new_ownarship_info'
            )";
//    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertNewOrganization:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");    
        $insert_success = TRUE;
}
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
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">        

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">

        <!--Google analytics code-->
        <?php // include_once 'include/header/header_ga.inc.php';  ?>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

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

            <!-- Navigation
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Admin Homepage</a>
                        <li><a href="search.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>
                        <li class="active"><a href="add_new.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Add New</a>
                            <!--                        
                            <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                            <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                            <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                            -->
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- main 
                    ================================================== -->
                    <section id="add-new">
                        <h3>Add new <?php echo $new_type; ?></h3>
                        <?php if ($insert_success): ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                &nbsp;<br />
                                <h4>New information has been successfully added to the database.</h4>
                                &nbsp;<br />
                            </div>                        
                        <?php endif; ?>
                        <!--options-->
                        <?php if ($add_new_type == ""): ?>
                            <div id="add_new_options">
                                <div class="row-fluid">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="add_new.php?type=org" class="btn btn-large btn-warning">
                                                        <i class="icon-hospital icon-2x pull-left"></i> Add New Organization
                                                    </a>
                                                </td>
                                                <td> Upload the organization photo by form here. If any photo is uploaded previously, then it will be replaced by new new uploaded image.</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="add_new.php?type=user" class="btn btn-large btn-info">
                                                        <i class="icon-user-md icon-2x pull-left"></i> Add New Organization User
                                                    </a>
                                                </td>
                                                <td> Upload different files related to the organization, click the button and go to the upload form. Details information is described there.</td>
                                            </tr>                                    
                                        </tbody>
                                    </table>                            
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($add_new_type == "org"): ?>
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="control-group">
                                    <label class="control-label" for="new_org_name">Organization Name</label>
                                    <div class="controls">
                                        <input type="text" id="new_org_name" name="new_org_name" placeholder="Organization Name"> 
                                    </div>
                                </div>
                                <?php
                                $last_org_code = (int) getLastOrgIdFromOrganizationTable();
                                $new_org_code = $last_org_code + 1;
                                ?>
                                <div class="control-group">
                                    <label class="control-label" for="new_org_code">Organization Code</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo "$new_org_code"; ?>" disabled=""/> 
                                        <input type="hidden" id="new_org_code" name="new_org_code" value="<?php echo "$new_org_code"; ?>" /> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="agency_code">Agency Name</label>
                                    <div class="controls">
                                        <select id="agency_code">
                                            <option value="0">-- Select form the list --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_established_year">Year established</label>
                                    <div class="controls">
                                        <input type="text" id="new_established_year" name="new_established_year" placeholder="Enter the Year"> 
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_location_type">Urban/Rural Location</label>
                                    <div class="controls">
                                        <select id="org_location_type">
                                            <option value="0">-- Select form the list --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_location_type">Urban/Rural Location</label>
                                    <div class="controls">
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
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_location_type">Urban/Rural Location</label>
                                    <div class="controls">
                                        <select id="admin_district" name="admin_district">
                                            <option value="0">Select District</option>                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_location_type">Urban/Rural Location</label>
                                    <div class="controls">
                                        <select id="admin_upazila" name="admin_upazila">
                                            <option value="0">Select Upazila</option>                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_ownarship_info">Ownership Information</label>
                                    <div class="controls">
                                        <select id="new_ownarship_info" name="new_ownarship_info">
                                            <option value="0">Select Ownership </option>                                        
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="new_post_type" name="new_post_type" value="org" /> 
                                <div class="control-group">
                                    <div class="controls">                                            
                                        <button type="submit" class="btn btn-large btn-info">Add New Organization</button>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

        <script src="library/dataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>
        <script src="library/dataTables-1.9.4/media/js/paging.js"></script>


        <script type="text/javascript">
            $.ajax({
                url: 'get/get_agency_code.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#agency_code')
                                .append($("<option></option>")
                                .attr("value", v.value)
                                .text(v.text));
                    });
                }
            });
            $.ajax({
                url: 'get/get_org_location_type.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#org_location_type')
                                .append($("<option></option>")
                                .attr("value", v.value)
                                .text(v.text));
                    });
                }
            });

            $.ajax({
                url: 'get/get_org_ownership.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#new_ownarship_info')
                                .append($("<option></option>")
                                .attr("value", v.value)
                                .text(v.text));
                    });
                }
            });

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
        </script>

    </body>
</html>

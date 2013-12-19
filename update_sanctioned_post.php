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
    if ($org_code == 0) $org_code = 99999999;
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

$step = 0;
if (isset($_REQUEST['step'])) {
    $step = (int) mysql_real_escape_string(trim($_REQUEST['step']));

    $org_code = (int) mysql_real_escape_string($_GET['org_code']);

    $designation_code = (int) mysql_real_escape_string($_GET['designation_code']);
    $designation_name = getDesignationNameformCode($designation_code);
}
/**
 * update sanctiond post
 */
if (isset($_POST['action'])) {
    $sp_id = (int) mysql_real_escape_string(trim($_POST['sp_id']));
    $org_code = (int) mysql_real_escape_string(trim($_POST['org_code']));
    $action  = mysql_real_escape_string(trim($_POST['action']));
    if ($action == "add"){
        $sql = "SELECT
                        *
                FROM
                        total_manpower_imported_sanctioned_post_copy
                WHERE
                        id = '$sp_id'
                AND active LIKE 1";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1</p><p>Query:</b></p>___<p>$sql</p>");
        $data = mysql_fetch_assoc($result);
        
        if ($org_code == $data['org_code']){
            $sql = "INSERT INTO `total_manpower_imported_sanctioned_post_copy` (
                `group`,
                `designation`,
                `type_of_post`,
                `sanctioned_post`,
                `sanctioned_post_group_code`,
                `pay_scale`,
                `class`,
                `first_level_id`,
                `first_level_name`,
                `org_code`,
                `designation_code`,
                `updated_by`,
                `second_level_id`,
                `second_level_name`,
                `bangladesh_professional_category_code`,
                `who_occupation_group_code`
            )
            VALUES
                (
		\"" . $data['group'] . "\",
		\"" . $data['designation'] . "\",
		\"" . $data['type_of_post'] . "\",
		\"" . $data['sanctioned_post'] . "\",
		\"" . $data['sanctioned_post_group_code'] . "\",
		\"" . $data['pay_scale'] . "\",
		\"" . $data['class'] . "\",
		\"" . $data['first_level_id'] . "\",
		\"" . $data['first_level_name'] . "\",
		\"" . $data['org_code'] . "\",
		\"" . $data['designation_code'] . "\",
		\"" . $_SESSION['username'] . "\",
		\"" . $data['second_level_id'] . "\",
		\"" . $data['second_level_name'] . "\",
                \"" . $data['bangladesh_professional_category_code'] . "\",
                \"" . $data['who_occupation_group_code'] . "\"
            )";
//            echo "<pre>$sql</pre>";
            $result = mysql_query($sql) or die(mysql_error() . "Query:1<br />___<br />$sql<br />");
        }
    }
    else if ($action == "delete"){
        // remove from the sanctioned post table
        $sql = "UPDATE total_manpower_imported_sanctioned_post_copy
                SET `active` = '0',
                `staff_id` = '0',
                `staff_id_2` = '0',
                `updated_by` = \"" . $_SESSION['username'] . "\"
                WHERE id = '$sp_id'";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1</p><p>Query:</b></p>___<p>$sql</p>");
//        echo "<pre>$sql</pre>";
        
        // search the post link in the staff table
        $sql = "SELECT * FROM `old_tbl_staff_organization` WHERE sp_id_2 = '$sp_id'";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1</p><p>Query:</b></p>___<p>$sql</p>");
        
        if (mysql_num_rows($result)) {
            // update the staff table by removeing the sanctioned post link 
            $sql = "UPDATE `old_tbl_staff_organization` SET `sp_id_2`='0', `sanctioned_post_id`='0', `updated_by` = \"" . $_SESSION['username'] . "\" WHERE sp_id_2 = '$sp_id'";
            $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1</p><p>Query:</b></p>___<p>$sql</p>");
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Nasir Khan Saikat">

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
                        <li class="active"><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Admin Homepage</a>
                        <li><a href="search.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>
                        <li><a href="add_new.php"><i class="icon-chevron-right"></i><i class="icon-plus"></i> Add New</a>
                            <!--                        
                            
                            
                            <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                            <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                            <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                            -->
                        <li><a href="transfer_approval.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-random"></i> Transfer Approval</a></li>
                        <li><a href="report/index.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-calendar"></i> Reports</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Update Sanctioned Post
                    ================================================== -->
                    <section id="admin_home_main">

                        <?php if ($step == 0) : ?>
                            <h3>Update Sanctioned Post</h3>
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                <div class="control-group">
                                    <label class="control-label" for="org_code">Enter Org Code</label>
                                    <div class="controls">
                                        <input type="text" id="org_code" name="org_code" placeholder="Organization Code" class="input-xlarge "> 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">   
                                        <input type="hidden" id="step" name="step" value="1"> 
                                        <button type="submit" class="btn btn-success"><strong>Get Summary</strong> <i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                        <?php if ($step == 1) : ?>
                            
                            <div class="row-fluid">
                                <div class="span10">
                                    <h3>Sanctioned Post Summary</h3>
                                </div>
<!--                                <div class="span3">
                                    <a href="update_sanctioned_post.php" class="btn btn-small btn-primary btn-block">Update Sanctioned post</a>
                                </div>-->
                                <div class="span2">
                                    <a href="update_sanctioned_post.php" class="btn btn-small btn-info btn-block">Back</a>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <h4><a href="org_profile.php?org_code=<?php echo "$org_code"; ?>" target="_blank"><?php echo "$org_name ($org_code)"; ?></a></h4>
                                <?php
                                $total_post = getTotalSanctionedPostCountFromOrgCode($org_code);
                                $total_filled_up = getTotalFilledUpSanctionedPostCountFromOrgCode($org_code);
                                $total_vacant_post = $total_post - $total_filled_up;
                                ?>
                                <strong>Total Sanctioned Post :</strong> <span class="label label-info"><?php echo $total_post; ?></span>
                                <br />
                                <strong>Total Filled up Sanctioned Post :</strong> <span class="label label-info"><?php echo $total_filled_up; ?></span>
                                <br />
                                <strong>Total Vacant Post  Sanctioned Post :</strong> <span class="label label-info"><?php echo $total_vacant_post; ?></span>
                                <br /><br />
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <?php
                                    $sql = "SELECT
                                                        total_manpower_imported_sanctioned_post_copy.id,
                                                        total_manpower_imported_sanctioned_post_copy.designation,
                                                        total_manpower_imported_sanctioned_post_copy.designation_code,
                                                        total_manpower_imported_sanctioned_post_copy.discipline,
                                                        total_manpower_imported_sanctioned_post_copy.type_of_post,
                                                        sanctioned_post_designation.ranking,
                                                        sanctioned_post_designation.class,
                                                        sanctioned_post_designation.payscale,
                                                        COUNT(*) AS sp_count
                                                FROM
                                                        `total_manpower_imported_sanctioned_post_copy`
                                                LEFT JOIN `sanctioned_post_designation` ON total_manpower_imported_sanctioned_post_copy.designation_code = sanctioned_post_designation.designation_code
                                                WHERE
                                                        total_manpower_imported_sanctioned_post_copy.org_code = $org_code
                                                        AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
                                                GROUP BY
                                                        total_manpower_imported_sanctioned_post_copy.designation
                                                ORDER BY
                                                        sanctioned_post_designation.ranking";
                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                    $i = 1;
                                    ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td><strong>#</strong></td>
                                                <td><strong>Designation</strong></td>
                                                <td><strong>Type of post</strong></td>
                                                <td><strong>Class</strong></td>
                                                <td><strong>Payscale</strong></td>
                                                <td><strong>Total Post</strong></td>
                                                <td><strong>Action</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($sp_data = mysql_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?php echo "$i"; $i++; ?></td>
                                                    <td><?php echo $sp_data['designation']; ?></td>
                                                    <td><?php echo getTypeOfPostNameFromCode($sp_data['type_of_post']); ?></td>
                                                    <td><?php echo $sp_data['class']; ?></td>
                                                    <td><?php echo $sp_data['payscale']; ?></td>
                                                    <td><?php echo $sp_data['sp_count']; ?></td>
                                                    <td>
                                                        <form class="form-inline" method="post">
                                                            <input name="org_code" value="<?php echo $org_code; ?>" type="hidden" />
                                                            <input name="sp_id" value="<?php echo $sp_data['id']; ?>" type="hidden" />
                                                            <input name="action" value="add" type="hidden" />
                                                            <button type="submit" class="btn btn-small btn-success">Add</button>
                                                        </form>
                                                        <form class="form-inline" method="get">
                                                            <input name="org_code" value="<?php echo $org_code; ?>" type="hidden" />
                                                            <input name="designation_code" value="<?php echo $sp_data['designation_code']; ?>" type="hidden" />
                                                            <input name="action" value="delete" type="hidden" />
                                                            <input type="hidden" id="step" name="step" value="2">
                                                            <button type="submit" class="btn btn-small btn-danger">Del</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
<!--                            <div class="row-fluid">
                                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                    <div class="control-group">
                                        <label class="control-label" for="designation_code">Designation</label>
                                        <div class="controls">
                                            <select id="designation_code" name="designation_code">
                                                <option value="0">Select Designation</option>
                                                <?php
                                                $sql = "SELECT
                                                            *
                                                    FROM
                                                            `total_manpower_imported_sanctioned_post_copy`
                                                    WHERE
                                                            org_code = '$org_code'
                                                    AND active LIKE 1
                                                    GROUP BY
                                                            designation_code";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($rows = mysql_fetch_assoc($result)) {
                                                    echo "<option value=\"" . $rows['designation_code'] . "\">" . $rows['designation'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">   
                                            <input type="hidden" id="org_code" name="org_code" value="<?php echo "$org_code"; ?>"> 
                                            <input type="hidden" id="step" name="step" value="2">
                                            <button type="submit" class="btn btn-success">Get Sanctioned Post List</button>
                                        </div>
                                    </div>
                                </form>
                            </div>-->
                        <?php endif; ?>
                        <?php if ($step == 2) : ?>
                            <div class="row-fluid">
                                <div class="span7">
                                    <h3>Delete Sanctioned Post</h3>
                                </div>
                                <div class="span3">
                                    <a href="update_sanctioned_post.php" class="btn btn-small btn-primary btn-block">Update Sanctioned post</a>
                                </div>
                                <div class="span2">
                                    <a href="update_sanctioned_post.php?org_code=<?php echo $org_code; ?>&step=1" class="btn btn-small btn-info btn-block">Back</a>
                                </div>
                            </div>

                            <h4><a href="org_profile.php?org_code=<?php echo "$org_code"; ?>" target="_blank"><?php echo "$org_name ($org_code)"; ?></a></h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td><strong>Designation Name</strong></td>
                                        <td><strong>Sanctioned Post ID</strong></td>
                                        <td><strong>Staff Name (Staff ID)</strong></td>
                                        <td><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT
                                                *
                                        FROM
                                                `total_manpower_imported_sanctioned_post_copy`
                                        WHERE
                                                org_code = '$org_code'
                                        AND designation_code = '$designation_code'            
                                        AND active LIKE 1";
                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                    while ($data = mysql_fetch_assoc($result)):
                                        ?>
                                        <tr>
                                            <td><?php echo $designation_name; ?></td>
                                            <td><?php echo $data['id']; ?></td>
                                            <td>
                                                <?php
                                                if ($data['staff_id_2'] > 0) {
                                                    echo "<a href=\"employee.php?staff_id=" . $data['staff_id_2'] . "\" target=_blank>";
                                                    echo getStaffNameFromId($data['staff_id_2']) . " (" . $data['staff_id_2'] . ")";
                                                    echo "</a>";
                                                } else {
                                                    echo $data['staff_id_2'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <form class="form-inline" method="post">
                                                    <input name="org_code" value="<?php echo $org_code; ?>" type="hidden" />
                                                    <input name="sp_id" value="<?php echo $data['id']; ?>" type="hidden" />
                                                    <input name="action" value="delete" type="hidden" />
                                                    <button type="submit" class="btn btn-small btn-danger"><i class="icon-trash icon-large"></i> Delete</button>
                                                </form>
                                                <!--<button class="btn btn-small btn-danger" type="button">Delete</button>-->
                                                <!--<span class="label label-important">Delete</span>-->
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
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
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

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

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

$insert_success = mysql_real_escape_string($_GET['insert_success']);

if (isset($_POST['new_post_type']) && $_POST['new_post_type'] == "org") {



    // Required field names
//    $required = array('new_org_name', 'new_org_code', 'new_established_year', 'admin_division', 'admin_district', 'admin_upazila', 'new_ownarship_info', 'email_address1');
//
//    // Loop over field names, make sure each one exists and is not empty
//    $error = false;
//    foreach ($required as $field) {
//        if (!isset($_POST[$field])) {
//            $error = TRUE;
//            echo "<pre>";
//            print_r($field);
//            print_r($required);
//            print_r($_POST);
//        }
//    }
//    if ($error) {
//        header("location:add_new.php?type=org");
//    } else {
//        $required_missing = FALSE;
    //@TODO: verify the required fields
    $new_org_name = mysql_real_escape_string($_POST['new_org_name']);
    $new_org_code = mysql_real_escape_string($_POST['new_org_code']);
    $new_agency_code = mysql_real_escape_string($_POST['agency_code']);
    $new_established_year = mysql_real_escape_string($_POST['new_established_year']);
    $org_location_type = mysql_real_escape_string($_POST['org_location_type']);
    $division_id = mysql_real_escape_string($_POST['admin_division']);
    $division_code = getDivisionCodeFormId($division_id);
    $district_id = mysql_real_escape_string($_POST['admin_district']);
    $district_code = getDistrictCodeFormId($district_id);
    $upazila_id = mysql_real_escape_string($_POST['admin_upazila']);
    $upazila_code = getUpazilaCodeFormId($upazila_id);
    $new_ownarship_info = mysql_real_escape_string($_POST['new_ownarship_info']);
    $new_org_email = mysql_real_escape_string($_POST['new_org_email']);
    $new_org_type = mysql_real_escape_string($_POST['org_type']);
    $new_functions_code = mysql_real_escape_string($_POST['org_organizational_functions_code']);
    $new_org_level_code = mysql_real_escape_string($_POST['org_level_code']);

    //@TODO change the division, district ID to CODE
    $sql = "INSERT INTO `organization` (
            `org_name`,
            `org_code`,
            `org_type_code`,
            `agency_code`,
            `year_established`,
            `org_location_type`,
            `division_id`,
            `division_code`,
            `district_id`,
            `district_code`,
            `upazila_id`,
            `upazila_thana_code`,
            `ownership_code`,
            `email_address1`,
            `org_function_code`,
            `org_level_code`)
        VALUES (
            \"$new_org_name\",
            '$new_org_code',
            '$new_org_type',
            '$new_agency_code',
            \"$new_established_year\",
             '$org_location_type',
            '$division_id',
            '$division_code',
            '$district_id',
            '$district_code',
            '$upazila_id',
            '$upazila_code',
            '$new_ownarship_info',
            '$new_org_email',
            '$new_functions_code',
            '$new_org_level_code'
            )";

//        $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertNewOrganization:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    $insert_success = TRUE;

    header("location:add_new.php?type=org&insert_success=true");

//        echo "$sql";
//    }
}

$error = "";
if (isset($_POST['new_post_type']) && $_POST['new_post_type'] == "user") {
    // if " new_user_type " == " Super Admin "
    // @TODO restructure the User table, include user_type info
    if (isset($_POST['new_user_type']) && $_POST['new_user_type'] == "3") {
        $new_user_name = mysql_real_escape_string($_POST['new_user_name']);
        $new_user_pass = mysql_real_escape_string($_POST['new_user_pass']);
        $new_user_pass2 = mysql_real_escape_string($_POST['new_user_pass2']);
//        $new_user_name = mysql_real_escape_string($_POST['new_user_name']);

        if ($new_user_pass != $new_user_pass2) {
            $error = "Password did not matched.";
        }

        if ($error == "") {
            $sql = "INSERT INTO `users` (
                        `username`,
                        `password`,
                        `user_type`,
                        `org_code`,
                        `updated_datetime`,
                        `updated_by`,
                        `active`)
                    VALUES (
                        \"$new_user_name\",
                        \"$new_user_pass\",
                        '$new_agency_code',
                        \"$new_established_year\",
                         '$org_location_type',
                        '$division_id',
                        '$district_id'
                        )";

            echo "$sql";
//            die();
//            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertNewOrganization:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
            $insert_success = TRUE;

//            header("location:add_new.php?type=user&insert_success=true");
        }
    } else if (isset($_POST['new_user_type']) && $_POST['new_user_type'] == "1") {
        $new_user_name = mysql_real_escape_string($_POST['new_user_name']);
        $new_user_pass = mysql_real_escape_string($_POST['new_user_pass']);
        $new_user_pass2 = mysql_real_escape_string($_POST['new_user_pass2']);
//        $new_user_name = mysql_real_escape_string($_POST['new_user_name']);

        if ($new_user_pass != $new_user_pass2) {
            $error = "Password did not matched.";
        }

        if ($error == "") {
            $sql = "INSERT INTO `users` (
                        `username`,
                        `password`,
                        `user_type`,
                        `org_code`,
                        `updated_datetime`,
                        `updated_by`,
                        `active`)
                    VALUES (
                        \"$new_user_name\",
                        \"$new_user_pass\",
                        '$new_agency_code',
                        \"$new_established_year\",
                         '$org_location_type',
                        '$division_id',
                        '$district_id'
                        )";

            echo "$sql";
//            die();
//            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertNewOrganization:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
            $insert_success = TRUE;

//            header("location:add_new.php?type=user&insert_success=true");
        }
    }
}


$required_missing = mysql_real_escape_string($_GET['required_missing']);
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
                        <li><a href="admin_home.php"><i class="icon-chevron-right"></i><i class="icon-home"></i> Admin Homepage</a>
                        <li><a href="search.php"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>
                        <li class="active"><a href="add_new.php"><i class="icon-chevron-right"></i><i class="icon-plus"></i> Add New</a>
                        <li><a href="transfer_approval.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-random"></i> Transfer Approval</a></li>
                        <li><a href="search.php"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>
                        <li><a href="settings.php"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
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
                                <h4>New information has been successfully added to the database.<br><?php echo $sql; ?></h4>
                                &nbsp;<br />
                            </div>
                        <?php endif; ?>

                        <!--add options-->
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
                                                    <a href="user_add.php" class="btn btn-large btn-info">
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

                        <!--Add new organization-->
                        <?php if ($add_new_type == "org"): ?>
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                &nbsp;<br />
                                <h4>All the fields are required. Please complete the form carefully.</h4>
                                &nbsp;<br />
                            </div>
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="control-group">
                                    <label class="control-label" for="new_org_name">Organization Name</label>
                                    <div class="controls">
                                        <input type="text" id="new_org_name" name="new_org_name" placeholder="Organization Name" >
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
                                    <label class="control-label" for="org_type">Organization Type</label>
                                    <div class="controls">
                                        <select id="org_type" name="org_type">
                                            <option value="0">-- Select form the list --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="agency_code">Agency Name</label>
                                    <div class="controls">
                                        <select id="agency_code" name="agency_code" >
                                            <option value="0">-- Select form the list --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_established_year">Year established</label>
                                    <div class="controls">
                                        <input type="text" id="new_established_year" name="new_established_year" placeholder="Enter the Year" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_location_type">Urban/Rural Location</label>
                                    <div class="controls">
                                        <select id="org_location_type" name="org_location_type" >
                                            <option value="0">-- Select form the list --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="admin_division">Division Name</label>
                                    <div class="controls">
                                        <select id="admin_division" name="admin_division" >
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
                                    <label class="control-label" for="admin_district">District Name</label>
                                    <div class="controls">
                                        <select id="admin_district" name="admin_district">
                                            <option value="0">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="admin_upazila">Upazila Name</label>
                                    <div class="controls">
                                        <select id="admin_upazila" name="admin_upazila" >
                                            <option value="0">Select Upazila</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_ownarship_info">Ownership Information</label>
                                    <div class="controls">
                                        <select id="new_ownarship_info" name="new_ownarship_info" required>
                                            <option value="0">Select Ownership </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_organizational_functions_code">Organization Function</label>
                                    <div class="controls">
                                        <select id="org_organizational_functions_code" name="org_organizational_functions_code" required>
                                            <option value="0">Select Function </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="org_level_code">Organization Level</label>
                                    <div class="controls">
                                        <select id="org_level_code" name="org_level_code" required>
                                            <option value="0">Select Level </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_org_email">Email Address</label>
                                    <div class="controls">
                                        <input type="text" id="new_org_email" name="new_org_email" placeholder="Organization Email Address">
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

                        <!--Add new user-->
                        <?php if ($add_new_type == "user"): ?>
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="control-group">
                                    <label class="control-label" for="new_user_name">UserName</label>
                                    <div class="controls">
                                        <input type="text" id="new_user_name" name="new_user_name" placeholder="User Name" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_user_pass">Password</label>
                                    <div class="controls">
                                        <input type="password" id="new_user_pass" name="new_user_pass" placeholder="Password" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_user_pass2">Retype Password</label>
                                    <div class="controls">
                                        <input type="password" id="new_user_pass2" name="new_user_pass2" placeholder="Retype Password" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_user_type">User Type</label>
                                    <div class="controls">
                                        <select id="new_user_type" name="new_user_type" required>
                                            <option value="0">Select User Type</option>
                                            <?php
                                            /**
                                             * @todo restructure the user type table
                                             */
                                            $sql = "SELECT user_type_code, user_type_name FROM user_type";
                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                            while ($rows = mysql_fetch_assoc($result)) {
                                                echo "<option value=\"" . $rows['user_type_code'] . "\">" . $rows['user_type_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="new_admin_org_code" style="display: none;">
                                    <div class="control-group">
                                        <label class="control-label" for="new_org_code">Organization Code</label>
                                        <div class="controls">
                                            <input type="text" value="99999999" disabled=""/>
                                            <input type="hidden" id="new_org_code" name="new_org_code" value="99999999" />
                                        </div>
                                    </div>
                                </div>

                                <div id="org_select_block" class="row-fluid" style="display: none;">
                                    <div class="span12 alert alert-info">
                                        <div class="">
                                            <p class="lead">Select Organization(s) from the administrative region, agency type or organization type</p>
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

                                                <select id="org_list" name="org_list">
                                                    <option value="0">Select Organization</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="new_post_type" name="new_post_type" value="user" />
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-large btn-info">Add New User</button>
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
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
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

            //org_type
            $.ajax({
                url: 'get/get_org_type_name.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#org_type')
                                .append($("<option></option>")
                                        .attr("value", v.value)
                                        .text(v.text));
                    });
                }
            });

            //org_organizational_functions_code
            $.ajax({
                url: 'get/get_org_function_code.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#org_organizational_functions_code')
                                .append($("<option></option>")
                                        .attr("value", v.value)
                                        .text(v.text));
                    });
                }
            });

            //get_org_level_code
            $.ajax({
                url: 'get/get_org_level_code.php',
                type: 'get',
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v) {
                        $('#org_level_code')
                                .append($("<option></option>")
                                        .attr("value", v.value)
                                        .text(v.text));
                    });
                }
            });

            $("#new_user_type").change(function() {
                var selectedType = $("#new_user_type").val();
                if (selectedType === "1") {
                    $("#new_admin_org_code").hide();
                    $("#org_select_block").slideDown();
                }
                else if (selectedType === "3") {
                    $("#org_select_block").hide();
                    $("#new_admin_org_code").slideDown();
                }
            });
            // load district
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

            // load upazila
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
            $('#org_type').change(function() {
                $("#loading_content").show();
                var div_id = $('#admin_division').val();
                var dis_id = $('#admin_district').val();
                var upa_id = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                var org_type_code = $('#org_type').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organization_list.php',
                    data: {
                        div_id: div_id,
                        dis_id: dis_id,
                        upa_id: upa_id,
                        agency_code: agency_code,
                        org_type_code: org_type_code
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
        </script>
    </body>
</html>

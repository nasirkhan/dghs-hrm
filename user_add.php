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


$insert_success = FALSE;
if (isset($_GET['insert_success'])){
    $insert_success = mysql_real_escape_string($_GET['insert_success']);
}

$error = "";
if (isset($_POST['new_user_type']) && $_POST['new_post_type'] == "user") {
    // if " new_user_type " == " Super Admin "
    // @TODO restructure the User table, include user_type info
    $new_user_name = mysql_real_escape_string($_POST['new_user_name']);
    $new_user_email = mysql_real_escape_string($_POST['new_user_email']);
    $new_user_pass = mysql_real_escape_string($_POST['new_user_pass']);
    $new_user_pass2 = mysql_real_escape_string($_POST['new_user_pass2']);
    $new_user_mobile = mysql_real_escape_string($_POST['new_user_mobile']);

    /**
     * super admin user
     */
    if ($_POST['new_user_type'] == "admin"){
        $new_user_org_code = '';
        $new_user_type = "admin";
    }

    /**
     * organization user
     */
    if ($_POST['new_user_type'] == "user"){
        $new_user_org_code = mysql_real_escape_string($_POST['org_list']);
        $new_user_type = "user";
    }



    if ($new_user_pass != $new_user_pass2) {
        $error = "Password did not matched.";
    }
    if(isUserExists($new_user_name)){
        $error = "This username '$new_user_name' already exists. Please use another one.";    
    }
    
    
    if ($error == "") {
        /**
         * Add new user | database update function
         */
        if(addNewUser($new_user_name, $new_user_email, $new_user_pass, $new_user_type, $new_user_org_code, $new_user_mobile)){
            header("location:user_add.php?insert_success=true");
        }        
    }
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
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- main
                    ================================================== -->
                    <section id="add-new">
                        <h3>Add new User</h3>
                        <?php if ($insert_success): ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                &nbsp;<br />
                                <h4>New information has been successfully added to the database.</h4>
                                &nbsp;<br />
                            </div>
                        <?php endif; ?>
                        <?php if ($error != ""): ?>
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                &nbsp;<br />
                                <h4><?php echo $error; ?></h4>
                                &nbsp;<br />
                            </div>
                        <?php endif; ?>


                        <!--Add new user-->

                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="control-group">
                                <label class="control-label" for="new_user_name">UserName</label>
                                <div class="controls">
                                    <input type="text" id="new_user_name" name="new_user_name" placeholder="User Name" required="">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="new_user_email">Email Address</label>
                                <div class="controls">
                                    <input type="text" id="new_user_email" name="new_user_email" placeholder="Email Address" required="" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="new_user_mobile">Mobile Number</label>
                                <div class="controls">
                                    <input type="text" id="new_user_mobile" name="new_user_mobile" placeholder="Mobile Number" required="" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="new_user_pass">Password</label>
                                <div class="controls">
                                    <input type="password" id="new_user_pass" name="new_user_pass" placeholder="Password" required="" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="new_user_pass2">Retype Password</label>
                                <div class="controls">
                                    <input type="password" id="new_user_pass2" name="new_user_pass2" placeholder="Retype Password" required="" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="new_user_type">User Type</label>
                                <div class="controls">
                                    <select id="new_user_type" name="new_user_type"  required="">
                                        <option value="0">Select User Type</option>
                                        <option value="user">Organization User</option>
                                        <option value="admin">Super Admin</option>                                        
                                    </select>
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
                                    <button type="submit" class="btn btn-info">Add New User</button>
                                </div>
                            </div>
                        </form>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <!-- Javascript
        ================================================== -->
        <script type="text/javascript">            

            $("#new_user_type").change(function() {
                var selectedType = $("#new_user_type").val();
                if (selectedType === "user") {
                    $("#new_admin_org_code").hide();
                    $("#org_select_block").slideDown();
                } else if (selectedType === "admin") {
                    $("#org_select_block").hide();
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

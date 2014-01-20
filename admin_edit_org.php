<?php
require_once 'configuration.php';

/**
 * PHP Email Configuration
 */
$to = 'asm.sayem@mis.dghs.gov.bd, sukhendu@mis.dghs.gov.bd , dr.bashar@mis.dghs.gov.bd , zillur@mis.dghs.gov.bd , rajib@mis.dghs.gov.bd , nasir.khan@activationltd.com , mahfuzur@mis.dghs.gov.bd , prince@mis.dghs.gov.bd , linkon@mis.dghs.gov.bd';
//$to  = "nasir8891@gmail.com";
// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "To: $to \r\n";


//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$user_name = $_SESSION['username'];

$echoAdminInfo = "";
$action = "";

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

$id = (int) mysql_real_escape_string($_POST['id']);
$action = mysql_real_escape_string($_POST['action']);

if (isset($_POST['id']) && isset($_POST['action'])) {
    if ($action == "approve") {
        // UPDATE organization_requested
        updateOrgRequest($id);

        // GET organizaion data
        $data = getOrgInfoFromOrganizationRequestTable($id);
        
        // Insect new organization
        $new_org_code = insertNewOrganization($data);
        $new_org_name = getOrgNameFormOrgCode($new_org_code);
        
        if ($data['org_type_code'] == 1039){
            // Add Sanctioned Post
            addCommunityClinicSanctionedPost($new_org_code);

            // Add new user 
            $new_user_name = $data['email_address1'];
            $new_user_email = $data['email_address1'];
            $new_user_pass = "dghs123";
            $new_user_type = "user";
            $new_user_org_code = $new_org_code;
            $new_user_mobile = $data['mobile_number1'];
            if (addNewUser($new_user_name, $new_user_email, $new_user_pass, $new_user_type, $new_user_org_code, $new_user_mobile)){
                $action_text = "User Created!";
            } else {
                $action_text = "No user created!";
            }
        }
        
        /**
         * Email content
         *
         */
        $headers .= "From: MIS, DGHS <info@dghs.gov.bd>" . "\r\n";
        $subject = "[Org Registry] Request for \"$new_org_name\" has been Approved";
        $message = "'$new_org_name' has been approved by '$user_name'. <br />"
                . "View the profile from the following URL <br />'$hrm_root_dir/org_profile.php?org_code=$new_org_code'<br /><br /><br />";
        $message .= "<table>";
        $message .= "<tr><td>Organization Name</td>" . "<td>$new_org_name</td></tr>";
        $message .= "<tr><td>Organization Type</td>" . "<td>" . getOrgTypeNameFormOrgTypeCode($new_org_type) . "</td></tr>";
        $message .= "<tr><td>Ownarship</td>" . "<td>" . getOrgOwnarshioNameFromCode($new_ownarship_info) . "</td></tr>";
        $message .= "<tr><td>Agency Name</td>" . "<td>" . getAgencyNameFromAgencyCode($new_agency_code) . "</td></tr>";
        $message .= "<tr><td>Organization Function</td>" . "<td>" . getOrgFunctionNameFromCode($new_functions_code) . "</td></tr>";
        $message .= "<tr><td>Level Name</td>" . "<td>" . $new_org_level_name . "</td></tr>";
        $message .= "<tr><td>Year Established</td>" . "<td>" . $year_established . "</td></tr>";
        $message .= "<tr><td>Organization Location</td>" . "<td>" . $org_location . "</td></tr>";
        $message .= "<tr><td>Division Name</td>" . "<td>" . $division_name . "</td></tr>";
        $message .= "<tr><td>District Name</td>" . "<td>" . $district_name . "</td></tr>";
        $message .= "<tr><td>Upazila Name</td>" . "<td>" . $upazila_name . "</td></tr>";
        $message .= "<tr><td>Latitude</td>" . "<td>" . $latitude . "</td></tr>";
        $message .= "<tr><td>Longitude</td>" . "<td>" . $longitude . "</td></tr>";
        $message .= "<tr><td>Contact</td>" . "<td>" . $new_org_mobile . "</td></tr>";
        $message .= "<tr><td>Email</td>" . "<td>" . $new_org_email . "</td></tr>";
        $message .= "</table>";
        $message .= "<br /><br />Application submitted on: " . date("Y-m-d H:i:s");
        // send mail
        mail($to, $subject, $message, $headers);
    } else if ($action == "reject") {
        $sql = "UPDATE organization_requested "
                . "SET "
                . "active='0', "
                . "approved_rejected_by='$user_name', "
                . "approved_rejected='rejected', "
                . "updated_by='$user_name' "
                . "WHERE "
                . "id=$id";
        $r = mysql_query($sql) or die(mysql_error() . "<p>Code:sql:4<br /><br /><b>Query:</b><br />___<br />$sql</p>");

        // GET organizaion data
        $sql = "SELECT * FROM `organization_requested` WHERE id=$id";
        $r = mysql_query($sql) or die(mysql_error() . "<p>Code:sql:2<br /><br /><b>Query:</b><br />___<br />$sql</p>");

        $data = mysql_fetch_assoc($r);

        $new_org_name = $data['org_name'];
        $last_org_code = (int) getLastOrgIdFromOrganizationTable();
        $new_org_code = $last_org_code + 1;
        $new_org_type = $data['org_type_code'];
        $new_agency_code = $data['agency_code'];
        $new_established_year = $data['year_established'];
        $org_location_type = $data['org_location_type'];
        $division_code = $data['division_code'];
        $division_name = $data['division_name'];
        $district_code = $data['district_code'];
        $district_name = $data['district_name'];
        $upazila_code = $data['upazila_thana_code'];
        $upazila_name = $data['upazila_thana_name'];
        $new_ownarship_info = $data['ownership_code'];
        $new_org_email = $data['email_address1'];
        $new_functions_code = $data['org_function_code'];
        $new_org_level_code = $data['org_level_code'];
        $new_org_level_name = $data['org_level_name'];
        $new_org_mobile = $data['mobile_number1'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        /**
         * Email content
         *
         */
        $headers .= "From: MIS, DGHS <info@dghs.gov.bd>" . "\r\n";
        $subject = "[Org Registry] Request for \"$new_org_name\" has been Rejected";
        $message = "'$new_org_name' has been Rejected by '$user_name'. <br /><br /><br />";
        $message .= "<table>";
        $message .= "<tr><td>Organization Name</td>" . "<td>$new_org_name</td></tr>";
        $message .= "<tr><td>Organization Type</td>" . "<td>" . getOrgTypeNameFormOrgTypeCode($new_org_type) . "</td></tr>";
        $message .= "<tr><td>Ownarship</td>" . "<td>" . getOrgOwnarshioNameFromCode($new_ownarship_info) . "</td></tr>";
        $message .= "<tr><td>Agency Name</td>" . "<td>" . getAgencyNameFromAgencyCode($new_agency_code) . "</td></tr>";
        $message .= "<tr><td>Organization Function</td>" . "<td>" . getOrgFunctionNameFromCode($new_functions_code) . "</td></tr>";
        $message .= "<tr><td>Level Name</td>" . "<td>" . $new_org_level_name . "</td></tr>";
        $message .= "<tr><td>Year Established</td>" . "<td>" . $year_established . "</td></tr>";
        $message .= "<tr><td>Organization Location</td>" . "<td>" . $org_location . "</td></tr>";
        $message .= "<tr><td>Division Name</td>" . "<td>" . $division_name . "</td></tr>";
        $message .= "<tr><td>District Name</td>" . "<td>" . $district_name . "</td></tr>";
        $message .= "<tr><td>Upazila Name</td>" . "<td>" . $upazila_name . "</td></tr>";
        $message .= "<tr><td>Latitude</td>" . "<td>" . $latitude . "</td></tr>";
        $message .= "<tr><td>Longitude</td>" . "<td>" . $longitude . "</td></tr>";
        $message .= "<tr><td>Contact</td>" . "<td>" . $new_org_mobile . "</td></tr>";
        $message .= "<tr><td>Email</td>" . "<td>" . $new_org_email . "</td></tr>";
        $message .= "</table>";
        $message .= "<br /><br />Application submitted on: " . date("Y-m-d H:i:s");
        // send mail
        mail($to, $subject, $message, $headers);

        header("location:admin_home.php");
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
                    <!-- admin home
                    ================================================== -->
                    <section id="admin_home_main">
                        <h3>Admin Dashboard</h3>
                        <?php if ($action == "approve"): ?>
                            <div class="alert">
                                <p class="lead">                                    
                                    <a href="admin_edit_org.php" class="btn btn-info pull-right">Go back to the approval queue.</a>
                                </p>
                                <p class="lead">
                                    <strong><?php echo "$new_org_name"; ?></strong> has been approved and you can view the
                                    profile from the following URL <em><a href="org_profile.php?org_code=<?php echo "$new_org_code"; ?>">org_profile.php?org_code=<?php echo "$new_org_code"; ?></a></em>
                                </p>
                                <p class="lead">
                                    
                                    <?php echo $action_text; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <?php
                        $id = (int) mysql_real_escape_string(trim($_GET['id']));
                        // if there is an ID mentioned, the details of that ID will be displayed.

                        if ($id > 0):
                            $sql = "SELECT * FROM `organization_requested` WHERE id=$id AND active LIKE 1;";
                            $new_org_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:sql:1<br /><br /><b>Query:</b><br />___<br />$sql<br />");

                            $new_org_result_count = mysql_num_rows($new_org_result);

                            $count = 0;
                                ?>
                            <?php
                            if ($new_org_result_count > 0):
                                $count++;
                                ?>
                                <div class="row-fluid">
                                    <div class="spa12">
                                        <p class="lead">Organizations Pending for approval</p>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <?php $data = mysql_fetch_assoc($new_org_result); ?>
                                                <tr>
                                                    <td width="40%"><strong>Submission Id</strong></td>
                                                    <td width="60%"><?php echo $data['id']; ?></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="40%"><strong>Organization Name</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="org_name" ><?php echo $data['org_name']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Organization Type</strong></td>
                                                    <td width="60%"><a href="#" class="" id="org_type_code" ><?php echo getOrgTypeNameFormOrgTypeCode($data['org_type_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Agency</strong></td>
                                                    <td width="60%"><a href="#" class="" id="agency_code" ><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Year Established</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="year_established" ><?php echo $data['year_established']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Urban/Rural Location</strong></td>
                                                    <td width="60%"><a href="#" class="" id="org_location_type" ><?php echo getOrgLocationTypeFromCode($data['org_location_type']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Division</strong></td>
                                                    <td width="60%"><a href="#" class="" id="division_code" ><?php echo getDivisionNamefromCode($data['division_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>District</strong></td>
                                                    <td width="60%"><a href="#" class="" id="district_code" ><?php echo getDistrictNamefromCode($data['district_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Upazila</strong></td>
                                                    <td width="60%"><a href="#" class="" id="upazila_thana_code" ><?php echo getUpazilaNamefromBBSCode($data['upazila_thana_code'], $data['district_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Ownarship</strong></td>
                                                    <td width="60%"><a href="#" class="" id="ownership_code" ><?php echo getOrgOwnarshioNameFromCode($data['ownership_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Organization Function</strong></td>
                                                    <td width="60%"><a href="#" class="" id="org_function_code" ><?php echo getOrgFunctionNameFromCode($data['org_function_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Organization Level</strong></td>
                                                    <td width="60%"><a href="#" class="" id="org_level_code" ><?php echo getOrgLevelNamefromCode($data['org_level_code']); ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Organization Email</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="email_address1" ><?php echo $data['email_address1']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Organization Contact Number</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="latitude" ><?php echo $data['mobile_number1']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Latitude</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="latitude" ><?php echo $data['latitude']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><strong>Longitude</strong></td>
                                                    <td width="60%"><a href="#" class="input-text" id="longitude" ><?php echo $data['longitude']; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <div class="pull-left">
                                                            <form method="post" action="">
                                                                <input name="id" value="<?php echo $data['id']; ?>" type="hidden" />
                                                                <input name="action" value="reject" type="hidden" />
                                                                <button class="btn btn-danger" type="submit">Reject</button>
                                                            </form>
                                                        </div>
                                                        <div class="pull-left">
                                                            <form method="post" action="">
                                                                <input name="id" value="<?php echo $data['id']; ?>" type="hidden" />
                                                                <input name="action" value="approve" type="hidden" />
                                                                <button class="btn btn-success" type="submit">Approve</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php elseif (!$id > 0): ?>
                            <?php
                            $sql = "SELECT * FROM `organization_requested` WHERE active LIKE 1;";
                            $new_org_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:sql:5<br /><br /><b>Query:</b><br />___<br />$sql<br />");

                            $new_org_result_count = mysql_num_rows($new_org_result);

                            $count = 0;
                            if (!$new_org_result_count > 0):
                            ?>
                            <div class="alert alert-info">
                                <p class="lead">
                                    No pending request.
                                </p>
                            </div>
                            <?php endif; ?>
                            <?php
                            if ($new_org_result_count > 0):
                                ?>
                                <div class="row-fluid">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                </div>
                                <div class="row-fluid">
                                    <div class="spa12">
                                        <p class="lead">Organizations Pending for approval</p>
                                        <table id="org_request_table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <td><strong>#</strong></td>
                                                    <td><strong>Org Name</strong></td>
                                                    <td><strong>Agency</strong></td>
                                                    <td><strong>Ownarship</strong></td>
                                                    <td><strong>Division</strong></td>
                                                    <td><strong>District</strong></td>
                                                    <td><strong>Upazila</strong></td>
                                                    <td><strong>Requested on</strong></td>
                                                    <td><strong>Action</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($data = mysql_fetch_assoc($new_org_result)):
                                                    $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $data['org_name']; ?></td>
                                                        <td><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></td>
                                                        <td><?php echo getOrgOwnarshioNameFromCode($data['ownership_code']); ?></td>
                                                        <td><?php echo $data['division_name']; ?></td>
                                                        <td><?php echo $data['district_name']; ?></td>
                                                        <td><?php echo $data['upazila_thana_name']; ?></td>
                                                        <td><?php echo $data['updated_datetime']; ?></td>
                                                        <td>
                                                            <a class="btn  btn-info" href="admin_edit_org.php?id=<?php echo $data['id']; ?>">View / Edit</a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </section> <!-- /admin_home_main -->
                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        <script>
            $(document).ready(function() {
                $('#org_request_table').dataTable();
            });</script>

        
        <script>
            $.fn.editable.defaults.mode = 'inline';

            var submission_id = <?php echo $id; ?>;

            var org_code = <?php echo $_SESSION['org_code']; ?>
            
            $(function() {
                $('a.input-text').editable({
                    type: 'text',
                    pk: submission_id,
                    url: 'post/post_new_org.php'
                });
            });

            //division_name
            $(function() {
                $('#division_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_division_name.php'
                });
            });

            //district
            $(function() {
                $('#district_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_district_name.php'
                });
            });

            //upazila name
            $(function() {
                $('#upazila_thana_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_upazila_thana_name.php'
                });
            });

            // org_type_code
            $(function() {
                $('#org_type_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_type_name.php'
                });
            });

            //agency_code
            $(function() {
                $('#agency_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_agency_code.php'
                });
            });

            // org_location_type
            $(function() {
                $('#org_location_type').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_location_type.php'
                });
            });

            // org ownarship code
            $(function() {
                $('#ownership_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_ownership.php'
                });
            });
            //org_function_code
            $(function() {
                $('#org_function_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_function_code.php'
                });
            });

            // organizaion level code
            $(function() {
                $('#org_level_code').editable({
                    type: 'select',
                    pk: submission_id,
                    url: 'post/post_new_org.php',
                    source: 'get/get_org_level_code.php'
                });
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


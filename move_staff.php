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
$action = mysql_real_escape_string($_GET['action']);
$staff_id = mysql_real_escape_string($_GET['staff_id']);

if ($staff_id > 0) {
    $sanctioned_post_id = getSanctionedPostIdFromStaffId($staff_id);
    $staff_name = getStaffNameFromId($staff_id);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Nasir Khan Saikat(nasir8891@gmail.com)">

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

        <style type="text/css">
            .padding_up_down{
                padding: 20px 0px 20px 0px;
            }
        </style>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
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

            <!-- Docs nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php if ($_SESSION['user_type'] == "admin"): ?>
                            <li><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-qrcode"></i> Admin Homepage</a>
                            <?php endif; ?>
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li class="active"><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-copy"></i> Match Employee</a></li>		
                        <li><a href="upload.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-upload-alt"></i> Upload</a></li>
                        <!--<li><a href="search.php"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>-->
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>		
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- main
                    ================================================== -->
                    <section id="move-options">
                        <h3>Move Request</h3>

                        <!--if action is not defined -->
                        <?php if ($action == ""): ?>
                            <table class="table table-striped table-hover">                            
                                <tbody>
                                    <tr>
                                        <td><a href="#">Promotion</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="move_staff.php?action=move_out&org_code=<?php echo "$org_code"; ?>">Transfer (Move Out)</a></td>
                                        <td><em>Request transfer of an staff form this organization to some other organization</em></td>
                                    </tr>
                                    <tr>
                                        <td><a href="move_staff.php?action=move_in&org_code=<?php echo "$org_code"; ?>">Transfer (Move In)</a></td>
                                        <td><em>Request transfer of an staff form another organization to this organization</em></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Retirement</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Suspension</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Termination</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Death</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Leaving Job</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Unauthorized absent</a></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Leave</a></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php elseif ($action == "move_out"):
                            ?>
                            <div id="move_out_main">
                                <div class="alert alert-info">
                                    <h4>Transfer (Move Out)</h4>                                
                                </div>
                                <?php if (!$staff_id > 0): ?>
                                    <?php
                                    $sql = "SELECT
                                    old_tbl_staff_organization.staff_id,
                                    old_tbl_staff_organization.sanctioned_post_id,
                                    old_tbl_staff_organization.designation_id,
                                    old_tbl_staff_organization.department_id,
                                    old_tbl_staff_organization.staff_name,
                                    old_tbl_staff_organization.father_name
                                FROM
                                    old_tbl_staff_organization
                                WHERE
                                    old_tbl_staff_organization.org_code = $org_code
                                ORDER BY
                                    old_tbl_staff_organization.staff_name ASC";
                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                    ?>

                                    <table id="staff_list" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Dept</th>
                                                <th>Designation</th>
                                                <th>Pay scale</th>
                                                <th>Class</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($data = mysql_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><a href="employee.php?staff_id=<?php echo $data['staff_id']; ?>"><?php echo $data['staff_name']; ?></a></td>
                                                    <td><?php echo getDeptNameFromId($data['department_id']); ?></td>
                                                    <?php
                                                    $designation_info = getDesignationInfoFromCode($data['designation_id']);
                                                    ?>
                                                    <td><?php echo $designation_info['designation']; ?></td>
                                                    <td><?php echo $designation_info['payscale']; ?></td>
                                                    <td><?php echo $designation_info['class']; ?></td>
                                                    <td><a href="move_staff.php?action=move_out&staff_id=<?php echo $data['staff_id']; ?>">Move Out</a></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <!--move_out_step1-->
                                    <div id="move_out_step1">
                                        <p class="lead">
                                            Move out request for :<br /> 
                                            <strong><a href="employee.php?staff_id=<?php echo $staff_id; ?>"><?php
                                                    echo "$staff_name (Staff Id: $staff_id)"
                                                    ?></a></strong>
                                            <br />
                                            <em>Select the new designation</em>
                                        </p>
                                        <div class="">                                            
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
                                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                    while ($rows = mysql_fetch_assoc($result)) {
                                                        echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <select id="org_list" name="org_list">
                                                    <option value="0">Select Organization</option>                                        
                                                </select>
                                                <select id="sanctioned_post" name="sanctioned_post">
                                                    <option value="0">Select Designation</option>                                        
                                                </select>

                                            </div>

                                            <div class="control-group">
                                                <button id="move_out_continue" type="button" class="btn btn-primary">Continue Move Out Request</button>

                                                <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                            </div>
                                            <div id="move_out_continue_details" class="alert alert-Warnign" style="display:none;">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="3"><strong><?php echo $staff_name; ?></strong></td>                                                
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>Organization</td>
                                                        <td>Designation</td>
                                                    </tr>
                                                    <tr class="error">
                                                        <td>Present</td>
                                                        <td><?php echo $org_name ?></td>
                                                        <td><?php echo getDesignationNameFormStaffId($staff_id); ?></td>
                                                    </tr>
                                                    <tr class="success">
                                                        <td>Move to</td>
                                                        <td><span id="mv_to_org"></span></td>
                                                        <td><span id="mv_to_des"></span></td>
                                                    </tr>
                                                </table>
                                                <form class="form-horizontal" action="move_staff_step_2.php" method="post" >
                                                    <div class="control-group">
                                                        <label class="control-label" for="govt_order">Memo No.:</label>
                                                        <div class="controls">
                                                            <input type="text" id="govt_order" name="govt_order" placeholder="Memo Number" autofocus="">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="comment">(Please mention the attachment if any): </label>
                                                        <div class="controls">
                                                            <textarea id="attachments" name="attachments" rows="3">Not Applicable</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">                                                        
                                                        request_submitted_by
                                                        <input type="text" id="request_submitted_by" name="request_submitted_by" value="<?php echo $_SESSION['username']; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        org_code
                                                        <input type="text" id="org_code" name="org_code" value="<?php echo $org_code; ?>">
                                                        post_staff_id
                                                        <input type="text" id="post_staff_id" name="post_staff_id" value="<?php echo $staff_id; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        post_mv_from_org
                                                        <input type="text" id="post_mv_from_org" name="post_mv_from_org" value="<?php echo $org_code; ?>">
                                                        post_mv_from_des
                                                        <input type="text" id="post_mv_from_des" name="post_mv_from_des" value="<?php echo $sanctioned_post_id; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        post_mv_to_org
                                                        <input type="text" id="post_mv_to_org" name="post_mv_to_org" value="">
                                                        post_mv_to_des
                                                        <input type="text" id="post_mv_to_des" name="post_mv_to_des" value="">
                                                    </div>

                                                    <button type="submit" class="btn btn-warning">Confirm Move Out Request</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            </div>
                            <!--</section>-->

                        <?php elseif ($action == "move_in"): ?>

                            <div id="move_in_main">
                                <div class="alert alert-info">
                                    <h4>Transfer (Move In)</h4>                                
                                </div>
                                <?php if (!$staff_id > 0): ?>
                                    <div id="move_in_step1">
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
                                        <div class="">
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
                                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                    while ($rows = mysql_fetch_assoc($result)) {
                                                        echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <select id="org_list" name="org_list">
                                                    <option value="0">Select Organization</option>                                        
                                                </select>
                                                <select id="sanctioned_post" name="sanctioned_post">
                                                    <option value="0">Select Designation</option>                                        
                                                </select>

                                            </div>

                                            <div class="control-group">
                                                <button id="show_employee" type="button" class="btn btn-primary">Show Employee List</button>

                                                <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                            </div>                                        
                                        </div>
                                        <div id="employee_list"></div>
                                    </div>
                                <?php else: ?>
                                    <div id="move_in_step2">
                                        <p class="lead">
                                            Move In request for:
                                            <br />
                                            <a href="employee.php?staff_id=<?php echo "$staff_id"; ?>"><?php echo "$staff_name (Staff Id: $staff_id)"; ?></a>
                                            <br />
                                            <em>Select the new designation</em>

                                            <select id="move_in_des_select" name="move_in_des_select" class="input-block-level">
                                                <option value="0">Select the destination designation</option>
                                                <?php
                                                $sql = "SELECT
                                                    total_manpower_imported_sanctioned_post_copy.id,
                                                    total_manpower_imported_sanctioned_post_copy.designation,
                                                    total_manpower_imported_sanctioned_post_copy.designation_code,
                                                    total_manpower_imported_sanctioned_post_copy.sanctioned_post_group_code
                                                    FROM
                                                    total_manpower_imported_sanctioned_post_copy
                                                    WHERE 
                                                    org_code = $org_code
                                                    GROUP BY
                                                    total_manpower_imported_sanctioned_post_copy.sanctioned_post_group_code 
                                                    ";
                                                $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                while ($data = mysql_fetch_assoc($result)) {
                                                    echo "<option value=\"" . $data['sanctioned_post_group_code'] . "\">" . $data['designation'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            
                                        <div id="load_sanctionedPost" >
                                            
                                        </div>
                                        </p>
                                        <div class="control-group">
                                            <button id="move_in_continue" type="button" class="btn btn-primary">Continue Move In Request</button>

                                            <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                                        </div>
                                        <div id="move_in_continue_details" class="alert alert-Warnign" style="display:none;">
                                            <table class="table">
                                                <tr>
                                                    <td colspan="3"><strong><?php echo $staff_name; ?></strong></td>                                                
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Organization</td>
                                                    <td>Designation</td>
                                                </tr>
                                                <tr class="error">
                                                    <td>Present</td>                                                    
                                                    <td><span id="mv_from_org"></span></td>
                                                    <td><span id="mv_from_des"></span></td>
                                                </tr>
                                                <tr class="success">
                                                    <td>Move to</td>
                                                    <td><span id="mv_to_org"></span></td>
                                                    <td><span id="mv_to_des"></span></td>
                                                </tr>
                                            </table>
<!--                                            <form class="form-horizontal">
                                                <div class="control-group">
                                                    <label class="control-label" for="govt_order">Memo No.:</label>
                                                    <div class="controls">
                                                        <input type="text" id="govt_order" placeholder="Memo Number">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="comment">(Please mention the attachment if any): </label>
                                                    <div class="controls">
                                                        <textarea id="comment" rows="3">Not Applicable</textarea>
                                                    </div>
                                                </div>

                                            </form>-->
                                            <form class="form-horizontal" action="move_staff_step_2.php" method="get" >
                                                    <div class="control-group">
                                                        <label class="control-label" for="govt_order">Memo No.:</label>
                                                        <div class="controls">
                                                            <input type="text" id="govt_order" name="govt_order" placeholder="Memo Number" autofocus="">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="comment">(Please mention the attachment if any): </label>
                                                        <div class="controls">
                                                            <textarea id="attachments" name="attachments" rows="3">Not Applicable</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">                                                        
                                                        request_submitted_by
                                                        <input type="text" id="request_submitted_by" name="request_submitted_by" value="<?php echo $_SESSION['username']; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        org_code
                                                        <input type="text" id="org_code" name="org_code" value="<?php echo $org_code; ?>">
                                                        post_staff_id
                                                        <input type="text" id="post_staff_id" name="post_staff_id" value="<?php echo $staff_id; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        post_mv_from_org
                                                        <input type="text" id="post_mv_from_org" name="post_mv_from_org" value="">
                                                        post_mv_from_des
                                                        <input type="text" id="post_mv_from_des" name="post_mv_from_des" value="<?php echo $sanctioned_post_id; ?>">
                                                    </div>
                                                    <div class="control-group">
                                                        post_mv_to_org
                                                        <input type="text" id="post_mv_to_org" name="post_mv_to_org" value="<?php echo $org_code; ?>">
                                                        post_mv_to_des
                                                        <input type="text" id="post_mv_to_des" name="post_mv_to_des" value="">
                                                    </div>

                                                    <button type="submit" class="btn btn-warning">Confirm Move In Request</button>
                                                </form>
                                            <!--<button id="move_in_confirm" type="button" class="btn btn-warning">Confirm Move In Request</button>-->
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>
                    </section> <!-- /move-options -->

                </div> <!-- /main -->
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

        <script src="library/dataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>
        <script src="library/dataTables-1.9.4/media/js/paging.js"></script>

        <script type="text/javascript">
            /* Table initialisation */
            $(document).ready(function() {
                $('#staff_list').dataTable({
                    "sDom": "<'row'<'span5'l><'span4'f>r>t<'row'<'span4'i><'span5'p>>",
                    "sPaginationType": "bootstrap"
                });
            });

            $.extend($.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper form-inline",
                "sSortAsc": "header headerSortDown",
                "sSortDesc": "header headerSortUp",
                "sSortable": "header"
            });

            // division
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

            // district 
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
            $('#org_agency').change(function() {
                $("#loading_content").show();
                var div_id = $('#admin_division').val();
                var dis_id = $('#admin_district').val();
                var upa_id = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organization_list.php',
                    data: {
                        div_id: div_id,
                        dis_id: dis_id,
                        upa_id: upa_id,
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
                var organization_id = $('#org_list').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_designation_list.php',
                    data: {
                        organization_id: organization_id
                    },
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

            // load move_out_continue 
            $('#move_out_continue').click(function() {
                $("#move_out_continue_details").slideDown();
                var mv_to_org = $("#org_list option:selected").text();
                $("#mv_to_org").html(mv_to_org);

                var mv_to_des = $("#sanctioned_post option:selected").text();
                $("#mv_to_des").html(mv_to_des);

                document.getElementById("post_mv_to_org").value = $("#org_list option:selected").val();

                document.getElementById("post_mv_to_des").value = $("#sanctioned_post option:selected").val();
            });

            //move_out_confirm
//            $('#move_out_confirm').click(function() {
//                var post_mv_to_org = document.getElementById("post_mv_to_org");
//                post_mv_to_org.value = $("#org_list option:selected").val();
//                
//                var post_mv_to_des = document.getElementById("post_mv_to_des");
//                post_mv_to_des.value = $("#sanctioned_post option:selected").val();
//            });

            // load employee 
            $('#show_employee').click(function() {
                var organization_id = $('#org_list').val();
                var designation_id = $('#sanctioned_post').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_employee_list.php',
                    data: {
                        org_code: <?php echo $org_code; ?>,
                        organization_id: organization_id,
                        designation_id: designation_id
                    },
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#employee_list").html(data);
                    }
                });
            });

            // load move_in_continue 
            $('#move_in_continue').click(function() {
                $("#move_in_continue_details").slideDown();

                var mv_from_org = "<?php if ($sanctioned_post_id > 0) echo getOrgNameFormSanctionedPostId($sanctioned_post_id) ?>";
                $("#mv_from_org").html(mv_from_org);

                var mv_from_des = "<?php if ($staff_id > 0) echo getDesignationNameFormStaffId($staff_id); ?>";
                $("#mv_from_des").html(mv_from_des);

                var mv_to_org = "<?php echo $org_name ?>";
                $("#mv_to_org").html(mv_to_org);

                var mv_to_des = $("#move_in_sanctioned_post option:selected").text();
                $("#mv_to_des").html(mv_to_des);
                
                document.getElementById("post_mv_from_org").value = "<?php echo $_GET['org_code']; ?>";

                document.getElementById("post_mv_from_des").value = "<?php if ($staff_id > 0) echo getSanctionedPostIdFromStaffId($staff_id); ?>";
                
                document.getElementById("post_mv_to_org").value = "<?php echo $org_code; ?>";

                document.getElementById("post_mv_to_des").value = $("#move_in_sanctioned_post").val();
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
            
            //reset search field
            $("#btn_reset").click(function() {
                $("#staff_list_display").html("");
            });
            
            // load sanctioned post based on designaion selection
            $("#move_in_des_select").change(function (){
                $("#loading_content").show();
                var des_group = $("#move_in_des_select").val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_sanctioned_post_from_designation.php',
                    data: {des_group:des_group, org_code: <?php echo "$org_code"; ?>},
                    success: function(data) {
                        $("#loading_content").hide();
                        $("#load_sanctionedPost").html("");
                        $("#load_sanctionedPost").html(data);
                    }
                });
            });
        </script>
    </body>
</html>

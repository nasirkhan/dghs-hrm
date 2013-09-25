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

//GET values
$staff_id = (int) mysql_real_escape_string($_GET['staff_id']);
$sanctioned_post_id = (int) mysql_real_escape_string($_GET['sanctioned_post_id']);
$action = mysql_real_escape_string($_GET['action']);

if ($sanctioned_post_id != "") {
    $temp = checkStaffExistsBySanctionedPost($sanctioned_post_id);
    $staff_exists = $temp['exists'];
    $staff_id = $temp['staff_id'];
    $staff_profile_exists = checkStaffProfileExists($staff_id);

    $sanctioned_post_within_org = checkSanctionedPostWithinOrgFromSanctionedPostId($sanctioned_post_id, $org_code);

    $designation = getDesignationNameFormSanctionedPostId($sanctioned_post_id);
} else if ($staff_id != "") {
    $staff_exists = checkStaffExists($staff_id);
    $staff_profile_exists = checkStaffProfileExists($staff_id);
    $designation = getDesignationNameFormStaffId($staff_id);
    $sanctioned_post_id = getSanctionedPostIdFromStaffId($staff_id);
}

$staff_org_code = getOrgCodeFromStaffId($staff_id);

$userCanEdit = FALSE;
if ($_SESSION['user_type'] == 'admin') {
    $userCanEdit = TRUE;
}
if ($staff_org_code == $org_code) {
    $userCanEdit = TRUE;
}
if ($sanctioned_post_within_org) {
    $userCanEdit = TRUE;
}


// set staff display mode
//if ($staff_exists && !$userCanEdit) {
//    $display_mode = "view"; 
//    
//    // data fetched form staff table
//    $data = getStaffInfoFromStaffId($staff_id);    
//    
//} else if ($staff_exists && $userCanEdit) {
//    $display_mode = "edit";
//    
//    // data fetched form staff table
//    $data = getStaffInfoFromStaffId($staff_id);
//    
//} else if ($action == "new" && $userCanEdit) {
//    if ($sanctioned_post_id != "") {
//        
//    }
//    $display_mode = "new";
//}
// Set Staff profile Display mode
if (!$userCanEdit && $staff_profile_exists) {
    $display_mode = "view";

    // data fetched form staff table
    $data = getStaffInfoFromStaffId($staff_id);
} else if ($staff_profile_exists && $userCanEdit) {
    $display_mode = "edit";

    // data fetched form staff table
    $data = getStaffInfoFromStaffId($staff_id);
} else if ($action == "new" && $userCanEdit) {
    if ($sanctioned_post_id != "") {
        
    }
    $display_mode = "new";
}

// staff search option
if (isset($_POST['search'])) {
    $search_string = mysql_real_escape_string($_POST['search']);
    $sql = "SELECT
                old_tbl_staff_organization.staff_id
            FROM
                `old_tbl_staff_organization`
            WHERE
                old_tbl_staff_organization.staff_name LIKE \"%$search_string%\" OR
                old_tbl_staff_organization.staff_id = \"$search_string\" AND
                old_tbl_staff_organization.org_code = $org_code";
    $s_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>a:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $s_data = mysql_fetch_assoc($s_result);

    if ($s_data['staff_id'] > 0) {
        $staff_id = $s_data['staff_id'];
        header("location:employee.php?staff_id=$staff_id");
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
                        <li class="active"><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="upload.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-upload-alt"></i> Upload</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Download
                    ================================================== -->
                    <section id="organization-profile">

                        <div class="row">
                            <div class="span9">

                                <?php if ($staff_id == "" && $action != "new"): ?>
                                    <div class="alert alert-success">
                                        <div>
                                            If you want to view a specific staff profile, please use the following serchbox to find. <br />
                                            Or, you can find the staff form the <a href="sanctioned_post.php">Sanctioned Post Page</a>.
                                        </div>
                                        <div>
                                            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <div class="input-append">
                                                    <!--<input class="span4" id="org_code" name="org_code" type="hidden" value="<?php echo $org_code; ?>">-->                                                                                                       
                                                    <input class="span4" id="search" name="search" type="text" placeholder="Enter Staff Name or Staff ID" >
                                                    <button class="btn" type="submit" >Search</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="staff_search_main">
                                            <div id="staff_search_input">
                                            
                                            </div>
                                            
                                            <div id="staff_search_result">
                                            
                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>

                                <?php if ($display_mode == "view"): ?>
                                    <table class="table table-striped table-hover" id="employee-profile">
                                        <tr>
                                            <td width="50%"><strong>Organization Name</strong></td>
                                            <td><?php echo $org_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization Code</strong></td>
                                            <td><?php echo $org_code; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Name</strong></td>
                                            <td><?php echo $data['staff_name']; ?></td>
                                        </tr>                                        
                                        <tr>
                                            <td width="50%"><strong><a href="#">Code No.(Doctors Only):</a></strong></td>
                                            <td><?php echo $data['staff_pds_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Department</strong></td>
                                            <td><?php echo getStaffDepertmentFromDepertmentId($data['department_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date of Birth</strong></td>
                                            <td><?php echo $data['birth_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Sex</strong></td>
                                            <td><?php echo getSexNameFromId($data['sex']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Religious Group</strong></td> <!--religion -->
                                            <td><?php echo getReligeonNameFromId($data['religion']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Marital Status</strong></td>
                                            <td><?php echo getMaritalStatusFromId($data['marital_status']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Fathers Name</strong></td> <!--father_name -->
                                            <td><?php echo $data['father_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Mothers Name</strong></td>
                                            <td><?php echo $data['mother_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Email Address</strong></td>
                                            <td><?php echo $data['email_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No.</strong></td>
                                            <td><?php echo $data['contact_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Present Address</strong></td><!-- mailing_address  -->
                                            <td><?php echo $data['mailing_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Permanent Address</strong></td>
                                            <td><?php echo $data['permanent_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Freedom Fighter? </strong></td>
                                            <td><?php echo getFreedomFighterNameFromId($data['freedom_fighter_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Tribal?</strong></td>
                                            <td><?php echo getTribalNameFromId($data['tribal_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Job Class</strong></td>
                                            <td><?php echo getClassNameformId($data['staff_job_class']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Professional Category</strong></td>
                                            <td><?php echo getProfessionalCategoryFromId($data['staff_professional_category']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Designation</strong></td>
                                            <td><?php echo $designation; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Post Type</strong></td>
                                            <td><?php echo getPostTypeFromId($data['post_type_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Posting</strong></td>
                                            <td><?php echo getStaffPostingTypeFormId($data['staff_posting']); ?></td>
                                        </tr>

                                        <tr>
                                            <td width="50%"><strong>Draw Salary from which place:</strong></td> <!-- draw_salary_id-->
                                            <td><?php echo getSalaryDrawNameFromID($data['draw_salary_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Designation Type</strong></td>
                                            <td><?php echo getDesignationTypeNameFromId($data['designation_type_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Posted As</strong></td> <!--job_posting_id-->
                                            <td><?php echo getJobPostingNameFromId($data['job_posting_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Working Status</strong></td>
                                            <td><?php echo getWorkingStatusNameFromId($data['working_status_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Salary drawn from which head:</strong></td><!-- draw_type_id-->
                                            <td><?php echo getDrawTypeNameFromId($data['draw_type_id']); ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Pay Scale of Current Designation</strong></td>
                                            <td><?php echo $data['pay_scale_of_current_designation']; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="50%"><strong>Current Basic Pay (Tk.):</strong></td>
                                            <td><?php echo $data['current_basic_pay_taka']; ?></td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Govt. Health Service</strong></td>
                                            <td><?php echo $data['date_of_joining_to_govt_health_service']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Current Place</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_place']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Current Designation</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_designation']; ?></td>

                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Professional Discipline of Current Designation</strong></td>
                                            <td><?php echo getProfessionalDisciplineNameFromId($data['professional_discipline_of_current_designation']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Education Qualification</strong></td><!--type_of_educational_qualification-->
                                            <td><?php //  echo getEducationalQualification($data['type_of_educational_qualification']);          ?></td>
                                        </tr>

                                        <script>
                                            var type_of_educational_qualification = "[";
                                            type_of_educational_qualification += "<?php echo $data['type_of_educational_qualification']; ?>";
                                            type_of_educational_qualification += "]";
                                        </script>

                                        <tr>
                                            <td width="50%"><strong>Actual Degree</strong></td>
                                            <td><?php echo $data['actual_degree']; ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Designation Id</strong></td>
                                            <td><?php echo getDesignationNameformCode($data['designation_id']); ?></td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td width="50%"><strong>Sanctioned Post ID</strong></td>
                                            <td><?php echo $sanctioned_post_id; ?></td>
                                        </tr>

                                        <tr>
                                            <td width="50%"><strong>Staff ID</strong></td>
                                            <td><?php echo $data['staff_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization Code</strong></td>
                                            <td><?php echo $org_code; ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Posting Status</strong></td>
                                            <td></td>
                                        </tr>
                                      
                                        <tr>
                                            <td width="50%"><strong>Staff Local ID</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_local_id"><?php echo $data['staff_local_id']; ?></a></td>
                                        </tr>  -->
                                        <tr>
                                            <td width="50%"><strong>Reside in Govt. Quarter?</strong></td><!-- govt_quarter_id-->
                                            <td><?php echo getGovtQuarter($data['govt_quarter_id']); ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Job Status</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="job_status" name="job_status"><?php echo $data['job_status']; ?></a></td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td width="50%"><strong>Further Remarks/Explanation:</strong></td><!--reason -->
                                            <td><?php echo $data['reason']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Last Updated On</strong></td>
                                            <td><?php echo $data['last_update']; ?></td>
                                        </tr>

                                    </table>

                                    <?php
                                elseif ($display_mode == "edit"):
                                    ?>
                                    <table class="table table-striped table-hover" id="employee-profile">
                                        <tr>
                                            <td width="50%"><strong>Staff Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_name"><?php echo $data['staff_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization Name</strong></td>
                                            <td><?php echo $org_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong><a href="#">Code No.(Doctors Only):</a></strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_pds_code"><?php echo $data['staff_pds_code']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Department</strong></td>
                                            <td><a href="#" id="department_id"><?php echo getStaffDepertmentFromDepertmentId($data['department_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date of Birth</strong></td>
                                            <td><a href="#" class="date-input" id="birth_date" ><?php echo $data['birth_date']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Sex</strong></td>
                                            <td><a href="#" class="" id="sex" ><?php echo getSexNameFromId($data['sex']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Religious Group</strong></td> <!--religion -->
                                            <td><a href="#" id="religion" name="religion"><?php echo getReligeonNameFromId($data['religion']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Marital Status</strong></td>
                                            <td><a href="#" class="" id="marital_status" ><?php echo getMaritalStatusFromId($data['marital_status']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Fathers Name</strong></td> <!--father_name -->
                                            <td><a href="#" class="text-input" data-type="text" id="father_name"><?php echo $data['father_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Mothers Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="mother_name"><?php echo $data['mother_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Email Address</strong></td>
                                            <td><a href="#" class="text-input" data-type="email" id="email_address" ><?php echo $data['email_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No.</strong></td>
                                            <td><a href="#" class="text-input" id="contact_no" ><?php echo $data['contact_no']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Present Address</strong></td><!-- mailing_address  -->
                                            <td><a href="#" class="date-textarea" id="mailing_address" ><?php echo $data['mailing_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Permanent Address</strong></td>
                                            <td><a href="#" class="date-textarea" id="permanent_address" ><?php echo $data['permanent_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Freedom Fighter? </strong></td>
                                            <td><a href="#" id="freedom_fighter_id" ><?php echo getFreedomFighterNameFromId($data['freedom_fighter_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Tribal?</strong></td>
                                            <td><a href="#" id="tribal_id" ><?php echo getTribalNameFromId($data['tribal_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Job Class</strong></td>
                                            <td><a href="#" id="staff_job_class" ><?php echo getClassNameformId($data['staff_job_class']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Professional Category</strong></td>
                                            <td><a href="#" id="staff_professional_category" ><?php echo getProfessionalCategoryFromId($data['staff_professional_category']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Designation</strong></td>
                                            <td><?php echo $designation; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Post Type</strong></td>
                                            <td><a href="#" class="" id="post_type_id" ><?php echo getPostTypeFromId($data['post_type_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Posting</strong></td>
                                            <td><a href="#" id="staff_posting"><?php echo getStaffPostingTypeFormId($data['staff_posting']); ?></a></td>
                                        </tr>

                                        <tr>
                                            <td width="50%"><strong>Draw Salary from which place:</strong></td> <!-- draw_salary_id-->
                                            <td><a href="#" id="draw_salary_id" ><?php echo getSalaryDrawNameFromID($data['draw_salary_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Designation Type</strong></td>
                                            <td><a href="#" id="designation_type_id" ><?php echo getDesignationTypeNameFromId($data['designation_type_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Posted As</strong></td> <!--job_posting_id-->
                                            <td><a href="#" id="job_posting_id" ><?php echo getJobPostingNameFromId($data['job_posting_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Working Status</strong></td>
                                            <td><a href="#" id="working_status_id" ><?php echo getWorkingStatusNameFromId($data['working_status_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Salary drawn from which head:</strong></td><!-- draw_type_id-->
                                            <td><a href="#" id="draw_type_id" ><?php echo getDrawTypeNameFromId($data['draw_type_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Pay Scale of Current Designation</strong></td>
                                            <td><a href="#" id="pay_scale_of_current_designation" name="pay_scale_of_current_designation"><?php echo getPayScaleId($data['pay_scale_of_current_designation']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Current Basic Pay (Tk.):</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="current_basic_pay_taka" name="current_basic_pay_taka"><?php echo $data['current_basic_pay_taka']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Govt. Health Service</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_govt_health_service" ><?php echo $data['date_of_joining_to_govt_health_service']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Current Place</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_current_place" ><?php echo $data['date_of_joining_to_current_place']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date Of Joining to Current Designation</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_current_designation" ><?php echo $data['date_of_joining_to_current_designation']; ?></a></td>

                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Professional Discipline of Current Designation</strong></td>
                                            <td><a href="#" id="professional_discipline_of_current_designation" name="professional_discipline_of_current_designation"><?php echo getProfessionalDisciplineNameFromId($data['professional_discipline_of_current_designation']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Education Qualification</strong></td><!--type_of_educational_qualification-->
                                            <td><a href="#" id="type_of_educational_qualification" name="type_of_educational_qualification"><?php //  echo getEducationalQualification($data['type_of_educational_qualification']);          ?></a></td>
                                        </tr>

                                        <script>
                                            var type_of_educational_qualification = "[";
                                            type_of_educational_qualification += "<?php echo $data['type_of_educational_qualification']; ?>";
                                            type_of_educational_qualification += "]";
                                        </script>

                                        <tr>
                                            <td width="50%"><strong>Actual Degree</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="actual_degree" name="actual_degree"><?php echo $data['actual_degree']; ?></a></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Designation Id</strong></td>
                                            <td><?php echo getDesignationNameformCode($data['designation_id']); ?></td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td width="50%"><strong>Sanctioned Post ID</strong></td>
                                            <td><?php echo $sanctioned_post_id; ?></td>
                                        </tr>

                                        <tr>
                                            <td width="50%"><strong>Staff ID</strong></td>
                                            <td><?php echo $data['staff_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization Code</strong></td>
                                            <td><?php echo $org_code; ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Posting Status</strong></td>
                                            <td></td>
                                        </tr>
                                      
                                        <tr>
                                            <td width="50%"><strong>Staff Local ID</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_local_id"><?php echo $data['staff_local_id']; ?></a></td>
                                        </tr>  -->
                                        <tr>
                                            <td width="50%"><strong>Reside in Govt. Quarter?</strong></td><!-- govt_quarter_id-->
                                            <td><a href="#" id="govt_quarter_id" name="govt_quarter_id"><?php echo getGovtQuarter($data['govt_quarter_id']); ?></a></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td width="50%"><strong>Job Status</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="job_status" name="job_status"><?php echo $data['job_status']; ?></a></td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td width="50%"><strong>Further Remarks/Explanation:</strong></td><!--reason -->
                                            <td><a href="#" class="text-input" data-type="text" id="reason" name="reason"><?php echo $data['reason']; ?></a> </td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Last Updated On</strong></td>
                                            <td><?php echo $data['last_update']; ?></td>
                                        </tr>

                                    </table>
                                    <?php
                                // add new employee
                                elseif ($display_mode == "new") :
                                    ?>
                                    <form class="form-horizontal" action="<?php echo "employee.php?sanctioned_post_id=$sanctioned_post_id&staff_id=$staff_id"; //echo $_SERVER['PHP_SELF'];         ?>" method="post">
                                        <fieldset>
                                            <table class="table table-striped"> 
                                                <tr>
                                                    <td width="50%"><strong>Organization Name</strong></td>
                                                    <td><?php echo $org_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Organization Code</strong></td>
                                                    <td><?php echo $org_code; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Sanctioned Post ID</strong></td>
                                                    <td><?php echo $sanctioned_post_id; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff ID</strong></td>
                                                    <td><?php echo $data['staff_id']; ?> <em class="text-success">(Will be added automatically)</em> </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Name</strong></td>
                                                    <td>
                                                        <input type="text" id="staff_name" name="staff_name" placeholder="" >                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Father's Name</strong></td>
                                                    <td>
                                                        <input type="text" id="father_name" name="father_name" placeholder="" >                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Mother's Name</strong></td>
                                                    <td>
                                                        <input type="text" id="mother_name" name="mother_name" placeholder="" >                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Email</strong></td>
                                                    <td>
                                                        <input type="text" id="email_address1" name="email_address1" placeholder="" >                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Contact No.</strong></td>
                                                    <td>
                                                        <input type="text" id="contact_no" name="contact_no" placeholder="" >                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Sex</strong></td>
                                                    <td>
                                                        <select id="sex" name="sex" >
                                                            <option value="0">-- Select form the list --</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Religious Group</strong></td>
                                                    <td>
                                                        <select id="religious_group" name="religious_group" >
                                                            <option value="0">-- Select form the list --</option>
                                                        </select>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Marital Status</strong></td>
                                                    <td>
                                                        <select id="merital_status" name="merital_status" >
                                                            <option value="0">-- Select form the list --</option>
                                                        </select>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Job Class</strong></td>
                                                    <td>

                                                        <select id="job_class" name="job_class" >
                                                            <option value="0">-- Select form the list --</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Present Address</strong></td>
                                                    <td>
                                                        <textarea type="text" id="present_address" name="present_address" placeholder="" ></textarea>                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Permanent Address</strong></td>
                                                    <td>
                                                        <textarea type="text" id="permanent_address" name="permanent_address" placeholder="" ></textarea>                                                        
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td width="50%"><strong></strong></td>
                                                    <td><button type="submit" class="btn btn-success btn-large disabled">Submit</button></td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                    </form>
                                    <?php
                                else:
                                    // echo "ELSE";
                                    ?>

                                <?php endif; ?>
                            </div>
                        </div>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>


        <script src="library/bootstrap-editable/js/bootstrap-editable.min.js"></script>
        <script>
            $.fn.editable.defaults.mode = 'inline';

            var staff_id = <?php echo $staff_id; ?>;
            var org_code = <?php echo $org_code; ?>;

            $('#employee-profile a.text-input').editable({
                type: 'text',
                pk: <?php echo $staff_id; ?>,
                url: 'post/post_employee.php',
                params: function(params) {
                    params.org_code = <?php echo $org_code; ?>;
                    return params;
                }
            });
            $('#employee-profile a.date-input').editable({
                type: 'date',
                pk: <?php echo $staff_id; ?>,
                url: 'post/post_employee.php',
                format: 'yyyy-mm-dd',
                datepicker: {
                    weekStart: 1
                },
                params: function(params) {
                    params.org_code = <?php echo $org_code; ?>;
                    return params;
                }
            });
            $('#employee-profile a.date-textarea').editable({
                type: 'textarea',
                pk: <?php echo $staff_id; ?>,
                url: 'post/post_employee.php',
                rows: 5,
                params: function(params) {
                    params.org_code = <?php echo $org_code; ?>;
                    return params;
                }
            });
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });


        </script>
        <script src="assets/js/common.js"></script>
    </body>
</html>

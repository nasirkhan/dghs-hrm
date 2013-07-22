<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

//SESSION data
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_code = $org_data['org_type_code'];
$org_type_name = $_SESSION['org_type_name'];

//GET values
$staff_id = (int) mysql_real_escape_string($_GET['staff_id']);
$sanctioned_post_id = (int) mysql_real_escape_string($_GET['sanctioned_post_id']);
$action = mysql_real_escape_string($_GET['action']);

if ($sanctioned_post_id != "") {
    $temp = checkStaffExistsBySanctionedPost($sanctioned_post_id);
    $staff_exists = $temp['exists'];
    $staff_id = $temp['staff_id'];

    $designation = getDesignationNameFormSanctionedPostId($sanctioned_post_id);
} else if ($staff_id != "") {
    $staff_exists = checkStaffExists($staff_id);
    $designation = getDesignationNameFormStaffId($staff_id);
    $sanctioned_post_id = getSanctionedPostIdFromStaffId($staff_id);
}


if ($staff_id != "" && $staff_exists) {
    $sql = "SELECT * FROM old_tbl_staff_organization WHERE old_tbl_staff_organization.staff_id = $staff_id AND old_tbl_staff_organization.org_code = $org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    // data fetched form organization table
    $data = mysql_fetch_assoc($result);
}



//  check and set the user's edit permission
$userCanEdit = TRUE;

// set the page display mode
if ($staff_exists && !$userCanEdit) {
    $display_mode = "view";
} else if ($staff_exists && $userCanEdit) {
    $display_mode = "edit";
} else if ($action == "new" && $userCanEdit) {
    if ($sanctioned_post_id != "") {
        
    }
    $display_mode = "new";
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
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" media='screen,print'>
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet" media='screen,print'>
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet" media='screen,print'>
        <link href="library/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" media='screen,print'>
        <link href="assets/css/style.css" rel="stylesheet" media='screen,print'>
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

        <!--
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'ACCOUNT_ID']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        -->
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
        ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="./index.php"><?php echo $app_name; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="./index.html">Home</a>                                
                            </li>
                            <li class="">
                                <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

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
            <div class="row" class="hidden-print">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li class="active"><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_request.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
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
<!--                                <p><pre>
                                    <?php
//                                    echo "$display_mode|";
//                                    print_r($temp);
//                                    print_r($_POST);
//                                    print_r($_GET);
                                    $exception_field = "";
                                    $query = createMySqlInsertString($_POST, $exception_field);
                                    print_r($query);
                                    $table_name = "old_tbl_staff_organization";
                                    $column_name = "govt_quarter";
                                    print_r(getEnumColumnValues($table_name, $column_name));
                                    ?>
                                </pre></p>-->
                                <?php if ($staff_id == "" && $action != "new"): ?>
                                    <div class="alert alert-success">
                                        <div>
                                            If you want to view a specific staff profile, please use the following serchbox to find. <br />
                                            Or, you can find the staff form the <a href="sanctioned_post.php">Sanctioned Post Page</a>.
                                        </div>
                                        <div>
                                            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                                <div class="input-append">
                                                    <!--<input class="span4" id="org_code" name="org_code" type="hidden" value="<?php echo $org_code; ?>">-->
                                                    <input class="span4" id="staff_id" name="staff_id" type="text">                                                    
                                                    <button class="btn" type="submit" >Search</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                <?php endif; ?>

                                <?php
                                // if ($staff_id != "" && !$staff_exists): 
                                if ($staff_id != ""):
                                    ?>
                                    <!--                                    
                                    <div class="alert alert-error">
                                        <div>
                                            <h3>Please search again.</h3>
                                            <p class="lead">The staff you are searching for do not belongs to this organization.<br />
                                                Or, you are not authorized to view the prfile.<br /></p>

                                            <p>If you want to view a specific staff profile, please use the following serchbox to find. <br />
                                                Or, you can find the staff form the <a href="sanctioned_post.php">Sanctioned Post Page</a>.</p>
                                        </div>
                                        <div>
                                            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                                <div class="input-append">
                                                    <input class="span4" id="org_code" name="org_code" type="hidden" value="<?php echo $org_code; ?>">
                                                    <input class="span4" id="staff_id" name="staff_id" type="text">                                                    
                                                    <button class="btn" type="submit" >Search</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>-->
                                <?php endif; ?>

                                <?php
//                                if ($staff_id != "" && $staff_exists && !$userCanEdit): 
                                if ($display_mode == "view"):
                                    ?>
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <td width="50%"><strong>Designation</strong></td>
                                            <td><?php echo $designation; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Sanctioned Post Id</strong></td>
                                            <td><?php echo $sanctioned_post_id; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff ID</strong></td>
                                            <td><?php echo $data['staff_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization ID</strong></td>
                                            <td><?php echo $data['organization_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Department ID</strong></td>
                                            <td><?php echo $data['department_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Posting</strong></td>
                                            <td><?php echo $data['staff_posting']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Job Class</strong></td>
                                            <td><?php echo $data['staff_job_class']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Professional Category</strong></td>
                                            <td><?php echo $data['staff_professional_category']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Designation Id</strong></td>
                                            <td><?php echo $data['designation_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Posting Status</strong></td>
                                            <td><?php echo $data['posting_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong><a href="#">Staff PDS Code</a></strong></td>
                                            <td><?php echo $data['staff_pds_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Name</strong></td>
                                            <td><?php echo $data['staff_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Local Id</strong></td>
                                            <td><?php echo $data['staff_local_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Father Name</strong></td>
                                            <td><?php echo $data['father_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Mother Name</strong></td>
                                            <td><?php echo $data['mother_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Birth Date</strong></td>
                                            <td><?php echo $data['birth_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Email Address</strong></td>
                                            <td><?php echo $data['email_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No</strong></td>
                                            <td><?php echo $data['contact_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Mailing Address</strong></td>
                                            <td><?php echo $data['mailing_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Permanent Address</strong></td>
                                            <td><?php echo $data['permanent_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Freedom Fighter Id</strong></td>
                                            <td><?php echo $data['freedom_fighter_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Tribal Id</strong></td>
                                            <td><?php echo $data['tribal_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Post Type Id</strong></td>
                                            <td><?php echo $data['post_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Draw Type Id</strong></td>
                                            <td><?php echo $data['draw_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Designation Type </strong></td>
                                            <td><?php echo $data['designation_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Job Posting</strong></td>
                                            <td><?php echo $data['job_posting_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Working Status</strong></td>
                                            <td><?php echo $data['working_status_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Draw Salary</strong></td>
                                            <td><?php echo $data['draw_salary_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Sex</strong></td>
                                            <td><?php echo getSexNameFromId($data['sex']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Marital Status</strong></td>
                                            <td><?php echo getMaritalStatusFromId($data['marital_status']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Religious Group</strong></td>
                                            <td><?php echo getReligeonNameFromId($data['religion']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date of Joining to Govt Health Service</strong></td>
                                            <td><?php echo $data['date_of_joining_to_govt_health_service']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date of Joining to Current Place</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_place']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Date of Joining to Current Designation</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Professional Discipline of Current Designation</strong></td>
                                            <td><?php echo $data['professional_discipline_of_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Type of Educational Qualification</strong></td>
                                            <td><?php echo $data['type_of_educational_qualification']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Actual Degree</strong></td>
                                            <td><?php echo $data['actual_degree']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Pay Scale of Current Designation</strong></td>
                                            <td><?php echo $data['pay_scale_of_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Current Basic Pay Taka</strong></td>
                                            <td><?php echo $data['current_basic_pay_taka']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>govt_quarter_id</strong></td>
                                            <td><?php echo $data['govt_quarter_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>job_status</strong></td>
                                            <td><?php echo $data['job_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>reason</strong></td>
                                            <td><?php echo $data['last_update']; ?></td>
                                        </tr>

                                    </table>
                                    
                                    <?php
//                                if ($staff_id != "" && $staff_exists && $userCanEdit): 
                                elseif ($display_mode == "edit"):
                                    ?>
                                    <table class="table table-striped table-hover" id="employee-profile">
                                        <tr>
                                            <td width="50%"><strong>Staff Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_name"><?php echo $data['staff_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong><a href="#">PDS Code</a></strong></td>
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
                                            <td width="50%"><strong>Religious Group</strong></td>
                                            <td><a href="#" id="religion" name="religion"><?php echo getReligeonNameFromId($data['religion']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Marital Status</strong></td>
                                            <td><a href="#" class="" id="marital_status" ><?php echo getMaritalStatusFromId($data['marital_status']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Father Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="father_name"><?php echo $data['father_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Mother Name</strong></td>
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
                                            <td width="50%"><strong>Mailing Address</strong></td>
                                            <td><a href="#" class="date-textarea" id="mailing_address" ><?php echo $data['mailing_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Permanent Address</strong></td>
                                            <td><a href="#" class="date-textarea" id="permanent_address" ><?php echo $data['permanent_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Freedom Fighter </strong></td>
                                            <td><a href="#" id="freedom_fighter_id" ><?php echo getFreedomFighterNameFromId($data['freedom_fighter_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Tribal</strong></td>
                                            <td><a href="#" id="tribal_id" ><?php echo getTribalNameFromId($data['tribal_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Job Class</strong></td>
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
                                            <td width="50%"><strong>Salary drawn from which head</strong></td>
                                            <td><a href="#" id="draw_salary_id" ><?php echo getSalaryDrawTypeNameFromID($data['draw_salary_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Designation Type</strong></td>
                                            <td><a href="#" id="designation_type_id" ><?php echo getDesignationTypeNameFromId($data['designation_type_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Job Posting </strong></td>
                                            <td><a href="#" id="job_posting_id" ><?php echo getJobPostingNameFromId($data['job_posting_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Working Status</strong></td>
                                            <td><a href="#" id="working_status_id" ><?php echo getWorkingStatusNameFromId($data['working_status_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Draw Type</strong></td>
                                            <td><a href="#" id="draw_type_id" ><?php echo getDrawTypeNameFromId($data['draw_type_id']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Pay Scale of Current Designation</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="pay_scale_of_current_designation" name="pay_scale_of_current_designation" readonly><?php echo $data['pay_scale_of_current_designation']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Current Basic Pay Taka</strong></td>
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
                                            <td><a href="#" class="text-input" data-type="text" id="professional_discipline_of_current_designation" name="professional_discipline_of_current_designation"><?php echo $data['professional_discipline_of_current_designation']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Type of Educational Qualification</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="type_of_educational_qualification" name="type_of_educational_qualification"><?php echo $data['type_of_educational_qualification']; ?></a></td>
                                        </tr>
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
                                            <td width="50%"><strong>Organization ID</strong></td>
                                            <td><?php echo $data['organization_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Posting Status</strong></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Staff Local Id</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_local_id"><?php echo $data['staff_local_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Govt Quarter </strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="govt_quarter_id" name="govt_quarter_id"><?php echo $data['govt_quarter_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Job Status</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="job_status" name="job_status"><?php echo $data['job_status']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Reason</strong></td>
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
                                    <form class="form-horizontal" action="<?php echo "employee.php?sanctioned_post_id=$sanctioned_post_id&staff_id=$staff_id"; //echo $_SERVER['PHP_SELF'];  ?>" method="post">
                                        <fieldset>
                                            <table class="table table-striped table-hover">
                                                <tr>
                                                    <td width="50%"><strong>Designation</strong></td>
                                                    <td><?php echo $designation; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Sanctioned Post Id</strong></td>
                                                    <td><?php echo $sanctioned_post_id; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff ID</strong></td>
                                                    <td><?php echo $data['staff_id']; ?> <em class="text-success">(Will be added automatically)</em> </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Organization Name</strong></td>
                                                    <td><?php echo $org_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Organization Code</strong></td>
                                                    <td><?php echo $org_code; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Department ID</strong></td>
                                                    <td><input name="department_id" type="text" placeholder="Enter Department ID" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Posting</strong></td>
                                                    <td><input name="staff_posting" type="text" placeholder="Enter staff_posting" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Job Class</strong></td>
                                                    <td><input name="staff_job_class" type="text" placeholder="Enter staff_job_class" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Professional Category</strong></td>
                                                    <td><input name="staff_professional_category" type="text" placeholder="Enter Staff Professional Category" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Designation Id</strong></td>
                                                    <td><input name="designation_id" type="text" placeholder="Enter designation_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Posting Status</strong></td>
                                                    <td><input name="posting_status" type="text" placeholder="Enter posting_status" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff PDS Code</strong></td>
                                                    <td><input name="staff_pds_code" type="text" placeholder="Enter staff_pds_code" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Name</strong></td>
                                                    <td><input name="staff_name" type="text" placeholder="Enter staff_name" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Staff Local Id</strong></td>
                                                    <td><input name="staff_local_id" type="text" placeholder="Enter staff_local_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Father Name</strong></td>
                                                    <td><input name="father_name" type="text" placeholder="Enter father_name" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Mother Name</strong></td>
                                                    <td><input name="mother_name" type="text" placeholder="Enter mother_name" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Birth Date</strong></td>
                                                    <td><input name="birth_date" type="text" placeholder="Date format yyyy-mm-dd" class="datepicker" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Email Address</strong></td>
                                                    <td><input name="email_address" type="text" placeholder="Enter email_address" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Contact No</strong></td>
                                                    <td><input name="contact_no" type="text" placeholder="Enter contact_no" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Mailing Address</strong></td>
                                                    <td><input name="mailing_address" type="text" placeholder="Enter mailing_address" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Permanent Address</strong></td>
                                                    <td><input name="permanent_address" type="text" placeholder="Enter permanent_address" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Freedom Fighter Id</strong></td>
                                                    <td><input name="freedom_fighter_id" type="text" placeholder="Enter freedom_fighter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Tribal Id</strong></td>
                                                    <td><input name="tribal_id" type="text" placeholder="Enter tribal_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Post Type Id</strong></td>
                                                    <td><input name="post_type_id" type="text" placeholder="Enter post_type_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Draw Type Id</strong></td>
                                                    <td><input name="draw_type_id" type="text" placeholder="Enter draw_type_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Designation Type Id</strong></td>
                                                    <td><input name="designation_type_id" type="text" placeholder="Enter designation_type_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Job Posting Id</strong></td>
                                                    <td><input name="job_posting_id" type="text" placeholder="Enter job_posting_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Working Status Id</strong></td>
                                                    <td><input name="working_status_id" type="text" placeholder="Enter working_status_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Draw Salary Id</strong></td>
                                                    <td><input name="draw_salary_id" type="text" placeholder="Enter govt_quadraw_salary_idrter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Sex</strong></td>
                                                    <td><input name="sex" type="text" placeholder="Enter sex" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Marital Status</strong></td>
                                                    <td><input name="marital_status" type="text" placeholder="Enter marital_status" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Religion</strong></td>
                                                    <td><input name="religion" type="text" placeholder="Enter religion" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Date of Joining to Govt Health Service</strong></td>
                                                    <td><input name="date_of_joining_to_govt_health_service" type="text" placeholder="Date format yyyy-mm-dd"  class="datepicker" readonly/></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Date of Joining to Current Place</strong></td>
                                                    <td><input name="date_of_joining_to_current_place" type="text" placeholder="Date format yyyy-mm-dd" class="datepicker" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Date of Joining to Current Designation</strong></td>
                                                    <td><input name="date_of_joining_to_current_designation" type="text" placeholder="Date format yyyy-mm-dd" class="datepicker" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Professional Discipline of Current Designation</strong></td>
                                                    <td><input name="professional_discipline_of_current_designation" type="text" placeholder="Enter govt_quarter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Type of Educational Qualification</strong></td>
                                                    <td><input name="type_of_educational_qualification" type="text" placeholder="Enter govt_quarter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Actual Degree</strong></td>
                                                    <td><input name="actual_degree" type="text" placeholder="Enter govt_quarter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Pay Scale of Current Designation</strong></td>
                                                    <td><input name="pay_scale_of_current_designation" type="text" placeholder="Enter govt_quarter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Current Basic Pay Taka</strong></td>
                                                    <td><input name="current_basic_pay_taka" type="text" placeholder="Enter govt_quarter_id" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Govt Quarter id</strong></td>                                                        
                                                    <td>
                                                        <select name="govt_quarter_id">
                                                            <?php
                                                            $table_name = "old_tbl_staff_organization";
                                                            $column_name = "govt_quarter";
                                                            $govt_quarter_id_list = getEnumColumnValues($table_name, $column_name);
                                                            foreach ($govt_quarter_id_list as $value) {
                                                                echo "<option value=\"$value\">$value</option>";
                                                            }
                                                            ?>
                                                        </select>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Job Status</strong></td>
                                                    <td><input name="job_status" type="text" placeholder="Enter job_status" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong>Reason</strong></td>
                                                    <td><input name="reason" type="text" placeholder="Enter reason" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%"><strong></strong></td>
                                                    <td><button type="submit" class="btn btn-success btn-large">Submit</button></td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <footer class="footer">
            <div class="container">                
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Contact Us</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Contact Developer</a></li>
                </ul>
            </div>
        </footer>



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
            $(function() {
                $('#sex').editable({
                    type: 'select',
                    pk: <?php echo $staff_id; ?>,
                    value: 1,
                    source: [
                        {value: 1, text: 'Male'},
                        {value: 2, text: 'Female'},
                        {value: 3, text: 'Other'},                        
                    ],
                    params: function(params) {
                        params.org_code = <?php echo $org_code; ?>;
                        return params;
                    }
                });
            });
//            $(function() {
//                $('#marital_status').editable({
//                    type: 'select',
//                    pk: <?php echo $staff_id; ?>,
//                    value: 1,
//                    source: [
//                        {value: 1, text: 'Single'},
//                        {value: 2, text: 'Married'}
//                    ],
//                    params: function(params) {
//                        params.org_code = <?php echo $org_code; ?>;
//                        return params;
//                    }
//                });
//            });
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        </script>
        <script src="assets/js/common.js"></script>
    </body>
</html>

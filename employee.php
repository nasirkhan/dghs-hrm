<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

//GET staff_id
$staff_id = $_GET['staff_id'];
$staff_id = (int) $staff_id;

//SESSION data: org_code
$org_code = $_SESSION['org_code'];
$org_data = getOrgNameAndOrgTypeCodeFormOrgCode($org_code);
$org_name = $org_data['org_name'];
$org_type_code = $org_data['org_type_code'];
$org_type_name = $_SESSION['org_type_name'];

$staff_exists = checkEmployeeExistsInOrganization($org_code, $staff_id);

if ($staff_id != "" && $staff_exists) {
    $sql = "SELECT * FROM old_tbl_staff_organization WHERE old_tbl_staff_organization.staff_id = $staff_id AND old_tbl_staff_organization.org_code = $org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    // data fetched form organization table
    $data = mysql_fetch_assoc($result);
}


//  check and set the user's edit permission
$userCanEdit = TRUE;
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
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li class="active"><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
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
                                <?php if ($staff_id == ""): ?>
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

                                <?php if ($staff_id != "" && !$staff_exists): ?>
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
                                                    <!--<input class="span4" id="org_code" name="org_code" type="hidden" value="<?php echo $org_code; ?>">-->
                                                    <input class="span4" id="staff_id" name="staff_id" type="text">                                                    
                                                    <button class="btn" type="submit" >Search</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                <?php endif; ?>

                                <?php if ($staff_id != "" && $staff_exists && !$userCanEdit): ?>
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <td><strong>Staff ID</strong></td>
                                            <td><?php echo $data['staff_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Organization ID</strong></td>
                                            <td><?php echo $data['organization_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Department ID</strong></td>
                                            <td><?php echo $data['department_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>staff_posting</strong></td>
                                            <td><?php echo $data['staff_posting']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>staff_job_class</strong></td>
                                            <td><?php echo $data['staff_job_class']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Professional Category</strong></td>
                                            <td><?php echo $data['staff_professional_category']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>designation_id</strong></td>
                                            <td><?php echo $data['designation_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>posting_status</strong></td>
                                            <td><?php echo $data['posting_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>staff_pds_code</strong></td>
                                            <td><?php echo $data['staff_pds_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>staff_name</strong></td>
                                            <td><?php echo $data['staff_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>staff_local_id</strong></td>
                                            <td><?php echo $data['staff_local_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>father_name</strong></td>
                                            <td><?php echo $data['father_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>mother_name</strong></td>
                                            <td><?php echo $data['mother_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>birth_date</strong></td>
                                            <td><?php echo $data['birth_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>email_address</strong></td>
                                            <td><?php echo $data['email_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>contact_no</strong></td>
                                            <td><?php echo $data['contact_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>mailing_address</strong></td>
                                            <td><?php echo $data['mailing_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>permanent_address</strong></td>
                                            <td><?php echo $data['permanent_address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>freedom_fighter_id</strong></td>
                                            <td><?php echo $data['freedom_fighter_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>tribal_id</strong></td>
                                            <td><?php echo $data['tribal_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>post_type_id</strong></td>
                                            <td><?php echo $data['post_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>draw_type_id</strong></td>
                                            <td><?php echo $data['draw_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>designation_type_id</strong></td>
                                            <td><?php echo $data['designation_type_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>job_posting_id</strong></td>
                                            <td><?php echo $data['job_posting_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>working_status_id</strong></td>
                                            <td><?php echo $data['working_status_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>draw_salary_id</strong></td>
                                            <td><?php echo $data['draw_salary_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>sex</strong></td>
                                            <td><?php echo $data['sex']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>marital_status</strong></td>
                                            <td><?php echo $data['marital_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>religion</strong></td>
                                            <td><?php echo $data['religion']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>date_of_joining_to_govt_health_service</strong></td>
                                            <td><?php echo $data['date_of_joining_to_govt_health_service']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>date_of_joining_to_current_place</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_place']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>date_of_joining_to_current_designation</strong></td>
                                            <td><?php echo $data['date_of_joining_to_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>professional_discipline_of_current_designation</strong></td>
                                            <td><?php echo $data['professional_discipline_of_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>type_of_educational_qualification</strong></td>
                                            <td><?php echo $data['type_of_educational_qualification']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>actual_degree</strong></td>
                                            <td><?php echo $data['actual_degree']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>pay_scale_of_current_designation</strong></td>
                                            <td><?php echo $data['pay_scale_of_current_designation']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>current_basic_pay_taka</strong></td>
                                            <td><?php echo $data['current_basic_pay_taka']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>govt_quarter_id</strong></td>
                                            <td><?php echo $data['govt_quarter_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>job_status</strong></td>
                                            <td><?php echo $data['job_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>reason</strong></td>
                                            <td><?php echo $data['last_update']; ?></td>
                                        </tr>

                                    </table>
                                <?php endif; ?>
                                <?php if ($staff_id != "" && $staff_exists && $userCanEdit): ?>
                                    <table class="table table-striped table-hover" id="employee-profile">
                                        <tr>
                                            <td><strong>Staff ID</strong></td>
                                            <td><?php echo $data['staff_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Organization ID</strong></td>
                                            <td><?php echo $data['organization_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Department ID</strong></td>
                                            <td><?php echo $data['department_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Posting</strong></td>
                                            <td><?php echo $data['staff_posting']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Job Class</strong></td>
                                            <td><?php echo getClassNameformId($data['staff_job_class']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Professional Category</strong></td>
                                            <td><?php echo $data['staff_professional_category']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Designation Id</strong></td>
                                            <td><?php echo getDesignationNameformCode($data['designation_id']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Posting Status</strong></td>
                                            <td><?php echo $data['posting_status']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff PDS Code</strong></td>
                                            <td><?php echo $data['staff_pds_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_name"><?php echo $data['staff_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Local Id</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="staff_local_id"><?php echo $data['staff_local_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Father Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="father_name"><?php echo $data['father_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mother Name</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="mother_name"><?php echo $data['mother_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date of Birth</strong></td>
                                            <td><a href="#" class="date-input" id="birth_date" ><?php echo $data['birth_date']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email Address</strong></td>
                                            <td><a href="#" class="text-input" data-type="email" id="email_address" ><?php echo $data['email_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Contact No.</strong></td>
                                            <td><a href="#" class="text-input" id="contact_no" ><?php echo $data['contact_no']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mailing Address</strong></td>
                                            <td><a href="#" class="date-textarea" id="mailing_address" ><?php echo $data['mailing_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Permanent Address</strong></td>
                                            <td><a href="#" class="date-textarea" id="permanent_address" ><?php echo $data['permanent_address']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Freedom Fighter Id</strong></td>
                                            <td><a href="#" class="text-input" id="freedom_fighter_id" ><?php echo $data['freedom_fighter_id']=="1" ? 'Yes' : 'No'; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tribal Id</strong></td>
                                            <td><a href="#" class="text-input" id="tribal_id" ><?php echo $data['tribal_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Post Type Id</strong></td>
                                            <td><a href="#" class="text-input" id="post_type_id" ><?php echo $data['post_type_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Draw Type Id</strong></td>
                                            <td><a href="#" class="text-input" id="draw_type_id" ><?php echo $data['draw_type_id']; ?></a></td>
                                        </tr>
<!--                                        <tr>
                                            <td><strong>Designation Type Id</strong></td>
                                            <td><a href="#" class="text-input" id="designation_type_id" ><?php echo $data['designation_type_id']; ?></a></td>
                                        </tr>-->
                                        <tr>
                                            <td><strong>Job Posting Id</strong></td>
                                            <td><a href="#" class="text-input" id="job_posting_id" ><?php echo $data['job_posting_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Working Status Id</strong></td>
                                            <td><a href="#" class="text-input" id="working_status_id" ><?php echo $data['working_status_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Draw Salary Id</strong></td>
                                            <td><a href="#" class="text-input" id="draw_salary_id" ><?php echo $data['draw_salary_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Sex</strong></td>
                                            <td><a href="#" class="" id="sex" ><?php echo $data['sex']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Marital Status</strong></td>
                                            <td><a href="#" class="" id="marital_status" ><?php echo $data['marital_status']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Religion</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="religion" name="religion"><?php echo $data['religion']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Of Joining to Govt. Health Service</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_govt_health_service" ><?php echo $data['date_of_joining_to_govt_health_service']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Of Joining to Current Place</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_current_place" ><?php echo $data['date_of_joining_to_current_place']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Of Joining to Current Designation</strong></td>
                                            <td><a href="#" class="date-input" id="date_of_joining_to_current_designation" ><?php echo $data['date_of_joining_to_current_designation']; ?></a></td>
                                            
                                        </tr>
                                        <tr>
                                            <td><strong>Professional Discipline of Current Designation</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="professional_discipline_of_current_designation" name="professional_discipline_of_current_designation"><?php echo $data['professional_discipline_of_current_designation']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type of Educational Qualification</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="type_of_educational_qualification" name="type_of_educational_qualification"><?php echo $data['type_of_educational_qualification']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Actual Degree</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="actual_degree" name="actual_degree"><?php echo $data['actual_degree']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pay Scale of Current Designation</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="pay_scale_of_current_designation" name="pay_scale_of_current_designation"><?php echo $data['pay_scale_of_current_designation']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Basic Pay Taka</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="current_basic_pay_taka" name="current_basic_pay_taka"><?php echo $data['current_basic_pay_taka']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Govt Quarter Id</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="govt_quarter_id" name="govt_quarter_id"><?php echo $data['govt_quarter_id']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Job Status</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="job_status" name="job_status"><?php echo $data['job_status']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Reason</strong></td>
                                            <td><a href="#" class="text-input" data-type="text" id="reason" name="reason"><?php echo $data['reason']; ?></a> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated On</strong></td>
                                            <td><?php echo $data['last_update']; ?></td>
                                        </tr>

                                    </table>
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

            $('#employee-profile a.text-input').editable({
                type: 'text',
                pk: <?php echo $staff_id; ?>,
                url: 'post/post_employee.php',
                title: 'Enter username',
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
            $(function(){
                $('#sex').editable({
                    type: 'select',
                    pk: <?php echo $staff_id; ?>,
                    value: 1,
                    source: [
                        {value: 1, text: 'Male'},
                        {value: 2, text: 'Female'}
                    ],
                    params: function(params) {
                        params.org_code = <?php echo $org_code; ?>;
                    return params;
                }
                });
            });
            $(function(){
                $('#marital_status').editable({
                    type: 'select',
                    pk: <?php echo $staff_id; ?>,
                    value: 1,
                    source: [
                        {value: 1, text: 'Single'},
                        {value: 2, text: 'Married'}
                    ],
                    params: function(params) {
                        params.org_code = <?php echo $org_code; ?>;
                    return params;
                }
                });
            });
        </script>
        
    </body>
</html>

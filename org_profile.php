<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

$org_code = $_GET['org_code'];
if ($org_code == "") {
    $org_code = $_SESSION['org_code'];
}
$org_code = (int) $org_code;


//org_code 10000001
$sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

// data fetched form organization table
$data = mysql_fetch_assoc($result);

$org_name = $data['org_name'];
$org_type_name = getOrgTypeNameFormOrgTypeId($data['org_type_code']);
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
                                <a href="./index.php">Home</a>                                
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

            <!-- left nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                            <!-- 
                            <ul class="nav nav-list bs-docs-sidenav-l2 nav-tab-ul">
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-hospital"></i> Basic Information</a>
                                </li>
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-envelope"></i> Contact Information</a>
                                </li>
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-shield"></i> Facility Information</a>
                                </li>
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-building"></i> Ownership Info</a>
                                </li>
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-th-list"></i> Land Information</a>
                                </li>
                                <li class="">
                                    <a href="#" data-toggle="tab"><i class="icon-qrcode"></i> Additional Information</a>
                                </li>
                            </ul>
                            -->
                        </li>
                        <li class="active"><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- organization-profile-details
                    ================================================== -->
                    <section id="organization-profile-details">

                        <ul class="nav nav-tabs nav-tab-ul" id="myTab">
                            <li class="active">
                                <a href="#basic-info" data-toggle="tab"><i class="icon-hospital"></i> Basic Information</a>
                            </li>
                            <li class="">
                                <a href="#contact-info" data-toggle="tab"><i class="icon-envelope"></i> Contact Info</a>
                            </li>
                            <li class="">
                                <a href="#facility-info" data-toggle="tab"><i class="icon-shield"></i> Facility Info</a>
                            </li>
                            <li class="">
                                <a href="#ownership-info" data-toggle="tab"><i class="icon-building"></i> Ownership Info</a>
                            </li>
                            <li class="">
                                <a href="#land-info" data-toggle="tab"><i class="icon-th-list"></i> Land Info</a>
                            </li>
                            <li class="">
                                <a href="#additional-info" data-toggle="tab"><i class="icon-qrcode"></i> Additional Info</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="basic-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Organization Name</strong></td>
                                        <td><?php echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Organization Code</strong></td>
                                        <td><?php echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Organization Type</strong></td>
                                        <td><?php echo $data['org_type_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Agency code</strong></td>
                                        <td><?php echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Agency Name</strong></td>
                                        <td><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Functional Code</strong></td>
                                        <td><?php echo $data['org_function_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Functional Name</strong></td>
                                        <td><?php echo getFunctionalNameFromFunctionalCode($data['org_function_code']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Organization Level</strong></td>
                                        <td><?php echo $data['org_level_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Health Care Level</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Special Services</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Year Established</strong></td>
                                        <td><?php echo $data['year_established']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Urban/Rural Location</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Division Name</strong></td>
                                        <td><?php echo $data['division_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Division Code</strong></td>
                                        <td><?php echo $data['division_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District Name</strong></td>
                                        <td><?php echo $data['district_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District Code</strong></td>
                                        <td><?php echo $data['district_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Upaziala Name</strong></td>
                                        <td><?php echo $data['upazila_thana_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Upazila Code</strong></td>
                                        <td><?php echo $data['upazila_thana_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Union Name</strong></td>
                                        <td><?php echo $data['union_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Union Code</strong></td>
                                        <td><?php echo $data['union_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ward</strong></td>
                                        <td><?php echo $data['ward_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Village/Street</strong></td>
                                        <td><?php echo $data['village_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>House No</strong></td>
                                        <td><?php echo $data['house_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Longitude</strong></td>
                                        <td><?php echo $data['longitude']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Latitude</strong></td>
                                        <td><?php echo $data['latitude']; ?></td>
                                    </tr>
                                </table>
                            </div> 
                            <div class="tab-pane" id="contact-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Mailing Address</strong></td>
                                        <td><?php echo $data['mailing_address']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Land Phone Number 1</strong></td>
                                        <td><?php echo $data['land_phone1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Land Phone Number 2</strong></td>
                                        <td><?php echo $data['land_phone2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Land Phone Number 3</strong></td>
                                        <td><?php echo $data['land_phone3']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile Phone Number 1</strong></td>
                                        <td><?php echo $data['mobile_number1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile Phone Number 2</strong></td>
                                        <td><?php echo $data['mobile_number2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile Phone Number 3</strong></td>
                                        <td><?php echo $data['mobile_number3']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Address 1</strong></td>
                                        <td><?php echo $data['email_address1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Address 2</strong></td>
                                        <td><?php echo $data['email_address2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Address 3</strong></td>
                                        <td><?php echo $data['email_address3']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fax Number 1</strong></td>
                                        <td><?php echo $data['fax_number1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fax Number 2</strong></td>
                                        <td><?php echo $data['fax_number2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fax Number 3</strong></td>
                                        <td><?php echo $data['fax_number3']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website URL</strong></td>
                                        <td><?php echo $data['website_address']; ?></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td><strong>Website2</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website3</strong></td>
                                        <td><?php // echo $data['district_code']; ?></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td><strong>Facebook</strong></td>
                                        <td><?php echo $data['facebook_page']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Google+</strong></td>
                                        <td><?php echo $data['google_plus_page']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Twitter</strong></td>
                                        <td><?php echo $data['twitter_page']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Youtube</strong></td>
                                        <td><?php echo $data['youtube_page']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="facility-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Main source of electricity</strong></td>
                                        <td><?php // echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate source of electricity</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Main water supply</strong></td>
                                        <td><?php // echo $data['org_type_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate water supply</strong></td>
                                        <td><?php // echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Toilet type</strong></td>
                                        <td><?php // echo $data['agency_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Toilet adequacy</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fuel source</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Laundry system</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Autoclave system</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Waste disposal</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sanctioned vehicles & office equipment</strong></td>
                                        <td><?php // echo $data['year_established']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sanctioned Bed No</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Other miscellaneous issues</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="ownership-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Special service / status of the hospital / clinic</strong></td>
                                        <td><?php // echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Permission/Approval/License information</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Permission/Approval/License information</strong></td>
                                        <td><?php // echo $data['org_type_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Permission/Approval/License Type</strong></td>
                                        <td><?php // echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Permission/ Approval/ License Authority</strong></td>
                                        <td><?php // echo $data['agency_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Permission/ Approval/ License No</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Next renewal Date</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Conditions given for permission/ approval/ license or renewal thereof </strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="land-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Land Information</strong></td>
                                        <td><?php // echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Land size (in acre)</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mouza name</strong></td>
                                        <td><?php // echo $data['org_type_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Geocode of Mouza</strong></td>
                                        <td><?php // echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>JL No.</strong></td>
                                        <td><?php // echo $data['agency_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Functional Code</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>RS Dag No</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Khatian No.</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mutation No.</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Other land information.</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="additional-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td><strong>Name of CHCP</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact no of CHCP</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Community group information</strong></td>
                                        <td><?php // echo $data['org_type_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name of Chairman(CG)</strong></td>
                                        <td><?php // echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact No</strong></td>
                                        <td><?php // echo $data['agency_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Community Support group information </strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name of Chairman (CSG-1)</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact No</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name of Chairman (CSG-2)</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact No</strong></td>
                                        <td><?php // echo $data['org_code']; ?></td>
                                    </tr>
                                </table>
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
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

        <script>
            $(function() {
                $('.nav-tab-ul #basic-info').tab('show');
            });
        </script>


        <script src="library/bootstrap-editable/js/bootstrap-editable.min.js"></script>
        <script>
            $.fn.editable.defaults.mode = 'inline';
            $(document).ready(function() {
                $('#username').editable();
            });
            $('#username').editable({
                type: 'text',
                pk: <?php echo $org_code; ?>,
                url: 'post_org_profile.php',
                title: 'Enter username',
                params: function(params) {
                params.a = 1;
                return params;
                }
            });
            
        </script>

    </body>
</html>

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


$sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

// data fetched form organization table
$data = mysql_fetch_assoc($result);

$org_name = $data['org_name'];
$org_type_name = $_SESSION['org_type_name'];

//  logged in user information
$user_name = $_SESSION['username'];
$user_type = $_SESSION['user_type'];

if ($user_type = "admin"){
    $isAdmin = TRUE;
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
                        <li><a href="move_request.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
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
                                <?php if ($isAdmin): ?>
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Organization Name</strong></td>
                                        <td><a href="#" class="text-input" id="org_name" ><?php echo "$org_name"; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Code</strong></td>
                                        <td><?php echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Type</strong></td>
                                        <td><a href="#" class="" id="org_type_code" ><?php echo getOrgTypeNameFormOrgTypeCode($data['org_type_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Agency code</strong></td>
                                        <td><?php echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Agency Name</strong></td>
                                        <td><a href="#" class="" id="agency_code" ><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Functional Code</strong></td>
                                        <td><?php echo $data['org_function_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Functional Name</strong></td>
                                        <td><a href="#" class="" id="org_function_code" ><?php echo getFunctionalNameFromFunctionalCode($data['org_function_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Level</strong></td>
                                        <td><a href="#" class="" id="org_level_code" ><?php echo getOrgLevelNamefromCode($data['org_level_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Health Care Level</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Special Services</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Year Established</strong></td>
                                        <td><a href="#" class="text-input" id="year_established" ><?php echo $data['year_established']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Urban/Rural Location</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Division Name</strong></td>
                                        <td><a href="#" class="" id="division_name" ><?php echo getDivisionNamefromCode($data['division_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Division Code</strong></td>
                                        <td><?php echo $data['division_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>District Name</strong></td>
                                        <td><a href="#" class="" id="district_name" ><?php echo getDistrictNamefromCode($data['district_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>District Code</strong></td>
                                        <td><?php echo $data['district_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Upaziala Name</strong></td>
                                        <td><a href="#" class="" id="upazila_thana_name" ><?php echo $data['upazila_thana_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Upazila Code</strong></td>
                                        <td><?php echo $data['upazila_thana_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Union Name</strong></td>
                                        <td><a href="#" class="" id="union_name" ><?php echo $data['union_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Union Code</strong></td>
                                        <td><?php echo $data['union_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Ward</strong></td>
                                        <td><a href="#" class="text-input" id="ward_code" ><?php echo $data['ward_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Village/Street</strong></td>
                                        <td><a href="#" class="text-input" id="village_code" ><?php echo $data['village_code']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>House No</strong></td>
                                        <td><a href="#" class="text-input" id="house_number" ><?php echo $data['house_number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Longitude</strong></td>
                                        <td><a href="#" class="text-input" id="longitude" ><?php echo $data['longitude']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Latitude</strong></td>
                                        <td><a href="#" class="text-input" id="latitude" ><?php echo $data['latitude']; ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="tab-pane active" id="basic-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Organization Name</strong></td>
                                        <td><?php echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Code</strong></td>
                                        <td><?php echo $data['org_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Type</strong></td>
                                        <td><?php echo $data['org_type_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Agency code</strong></td>
                                        <td><?php echo $data['agency_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Agency Name</strong></td>
                                        <td><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Functional Code</strong></td>
                                        <td><?php echo $data['org_function_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Functional Name</strong></td>
                                        <td><?php echo getFunctionalNameFromFunctionalCode($data['org_function_code']); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Level</strong></td>
                                        <td><?php echo $data['org_level_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Health Care Level</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Special Services</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Year Established</strong></td>
                                        <td><?php echo $data['year_established']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Urban/Rural Location</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Division Name</strong></td>
                                        <td><?php echo $data['division_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Division Code</strong></td>
                                        <td><?php echo $data['division_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>District Name</strong></td>
                                        <td><?php echo $data['district_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>District Code</strong></td>
                                        <td><?php echo $data['district_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Upaziala Name</strong></td>
                                        <td><?php echo $data['upazila_thana_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Upazila Code</strong></td>
                                        <td><?php echo $data['upazila_thana_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Union Name</strong></td>
                                        <td><?php echo $data['union_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Union Code</strong></td>
                                        <td><?php echo $data['union_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Ward</strong></td>
                                        <td><?php echo $data['ward_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Village/Street</strong></td>
                                        <td><?php echo $data['village_code']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>House No</strong></td>
                                        <td><?php echo $data['house_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Longitude</strong></td>
                                        <td><?php echo $data['longitude']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Latitude</strong></td>
                                        <td><?php echo $data['latitude']; ?></td>
                                    </tr>
                                </table>
                            </div> 
                            <?php endif; ?>
                            <div class="tab-pane" id="contact-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Mailing Address</strong></td>
                                        <td><a href="#" class="text-input" id="mailing_address" ><?php echo $data['mailing_address']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Land Phone Number 1</strong></td>
                                        <td><a href="#" class="text-input" id="land_phone1" ><?php echo $data['land_phone1']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Land Phone Number 2</strong></td>
                                        <td><a href="#" class="text-input" id="land_phone2" ><?php echo $data['land_phone2']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Land Phone Number 3</strong></td>
                                        <td><a href="#" class="text-input" id="land_phone3" ><?php echo $data['land_phone3']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mobile Phone Number 1</strong></td>
                                        <td><a href="#" class="text-input" id="mobile_number1" ><?php echo $data['mobile_number1']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mobile Phone Number 2</strong></td>
                                        <td><a href="#" class="text-input" id="mobile_number2" ><?php echo $data['mobile_number2']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mobile Phone Number 3</strong></td>
                                        <td><a href="#" class="text-input" id="mobile_number3" ><?php echo $data['mobile_number3']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Email Address 1</strong></td>
                                        <td><a href="#" class="text-input" id="email_address1" ><?php echo $data['email_address1']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Email Address 2</strong></td>
                                        <td><a href="#" class="text-input" id="email_address2" ><?php echo $data['email_address2']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Email Address 3</strong></td>
                                        <td><a href="#" class="text-input" id="email_address3" ><?php echo $data['email_address3']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Fax Number 1</strong></td>
                                        <td><a href="#" class="text-input" id="fax_number1" ><?php echo $data['fax_number1']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Fax Number 2</strong></td>
                                        <td><a href="#" class="text-input" id="fax_number2" ><?php echo $data['fax_number2']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Fax Number 3</strong></td>
                                        <td><a href="#" class="text-input" id="fax_number3" ><?php echo $data['fax_number3']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Website URL</strong></td>
                                        <td><a href="#" class="text-input" id="website_address" ><?php echo $data['website_address']; ?></a></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td><strong>Website2</strong></td>
                                        <td><?php // echo $data['org_code'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website3</strong></td>
                                        <td><?php // echo $data['district_code'];  ?></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td width="50%"><strong>Facebook</strong></td>
                                        <td><a href="#" class="text-input" id="facebook_page" ><?php echo $data['facebook_page']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Google+</strong></td>
                                        <td><a href="#" class="text-input" id="google_plus_page" ><?php echo $data['google_plus_page']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Twitter</strong></td>
                                        <td><a href="#" class="text-input" id="twitter_page" ><?php echo $data['twitter_page']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Youtube</strong></td>
                                        <td><a href="#" class="text-input" id="youtube_page" ><?php echo $data['youtube_page']; ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="facility-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Main source of electricity</strong></td>
                                        <td><a href="#" class="" id="source_of_electricity_main_code" ><?php echo getElectricityMainSourceNameFromCode($data['source_of_electricity_main_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Alternate source of electricity</strong></td>
                                        <td><a href="#" class="" id="source_of_electricity_alternate_code" ><?php echo getElectricityAlterSourceNameFromCode($data['source_of_electricity_alternate_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Main water supply</strong></td>
                                        <td><a href="#" class="" id="source_of_water_supply_main_code" ><?php echo getWaterMainSourceNameFromCode($data['source_of_water_supply_main_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Alternate water supply</strong></td>
                                        <td><a href="#" class="" id="source_of_water_supply_alternate_code" ><?php echo getWaterAlterSourceNameFromCode($data['source_of_water_supply_alternate_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Toilet type</strong></td>
                                        <td><a href="#" class="" id="toilet_type_code" ><?php echo getToiletTypeNameFromCode($data['toilet_type_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Toilet adequacy</strong></td>
                                        <td><a href="#" class="" id="toilet_adequacy_code" ><?php echo getToiletAdequacyNameFromCode($data['toilet_adequacy_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Fuel source</strong></td>
                                        <td><a href="#" class="" id="fuel_source_code" ><?php echo getFuelSourceNameFromCode($data['fuel_source_code']);  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Laundry system</strong></td>
                                        <td><a href="#" class="" id="laundry_code" ><?php echo $data['laundry_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Autoclave system</strong></td>
                                        <td><a href="#" class="" id="autoclave_code" ><?php echo $data['autoclave_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Waste disposal</strong></td>
                                        <td><a href="#" class="" id="waste_disposal_code" ><?php echo $data['waste_disposal_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Sanctioned office equipment</strong></td>
                                        <td><a href="#" class="text-input" id="sanctioned_office_equipment" ><?php echo $data['sanctioned_office_equipment'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Sanctioned vehicles</strong></td>
                                        <td><a href="#" class="text-input" id="sanctioned_vehicles" ><?php echo $data['sanctioned_vehicles'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Sanctioned Bed No</strong></td>
                                        <td><a href="#" class="text-input" id="sanctioned_bed_number" ><?php echo $data['sanctioned_bed_number'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Other miscellaneous issues</strong></td>
                                        <td><a href="#" class="text-input" id="other_miscellaneous_issues" ><?php echo $data['other_miscellaneous_issues'];  ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="ownership-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="60%"><strong>Special service / status of the hospital / clinic</strong></td>
                                        <td><a href="#" class="text-input" id="land_mutation_number" ><?php // echo $data['org_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/Approval/License information</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_info_code" ><?php echo $data['permission_approval_license_info_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Date of Permission/Approval/License information</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_info_date" ><?php echo $data['permission_approval_license_info_date'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/Approval/License Type</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_type" ><?php echo $data['permission_approval_license_type'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/ Approval/ License Authority</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_aithority" ><?php echo $data['permission_approval_license_aithority'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/ Approval/ License No</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_number" ><?php echo $data['permission_approval_license_number'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Next renewal Date</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_next_renewal_date" ><?php echo $data['permission_approval_license_next_renewal_date'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Conditions given for permission/ approval/ license or renewal thereof </strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_conditions" ><?php echo $data['permission_approval_license_conditions'];  ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="land-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Land Information</strong></td>
                                        <td><a href="#" class="text-input" id="land_info_code" ><?php echo $data['land_info_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Land size (in acre)</strong></td>
                                        <td><a href="#" class="text-input" id="land_size" ><?php echo $data['land_size'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mouza name</strong></td>
                                        <td><a href="#" class="text-input" id="land_mouza_name" ><?php echo $data['land_mouza_name'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Geocode of Mouza</strong></td>
                                        <td><a href="#" class="text-input" id="land_mouza_geo_code" ><?php echo $data['land_mouza_geo_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>JL No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_jl_number" ><?php echo $data['land_jl_number'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Functional Code</strong></td>
                                        <td><a href="#" class="text-input" id="land_functional_code" ><?php echo $data['land_functional_code'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>RS Dag No</strong></td>
                                        <td><a href="#" class="text-input" id="land_rs_dag_number" ><?php echo $data['land_rs_dag_number'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Khatian No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_kharian_number" ><?php echo $data['land_kharian_number'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mutation No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_other_info" ><?php echo $data['land_other_info'];  ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Other land information.</strong></td>
                                        <td><a href="#" class="text-input" id="land_mutation_number" ><?php echo $data['land_mutation_number'];  ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="additional-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Name of CHCP</strong></td>
                                        <td><a href="#" class="text-input" id="additional_chcp_name" ><?php echo $data['additional_chcp_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Contact no of CHCP</strong></td>
                                        <td><a href="#" class="text-input" id="additional_chcp_contact" ><?php echo $data['additional_chcp_contact']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Community group information</strong></td>
                                        <td><a href="#" class="text-input" id="additional_community_group_info" ><?php echo $data['additional_community_group_info']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Name of Chairman(CG)</strong></td>
                                        <td><a href="#" class="text-input" id="additional_chairnam_name" ><?php echo $data['additional_chairnam_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Contact No</strong></td>
                                        <td><a href="#" class="text-input" id="additional_chairman_contact" ><?php echo $data['additional_chairman_contact']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Community Support group information </strong></td>
                                        <td><a href="#" class="text-input" id="additional_chairman_community_support_info" ><?php echo $data['additional_chairman_community_support_info']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Name of Chairman (CSG-1)</strong></td>
                                        <td><a href="#" class="text-input" id="additional_csg_1_name" ><?php echo $data['additional_csg_1_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Contact No</strong></td>
                                        <td><a href="#" class="text-input" id="additional_csg_1_contact" ><?php echo $data['additional_csg_1_contact']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Name of Chairman (CSG-2)</strong></td>
                                        <td><a href="#" class="text-input" id="additional_csg_2_name" ><?php echo $data['additional_csg_2_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Contact No</strong></td>
                                        <td><a href="#" class="text-input" id="additional_csg_2_contact" ><?php echo $data['additional_csg_2_contact']; ?></a></td>
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
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="assets/js/holder/holder.js"></script>
        <script type="text/javascript" src="assets/js/google-code-prettify/prettify.js"></script>

        <script type="text/javascript" src="assets/js/application.js"></script>

        <script>
            $(function() {
                $('.nav-tab-ul #basic-info').tab('show');
            });
        </script>


        <script src="library/bootstrap-editable/js/bootstrap-editable.min.js"></script>
        <script>
            $.fn.editable.defaults.mode = 'inline';
            
            var org_code = <?php echo $org_code; ?>;

            
        </script>
        <script src="assets/js/common.js"></script>
    </body>
</html>

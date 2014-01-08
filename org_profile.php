<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

if(strlen($_REQUEST['org_code'])){
    if(isValidOrgCode($_REQUEST['org_code'])){
        $org_code=$_REQUEST['org_code'];
        setOrgSession($org_code); // assign values from session array
    }
}


// assign values admin users
if($_SESSION['user_type']=="admin" && $_GET['org_code'] != ""){
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}


/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051){
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])){
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


$sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

// data fetched form organization table
$data = mysql_fetch_assoc($result);


/**
 * check if the organization type is Community clinic or not
 */
$org_type_code = getOrgTypeCodeFromOrgCode($org_code);
// Community Clinic type code is 1039
if ($org_type_code == 1039) {
    $isCommunityClinic = TRUE;
} else {
    $isCommunityClinic = FALSE;
}

$showSanctionedBed = showSanctionedBed($org_type_code);

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

            <!-- left nav
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
                    <!-- organization-profile-details
                    ================================================== -->
                    <section id="organization-profile-details">

                        <ul class="nav nav-tabs nav-tab-ul" id="myTab">
                            <li class="active">
                                <a href="#basic-info" data-toggle="tab"><i class="icon-hospital"></i> Basic Information</a>
                            </li>
                            <li class="">
                                <a href="#ownership-info" data-toggle="tab"><i class="icon-building"></i> Ownership Info</a>
                            </li>
                            <li class="">
                                <a href="#contact-info" data-toggle="tab"><i class="icon-envelope"></i> Contact Info</a>
                            </li>
                            <li class="">
                                <a href="#land-info" data-toggle="tab"><i class="icon-th-list"></i> Land Info</a>
                            </li>
                            <li class="">
                                <a href="#permission_approval-info" data-toggle="tab"><i class="icon-qrcode"></i> Permission/Approval Info</a>
                            </li>
                            <li class="">
                                <a href="#facility-info" data-toggle="tab"><i class="icon-shield"></i> Facility Info</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="basic-info">
                                <?php if ($isAdmin): ?>
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <td width="50%"><strong>Organization Name</strong></td>
                                            <td><a href="#" class="text-input" id="org_name" ><?php echo $data['org_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Organization Code</strong></td>
                                            <td><?php echo $data['org_code']; ?></td>
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
                                            <td width="50%"><strong>Financial Code (Revenue Code)</strong></td>
                                            <td><a href="#" class="text-input" id="financial_revenue_code" ><?php echo $data['financial_revenue_code']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Year Established</strong></td>
                                            <td><a href="#" class="text-input" data-placeholder="Example, 2011" id="year_established" ><?php echo $data['year_established']; ?></a></td>
                                        </tr>
                                        <tr  class="success">
                                            <td width="50%" colspan="2"><strong>Urban/Rural Location Information of the Organization</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">Urban/Rural Location</td>
                                            <td><a href="#" class="" id="org_location_type" ><?php echo getOrgLocationTypeFromCode($data['org_location_type']); ?></a></td>
                                        </tr>
                                        <tr class="success">
                                            <td width="50%" colspan="2"><strong>Regional location of the organization</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Division Name</strong></td>
                                            <td><a href="#" class="" id="division_code" ><?php echo getDivisionNamefromCode($data['division_code']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Division Code</strong></td>
                                            <td><?php echo $data['division_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>District Name</strong></td>
                                            <td><a href="#" class="" id="district_code" ><?php echo getDistrictNamefromCode($data['district_code']); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>District Code</strong></td>
                                            <td><?php echo $data['district_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Upazila Name</strong></td>
                                            <td><a href="#" class="" id="upazila_thana_code" ><?php echo $data['upazila_thana_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Upazila Code</strong></td>
                                            <td><?php echo $data['upazila_thana_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Union Name</strong></td>
                                            <td><a href="#" class="" id="union_code" ><?php echo $data['union_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Union Code</strong></td>
                                            <td><?php echo $data['union_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Ward (New Ward Number)</strong></td>
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
                                <?php else: ?>
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
                                            <td width="50%"><strong>Agency code</strong></td>
                                            <td><?php echo $data['agency_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Agency Name</strong></td>
                                            <td><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Financial Code (Revenue Code)</strong></td>
                                            <td><?php echo $data['financial_revenue_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Year Established</strong></td>
                                            <td><?php echo $data['year_established']; ?></td>
                                        </tr>
                                        <tr  class="success">
                                            <td width="50%" colspan="2"><strong>Urban/Rural Location Information of the Organization</strong></td>
                                            <!--<td><?php // echo $data['org_code'];      ?></td>-->
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Urban/Rural Location</strong></td>
                                            <td><?php // echo $data['org_code'];      ?></td>
                                        </tr>
                                        <tr  class="success">
                                            <td width="50%" colspan="2"><strong>Regional location of the organization</strong></td>
                                            <!--<td><?php // echo $data['org_code'];      ?></td>-->
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
                                            <td width="50%"><strong>Upazila Name</strong></td>
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
                                            <td><a href="#" class="text-input" id="longitude" ><?php echo $data['longitude']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Latitude</strong></td>
                                            <td><a href="#" class="text-input" id="latitude" ><?php echo $data['latitude']; ?></a></td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane" id="ownership-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Ownership</strong></td>
                                        <td width="50%"><a href="#" class="" id="ownership_code" ><?php echo getOrgOwnarshioNameFromCode($data['ownership_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Type</strong></td>
                                        <td width="50%"><a href="#" class="" id="org_type_code" ><?php echo getOrgTypeNameFormOrgTypeCode($data['org_type_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Function</strong></td>
                                        <td width="50%"><a href="#" class="" id="org_function_code" ></a></td>
                                        <script>
                                            var org_function_value = "<?php echo $data['org_function_code']; ?>";
                                        </script>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Organization Level</strong></td>
                                        <td width="50%"><a href="#" class="" id="org_level_code" ><?php echo getOrgLevelNamefromCode($data['org_level_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Health Care Level</strong></td>
                                        <td width="50%"><a href="#" class="" id="org_healthcare_level_code" ><?php echo $data['org_healthcare_level_code']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Special service / status of the hospital / clinic</strong></td>
                                        <td width="50%"><a href="#" class="" id="special_service_code" ></a></td>
                                    <script>
                                        var special_service_code_values = "<?php echo $data['special_service_code']; ?>";
                                    </script>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="permission_approval-info">
                                <table class="table table-striped table-hover">
                                    <!--
                                    <tr>
                                        <td width="60%"><strong>Special service / status of the hospital / clinic</strong></td>
                                        <td><a href="#" class="text-input" id="land_mutation_number" ><?php // echo $data['org_code'];      ?></a></td>
                                    </tr>
                                    -->

                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Permission/Approval/License information</strong></td>
                                    </tr>

                                    <tr>
                                        <td width="60%"><strong>Date of Permission/Approval/License information</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_info_date" ><?php echo $data['permission_approval_license_info_date']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/Approval/License Type</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_type" ><?php echo $data['permission_approval_license_type']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/ Approval/ License Authority</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_aithority" ><?php echo $data['permission_approval_license_aithority']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Permission/ Approval/ License No</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_number" ><?php echo $data['permission_approval_license_number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Next renewal Date</strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_next_renewal_date" ><?php echo $data['permission_approval_license_next_renewal_date']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="60%"><strong>Conditions given for permission/ approval/ license or renewal thereof </strong></td>
                                        <td><a href="#" class="text-input" id="permission_approval_license_conditions" ><?php echo $data['permission_approval_license_conditions']; ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="contact-info">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td width="50%"><strong>Mailing Address</strong></td>
                                        <td><a href="#" class="textarea-input" id="mailing_address" ><?php echo $data['mailing_address']; ?></a></td>
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
                                        <td><?php // echo $data['org_code'];      ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Website3</strong></td>
                                        <td><?php // echo $data['district_code'];      ?></td>
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
                                    <?php if ($isCommunityClinic): ?>
                                        <tr class="success">
                                            <td><strong>Additional Information</strong></td>
                                            <td></td>
                                        </tr>
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
                                            <td><!-- <a href="#" class="text-input" id="additional_community_group_info" ><?php echo $data['additional_community_group_info']; ?></a> --></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Name of Chairman (CG)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_chairnam_name" ><?php echo $data['additional_chairnam_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No (CG)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_chairman_contact" ><?php echo $data['additional_chairman_contact']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Community Support group information </strong></td>
                                            <td><!-- <a href="#" class="text-input" id="additional_chairman_community_support_info" ><?php echo $data['additional_chairman_community_support_info']; ?></a> --></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Name of Chairman (CSG-1)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_csg_1_name" ><?php echo $data['additional_csg_1_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No (CSG-1)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_csg_1_contact" ><?php echo $data['additional_csg_1_contact']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Name of Chairman (CSG-2)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_csg_2_name" ><?php echo $data['additional_csg_2_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><strong>Contact No (CSG-2)</strong></td>
                                            <td><a href="#" class="text-input" id="additional_csg_2_contact" ><?php echo $data['additional_csg_2_contact']; ?></a></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                            <div class="tab-pane" id="facility-info">
                                <table class="table table-striped table-hover">
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Source of Electricity</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Main source of electricity</td>
                                        <td><a href="#" class="" id="source_of_electricity_main_code" ><?php echo getElectricityMainSourceNameFromCode($data['source_of_electricity_main_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Alternate source of electricity</td>
                                        <td><a href="#" class="" id="source_of_electricity_alternate_code" ><?php echo getElectricityAlterSourceNameFromCode($data['source_of_electricity_alternate_code']); ?></a></td>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Source of water Supply</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Main water supply</td>
                                        <td><a href="#" class="" id="source_of_water_supply_main_code" ><?php echo getWaterMainSourceNameFromCode($data['source_of_water_supply_main_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Alternate water supply</td>
                                        <td><a href="#" class="" id="source_of_water_supply_alternate_code" ><?php echo getWaterAlterSourceNameFromCode($data['source_of_water_supply_alternate_code']); ?></a></td>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Toilet Facility</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Toilet type</td>
                                        <td><a href="#" class="" id="toilet_type_code" ><?php echo getToiletTypeNameFromCode($data['toilet_type_code']); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Toilet adequacy</td>
                                        <td><a href="#" class="" id="toilet_adequacy_code" ><?php echo getToiletAdequacyNameFromCode($data['toilet_adequacy_code']); ?></a></td>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Fuel Source</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Fuel source</td>
                                        <td><a href="#" class="" id="fuel_source_code" ></a></td>
                                        <script>
                                            var fuel_source_code_values = "<?php echo $data['fuel_source_code']; ?>";
                                        </script>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Laundry System</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Laundry system</td>
                                        <td><a href="#" class="" id="laundry_code" ></a></td>
                                        <script>
                                            var laundry_code_values = "<?php echo $data['laundry_code']; ?>";
                                        </script>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Autoclave System</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Autoclave System</td>
                                        <td><a href="#" class="" id="autoclave_code" ></a></td>
                                        <script>
                                            var autoclave_code_values = "<?php echo $data['autoclave_code']; ?>";
                                        </script>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Waste Disposal System</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Waste disposal</td>
                                        <td><a href="#" class="" id="waste_disposal_code" ></a></td>
                                        <script>
                                            var waste_disposal_code_values = "<?php echo $data['waste_disposal_code']; ?>";
                                        </script>
                                    </tr>
                                    <tr class="success">
                                        <td width="50%" colspan="2"><strong>Sanctioned Assets</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Sanctioned Office equipment</td>
                                        <td><a href="#" class="text-input" id="sanctioned_office_equipment" ><?php echo $data['sanctioned_office_equipment']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Sanctioned vehicles</td>
                                        <td><a href="#" class="text-input" id="sanctioned_vehicles" ><?php echo $data['sanctioned_vehicles']; ?></a></td>
                                    </tr>
                                    <?php if($showSanctionedBed): ?>
                                    <tr>
                                        <td width="50%">Sanctioned Bed No</td>
                                        <td><a href="#" class="text-input" id="sanctioned_bed_number" ><?php echo $data['sanctioned_bed_number']; ?></a></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td width="50%">Other miscellaneous issues</td>
                                        <td><a href="#" class="text-input" id="other_miscellaneous_issues" ><?php echo $data['other_miscellaneous_issues']; ?></a></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="land-info">
                                <table class="table table-striped table-hover">
                                    <!--
                                    <tr>
                                        <td width="50%"><strong>Land Information</strong></td>
                                        <td><a href="#" class="text-input" id="land_info_code" ><?php echo $data['land_info_code']; ?></a></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td width="50%"><strong>Land size (in decimal)</strong></td>
                                        <td><a href="#" class="text-input" id="land_size" ><?php echo $data['land_size']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mouza name</strong></td>
                                        <td><a href="#" class="text-input" id="land_mouza_name" ><?php echo $data['land_mouza_name']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Geocode of Mouza</strong></td>
                                        <td><a href="#" class="text-input" id="land_mouza_geo_code" ><?php echo $data['land_mouza_geo_code']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>JL No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_jl_number" ><?php echo $data['land_jl_number']; ?></a></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td width="50%"><strong>Functional Code</strong></td>
                                        <td><a href="#" class="text-input" id="land_functional_code" ><?php echo $data['land_functional_code']; ?></a></td>
                                    </tr>
                                    -->

									  <tr>
                                        <td width="50%"><strong>SA Dag No</strong></td>
                                        <td><a href="#" class="text-input" id="land_ss_dag_number" ><?php echo $data['land_ss_dag_number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>RS Dag No</strong></td>
                                        <td><a href="#" class="text-input" id="land_rs_dag_number" ><?php echo $data['land_rs_dag_number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Khatian No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_kharian_number" ><?php echo $data['land_kharian_number']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Mutation No.</strong></td>
                                        <td><a href="#" class="text-input" id="land_other_info" ><?php echo $data['land_other_info']; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><strong>Other land information.</strong></td>
                                        <td><a href="#" class="text-input" id="land_mutation_number" ><?php echo $data['land_mutation_number']; ?></a></td>
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
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <script>
            $(function() {
                $('.nav-tab-ul #basic-info').tab('show');
            });
        </script>
        <script>
            $.fn.editable.defaults.mode = 'inline';

            var org_code = <?php echo $org_code; ?>;
            var selected_div_name = $("#division_name").text();

            $("#district_name").change(function() {
                selected_div_name = $("#division_name").text();
            });

        </script>
        <script src="assets/js/common.js"></script>
    </body>
</html>

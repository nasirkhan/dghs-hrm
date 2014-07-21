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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
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

            <!-- Docs nav
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
                    <!-- info area
                    ================================================== -->
                    <section id="report">

                        <h3>List of report pages</h3>
                        
                        <div class="row-fluid">
                            Designation wise report
                            <ul>
                                <li>
                                    <a href="report_master.php?t=post&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=&noDatatable=true&f_staff_professional_category=1&f_org_type_code=1&f_designation=1&SQLSelect=p.pay_scale!%3D0+AND+p.active+%3D+1&SQLGroup=class%2Cpay_scale%2Ctype_of_post_name%2Cdesignation&ColOrder=designation%2Ctype_of_post_name%2Cclass%2Cpay_scale&ColAlias=Designation%2CType+of+Post%2CClass%2CPayscale&orderbyfull=pay_scale%2Cdesignation_ranking&rTitle=Designation+Wise+Report&submit=">Designation Wise Summary Report </a>
                                </li>
                                <li>
                                    <a href="report_master.php?t=post&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=7&noDatatable=true&f_staff_professional_category=1&f_org_type_code=1&f_group_code=1&SQLSelect=p.pay_scale!%3D0+AND+p.active+%3D+1+AND+p.designation_group_name!%3D+%27%27&SQLGroup=designation_group_name%2Cpay_scale&ColOrder=designation_group_name%2Cclass%2Cpay_scale&ColAlias=&orderbyfull=pay_scale%2Cdesignation_ranking&rTitle=Designation+Group+wise+Summary+Report&submit=">Designation Group Wise Summary Report </a>
                                </li>
                                <li>
                                    <a href="report_institute_wise_designation_summary.php">Institute Wise Designation Summary Report </a>
                                </li>
                                <li>
                                    <a href="report_type_of_post_and_institute_wise_designation.php">Type of post and Institute wise designation</a>
                                </li>
                                <li>
                                    <a href="report_master.php?t=post&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=&noDatatable=true&f_staff_professional_category=1&f_org_type_code=1&SQLSelect=p.active+%3D+1&SQLGroup=p.org_name&ColOrder=org_name&ColAlias=Institute+Name&orderbyfull=&rTitle=Institute+Wise+Summary+Report&submit=">Institute Wise Summary Report</a>
                                </li>
                            </ul>
                            Personnel wise report
                            <ul>
                                <li>
                                    <a href="report_master.php?t=&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=&noDatatable=true&f_org_type_code=1&f_professional_discipline_of_current_designation=1&f_group_code=1&SQLSelect=p.pay_scale!%3D0+AND+p.active+%3D+1+AND+s.staff_name!%3D+%27%27&SQLGroup=&ColOrder=designation_group_name%2Cdiscipline%2Cstaff_id%2Cstaff_name%2Cbirth_date%2Cjob_posting_name%2Corg_name%2Ccontact_no&ColAlias=Designation+Group+Name%2CDiscipline%2CPDS+Code+No.%2CName%2CDate+of+Birth%2CPosting+Status%2CPlace+of+Posting%2CMobile+No&orderbyfull=pay_scale%2Cdesignation_ranking&rTitle=Discipline+wise+report+with+Designation+group&submit=">Discipline wise report with Designation group</a>
                                </li>
                                <li>
                                    <a href="report_master.php?t=&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=&noDatatable=true&f_org_type_code=1&f_professional_discipline_of_current_designation=1&f_group_code=1&SQLSelect=p.pay_scale!%3D0+AND+p.active+%3D+1+AND+s.staff_name!%3D+%27%27&SQLGroup=&ColOrder=discipline%2Cdesignation%2Cstaff_id%2Cstaff_name%2Cbirth_date%2Cjob_posting_name%2Corg_name%2Ccontact_no&ColAlias=Discipline%2CDesignation+Group+Name%2CEmployee+No%2CName%2CDate+of+Birth%2CPosting+Status%2CPlace+of+Posting%2CMobile+No&orderbyfull=pay_scale%2Cdesignation_ranking&rTitle=Designation+group+wise+report+with+discipline&submit=">Designation group wise report with discipline</a>
                                </li>
                                <li>
                                    <a href="report_master.php?t=&f_division_code=1&division_code=&f_district_code=1&district_code=&admin_upazila=1&upazila_id=&noDatatable=true&f_designation=1&SQLSelect=p.pay_scale!%3D0+AND+p.active+%3D+1+AND+s.staff_name!%3D+%27%27&SQLGroup=&ColOrder=designation%2Cstaff_id%2Cstaff_pds_code%2Cstaff_name%2Cbirth_date%2Cjob_posting_name%2Corg_name%2Ccontact_no&ColAlias=Designation%2CEmployee+No%2CCode%2CName%2CDate+of+Birth%2CPosting+Status%2CPlace+of+Posting%2CMobile+No&oorderbyfull=pay_scale%2Cdesignation_ranking&rTitle=Designation+wise+report+&submit=">Designation wise report </a>
                                </li>
                                <li>
                                    <a href="report_lpr.php">LPR information</a>
                                </li>
                                <li>
                                    <a href="report_staff_list_by_permanenet_address.php">District (permanent address) wise list</a>
                                </li>
                                <li>
                                    <a href="report_posting_status_wise_list.php">Posting Status wise list</a>
                                </li>
                            </ul>
                            Other Reports
                            <ul>
                                <li><a href="report_monthly_update.php">Monthly Update Summary</a></li>
                            </ul>
<!--                            <table class="table table-striped table-bordered">
                                
                                <tbody>
                                    <?php if (hasPermission('mod_report_summary_report_link', 'view', getLoggedUserName())) : ?>
                                    <tr>
                                        <td><a href="report_summary.php?org_code=<?php echo $org_code; ?>">Organization Summary Report</a></td>                                        
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (hasPermission('mod_report_all_report_link', 'view', getLoggedUserName())) : ?>
                                    
                                    <tr>                                        
                                        <td><a href="report_manpower.php">Summary Report Includes All Organization</a></td>
                                    </tr>
                                    
                                    <tr>                                        
                                        <td><a href="report_org_list_1.1.php">Organization List</a></td>
                                    </tr>
                                    
                                    <tr>                                        
                                        <td><a href="report_designation_report.php">Designation Report</a></td>
                                    </tr>
                                    
                                    <tr>                                        
                                        <td><a href="report_designation_with_who_category.php">Summary Report WHO Health Professional Group (All Organization)</a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_monthly_update.php">Monthly Update Summary</a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_staff_list_by_permanenet_address.php">Staff District (permanent address) wise list</a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_staff_list_by_designation_group_without_descipline.php">Staff list by designation group report without discipline</a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_staff_list_by_designation_group_with_descipline.php">Staff list by designation group report with discipline</a></td>
                                    </tr>
                                    
                                    <tr>                                        
                                        <td><a href="report_post_status_summary.php">Post Status Summary Report</a></td>
                                    </tr>
                                    
                                    <tr>                                        
                                        <td><a href="report_staff_list_by_descipline_with_designation_group.php">Staff list report by discipline with designation group </a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_designation_summary.php">Designation Summary Report </a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_designation_group_summary.php">Designation Group Summary Report </a></td>
                                    </tr>
                                    <tr>                                        
                                        <td><a href="report_lpr.php">LPR Report </a></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>-->
                                
                            </table>
                            
                        </div>

                    </section>

                </div>
            </div>

        </div>

        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>


    </body>
</html>

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

            <!-- Docs nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php if ($_SESSION['user_type'] == "admin"): ?>
                            <li><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-qrcode"></i> Admin Homepage</a>
                            <?php endif; ?>
                        <li class="active"><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-copy"></i> Match Employee</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <section id="organization-profile">
                        <div class="row">
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

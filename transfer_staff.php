<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';

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
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>
        <link href="assets/css/move_staff.css" rel="stylesheet"/>
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
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- main
                    ================================================== -->
                    
                    <!--
                    Release list
                    -->
                    <?php 
                    $data = showTransferList($org_code, 'from_working_org_code', 'order', 'list');
                    $data_count = showTransferList($org_code, 'from_working_org_code', 'order', 'count');
                    
                    if ($data_count > 0):
                    ?>
                    <h3> Release List</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Staff Name</td>
                                <td>Staff ID</td>
                                <td>Designation</td>
                                <td>Class</td>
                                <td>Pay Scale</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i< $data_count; $i++): 
                            $staff_info = getStaffInfoFromStaffId($data['staff_id']);
                        
                            $sanctioned_post_info = getSanctionedPostInfoFromStaffId($data['staff_id']);
                            ?>

                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo getStaffNameFromId($data['staff_id']);?></td>
                                <td><?php echo $data['staff_id']; ?></td>
                                <td><?php echo $sanctioned_post_info['designation'];?></td>
                                <td><?php echo $sanctioned_post_info['class'];?></td>
                                <td><?php echo $sanctioned_post_info['pay_scale'];?></td>
                                <td><a href="transfer_staff.php?staff_id=<?php echo $data['staff_id']; ?>&action=release" class="btn btn-warning btn-small" >Release</td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                    

                    <!--
                    Join list
                    -->
                    <?php 
                    $data = showTransferList($org_code, 'to_working_org_code', 'join', 'list');
                    $data_count = showTransferList($org_code, 'to_working_org_code', 'join', 'count');

                    if ($data_count > 0):
                    ?>
                    <h3> Join List</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Staff Name</td>
                                <td>Staff ID</td>
                                <td>Designation</td>
                                <td>Class</td>
                                <td>Pay Scale</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i< $data_count; $i++): 
                            $staff_info = getStaffInfoFromStaffId($data['staff_id']);
                        
                            $sanctioned_post_info = getSanctionedPostInfoFromStaffId($data['staff_id']);
                            ?>

                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo getStaffNameFromId($data['staff_id']);?></td>
                                <td><?php echo $data['staff_id']; ?></td>
                                <td><?php echo $sanctioned_post_info['designation'];?></td>
                                <td><?php echo $sanctioned_post_info['class'];?></td>
                                <td><?php echo $sanctioned_post_info['pay_scale'];?></td>
                                <td>
                                    <?php if ($data['status'] == "release"): ?>
                                        <a href="transfer_staff.php?staff_id=<?php echo $data['staff_id']; ?>&action=join" class="btn btn-info btn-small" >
                                    <?php else: ?>
                                        <a href="" class="btn btn-info btn-small disabled" >
                                    <?php endif; ?>    
                                        Join
                                    </a>
                                </td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div> <!-- /main -->
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
          
    </body>
</html>

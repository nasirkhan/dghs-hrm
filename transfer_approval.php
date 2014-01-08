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
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <section id="organization-profile">

                        <h3>Transfer Approval</h3>

                        <div class="row-fluid">

                            <div class="span12">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Requested By</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $sql = "SELECT
                                                    *
                                            FROM
                                                    `transfer_post`
                                            WHERE
                                                    `active` = 1
                                                AND
                                                    `status` = 1;";
                                        $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");

                                        while ($data = mysql_fetch_assoc($result)):
                                            ?>
                                            <tr>
                                                <td><?php echo getStaffNameFromId($data['staff_id']); ?></td>
                                                <td><?php echo getDesignationNameFormSanctionedPostId($data['present_sanctioned_post_id']); ?> <br />(<?php echo getOrgNameFormOrgCode($data['present_org_code']); ?>)</td>
                                                <td><?php echo getDesignationNameFormSanctionedPostId($data['move_to_sanctioned_post_id']); ?> <br />(<?php echo getOrgNameFormOrgCode($data['move_to_org_code']); ?>)</td>
                                                <td><?php echo $data['updated_by']; ?></td>
                                                <td><?php echo $data['update_time']; ?></td>
                                                <td>
                                                    <div id="div<?php echo $data['id']; ?>">
                                                        <button id="approve-<?php echo $data['id']; ?>" class="btn btn-success" value="approve"><?php echo "Approve"; ?></button>
                                                        <button id="cancel-<?php echo $data['id']; ?>" class="btn btn-danger" value="cancel"><?php echo "Cancel"; ?></button>
                                                    </div>
                                                </td>
                                                <script type="text/javascript">

                                                $("#approve-<?php echo $data['id']; ?>").click(function (){
                                                    $.ajax({
                                                        type: "POST",
                                                        url: 'post/post_transfer.php',
                                                        data: {id:<?php echo $data['id']; ?>, action: "approve"},
                                                        success: function(data) {
                                                            $("#loading_content").hide();
                                                            $("#div<?php echo $data['id']; ?>").html("");
                                                            $("#div<?php echo $data['id']; ?>").html(data);
                                                        }
                                                    });
                                                });
                                                $("#cancel-<?php echo $data['id']; ?>").click(function (){
                                                    $.ajax({
                                                        type: "POST",
                                                        url: 'post/post_transfer.php',
                                                        data: {id:<?php echo $data['id']; ?>, action: "cancel"},
                                                        success: function(data) {
                                                            $("#loading_content").hide();
                                                            $("#div<?php echo $data['id']; ?>").html("");
                                                            $("#div<?php echo $data['id']; ?>").html(data);
                                                        }
                                                    });
                                                });
                                                </script>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
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
    </body>
</html>

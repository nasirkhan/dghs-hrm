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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Nasir Khan Saikat(nasir8891@gmail.com)">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
        
        <script src="assets/js/jquery.js"></script>
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
                        <li><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-qrcode"></i> Admin Homepage</a>
                        <li><a href="search.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-search"></i> Search</a></li>
                        <li><a href="add_new.php"><i class="icon-chevron-right"></i><i class="icon-plus"></i> Add New</a>
                        
<!--                        <li class="active"><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-copy"></i> Match Employee</a></li>		-->
                        <li class="active"><a href="transfer_approval.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-random"></i> Transfer Approval</a></li>		
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>		
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
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
                                                <td><?php echo getDesignationNameFormSanctionedPostId($data['present_sanctioned_post_id']); ?></td>
                                                <td><?php $desInfo = getDesignationInfoFromCode($data['move_to_designation_id']); echo $desInfo['designation']; ?></td>
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
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
        <!--<script src="assets/js/jquery.js"></script>-->
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

    </body>
</html>

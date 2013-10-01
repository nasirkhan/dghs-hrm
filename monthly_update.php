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
date_default_timezone_set('Asia/Dhaka');
$current_year = date("Y");
$current_month = date("n");


if (isset($_POST['postt_type'])) {
    $move_in = mysql_real_escape_string(trim($_POST['move_in']));
    $move_out = mysql_real_escape_string(trim($_POST['move_out']));
    $add_new = mysql_real_escape_string(trim($_POST['add_new']));
    $match_staff = mysql_real_escape_string(trim($_POST['match_staff']));
    $current_year = mysql_real_escape_string(trim($_POST['current_year']));
    $current_month = mysql_real_escape_string(trim($_POST['current_month']));
    $org_code = mysql_real_escape_string(trim($_POST['org_code']));

    $sql = "SELECT
                    *
            FROM
                    monthly_update
            WHERE
                    org_code = $org_code
            AND report_year = $current_year
            AND report_month = $current_month
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>monthlyUpdate:1</p><p>Query:</b></p>___<p>$sql</p>");

    if (mysql_num_rows($result) == 1) {
        $username = $_SESSION['username'];
        $sql = "UPDATE 
                    monthly_update 
                SET 
                    move_in=$move_in,
                    move_out=$move_out,
                    add_profile=$add_new,
                    match_employee=$match_staff,
                    updated_by=\"$username\"    
                WHERE
                    org_code = $org_code
                    AND 
                    report_year = $current_year
                    AND 
                    report_month = $current_month";
        $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>monthlyUpdate:1</p><p>Query:</b></p>___<p>$sql</p>");
    }
    else{
        $username = $_SESSION['username'];
        $sql = "INSERT INTO 
            `monthly_update` (`org_code`, `report_month`, `report_year`, `move_in`, `move_out`, `add_profile`, `match_employee`, `updated_by`, `updated_datetime`) 
            VALUES ('$org_code', '$current_month', '$current_year', '$move_in', '$move_out', '$add_new', '$match_staff', \"$username\", \"" . date("Y-m-d H:i:s")  . "\")";
        $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>monthlyUpdate:1</p><p>Query:</b></p>___<p>$sql</p>");
    }
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
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-copy"></i> Match Employee</a></li>		
                        <li class="active"><a href="monthly_update.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-th-list"></i> Monthly Update</a></li>		
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>		
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <section id="mothly_update">
                        <h3>Monthly Update Summary</h3>
                        <div class="row">

                            <div class="span9">

                                <?php if ($_GET['update'] == ""): ?>

                                    <div class="well well-large">

                                        <p class="lead">

                                            Do you want to submit the update report of HRM for this month?

                                        </p>

                                        <p>
                                            <a class="btn btn-large btn-success" type="button" href="monthly_update.php?update=yes&year=<?php echo "$current_year"; ?>&month=<?php echo "$current_month"; ?>&org_code=<?php echo "$org_code"; ?>">Yes, update now</a>
                                            <a class="btn btn-large btn-warning" type="button" href="monthly_update.php?update=no&year=<?php echo "$current_year"; ?>&month=<?php echo "$current_month"; ?>&org_code=<?php echo "$org_code"; ?>">No, update later</a>
                                        </p>

                                    </div>

                                <?php endif; ?>

                                <?php if ($_GET['update'] == "yes"): ?>
                                    <?php
                                    $current_month = mysql_real_escape_string(trim($_GET['month']));
                                    $current_year = mysql_real_escape_string(trim($_GET['year']));
                                    $org_code = mysql_real_escape_string(trim($_GET['org_code']));

                                    $sql = "SELECT
                                                *
                                        FROM
                                                monthly_update
                                        WHERE
                                                org_code = $org_code
                                        AND report_year = $current_year
                                        AND report_month = $current_month
                                        LIMIT 1";
                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>monthlyUpdate:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                    if (mysql_num_rows($result) == 1) {
                                        $data = mysql_fetch_assoc($result);

                                        $current_month = $data['report_month'];
                                        $current_year = $data['report_year'];
                                        $org_code = $data['org_code'];
                                    }
                                    ?>


                                    <form class="form-horizontal" action="" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="move_in">Total Move Out</label>
                                            <div class="controls">
                                                <input type="text" id="move_in" name="move_in" placeholder="Total Move Out" value="<?php echo $data['move_in']; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="move_out">Total Move In</label>
                                            <div class="controls">
                                                <input type="text" id="move_out" name="move_out" placeholder="Total Move In" value="<?php echo $data['move_out']; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="add_new">Total Add Profile</label>
                                            <div class="controls">
                                                <input type="text" id="add_new" name="add_new" placeholder="Total Add Profile" value="<?php echo $data['add_profile']; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="match_staff">Total Match Employee</label>
                                            <div class="controls">
                                                <input type="text" id="match_staff" name="match_staff" placeholder="Total Match Employee" value="<?php echo $data['match_employee']; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="match_staff"><em>Last Updated on</em></label>
                                            <label class="control-label" for="match_staff"><em><?php echo $data['updated_datetime']; ?></em></label>
                                        </div>
                                        <input type="hidden" name="current_month" value="<?php echo "$current_month"; ?>">
                                        <input type="hidden" name="current_year" value="<?php echo "$current_year"; ?>">
                                        <input type="hidden" name="org_code" value="<?php echo "$org_code"; ?>">

                                        <input type="hidden" name="postt_type" value="update_report">
                                        <div class="control-group">
                                            <div class="controls">                                                
                                                <button type="submit" class="btn btn-large btn-info">Update Report</button>
                                            </div>
                                        </div>
                                    </form>

                                <?php endif; ?>


                                <?php if ($_GET['update'] == "no"): ?>


                                <?php endif; ?>
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
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

    </body>
</html>

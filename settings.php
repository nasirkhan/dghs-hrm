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
if ($org_type_code == 1029 || $org_type_code == 1051) {
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])) {
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


$username = $_SESSION['username'];


$oldPasswordCorrect = TRUE;
$newPassMatched = TRUE;
$passwordUpdated = FALSE;

if ($_POST['changePassword'] == 'true') {
    // Password Change request
    $inputOldPassword = $_POST['inputOldPassword'];
    $inputNewPassword = $_POST['inputNewPassword'];
    $inputNewPassword2 = $_POST['inputNewPassword2'];

//check if new password has been entered correctly or not
    if ($inputNewPassword == $inputNewPassword2) {
        $newPassMatched = TRUE;
    } else {
        $newPassMatched = FALSE;
    }

//  check if old passwprd is correc    
    $oldPasswordCorrect = checkPasswordIsCorrect($username, $inputOldPassword);

// update new password
    if ($oldPasswordCorrect && $newPassMatched) {
        updatePassword($username, $inputNewPassword);
        $passwordUpdated = TRUE;
    }
}

/**
 * *****************************************************************************
 * 
 * submitted by admin
 * 
 * *****************************************************************************
 */
// 
if (isset($_POST['changePassword']) && ($_POST['changePassword'] == 'admin_true')) {
    // Password Change request
    $inputNewPassword = mysql_real_escape_string(trim($_POST['inputNewPassword']));

    $user_username = mysql_real_escape_string(trim($_POST['user_username']));
    $user_email = $user_username;
    $user_password = $inputNewPassword;
    $user_id = mysql_real_escape_string(trim($_POST['user_id']));
    $user_org_code = mysql_real_escape_string(trim($_POST['user_org_code']));

    // update user table
    $sql = "UPDATE `user` SET "
            . "`username`= '$user_username',"
            . "`email` = '$user_email',"
            . "`password` = '" . md5($user_password) . "'"
            . "WHERE `org_code` = '$user_org_code' AND `id` = '$user_id'";
    //    echo "<pre>$sql</pre>";
    $result = mysql_query($sql) or die(mysql_error() . "<br />updatePassword:1<br /><b>Query:</b><br />___<br />$sql<br />");


    // update 'email addtess' in organizaion table
    $sql = "UPDATE `organization` SET "
            . "`email_address1`= '$user_username'"
            . "WHERE `org_code` = '$user_org_code'";
    //    echo "<pre>$sql</pre>";
    $result = mysql_query($sql) or die(mysql_error() . "<br />updatePassword:1<br /><b>Query:</b><br />___<br />$sql<br />");

    // emil the user$to  = "$user_name";
    $to = "$user_username";
    $password = $user_password;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "To: $to \r\n";
    $headers .= 'From: MIS DGHS <info@dghs.gov.bd>' . "\r\n";
    $subject = "[HRM] Email Notification for Password change ";
    $message = "Your password has been changed. ";
    $message .= "Your new password is " . $password;
    mail($to, $subject, $message, $headers);
    
    // load the same page
    header("location:settings.php?org_code=$user_org_code");
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
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">        

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <?php include_once 'include/header/header_icon.inc.php'; ?>

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

            <!-- Navigation
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">  
                        <?php if ($_SESSION['user_type'] == "admin"): ?>
                            <li><a href="admin_home.php"><i class="icon-chevron-right"></i><i class="icon-qrcode"></i> Admin Homepage</a>
                            <?php endif; ?>
                            <?php
                            $active_menu = "settings";
                            include_once 'include/left_menu.php';
                            ?>    
                    </ul>
                </div>
                <div class="span9">
                    <!-- main 
                    ================================================== -->
                    <section id="user_settings">

                        <div class="row">
                            <div class="span9">
                                <?php if (!$newPassMatched): ?>
                                    <div class="">
                                        <div class="alert alert-block alert-Warnign">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <p class="lead"><strong>Warning!</strong><br /> 
                                                You have to write the "New Password" twice.<br />
                                                But unfortunately you have entered two different words in two input fields.<br />
                                                Please try again. 
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($passwordUpdated): ?>
                                    <div class="">
                                        <div class="alert alert-block alert-success">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <p class="lead"><strong>Congratulation!</strong><br /> 
                                                Your password has been changed successfully.<br />
                                                You have to use this new password from your next login.
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!$oldPasswordCorrect): ?>
                                    <div class="">
                                        <div class="alert alert-block alert-error">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <p class="lead"><strong>Warning!</strong><br /> 
                                                Your have entered a wrong "Old Password"<br />
                                                Please try again with the accurate credential.
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <h3>Change Password</h3>
                                <?php
                                if ($_SESSION['user_type'] == 'admin' && $org_code != 99999999):
                                    $user_info = getUserInfoFromOrgCode($org_code);
                                    $user_id = $user_info['id'];
                                    $user_username = $user_info['username'];
                                    $user_password = $user_info['password'];
                                    $user_org_code = $user_info['org_code'];
                                    ?>
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="control-group">
                                            <label class="control-label" for="username">Login username</label>
                                            <div class="controls">
                                                <input type="text" id="user_username" name="user_username" value="<?php echo $user_username; ?>" class="input-xlarge " required=""> 
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">New Password</label>
                                            <div class="controls">
                                                <input type="password" id="inputNewPassword" name="inputNewPassword" placeholder="New Password" class="input-xlarge " required=""> 
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">   
                                                <input type="hidden" id="changePassword" name="changePassword" value="admin_true"> 
                                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                                <input type="hidden" id="user_org_code" name="user_org_code" value="<?php echo $user_org_code; ?>">
                                                <button type="submit" class="btn btn-success">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php else: ?>

                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail">Login Email</label>
                                            <div class="controls">
                                                <span class="input-xlarge uneditable-input"><?php echo $username; ?></span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">Old Password</label>
                                            <div class="controls">
                                                <input type="password" id="inputOldPassword" name="inputOldPassword" placeholder="Old Password" class="input-xlarge "> 
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">New Password</label>
                                            <div class="controls">
                                                <input type="password" id="inputNewPassword" name="inputNewPassword" placeholder="New Password" class="input-xlarge "> 
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">New Password(Type again)</label>
                                            <div class="controls">
                                                <input type="password" id="inputNewPassword2" name="inputNewPassword2" placeholder="New Password (Type again)" class="input-xlarge "> 
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">   
                                                <input type="hidden" id="changePassword" name="changePassword" value="true"> 
                                                <button type="submit" class="btn btn-success">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
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

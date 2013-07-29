<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
$org_code = $_GET['org_code'];
if ($org_code == "") {
    $org_code = $_SESSION['org_code'];
}
//$org_code = $_SESSION['org_code'];
$org_code = (int) $org_code;
$username = getEmailAddressFromOrgCode($org_code);


$oldPasswordCorrect = TRUE;
$newPassMatched = TRUE;
$passwordUpdated =FALSE;

if ($_POST['changePassword'] == 'true'){
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
    if($oldPasswordCorrect && $newPassMatched){
        updatePassword($username, $inputNewPassword);
        $passwordUpdated = TRUE;
    }
}



//org_code 10000001
//$sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
//$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//
//// data fetched form organization table
//$data = mysql_fetch_assoc($result);
//
//$org_name = $data['org_name'];
//$org_code = $data['org_code'];

$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
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
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.ie.css" />
        <![endif]-->

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
                                <a href="./index.html">Home</a>                                
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

            <!-- Navigation
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li class="active"><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Download
                    ================================================== -->
                    <section id="organization-profile">

                        <div class="row">
                            <div class="span9">
                                <?php if(!$newPassMatched): ?>
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
                                
                                <?php if($passwordUpdated): ?>
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
                                
                                <?php if(!$oldPasswordCorrect): ?>
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

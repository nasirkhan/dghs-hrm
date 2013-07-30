<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
if ($_SESSION['user_type'] != 'admin') {
    header("location:home.php");
}

// set org_code
$org_code = mysql_real_escape_string($_GET['org_code']);
if ($org_code == "") {
    $org_code = $_SESSION['org_code'];
}
if ($_SESSION['user_type'] == "admin") {
    $org_code = mysql_real_escape_string($_GET['org_code']);

    if ($org_code == "") {
        $org_code = "99999999";
    }
}
$org_code = (int) $org_code;



$sql = "SELECT org_name,org_type_code FROM organization WHERE  org_code =$org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

// data fetched form organization table
$data = mysql_fetch_assoc($result);

$org_name = $data['org_name'];
$org_type_name = $data['org_type_name'];
$user_name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Nasir Khan Saikat">

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

            <!-- Docs nav
            ================================================== -->
            <div class="row-fluid">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li class="active"><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Admin Homepage</a>
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- admin home
                    ================================================== -->
                    <section id="admin_home_main">
                        <h3>Admin Dashboard</h3>

                        <div class="row-fluid">                            
                            <div class="btn-group span12">
                                <button class="btn btn-large btn-warning" data-toggle="collapse" data-target="#search_org">
                                    <i class="icon-hospital pull-left"></i> Search Organization
                                </button>
                                <button class="btn btn-large btn-info">
                                    <i class="icon-user-md pull-left"></i> Search Staff
                                </button>
                                <button class="btn btn-large btn-primary">
                                    <i class="icon-user pull-left"></i> Search User
                                </button>
                            </div>
                        </div>
                        <!--Search Organization-->
                        <div  id="search_org" class="collapse in">
                            <div class="row-fluid">
                                <div class="span12 alert">
                                    <div class="control-group">
                                        <label class="control-label" for="searchOrg">Search By Organization Name or Organization Code</label>
                                        <div class="controls input-append">
                                            <input type="text" id="searchOrg" class="input-xlarge" placeholder="Write Organization Name or Code">
                                            <button id="btn_search_org" class="btn" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            
                            <div class="row-fluid">
                                <div class="span12 alert">
                                    
                                </div>
                                
                            </div>
                        </div>

                    </section> <!-- /admin_home_main -->                   
                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>



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

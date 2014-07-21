<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

if (isset($_GET['pds_code'])) {
    $pds_code = mysql_real_escape_string(trim($_GET['pds_code']));
    $type = mysql_real_escape_string(trim($_GET['type']));
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
                <h1><?php echo "$org_name $echoAdminInfo"; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- nav
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
                    <!-- Sanctioned Post
                    ================================================== -->
                    <section id="sanctioned-post">

                        <div class="row">
                            <div class="span9">
                                <iframe src="http://pds.dghs.gov.bd:88/hrmreport.aspx?hrid=<?= $pds_code ?>&rType=<?= $type ?>" width="820" height="1100" frameborder="0"></iframe> 
                            </div>
                        </div>                        
                    </section>
                </div>
            </div>
        </div> <!-- /container -->


        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        
    </body>
</html>

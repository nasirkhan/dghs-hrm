<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
$org_code = $_GET['org_code'];
if ($org_code == "") {
    $org_code = $_SESSION['org_code'];
}
$org_code = (int) $org_code;


//org_code 10000001
$sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

// data fetched form organization table
$data = mysql_fetch_assoc($result);

$org_name = $data['org_name'];
$org_code = $data['org_code'];
$org_type_name = getOrgTypeNameFormOrgTypeId($data['org_type_code']);
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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

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

        <!--
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'ACCOUNT_ID']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        -->



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

            <!-- nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li><a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
                        <li><a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a></li>
                        <li class="active"><a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a></li>
                        <li><a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Sanctioned Post
                    ================================================== -->
                    <section id="sanctioned-post">

                        <div class="row">
                            <div class="span9">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sanctioned Post</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT designation, discipline, COUNT(*) AS sp_count 
                                            FROM total_manpower_imported_sanctioned_post 
                                            WHERE org_code = $org_code
                                            GROUP BY designation";
                                        $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                        while ($sp_data = mysql_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo "<div class=\"row\">";
                                            echo "<div class=\"span9\">";
                                            echo "<div class=\"pull-left\">" . $sp_data['designation'] . "</div>";
                                            $designation_div_id = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($sp_data['designation']));
                                            echo "<div class=\"pull-right\">" . $sp_data['sp_count'] . "";
                                            echo " <button type=\"submit\" name=\"btn-$designation_div_id\" id=\"btn-$designation_div_id\" value=\"" . $sp_data['designation'] . "\" class=\"btn btn-info btn-small\" data-toggle=\"collapse\" data-target=\"#$designation_div_id\" >View List</button>";

                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";

                                            // sanctioned post list display
                                            echo "<div class=\"row\">";
                                            echo "<div class=\"span9\">";
                                            echo "<div id=\"$designation_div_id\" class=\"collapse\">";
                                            echo "<strong>First Level Division:</strong> ABCD, <strong>Second Level Division:</strong> EFGH<br />";
                                            echo "<div class=\"clearfix alert alert-info\" id=\"list-$designation_div_id\">";
                                            ?>
                                    <div id="loading-<?php echo $designation_div_id; ?>"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</div>
                                        <script type="text/javascript" language="javascript">
                                            $(document).ready(function() {
                                                $("#btn-<?php echo $designation_div_id; ?>").click(function(event) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "result.php",
                                                        data: {designation: "<?php echo $sp_data['designation']; ?>"},
                                                        dataType: 'json',
                                                        success: function(data) {
                                                            $('#loading-<?php echo $designation_div_id; ?>').hide();
                                                            $('#list-<?php echo $designation_div_id; ?>').html("");
//                                                            $('#list-<?php echo $designation_div_id; ?>').append("<div class=\"row\">");
                                                            $.each(data, function(k,v) {
                                                                $("#list-<?php echo $designation_div_id; ?>").append("<div class=\"row\">");                                                            
                                                                $("#list-<?php echo $designation_div_id; ?>").append("<div class=\"span3\">Sanctioned PostId: " + v.sanctioned_post_id + "</div>");
                                                                $("#list-<?php echo $designation_div_id; ?>").append("<div class=\"span3\">Class: " + v.class + "</div>");
                                                                $("#list-<?php echo $designation_div_id; ?>").append("<div class=\"span2\"> <a href=\"employee.php?staff_id=" + v.sanctioned_post_id + "&sanctioned_post_id=" + v.sanctioned_post_id + "\" target=\"_blank\" name=\"a-btn-<?php echo $designation_div_id; ?>\" id=\"a-btn-<?php echo $designation_div_id; ?>\" class=\"btn btn-warning btn-mini\" data-toggle=\"collapse\" >View Profile</a></div>");
                                                                $('#list-<?php echo $designation_div_id; ?>').append("</div>");
                                                            });
//                                                            $('#list-<?php echo $designation_div_id; ?>').append("</div>");
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        <?php
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </section>

                </div>

            </div>

        </div>


        <div>
            <pre>

            </pre>
        </div>
        <!-- Footer
        ================================================== -->
        <footer class="footer">
            <div class="container">                
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Contact Us</a></li>
                    <li class="muted">&middot;</li>
                    <li><a href="#">Contact Developer</a></li>
                </ul>
            </div>
        </footer>



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

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
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
        
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


        <script src="assets/js/jquery.js"></script>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
        ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn navbar-btn" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="./index.php"><?php echo $app_name; ?></a>
                    <div class="navbar-collapse collapse">
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
                        <li><a href="move_request.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
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
                                <h3>Sanctioned Post</h3>
                                <h5>First Level Divisions</h5>
                                <div class="accordion" id="sanctioned_post_divisions">
                                    <?php
                                    $sql = "SELECT total_manpower_imported_sanctioned_post_copy.first_level_name,
                                                total_manpower_imported_sanctioned_post_copy.first_level_id
                                            FROM total_manpower_imported_sanctioned_post_copy
                                            WHERE total_manpower_imported_sanctioned_post_copy.org_code= $org_code 
                                            AND total_manpower_imported_sanctioned_post_copy.first_level_name != \"\"
                                            GROUP BY total_manpower_imported_sanctioned_post_copy.first_level_name
                                            ORDER BY total_manpower_imported_sanctioned_post_copy.first_level_name";
                                    $first_level_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sanctioned_post_divisions:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                    while ($first_level_list = mysql_fetch_assoc($first_level_result)):
                                        $first_level_accord_id = $designation_div_id = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($first_level_list['first_level_name']));
                                        ;
                                        ?>
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" id="heading<?php echo "$first_level_accord_id"; ?>" data-toggle="collapse" data-parent="#sanctioned_post_divisions" href="#<?php echo "$first_level_accord_id"; ?>">
                                                    <?php echo $first_level_list['first_level_name']; ?>
                                                </a>
                                            </div>
                                            <div id="<?php echo "$first_level_accord_id"; ?>" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                    <p>                                                    
                                                        <button class="btn btn-primary btn-sm" type="button">View Designations</button>
                                                        <button class="btn btn-info btn-sm" type="button" id="load_2nd_for<?php echo $designation_div_id; ?>">View Second Level Divisions</button>
                                                    </p>
                                                    <div id="div_2nd_<?php echo $designation_div_id; ?>"></div>
                                                    <div id="loading-2nd-<?php echo $designation_div_id; ?>"  class="alert" style="display: none;"><i class="icon-spinner icon-spin icon-large"></i> Loading second level divisions...</div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $("#load_2nd_for<?php echo $designation_div_id; ?>").click(function() {
                                                    $("#loading-2nd-<?php echo $designation_div_id; ?>").show();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "get/get_sp_second_level.php",
                                                        data: {
                                                            first_level_id: "<?php echo $first_level_list['first_level_id']; ?>",
                                                            div: "desi_2nd_",
                                                            loading: "loading-desi-"
                                                        },
                                                        success: function(data) {
                                                            $("#loading-2nd-<?php echo $designation_div_id; ?>").hide();
                                                            $('#div_2nd_<?php echo $designation_div_id; ?>').html("");
                                                            $("#div_2nd_<?php echo $designation_div_id; ?>").append(data);
                                                        }
                                                    });

                                                });
                                            </script>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
<!--                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sanctioned Post</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                $sql = "SELECT id, designation, discipline, COUNT(*) AS sp_count 
                                            FROM total_manpower_imported_sanctioned_post_copy 
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
                                    echo "<div class=\"pull-right\">" . $sp_data['sp_count'] . "&nbsp&nbsp&nbsp&nbsp";
                                    echo " <a name=\"sp-btn-$designation_div_id\" id=\"sp-btn-$designation_div_id\" href=\"#sp-$designation_div_id\" role=\"button\" class=\"btn btn-sm\" data-toggle=\"modal\"><i class=\"icon-file-alt\"></i> Sanctioned Post Desctiption</a>";
                                    echo " <button type=\"submit\" name=\"btn-$designation_div_id\" id=\"btn-$designation_div_id\" value=\"" . $sp_data['designation'] . "\" class=\"btn btn-info btn-sm\" data-toggle=\"collapse\" data-target=\"#$designation_div_id\" ><i class=\"icon-list-ul\"></i> View Staff List</button>";

                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    // sanctioned post list display
                                    echo "<div class=\"row\">";
                                    echo "<div class=\"span9\">";
                                    echo "<div id=\"$designation_div_id\" class=\"collapse\">";
//                                            echo "<strong>First Level Division:</strong> ABCD, <strong>Second Level Division:</strong> EFGH<br />";
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
                                                                    $.each(data, function(k, v) {
                                                                        var data_list = "<div class=\"row\">";
                                                                        data_list += "<div class=\"span3\">Sanctioned PostId: " + v.sanctioned_post_id + " (Staff:" + v.staff_id + ") </div>";
                                                                        data_list += "<div class=\"span3\">Class: " + v.class + "</div>";
                                                                        if (v.staff_id > 0) {
                                                                            data_list += "<div class=\"span2\"> <a href=\"employee.php?staff_id=" + v.staff_id + "&sanctioned_post_id=" + v.sanctioned_post_id + "\" target=\"_blank\"  class=\"btn btn-warning btn-xs\" ><i class=\"icon-user\"></i> View Profile</a>";
                                                                            data_list += "<a href=\"#moveOut_" + v.sanctioned_post_id + "\" role=\"button\" data-toggle=\"modal\"  class=\"btn btn-primary btn-xs\" ><i class=\"icon-external-link\"></i> Move Out</a></div>";
                                                                            data_list += "'<div id=\"moveOut_" + v.sanctioned_post_id + "\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">;";
                                                                            data_list += "<div class=\"modal-header\">";
                                                                            data_list += "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>";
                                                                            data_list += "<h3 id=\"myModalLabel\">Move Out Type</h3>";
                                                                            data_list += "</div>";
                                                                            data_list += "<div class=\"modal-body\">";
                                                                            data_list += "<ul>";
                                                                            data_list += "<li><a href=\"#\">Promotion</a></li>";
                                                                            data_list += "<li><a href=\"move_request.php?action=move_out&staff_id=" + v.staff_id + "&sanctioned_post_id=" + v.sanctioned_post_id + "\" target=\"_blank\" >Transfer</a></li>";
                                                                            data_list += "<li><a href=\"#\">Retire</a></li>";
                                                                            data_list += "<li><a href=\"#\">Suspend</a></li>";
                                                                            data_list += "<li><a href=\"#\">Death</a></li>";
                                                                            data_list += "</ul>";
                                                                            data_list += "</div>";
                                                                            data_list += "<div class=\"modal-footer\">";
                                                                            data_list += "<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Close</button>";
                                                                            data_list += "</div>";
                                                                            data_list += "</div>";


                                                                        }
                                                                        else {
                                                                            data_list += "<div class=\"span2\"> <a href=\"employee.php?sanctioned_post_id=" + v.sanctioned_post_id + "&action=new\" target=\"_blank\"  class=\"btn btn-success btn-xs\" >Add Profile</a></div>";
                                                                        }

                                                                        data_list += "</div>";
                                                                        $("#list-<?php echo $designation_div_id; ?>").append(data_list);
                                                                    });
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
                                    ?>

                                                <div id="sp-<?php echo "$designation_div_id"; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3><?php echo $sp_data['designation']; ?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="sp-loading-<?php echo $designation_div_id; ?>"><i class="icon-spinner icon-spin icon-large"></i> Loading Content...</div>
                                                        <div id="sp-content-<?php echo $designation_div_id; ?>"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </div>
                                                <script type="text/javascript" language="javascript">
                                                    $(document).ready(function() {
                                                        $("#sp-btn-<?php echo $designation_div_id; ?>").click(function(event) {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "result-sp.php",
                                                                data: {id: "<?php echo $sp_data['id']; ?>"},
                                                                dataType: 'json',
                                                                success: function(data) {
                                                                    $('#sp-loading-<?php echo $designation_div_id; ?>').hide();
                                                                    $('#sp-content-<?php echo $designation_div_id; ?>').html("");
                                                                    $.each(data, function(k, v) {
                                                                        var data_all = "<table class=\"table\">";
                                                                        data_all += "<tr><td><b>Sanctioned Post Id</b></td><td>" + v.sanctioned_post_id + "</td></tr>";
                                                                        data_all += "<tr><td><b>Organizaion Code</b></td><td><?php echo "$org_code"; ?></td></tr>";
                                                                        data_all += "<tr><td><b>Organizaion Name</b></td><td><?php echo "$org_name"; ?></td></tr>";
                                                                        data_all += "<tr><td><b>First Level Name</b></td><td>" + v.first_level_name + "</td></tr>";
                                                                        data_all += "<tr><td><b>Second Level Name</b></td><td>" + v.second_level_name + "</td></tr>";
                                                                        data_all += "<tr><td><b>Class</b></td><td>" + v.class + "</td></tr>";
                                                                        data_all += "<tr><td><b>Pay Scale</b></td><td>" + v.pay_scale + "</td></tr>";
                                                                        data_all += "<tr><td><b>Type of Post</b></td><td>" + v.type_of_post + "</td></tr>";
                                                                        data_all += "<tr><td><b>Discipline</b></td><td>" + v.discipline + "</td></tr>";
                                                                        data_all += "<tr><td><b>Bangladesh Professional Category </b></td><td></td></tr>";
                                                                        data_all += "<tr><td><b>WHO Major Health Occupation Group</b></td><td></td></tr>";
                                                                        data_all += "<tr><td><b>WHO-ISCO Occupation Name </b></td><td></td></tr>";
                                                                        data_all += "<tr><td><b>Year when the post created </b></td><td></td></tr>";
                                                                        data_all += "<tr><td><b>Recruitment rule for the post</b></td><td></td></tr>";
                                                                        data_all += "</table>";
                                                                        $('#sp-content-<?php echo $designation_div_id; ?>').append(data_all);
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                    <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                    </tbody>

                                </table>-->
                            </div>

                        </div>

                    </section>

                </div>

            </div>

        </div> <!-- /container -->


        <!--        <div>
                    <pre>
        
                    </pre>
                </div>-->
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
        <!--<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>

    </body>
</html>

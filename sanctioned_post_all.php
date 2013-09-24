<?php
require_once 'configuration.php';

/*
if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
*/
/*
// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];

$echoAdminInfo = "";

// assign values admin users
if($_SESSION['user_type']=="admin" && $_GET['org_code'] != ""){
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php //echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Nasir Khan Saikat(nasir8891@gmail.com)">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

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

    <body data-spy="scroll">

        <!-- Top navigation bar
        ================================================== -->

        <!-- Subhead
        ================================================== -->
            <div class="container">
                <h2><?php // echo "$org_name $echoAdminInfo"; ?></h2>
                <p class="lead"><?php //echo "$org_type_name"; ?></p>
            </div>


        <div class="container">

            <!-- nav
            ================================================== -->
            <div class="row">
       
                <div class="span9">
                    <!-- Sanctioned Post
                    ================================================== -->
                    <section id="sanctioned-post">

                        <div class="row">
                            <div class="span9" style="width:1180px;">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="7">&nbsp;</th>  
											<th><a href="" onclick="javascript:window.print()" >Print</a></th>
                                        </tr>
										  <tr>
                                            <th> Sanctioned Post</th>  
											<th> No. of Post</th>
											<th> Type  of Post</th>
											<th> Pay Scale</th>
											<th> Job Class</th>
											<th> Existing Male</th>
											<th> Existing Female</th>
											<th> Existing total</th>
											<th> Vacant Post</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										
                                        $sql = "SELECT id, designation, discipline,type_of_post,pay_scale,class,existing_male,existing_female,existing_total,vacant_post, COUNT(*) AS sp_count 
                                            FROM total_manpower_imported_sanctioned_post_copy 
                                            GROUP BY designation order by pay_scale asc";
                                        $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                       $cnt =0;
                                        while ($sp_data = mysql_fetch_assoc($result)) {
										 $cnt+=$sp_data['sp_count'];
                                            echo "<tr>";
                                            echo "<td>";
											echo $sp_data['designation'];
											echo "</td>";
											 echo "<td align='right'>";
											 echo  $sp_data['sp_count'];
                                           echo "</td>";
											 echo "<td>";
											echo $sp_data['type_of_post'];
											echo "</td>";
											echo "<td>";
											echo $sp_data['pay_scale'];
											echo "</td>";
										     echo "<td>";
											echo $sp_data['class'];
											echo "</td>";
											 echo "<td>";
											echo $sp_data['existing_male'];
											echo "</td>";
											echo "<td>";
											echo $sp_data['existing_female'];
											echo "</td>";
											echo "<td>";
											echo $sp_data['existing_total'];
											echo "</td>";
											echo "<td>";
											echo $sp_data['vacant_post'];
											echo "</td>";
											
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";

                                            // sanctioned post list display
                                           
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
                                    
                                        <?php
                                        echo "</td>";
                                        echo "</tr>";
										
										
										
										
										
                                    }
									
									echo "<tr>";
									echo "<td >";
									echo '<b>Total no of sanctioned post</b>';
									echo "</td>";
									echo "<td >";
									echo $cnt;
									echo "</td >";
									echo "<td colspan='7'>";
									
									echo "</td>";
									echo "</tr>";
									
									//print_r($sp_data);
									//echo $sp_data[0]['sp_count'];
								    // $sp_count=mysql_fetch_array($result);
									 //print_r($sp_count)
							
									 //echo $sp_count[0]['sp_count'];
                                    ?>
                                    </tbody>

                                </table>
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

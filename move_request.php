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

        <!-- Show District -->
        <script>
            function showDist(str)
            {
                if (str == "")
                {
                    document.getElementById("txtDist").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("txtDist").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "district.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
        <!-- Show District -->



        <!-- Show Upazilla -->
        <script>
            function showUpa(str)
            {
                if (str == "")
                {
                    document.getElementById("txtUpa").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("txtUpa").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "upazila.php?q=" + str, true);
                xmlhttp.send();
            }

            function showOrg(str)
            {

                if (str == "")
                {
                    document.getElementById("txtOrg").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("txtOrg").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "org.php?q=" + str, true);
                xmlhttp.send();
            }

            function showOrgType(str)
            {
                var p = document.form1.div.value;
                var q = document.form1.dis.value;

                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("txtOrgType").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "orgtype.php?p=" + p, true);
                xmlhttp.send();
            }
        </script>
        <!-- Show Upazilla -->



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
                        <li class="active"><a href="move_request.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a></li>
                        <li><a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a></li>                        
                        <li><a href="logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Download
                    ================================================== -->
                    <section id="organization-profile">

                        <div class="row">
                            <div class="span9">
                                <h3>Move Request</h3>
<!--                                <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form1">
                                    <div class="control-group">
                                        <select id="div" name="div" onChange="showDist(this.value)" class="editable editable-click">
                                            <option value="0">--Select Division--</option>
                                <?php
                                $div = mysql_query("SELECT * FROM admin_division ORDER BY division_name");
                                while ($rowdiv = mysql_fetch_assoc($div)) {
                                    $s6 = "";
                                    /* if($rorg1['division_bbs_code'] == $rowdiv['id'])
                                      {
                                      $s6 = "selected";
                                      } */
                                    ?>
                                                    <option value="<?php echo $rowdiv['id']; ?>" <?php //echo $s6;      ?>><?php echo $rowdiv['division_name']; ?></option>
                                    <?php
                                }
                                ?>
                                        </select>
                                    </div>
                                    <div id="txtDist">
                                        <select id="dis" name="dis">
                                            <option value="0">--Select District--</option>
                                        </select>
                                    </div>
                                    <br>
                                    
                                    <div id="txtUpa">
                                     <select id="upa">
                                     <option value="">--Select Upazila--</option>
                                     </select>
                                    </div>
                                    
                                    <div id="txtOrg">
                                        <select id="org" name="org">
                                            <option value="0">--Select Organization--</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div id="txtOrgType">
                                        <select id="orgtype" name="orgtype">
                                            <option value="0">--Select Org. Type--</option>
                                        </select>
                                    </div>


                                    <br>
                                    <div class="control-group">
                                        <input type="submit" class="btn btn-info btn-small">
                                    </div>
                                </form>
                                -->


                                <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="search">
                                    <div class="control-group">
                                        <select id="admin_division" name="admin_division">
                                            <option value="0">Select Division</option>
                                            <?php
                                            /**
                                             * @todo change old_visision_id to division_bbs_code
                                             */
                                            $sql = "SELECT admin_division.division_name, admin_division.old_division_id FROM admin_division";
                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                            while ($rows = mysql_fetch_assoc($result)) {
                                                echo "<option value=\"" . $rows['old_division_id'] . "\">" . $rows['division_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <select id="admin_district" name="admin_district">
                                            <option value="0">Select District</option>                                        
                                        </select>
                                        <select id="admin_upazila" name="admin_upazila">
                                            <option value="0">Select Upazila</option>                                        
                                        </select>
                                    </div>
                                    <div class="control-group">
                                        <select id="org_agency" name="org_agency">
                                            <option value="0">Select Agency</option>
                                            <?php
                                            $sql = "SELECT
                                                        org_agency_code.org_agency_code,
                                                        org_agency_code.org_agency_name
                                                    FROM
                                                        org_agency_code
                                                    ORDER BY
                                                        org_agency_code.org_agency_code";
                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                            while ($rows = mysql_fetch_assoc($result)) {
                                                echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <select id="org_list" name="org_list">
                                            <option value="0">Select Organization</option>                                        
                                        </select>
                                        <select id="sanctioned_post" name="org_list">
                                            <option value="0">Select Designation</option>                                        
                                        </select>
                                    </div>
                                        
                                    <div class="control-group">
                                        <button type="submit" class="btn">Submit</button>
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
        <script type="text/javascript">
            // division
            $('#admin_division').change(function() {
                var div_id = $('#admin_division').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_district_list.php',
                    data: {div_id: div_id},
                    dataType: 'json',
                    success: function(data)
                    {
                        var admin_district = document.getElementById('admin_district');
                        admin_district.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_district.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // district 
            $('#admin_district').change(function() {
                var dis_id = $('#admin_district').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_upazila_list.php',
                    data: {dis_id: dis_id},
                    dataType: 'json',
                    success: function(data)
                    {
                        var admin_upazila = document.getElementById('admin_upazila');
                        admin_upazila.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_upazila.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });
            
            // load organization 
            $('#org_agency').change(function() {
                var div_id = $('#admin_division').val();
                var dis_id = $('#admin_district').val();
                var upa_id = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organization_list.php',
                    data: {
                        div_id: div_id,
                        dis_id: dis_id,
                        upa_id: upa_id,
                        agency_code: agency_code
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        var org_list = document.getElementById('org_list');
                        org_list.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            org_list.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });
            
            // load designation 
            $('#org_list').change(function() {
                var organization_id = $('#org_list').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_designation_list.php',
                    data: {
                        organization_id: organization_id
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        var sanctioned_post = document.getElementById('sanctioned_post');
                        sanctioned_post.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            sanctioned_post.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });
        </script>
    </body>
</html>

<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$user_name = $_SESSION['username'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_REQUEST['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_REQUEST['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}

$govt_order = mysql_real_escape_string($_POST['govt_order']);
$attachments = mysql_real_escape_string($_POST['attachments']);
$staff_id = mysql_real_escape_string($_POST['post_staff_id']);
$post_mv_from_org = mysql_real_escape_string($_POST['post_mv_from_org']);
$post_mv_from_des = mysql_real_escape_string($_POST['post_mv_from_des']);
$post_mv_to_org = mysql_real_escape_string($_POST['post_mv_to_org']);
$post_mv_to_des = mysql_real_escape_string($_POST['post_mv_to_des']);


// redirect direct access
if (!$staff_id > 0){
    if($_SESSION['user_type'] == "admin"){
        header("location:admin_home.php");
    }
    else {
        header("location:home.php");
    }    
}

$insert_ok = TRUE;



if ($insert_ok){
    $sql = "INSERT INTO `transfer_post` (
                `request_submitted_by`, 
                `staff_id`, 
                `present_designation_id`, 
                `present_sanctioned_post_id`, 
                `present_org_code`, 
                `move_to_designation_id`, 
                `move_to_org_code`, 
                `updated_by`, 
                `status`) 
            VALUES (
            '$user_name', 
            '$staff_id', 
            '$post_mv_from_des', 
            NULL, 
            '$post_mv_from_org', 
            '$post_mv_to_des', 
            '$post_mv_to_org', 
            '$user_name', 
            '1')";
    
//    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

}



$staff_name = getStaffNameFromId($staff_id);

$sanctioned_post_name_from = getSanctionedPostNameFromSanctionedPostId($post_mv_from_des);
$sanctioned_post_name_to = getSanctionedPostNameFromSanctionedPostGroupCode($post_mv_to_des);

$org_name_from = getOrgNameFormOrgCode($post_mv_from_org);
$org_name_to = getOrgNameFormOrgCode($post_mv_to_org);

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

        <style type="text/css">
            .padding_up_down{
                padding: 20px 0px 20px 0px;
            }
        </style>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
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
            <section id="move_staff_confirm">
                <div id="move_out_print_order_main" class="row well" >
                    <!--<form action="<?php // echo $_SERVER['PHP_SELF']; ?>" method="post">-->
                    <div id="move_out_print_order_header" class="row text-center">
                        <h3>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h3>
                        <br />
                        <select id="order_approved_by_org" name="order_approved_by_org">
                            <!-- @todo set the values-->
                            <option value="org_1">স্বাস্থ্য ও পরিবার কল্যান মন্ত্রণালয়</option>
                            <option value="org_2">স্বাস্থ্য অধিদপ্তর</option>
                            <option value="org_3">বিভাগীয় পরিচালক (স্বাস্থ্য)- ঢাকা</option>
                            <option value="org_4">বিভাগীয় পরিচালক (স্বাস্থ্য)- চট্টগ্রাম</option>
                            <option value="org_5">বিভাগীয় পরিচালক (স্বাস্থ্য)- রাজশাহী</option>
                            <option value="org_6">বিভাগীয় পরিচালক (স্বাস্থ্য)- রংপুর</option>
                            <option value="org_7">বিভাগীয় পরিচালক (স্বাস্থ্য)- বরিশাল</option>
                            <option value="org_8">বিভাগীয় পরিচালক (স্বাস্থ্য)- খুলনা</option>
                            <option value="org_9">বিভাগীয় পরিচালক (স্বাস্থ্য)- সিলেট</option>
                        </select>
                        <div >ওয়েবসাইট: <input id="order_approved_by_org_website" type="text" name="order_approved_by_org_website"/></div>
                        <div >ইমেইল: <input id="order_approved_by_org_email" type="text" name="order_approved_by_org_email"/></div>
                        
                    </div>
                    <div id="move_out_print_order_body" class="row padding_up_down">
                        <div class="row">
                            <div class="span4">স্মারক নং: <?php echo "$govt_order"; ?></div>
                            <input id="govt_order_number" type="hidden" name="govt_order_number" value="<?php echo "$govt_order"; ?>" />
                            <div class="span4">
                                <select id="order_type" name="order_type">
                                    <!-- @todo set the values-->
                                    <option value="order_type_1">সার্কুলার</option>
                                    <option value="order_type_2">আদেশ</option>
                                    <option value="order_type_3">প্রজ্ঞাপন</option>
                                </select>
                            </div>
                            <div class="span4"> তারিখ:
                                <input type="text" id="date" placeholder="তারিখ" name="order_date">
                                </div>
                        </div>
                        <div class="row padding_up_down">
                            বিসিএস (স্বাস্থ্য) ক্যাডারের নিম্নলিখিত কর্মকর্তা/কর্মকর্তাবৃন্দকে পূনরাদেশ না দেয়া পর্যন্ত তাঁর/তাঁদের নামের পাশে বর্ণিত পদে বদলী/পদায়ন করা হলোঃ 
                        </div>
                        <div class="row padding_up_down">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>অনলাইন ট্রান্সফার কোড নং</td>
                                        <td>নাম, পদবী ও বর্তমান কর্মস্থল</td>
                                        <td>বদলী / পদায়নকৃত কর্মস্থল</td>
                                        <td>সংযুক্তি (যদিথাকে)</td>
                                        <td>তাৎক্ষণিক অবমুক্তির তারিখ (প্রযোজ্য হলে)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <?php 
                                            echo "$staff_name, $sanctioned_post_name_from, $org_name_from";
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            echo "$sanctioned_post_name_to, $org_name_to";
                                            ?>
                                        </td>
                                        <td><?php echo "$attachments"; ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="span8"> 
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox1" value="option1"> এই আদেশ জনস্বার্থে জারি করা হলো।
                                </label>
                            </div>
                            <div class="span4">
                                <select id="order_send_from">
                                    <!-- @todo set the values-->
                                    <option value="order_send_from1">আদেশক্রমে</option>
                                    <option value="order_send_from2">রাষ্ট্রপতির আদেশক্রমে</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span6 offset6 form-horizontal padding_up_down">
                                <div class="control-group">
                                    <label class="control-label" for="senderName">নাম: </label>
                                    <div class="controls">
                                        <input type="text" id="senderName" placeholder="নাম">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderDesignation">পদবী: </label>
                                    <div class="controls">
                                        <input type="text" id="senderDesignation" placeholder="পদবী">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderPhone">ফোন: </label>
                                    <div class="controls">
                                        <input type="text" id="senderPhone" placeholder="ফোন">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderEmail">ইমেইল: </label>
                                    <div class="controls">
                                        <input type="text" id="senderEmail" placeholder="ইমেইল">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span8"> 
                                <!--স্মারক নং:--> 
                            </div>
                            <div class="span4">
                                স্মারক নং:
                            </div>
                        </div>
                        <div class="row">
                            <div class="span12"> 
                                অনুলিপি সদয় অবগতি ও প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য প্রেরণ করা হলো:
                            </div>
                        </div>
                        <div class="row">
                            <div class="span12"> 
                                <textarea class="input-block-level" rows="4" id="comment"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span6 offset6 form-horizontal padding_up_down">
                                <div class="control-group">
                                    <label class="control-label" for="senderName1">নাম: </label>
                                    <div class="controls">
                                        <input type="text" id="senderName" name="senderName" placeholder="নাম">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderDesignation">পদবী: </label>
                                    <div class="controls">
                                        <input type="text" id="senderDesignation1" name="senderDesignation" placeholder="পদবী">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderPhone">ফোন: </label>
                                    <div class="controls">
                                        <input type="text" id="senderPhone1" name="senderPhone" placeholder="ফোন">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="senderEmail">ইমেইল: </label>
                                    <div class="controls">
                                        <input type="text" id="senderEmail1" name="senderEmail" placeholder="ইমেইল">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p class="text-center">
                                <button class="btn btn-lg btn-warning" type="button">Cancel</button>
                                <button class="btn btn-lg btn-success" type="button" id="send_transfer_order" >Send Transfer Order</button>
                            </p>
                        </div>
                    </div> <!-- /move_out_print_order_body -->
                    <!--</form>-->
                    <div id="display_info"></div>
                </div>
            </section> <!-- /move_staff_confirm -->
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

        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>       
        <script type="text/javascript">
            var sender_org_name = $("#order_approved_by_org").val();
            if (sender_org_name === "org_1"){
                $("#order_approved_by_org_website").val("http://dghs.gov.bd");
                $("#order_approved_by_org_email").val("info@dghs.gov.bd");
            }   
            $("#send_transfer_order").click(function (){
                $("#display_info").html("");
                var display_info = "";
                display_info += $("#order_approved_by_org").val();
                display_info += "<br />";
                display_info += $("#order_approved_by_org_website").val();
                display_info += "<br />";
                display_info += $("#order_approved_by_org_email").val();
                display_info += "<br />";
                display_info += $("#govt_order_number").val();
                display_info += "<br />";
                display_info += $("#order_type").val();
                display_info += "<br />";
                display_info += $("#date").val();
                display_info += "<br />";
                display_info += $("#inlineCheckbox1").val();
                display_info += "<br />";
                display_info += $("#order_send_from").val();
                display_info += "<br />";
                display_info += $("#senderName").val();
                display_info += "<br />";
                display_info += $("#senderDesignation").val();
                display_info += "<br />";
                display_info += $("#senderPhone").val();
                display_info += "<br />";
                display_info += $("#senderEmail").val();
                display_info += "<br />";
                display_info += $("#comment").val();
                display_info += "<br />";
                display_info += $("#senderName1").val();
                display_info += "<br />";
                display_info += $("#senderDesignation1").val();
                display_info += "<br />";
                display_info += $("#senderPhone1").val();
                display_info += "<br />";
                display_info += $("#senderEmail1").val();

                $("#display_info").append(display_info);
            });
        </script>
    </body>
</html>

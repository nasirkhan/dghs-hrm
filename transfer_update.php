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
}
if ($_SESSION['user_type'] == "admin") {
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}

if (isset($_REQUEST['order_type'])) {
    $order_type = mysql_real_escape_string(trim($_REQUEST['order_type']));

    if ($order_type == "order") {
        $sql = "SELECT * FROM `transfer_queue` WHERE order_creater_by LIKE \"$user_name\" and `status` LIKE \"pending\" ORDER BY `serial`";
        $listed_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
    } else if ($order_type == "order_submit") {
//        echo "paisi";
        $order_memo_no = mysql_real_escape_string(trim($_POST['order_memo_no']));
        $order_memo_date = mysql_real_escape_string(trim($_POST['order_memo_date']));
        $order_comment = mysql_real_escape_string(trim($_POST['order_comment']));
                       
        $sql = "SELECT * FROM `transfer_queue` WHERE order_creater_by LIKE \"$user_name\" and `status` LIKE \"pending\" ORDER BY `serial`";
        $listed_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
//        echo "<pre>$sql</pre>";
//        die();
        while ($row = mysql_fetch_assoc($listed_result)){
            $sql = "INSERT INTO `transfer_staff` (
                            `request_submitted_by`,
                            `staff_id`,
                            `present_designation_id`,
                            `present_sanctioned_post_id`,
                            `present_org_code`,
                            `move_to_designation_id`,
                            `move_to_sanctioned_post_id`,
                            `move_to_org_code`,
                            `order_memo_no`,
                            `order_memo_date`,
                            `order_memo_comment`,
                            `updated_by`
                    )
                    VALUES
                    (
                            '$user_name',
                            '" . $row['staff_id'] . "',
                            '" . $row['staff_id'] . "',
                            '" . $row['staff_id'] . "',
                            '" . $row['from_org_code'] . "',
                            '" . $row['to_designation_code'] . "',
                            '" . $row['to_designation_code'] . "',
                            '" . $row['to_org_code'] . "',
                            '" . $_POST['order_memo_no'] . "',
                            '" . $_POST['order_memo_date'] . "',
                            '" . $_POST['order_memo_comment'] . "',
                            '$user_name'
                    )";
            
            $r = mysql_query($sql) or die(mysql_error() . "<p>Code:2<br /><br /><b>Query:</b><br />___<br />$sql</p>");
            
            
            $sql = "UPDATE `transfer_queue` SET `status`='order' WHERE (`id`='" . $row['id'] . "')";
            $r = mysql_query($sql) or die(mysql_error() . "<p>Code:3<br /><br /><b>Query:</b><br />___<br />$sql</p>");            
        }
        header('location:transfer.php');
    } else if ($order_type == "release"){
        $staff_id = mysql_real_escape_string(trim($_REQUEST['staff_id']));
        
        $sql = "SELECT * FROM `transfer_staff` WHERE staff_id = '$staff_id' AND `status` LIKE 'order' AND active LIKE '1'";
        $staff_result = mysql_query($sql) or die(mysql_error() . "<p>Code:4<br /><br /><b>Query:</b><br />___<br />$sql</p>");        
        
//        $data = mysql_fetch_assoc($staff_result);
//        print_r($sql);
    } 
    
} else {
    header('location:transfer.php');
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
        <div class="hidden-print">
            <?php include_once 'include/header/header_top_menu.inc.php'; ?>
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
                <div class="span3 bs-docs-sidebar hidden-print">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Search main div
                    ================================================== -->
                    <section id="search_main">
                        <?php
                        if ($_POST['order_type'] == "order"):
                            $transfer_top_header = "Bnagladesh Govt.";
                            $transfer_memo_no = mysql_real_escape_string(trim($_POST['memo_no']));
                            $transfer_memo_date = mysql_real_escape_string(trim($_POST['memo_date']));
                            $transfer_top_intro = "BCS info.....alskdasd asdada asdajdlas alaks caslnasslaj as'las .";
                            $transfer_comment = mysql_real_escape_string(trim($_POST['comment']));
                            $transfer_signed_by = "Name :lasdj <br> Phone: 123456789 <br> email: abc@def.gh"
                            ?>

                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-center">
                                        <?php echo $transfer_top_header; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <p class="text-left">
                                        <?php echo $transfer_memo_no; ?>
                                    </p>
                                </div>
                                <div class="span6">
                                    <p class="text-right">
                                        <?php echo $transfer_memo_date; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-center">
                                        <?php echo $transfer_top_intro; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Transfer info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysql_fetch_assoc($listed_result)) : ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <?php echo getStaffNameFromId($row['staff_id']); ?>,
                                                        <?php echo getDesignationNameformCode($row['designation_code']); ?>,
                                                        <?php echo getOrgNameFormOrgCode($row['org_code']); ?>,
                                                    </td>
                                                    <td>
                                                        <?php echo getDesignationNameformCode($row['to_designation_code']); ?>,
                                                        <?php echo getOrgNameFormOrgCode($row['to_org_code']); ?>,
                                                        <?php
                                                        if ($row['to_org_code'] != $row['to_working_org_code']) {
                                                            echo getOrgNameFormOrgCode($row['to_working_org_code']);
                                                        }
                                                        ?>
                                                    </td>                                                
                                                </tr>
                                            <?php endwhile; ?>                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-left">
                                        <?php echo $transfer_comment; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-right">
                                        <?php echo $transfer_signed_by; ?>
                                    </p>
                                </div>
                            </div>
                        <?php elseif ($_REQUEST['order_type'] == "release"):
                            $data = mysql_fetch_assoc($staff_result);
                            
                            $transfer_id = $data['id'];
                            $transfer_top_header = "Bnagladesh Govt.";
                            $transfer_memo_no = $data['memo_no'];
                            $transfer_memo_date = $data['memo_date']; 
                            $transfer_top_intro = "BCS info.....alskdasd asdada asdajdlas alaks caslnasslaj as'las .";
                            $transfer_comment = $data['comment'];
                            $transfer_signed_by_1 = "Name : <br> Phone:  <br> email: ";
                            $transfer_signed_by_2 = "Name : <br> Phone:  <br> email: ";
                                    
                            ?>

                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-center">
                                        <?php echo $transfer_top_header; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <p class="text-left">
                                        <?php echo $transfer_memo_no; ?>
                                    </p>
                                </div>
                                <div class="span6">
                                    <p class="text-right">
                                        <?php echo $transfer_memo_date; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-center">
                                        <?php echo $transfer_top_intro; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Present Info</th>
                                                <th>Transfer info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $transfer_id; ?></td>
                                                <td>
                                                    <?php echo $data['staff_id']; ?>,
                                                    <?php echo $data['designation_code']; ?>,
                                                    <?php echo $data['org_code']; ?>,
                                                </td>
                                                <td>
                                                    <?php echo $data['to_designation_code']; ?>,
                                                    <?php echo $data['to_org_code']; ?>,
                                                    <?php
                                                    if ($data['to_org_code'] != $data['to_working_org_code']) {
                                                        echo getOrgNameFormOrgCode($data['to_working_org_code']);
                                                    }
                                                    ?>
                                                </td>                                                
                                            </tr>                                      
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-left">
                                        <?php echo $transfer_comment; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <p class="text-right">
                                        <?php echo $transfer_signed_by; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="hidden-print">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                                <input type="hidden" name="order_memo_no" value="<?php echo "$transfer_memo_no"; ?>" />
                                <input type="hidden" name="order_memo_date" value="<?php echo "$transfer_memo_date"; ?>" />
                                <input type="hidden" name="order_comment" value="<?php echo "$transfer_comment"; ?>" />
                                <input type="hidden" name="order_type" value="order_submit" />
                                <button type="submit" class="btn btn-success">Confirm Submission</button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <!-- Footer
        ================================================== -->
        <div class="hidden-print">
            <?php include_once 'include/footer/footer.inc.php'; ?>
        </div>       
    </body>
</html>

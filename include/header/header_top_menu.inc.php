<?php
$start_time = microtime(true);

if (isset($_POST['search_type']) && isset($_POST['code'])) {
    $code = mysql_real_escape_string(stripslashes(trim($_POST['code'])));
    $search_type = mysql_real_escape_string(stripslashes(trim($_POST['search_type'])));

    /**
     * Search by Org Code
     */
    if ($search_type == "org_code") {
        if (isValidOrgCode($code)) {
//            header("location:home.php?org_code=$code");
            echo "<script type=\"text/javascript\">window.location.href = \"home.php?org_code=$code\";</script>";
        } else {
//            header("location:index.php");
            echo "<script type=\"text/javascript\">window.location.href = \"index.php\";</script>";
        }
    }

    /**
     * Search By Staff Id
     */
    if ($search_type == "staff_id") {
        if (isValidStaffId($code)) {
            header("location:employee.php?staff_id=$code");
        } else {
            header("location:index.php");
        }
    }

    /**
     * Search By Staff Mobile Number
     */
    if ($search_type == "staff_mobile") {
        $ivValidMobile = isValidStaffMobile($code);
        if ($ivValidMobile) {
            header("location:employee.php?staff_id=$ivValidMobile");
        } else {
            header("location:index.php");
        }
    }
}
?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <!--<a class="brand" href="./index.php"><?php echo $app_name; ?></a>-->
            <ul class="nav">
                <li class="active">
                    <a href="index.php">Home</a>
                </li>
                <li class="">
                    <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
                </li>
            </ul>
            <div id="headerJumpMenu" class="pull-right">
                <div class="btn-group pull-right" style="margin-left: 5px;">
                    <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> </a>
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="settings.php"><i class="icon-pencil"></i> Edit</a></li>
                        <li><a href="logout.php"><i class="icon-power-off"></i> Logout</a></li>
                        <!--
                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="i"></i> Make admin</a></li>
                        -->
                    </ul>
                </div>
                <?php if (hasPermission('mod_top_nav_search', 'view', getLoggedUserName())): ?>
                    <div class="nav-collapse collapse pull-right">

                        <form class="navbar-form pull-left" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input name="code" type="text" placeholder="Code" class="span2">
                            <select name="search_type" class="span2">
                                <option value="org_code"> Org Code </option>
                                <option value="staff_id"> Staff Id </option>
                                <option value="staff_mobile"> Staff Mobile Number </option>
                            </select>
                            <button class="btn btn-primary" type="submit">Go</button>
                        </form>
                    </div><!--/.nav-collapse -->
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

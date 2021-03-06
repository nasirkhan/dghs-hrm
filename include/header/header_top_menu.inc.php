<?php
$start_time = microtime(true);
?>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
        <!--<a class="brand" href="./index.php"><?php echo $app_name; ?></a>-->
      <ul class="nav">
        <li class="active">
          <a href="index.php"><i class="icon-home"></i> Home </a>
        </li>
        <li class="">
          <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
        </li>
        <?php if (hasPermission('mod_top_nav_search', 'view', getLoggedUserName())) { ?>
          <li class="">
            <a href="admin_home.php" target="_brank">Admin</a>
          </li>
          <li class="">
            <a href="report_index.php" target="_brank">Report</a>
          </li>
        <?php } ?>
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
          <div class=" pull-right">

            <form class="navbar-form pull-left" action="include/header/header_search_area.php" method="post">
              <input name="code" type="text" placeholder="Code" class="span2">
              <select name="search_type" class="span2">
                <option value="org_code"> Org Code </option>
                <option value="staff_id"> Staff Id </option>
                <option value="staff_mobile"> Staff Mobile Number </option>
                <option value="staff_pds"> Staff PDS Code </option>
                <option value="staff_name"> Staff Name </option>
                <option value="staff_father_name"> Staff Father's Name </option>
              </select>
              <button class="btn btn-primary" type="submit">Go</button>
            </form>
          </div><!--/.nav-collapse -->
        <?php endif; ?>

      </div>
    </div>

  </div>

</div>

<div id="adminMenu" class="leftMenuContainer">
    <ul id="leftMenuAdmin" class="">
<!--        <li class="nav-header"><i class="icon-search"></i>ADMIN MENU</li>-->

        <li>
            <h5><i class="icon-desktop"></i><a href="admin_home.php">Admin Dashboard</a></h5>
            <blockquote>
                <small>You are now logged in as Super Admin of the system.
                    <?php if (!orgSelected()) { ?>
                        Please select an organization to start your activity.
                    <?php } ?>
                </small>
            </blockquote>
        </li>
        <li><a href="org.php"><i class="icon-hospital"></i> Organizations</a></li>
        <ul>
            <li><a href="search.php?type=org"><i class="icon-search"></i> Search</a></li>
            <li><a href="org_add.php"><i class="icon-plus"></i> Add</a></li>
            <li><a href="delete.php"><i class="icon-trash"></i> Delete</a></li>
            <li>
                <!-- The Organizations waiting for approval count will be shown here -->
                <a href="admin_edit_org.php">
                 <?php
                require_once 'configuration.php';
                $sql = "SELECT * FROM `organization_requested` WHERE active LIKE 1;";
                $new_org_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:sql:1<br /><br /><b>Query:</b><br />___<br />$sql<br />");
                $new_org_result_count = mysql_num_rows($new_org_result);
                ?>
                <i class="icon-check"></i>
                Org Awaiting Approval
                <?php if ($new_org_result_count > 0): ?>
                    <span class="badge badge-warning"><?php echo "$new_org_result_count"; ?></span>
                <?php endif; ?>
               <!-- <a href="admin_edit_org.php"><i class="icon-check"></i> Organizations Awaiting Approval</a>-->
                </a>
            </li>
            <!--<li><a href="">All Employee</a></li>-->
        </ul>
        <li><a href="<?= $attendanceMonitorUrl ?>" target="_blank"><i class="icon-check-sign"></i> Attendance</a></li>
        <li><a href="report_index.php"><i class="icon-list"></i> Reports</a></li>
        <li><a href="user_add.php"><i class="icon-user"></i> Add User</a></li>

        <!--
        <li><a href="#">Configuration</a></li>
        <ul>
            <li><a href="#">Designations</a></li>
            <li><a href="#">Class</a></li>
            <li><a href="#">Payscale</a></li>
            <li><a href="#">Type of Post</a></li>
            <li><a href="#">First Level Names</a></li>
            <li><a href="#">Second Level Name</a></li>
        </ul>
        -->
    </ul>
</div>



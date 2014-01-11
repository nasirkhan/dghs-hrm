<?php ?>
<div id="adminMenu" class="leftMenuContainer">
    <ul id="leftMenuAdmin" class="">
<!--        <li class="nav-header"><i class="icon-search"></i>ADMIN MENU</li>-->

        <li><h5><i class="icon-desktop"></i> <a href="admin_home.php">Admin Dashboard</a></h5>
            <blockquote>
                <small>You are now logged in as Super Admin of the system. Please select an organization to start your activity.</small>
            </blockquote>
        </li>
        <li><a href="org.php"><i class="icon-hospital"></i> Organizations</a></li>
        <ul>
            <li><a href="search.php?type=org"><i class="icon-search"></i> Search</a></li>
            <li><a href="add_new.php?type=org"><i class="icon-plus"></i> Add</a></li>
            <li><a href="admin_edit_org.php"><i class="icon-check"></i> Organizations Awaiting Approval</a></li>
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



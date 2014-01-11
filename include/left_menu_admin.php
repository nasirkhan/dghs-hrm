<?php ?>
<div id="adminMenu" class="leftMenuContainer">
    <ul id="leftMenuAdmin" class="">
<!--        <li class="nav-header"><i class="icon-search"></i>ADMIN MENU</li>-->

        <li><h5><i class="icon-desktop"></i> <a href="admin_home.php">Admin Dashboard</a></h5>
            <blockquote>
                <small>You are now logged in as Super Admin of the system. Please select an organization to start your activity.</small>
            </blockquote>
        </li>
        <li><a href="org.php">Organizations</a></li>
        <ul>
            <li><a href="search.php?type=org">Search</a></li>
            <li><a href="add_new.php?type=org">Add</a></li>
            <li><a href="admin_edit_org.php">Organizations Awaiting Approval</a></li>
            <!--<li><a href="">All Employee</a></li>-->
        </ul>
        <li><a href="report_index.php">Reports</a></li>
        <li><a href="user_add.php">Add User</a></li>

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



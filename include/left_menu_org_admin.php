<?php ?>
<div id="orgMenu" class="leftMenuContainer">
    <!--    <h4>ORGANIZATION MENU</h4>-->

    <ul id="leftMenuAdmin">
        <li>
            <h5 class="pull-left">
                <i class="icon-hospital"></i> <a href="home.php?org_code=<?= $org_code ?>"><?= $org_name ?></a>
                <?php if (hasPermission('mod_admin', 'view', getLoggedUserName())): ?>
                    <a href="org.php"><span class="btn btn-success btn-mini pull-right">Change</span></a>
                <?php endif; ?> 
            </h5>

            <div class="clearfix"></div>
            <blockquote>
                <small>You are now logged in as Admin of the above organization. Now you can manage organizational information, profile, sanctioned post and
                    other employee related information from the menu below</small>
            </blockquote>
        </li>

        <li><a href="org_profile.php?org_code=<?= $org_code ?>">Profile</a></li>
        <li><a href="sanctioned_post.php?org_code=<?= $org_code ?>">Sanctioned Post</a></li>
        <ul>
            <!--<li><a href="sanctioned_post_sorted.php?org_code=<?= $org_code ?>">Search</a></li>-->
            <!--<li><a href="sanctioned_post_report.php?org_code=<?= $org_code ?>">Report</a></li>-->
            <!--
            <li><a href="sanctioned_post_update.php?org_code=<?= $org_code ?>">Add</a></li>
            <li><a href="sanctioned_post.php?org_code=<?= $org_code ?>">Report</a></li>
            -->
        </ul>
        <li><a href="match_employee.php?org_code=<?= $org_code ?>">Employee</a></li>
        <ul>
            <li><a href="match_employee.php?org_code=<?= $org_code ?>">Search</a></li>
            <li><a href="sanctioned_post_update.php?org_code=<?= $org_code ?>">Add</a></li>
            <li><a href="move_staff.php?org_code=<?= $org_code ?>">Move Request</a></li>
            <li><a href="match_employee.php?org_code=<?= $org_code ?>">Match Employee</a></li>
            <li><a href="employee_report.php?org_code=<?= $org_code ?>">Report</a></li>
        </ul>
        <li><a href="transfer_staff.php?org_code=<?= $org_code ?>">Transfer</a></li>
        <!--<li><a href="employee.php.php?org_code=<?= $org_code ?>">Org admin users</a></li>-->

        <li><a href="<?= $attendanceMonitorUrl ?>?org_code[]=<?= $org_code ?>&submit=Filter" target="_blank">Attendance</a></li>
        <li><a href="monthly_update.php?org_code=<?= $org_code ?>">Monthly Update</a></li>
    </ul>

</div>
<!--
|-- Search ** (List + edit/delete)
|-- | -- Org Home - SELECTED_ORG_NAME
|-- | -- | -- Profile (Editable page)
|-- | -- | -- Sanctioned Post
|-- | -- | -- | -- Search ** (List + edit/delete)
|-- | -- | -- | -- Add
|-- | -- | -- | -- Reports
|-- | -- | -- Employee
|-- | -- | -- | -- Search ** (List+ edit/delete/Move Out)
|-- | -- | -- | -- Add
|-- | -- | -- | -- Move Request
|-- | -- | -- | -- Match Employee
|-- | -- | -- | -- Reports
|-- | -- | -- Org Admin Users
|-- | -- | -- Reports
-->
<?php ?>
<h4>ORGANIZATION MENU</h4>

<ul id="leftMenuAdmin">
    <li><a href="home.php?org_code=<?= $org_code?>"><?= $org_name ?></a></li>    
    <ul>
        <li><a href="org_profile.php?org_code=<?= $org_code?>">Profile</a></li>
        <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Sanctioned Post</a></li>
        <ul>
            <li><a href="sanctioned_post_sorted.php?org_code=<?= $org_code?>">Search</a></li>
            <!--
            <li><a href="sanctioned_post_update.php?org_code=<?= $org_code?>">Add</a></li>
            <li><a href="sanctioned_post.php?org_code=<?= $org_code?>">Report</a></li>
            -->
        </ul>
        <li><a href="match_employee.php?org_code=<?= $org_code?>">Employee</a></li>
        <ul>
            <li><a href="match_employee.php?org_code=<?= $org_code?>">Search</a></li>
            <li><a href="sanctioned_post_update.php?org_code=<?= $org_code?>">Add</a></li>
            <li><a href="move_staff.php?org_code=<?= $org_code?>">Move Request</a></li>
            <li><a href="match_employee.php?org_code=<?= $org_code?>">Match Employee</a></li>
            <li><a href="employee_report.php?org_code=<?= $org_code?>">Report</a></li>
        </ul>
        <!--<li><a href="employee.php.php?org_code=<?= $org_code?>">Org admin users</a></li>-->
    </ul>    
</ul>

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
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<li class= "<?php echo ($active_menu == "home") ? "active" : ""; ?>">
    <a href="home.php?org_code=<?php echo $org_code; ?>"><i class="icon-home"></i><?php if($isAdmin) echo "$org_name"; else echo "Homepage";?> </a>
</li>
<li class= "<?php echo ($active_menu == "org_profile") ? "active" : ""; ?>">
    <a href="org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-hospital"></i> Organization Profile</a>
</li>
<li class= "<?php echo ($active_menu == "sanctioned_post") ? "active" : ""; ?>">
    <a href="sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-group"></i> Sanctioned Post</a>
</li>
<li class= "level2 <?php echo ($active_menu == "sanctioned_post_sorted") ? "active" : ""; ?>">
    <a href="sanctioned_post_sorted.php?org_code=<?php echo $org_code; ?>"><i class="icon-sort-by-alphabet"></i> Sanctioned Post [Sorted]</a>
</li>
<li class= "level2 <?php echo ($active_menu == "sanctioned_post2") ? "active" : ""; ?>">
    <a href="sanctioned_post2.php?org_code=<?php echo $org_code; ?>"><i class="icon-sitemap"></i> Sanctioned Post [Tree View]</a>
</li>
<?php if($isAdmin): ?>
    <li class= "level2 <?php echo ($active_menu == "sanctioned_post_add") ? "active" : ""; ?>">
        <a href="update_sanctioned_post.php?org_code=<?php echo $org_code; ?>&action=new_designation&step=3"><i class="icon-plus"></i> Add Sanctioned Post</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "sanctioned_post_repot") ? "active" : ""; ?>">
        <a href="#"><i class="icon-calendar-empty"></i> Sanctioned Post Report</a>
    </li>
<?php endif; ?>

<li class= "<?php echo ($active_menu == "employee") ? "active" : ""; ?>">
    <a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-user-md"></i> Employee Profile</a>
</li>
    <li class= "level2 <?php echo ($active_menu == "employee_add") ? "active" : ""; ?>">
        <a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-user-md"></i> Add Employee Profile</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "move_staff") ? "active" : ""; ?>">
        <a href="move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-exchange"></i> Move Request</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "match_employee") ? "active" : ""; ?>">
        <a href="match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-copy"></i> Match Employee</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "employee_report") ? "active" : ""; ?>">
        <a href="employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-calendar-empty"></i> Employee Reports</a>
    </li>  
<li class= "<?php echo ($active_menu == "org_add") ? "active" : ""; ?>">
    <li><a href="add_new.php"><i class="icon-plus"></i> Add Organization</a>
</li>  
<li class= "<?php echo ($active_menu == "org_approve") ? "active" : ""; ?>">
    <a href="admin_edit_org.php"><i class="icon-ok"></i> Org Request Approval</a>
</li>
<li class= "<?php echo ($active_menu == "#") ? "active" : ""; ?>">
    <a href="#"><i class="icon-list"></i> All Employee</a>
</li>
<li class= "<?php echo ($active_menu == "upload") ? "active" : ""; ?>">
    <a href="upload.php?org_code=<?php echo $org_code; ?>"><i class="icon-upload-alt"></i> Upload</a>
</li>
<li class= "<?php echo ($active_menu == "monthly_update") ? "active" : ""; ?>">
    <a href="monthly_update.php?org_code=<?php echo $org_code; ?>"><i class="icon-th-list"></i> Monthly Update</a>
</li>
<li class= "<?php echo ($active_menu == "report/index") ? "active" : ""; ?>">
    <a href="report/index.php?org_code=<?php echo $org_code; ?>"><i class="icon-calendar"></i> Reports</a>
</li>
<li class= "<?php echo ($active_menu == "settings") ? "active" : ""; ?>">
    <a href="settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-cogs"></i> Settings</a>
</li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> Designations</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> Class</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> Pay Scale</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> Type of Posts</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> First Level Names</a>
    </li>
    <li class= "level2 <?php echo ($active_menu == "##") ? "active" : ""; ?>">
        <a href="#"><i class="icon-list-ul"></i> Second Level Names</a>
    </li>
<li class= "<?php echo ($active_menu == "logout") ? "active" : ""; ?>">
    <a href="logout.php"><i class="icon-signout"></i> Sign out</a>
</li>
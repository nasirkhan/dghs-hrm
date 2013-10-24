<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<li <?php if ($active_menu == "home"){ echo " class=\"active\""; } ?>>
    <a href="../home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-home"></i> Homepage</a>
</li>
<li <?php if ($active_menu == "org_profile"){ echo " class=\"active\""; } ?>>
    <a href="../org_profile.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-hospital"></i> Organization Profile</a>
</li>
<li <?php if ($active_menu == "sanctioned_post"){ echo " class=\"active\""; } ?>>
    <a href="../sanctioned_post.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post</a>
</li>
<li <?php if ($active_menu == "sanctioned_post_sorted"){ echo " class=\"active\""; } ?>>
    <a href="../sanctioned_post_sorted.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post [Sorted]</a>
</li>
<li <?php if ($active_menu == "sanctioned_post2"){ echo " class=\"active\""; } ?>>
    <a href="../sanctioned_post2.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-group"></i> Sanctioned Post [Tree View]</a>
</li>
<li <?php if ($active_menu == "employee"){ echo " class=\"active\""; } ?>>
    <a href="../employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-user-md"></i> Employee Profile</a>
</li>
<li <?php if ($active_menu == "match_employee"){ echo " class=\"active\""; } ?>>
    <a href="../match_employee.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-copy"></i> Match Employee</a>
</li>		
<li <?php if ($active_menu == "move_staff"){ echo " class=\"active\""; } ?>>
    <a href="../move_staff.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-exchange"></i> Move Request</a>
</li>                        
<li <?php if ($active_menu == "upload"){ echo " class=\"active\""; } ?>>
    <a href="../upload.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-upload-alt"></i> Upload</a>
</li>
<li <?php if ($active_menu == "monthly_update"){ echo " class=\"active\""; } ?>>
    <a href="../monthly_update.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-th-list"></i> Monthly Update</a>
</li>		
<li <?php if ($active_menu == "report/index"){ echo " class=\"active\""; } ?>>
    <a href="report/index.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-calendar"></i> Reports</a>
</li>
<li <?php if ($active_menu == "settings"){ echo " class=\"active\""; } ?>>
    <a href="../settings.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-cogs"></i> Settings</a>
</li>		
<li <?php if ($active_menu == "logout"){ echo " class=\"active\""; } ?>>
    <a href="../logout.php"><i class="icon-chevron-right"></i><i class="icon-signout"></i> Sign out</a>
</li>
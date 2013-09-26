<?php
require_once '../configuration.php';


$des_group = mysql_real_escape_string(trim($_REQUEST['des_group']));
$org_code = mysql_real_escape_string(trim($_REQUEST['org_code']));

$sql = "SELECT * FROM `total_manpower_imported_sanctioned_post_copy` WHERE sanctioned_post_group_code=$des_group AND org_code=$org_code AND staff_id_2 <=0";
$result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>get_sanctioned_post_from_designation:1</b></p><p><b>Query:</b></p>___<p>$sql</p>");

$count = mysql_num_rows($result);
if ($count > 0):
    while ($row = mysql_fetch_assoc($result)):
        ?>
        <select id="move_in_sanctioned_post" class="input-block-level">
            <option value="<?php echo $row['id']; ?>"><?php echo $row['designation']; ?> (<?php echo $row['id']; ?>)</option>
        </select>

    <?php endwhile; ?>
<?php else: ?>
    <select id="move_in_sanctioned_post" class="input-block-level">
        <option value="0">No Vacant Post</option>
    </select>   
<?php endif; ?>
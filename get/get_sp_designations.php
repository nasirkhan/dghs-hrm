<?php
require_once '../configuration.php';

if (isset($_REQUEST["first_level_id"])) {
    $first_level_id = mysql_real_escape_string($_REQUEST['first_level_id']);
}
if (isset($_REQUEST["second_level_id"])) {
    $second_level_id = mysql_real_escape_string($_REQUEST['second_level_id']);
}
 else {
     $second_level_id=0;
}
if (isset($_REQUEST["div"])) {
    $div_id = mysql_real_escape_string($_REQUEST['div']);
}
if (isset($_REQUEST["loading"])) {
    $loading_id = mysql_real_escape_string($_REQUEST['loading']);
}
if (isset($_REQUEST["org_code"])) {
    $org_code = mysql_real_escape_string($_REQUEST['org_code']);
}
//$org_code = $_SESSION['org_code'];

$sql = "SELECT
	total_manpower_imported_sanctioned_post_copy.id,
	total_manpower_imported_sanctioned_post_copy.designation,
	total_manpower_imported_sanctioned_post_copy.designation_code,
	total_manpower_imported_sanctioned_post_copy.staff_id
FROM
	total_manpower_imported_sanctioned_post_copy
WHERE
	total_manpower_imported_sanctioned_post_copy.first_level_id = $first_level_id
AND total_manpower_imported_sanctioned_post_copy.second_level_id = $second_level_id
AND total_manpower_imported_sanctioned_post_copy.org_code = $org_code
GROUP BY
	total_manpower_imported_sanctioned_post_copy.designation
ORDER BY
	total_manpower_imported_sanctioned_post_copy.designation
";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_sp_second_level:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

//$total_rows= mysql_num_rows($sanctioned_post_list_result);

echo "<table class=\"table\">";
while ($data_list = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td width=\"50%\">" . $data_list['designation'] . "</td>";// (Staff Id:" . $data_list['staff_id'] . ")</td>";
    echo "<td>";
    echo "<button class=\"btn btn-small btn-warning\" id=\"designation" . $data_list['designation_code'] . "\"type=\"button\"><i class=\"icon-list-ul\"></i> View Sanctioned Posts</button>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan=2>";
    ?>
    <div id="loading-desig<?php echo $data_list['designation_code']; ?>"  class="alert" style="display: none;"><i class="icon-spinner icon-spin icon-large"></i> Loading Sanctioned Posts...</div>
    <div id="descri<?php echo $data_list['designation_code']; ?>"></div>
    <script type="text/javascript">
        $("#designation<?php echo $data_list['designation_code']; ?>").click(function() {
            $("#loading-desig<?php echo $data_list['designation_code']; ?>").show();
            $.ajax({
                type: "POST",
                url: "get/get_sp_posts.php",
                data: {
                    org_code:"<?php echo $org_code; ?>",
                    first_level_id: "<?php echo $first_level_id; ?>",
                    second_level_id: "<?php echo $data_list['second_level_id']; ?>",
                    designation: "<?php echo $data_list['designation']; ?>"
                },
                success: function(data) {
                    $("#loading-desig<?php echo $data_list['designation_code']; ?>").hide();
                    $('#descri<?php echo $data_list['designation_code']; ?>').html("");
                    $("#descri<?php echo $data_list['designation_code']; ?>").append(data);
                }
            });

        });
    </script>
    <?php
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
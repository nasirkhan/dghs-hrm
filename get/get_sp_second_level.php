<?php
require_once '../configuration.php';

if (isset($_REQUEST["first_level_id"])) {
    $first_level_id = mysql_real_escape_string($_REQUEST['first_level_id']);
//   echo $first_level_id;
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
total_manpower_imported_sanctioned_post_copy.second_level_id,
total_manpower_imported_sanctioned_post_copy.second_level_name
FROM total_manpower_imported_sanctioned_post_copy
WHERE
total_manpower_imported_sanctioned_post_copy.first_level_id = $first_level_id AND
total_manpower_imported_sanctioned_post_copy.second_level_name != \"\" AND
total_manpower_imported_sanctioned_post_copy.org_code=$org_code
GROUP BY total_manpower_imported_sanctioned_post_copy.second_level_name
ORDER BY total_manpower_imported_sanctioned_post_copy.second_level_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_sp_second_level:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

//$total_rows= mysql_num_rows($sanctioned_post_list_result);
//while ($data_list = mysql_fetch_assoc($result)) {
//    $data[] = array(
//        "second_level_id" => $data_list['second_level_id'],
//        "second_level_name" => $data_list['second_level_name']
//    );
//}

echo "<table class=\"table\">";
//echo "<caption>Second Level Divisions of $first_level_id</caption>";
echo "<h5>Second Level Divisions of \"" . getFirstLevelNameFromID($first_level_id) . "\"</h5>";
while ($data_list = mysql_fetch_assoc($result)) {
    echo "<tr class=\"success\">";
    echo "<td width=\"50%\">" . $data_list['second_level_name'] . " (Code:" . $data_list['second_level_id'] . ")</td>";
    echo "<td>";
    echo "<button class=\"btn btn-small btn-info\" id=\"2nd" . $data_list['second_level_id'] . "\"type=\"button\">View Designations</button>";
    echo "</td>";
    echo "</tr>";
    echo "<tr class=\"success\">";
    echo "<td colspan=2>";
    ?>
    <div id="<?php echo $loading_id . $data_list['second_level_id']; ?>"  class="alert" style="display: none;"><i class="icon-spinner icon-spin icon-large"></i> Loading designation list...</div>
    <div id="<?php echo $div_id . $data_list['second_level_id']; ?>"></div>
    <script type="text/javascript">
        $("#2nd<?php echo $data_list['second_level_id']; ?>").click(function() {
            $("#<?php echo $loading_id . $data_list['second_level_id']; ?>").show();
            $.ajax({
                type: "POST",
                url: "get/get_sp_designations.php",
                data: {
                    org_code:"<?php echo "$org_code";?>",
                    first_level_id: "<?php echo $first_level_id; ?>",
                    second_level_id: "<?php echo $data_list['second_level_id']; ?>"
                },
                success: function(data) {
                    $("#<?php echo $loading_id . $data_list['second_level_id']; ?>").hide();
                    $('#<?php echo $div_id . $data_list['second_level_id']; ?>').html("");
                    $("#<?php echo $div_id . $data_list['second_level_id']; ?>").append(data);
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
<?php
set_time_limit(120000);

require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}

$sql = "SELECT
                total_manpower_imported_sanctioned_post_copy.designation,
                total_manpower_imported_sanctioned_post_copy.designation_code,
                sanctioned_post_type_of_post.type_of_post_name,
                sanctioned_post_type_of_post.type_of_post_code,
                sanctioned_post_designation.class,
                sanctioned_post_designation.payscale,
                sanctioned_post_designation.ranking,
                count(*) AS total_count
        FROM
                `total_manpower_imported_sanctioned_post_copy`
        LEFT JOIN old_tbl_staff_organization ON old_tbl_staff_organization.sp_id_2 = total_manpower_imported_sanctioned_post_copy.id
        LEFT JOIN sanctioned_post_type_of_post ON total_manpower_imported_sanctioned_post_copy.type_of_post = sanctioned_post_type_of_post.type_of_post_code
        LEFT JOIN sanctioned_post_designation ON sanctioned_post_designation.designation_code = total_manpower_imported_sanctioned_post_copy.designation_code
        WHERE
                total_manpower_imported_sanctioned_post_copy.active LIKE 1
        GROUP BY
                total_manpower_imported_sanctioned_post_copy.type_of_post,
                total_manpower_imported_sanctioned_post_copy.designation
        ORDER BY
                sanctioned_post_designation.ranking";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>report_post_status_summary:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $org_name . " Report | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>
    </head>

    <body>

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo $org_name . $echoAdminInfo; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- Docs nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <section id="report">

                        <div class="row">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><strong>#</strong></th>
                                        <th><strong>Designation</strong></th>
                                        <th><strong>Type of post</strong></th>
                                        <th><strong>Class</strong></th>
                                        <th><strong>Payscale</strong></th>
                                        <th><strong>Total</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT sanctioned_post_designation.designation_code FROM `sanctioned_post_designation` ORDER BY ranking";
                                    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>report_post_status_summary:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                    
                                    $row_count = 0;
                                    while ($row = mysql_fetch_assoc($result)):
                                        $row_count++;
                                        ?>
                                        <tr>
                                            <td><?php echo $row_count; ?></td>
                                            <td><?php echo $row['designation']; ?></td>
                                            <td><?php echo $row['type_of_post_name']; ?></td>
                                            <td><?php echo $row['class']; ?></td>
                                            <td><?php echo $row['payscale']; ?></td>
                                            <td><?php echo $row['total_count']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        <script type="text/javascript">
            // load division
            $('#admin_division').change(function() {
                $("#loading_content").show();
                var div_id = $('#admin_division').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_district_list.php',
                    data: {div_id: div_id},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var admin_district = document.getElementById('admin_district');
                        admin_district.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_district.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load district 
            $('#admin_district').change(function() {
                var dis_id = $('#admin_district').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_upazila_list.php',
                    data: {dis_id: dis_id},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var admin_upazila = document.getElementById('admin_upazila');
                        admin_upazila.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_upazila.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            $("#generate_report").hide();
        </script>
    </body>
</html>

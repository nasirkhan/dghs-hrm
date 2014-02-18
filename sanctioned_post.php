<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';

/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051) {
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])) {
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}

$action = mysql_real_escape_string(trim($_GET['action']));
if (isset($_POST['action'])) {
    $sp_id = (int) mysql_real_escape_string(trim($_POST['sp_id']));
    $org_code = (int) mysql_real_escape_string(trim($_POST['org_code']));
    $action = mysql_real_escape_string(trim($_POST['action']));

    if ($action == "add") {
        $sql = "SELECT
                        *
                FROM
                        total_manpower_imported_sanctioned_post_copy
                WHERE
                        id = '$sp_id'
                AND active LIKE 1";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1</p><p>Query:</b></p>___<p>$sql</p>");
        $data = mysql_fetch_assoc($result);

        if ($org_code == $data['org_code']) {
            $sql = "INSERT INTO `total_manpower_imported_sanctioned_post_copy` (
                `group`,
                `designation`,
                `type_of_post`,
                `sanctioned_post`,
                `sanctioned_post_group_code`,
                `pay_scale`,
                `class`,
                `first_level_id`,
                `first_level_name`,
                `org_code`,
                `designation_code`,
                `updated_by`,
                `second_level_id`,
                `second_level_name`,
                `bangladesh_professional_category_code`,
                `who_occupation_group_code`
            )
            VALUES
                (
		\"" . $data['group'] . "\",
		\"" . $data['designation'] . "\",
		\"" . $data['type_of_post'] . "\",
		\"" . $data['sanctioned_post'] . "\",
		\"" . $data['sanctioned_post_group_code'] . "\",
		\"" . $data['pay_scale'] . "\",
		\"" . $data['class'] . "\",
		\"" . $data['first_level_id'] . "\",
		\"" . $data['first_level_name'] . "\",
		\"" . $data['org_code'] . "\",
		\"" . $data['designation_code'] . "\",
		\"" . $_SESSION['username'] . "\",
		\"" . $data['second_level_id'] . "\",
		\"" . $data['second_level_name'] . "\",
                \"" . $data['bangladesh_professional_category_code'] . "\",
                \"" . $data['who_occupation_group_code'] . "\"
            )";
//            echo "<pre>$sql</pre>";
            $result = mysql_query($sql) or die(mysql_error() . "Query:1<br />___<br />$sql<br />");
        }
    }
}


/**
 * Sanctioned post info of the organization
 *
 */
$sql = "SELECT
                total_manpower_imported_sanctioned_post_copy.id,
                total_manpower_imported_sanctioned_post_copy.designation,
                total_manpower_imported_sanctioned_post_copy.discipline,
                total_manpower_imported_sanctioned_post_copy.type_of_post,
                sanctioned_post_designation.ranking,
                sanctioned_post_designation.class,
                sanctioned_post_designation.payscale,
                sanctioned_post_designation.designation_code,
                COUNT(*) AS sp_count
        FROM
                `total_manpower_imported_sanctioned_post_copy`
        LEFT JOIN `sanctioned_post_designation` ON total_manpower_imported_sanctioned_post_copy.designation_code = sanctioned_post_designation.designation_code
        WHERE
                total_manpower_imported_sanctioned_post_copy.org_code = $org_code
                AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
        GROUP BY
                total_manpower_imported_sanctioned_post_copy.designation
        ORDER BY
                sanctioned_post_designation.ranking";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>

    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo "$org_name $echoAdminInfo"; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- nav
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
                    <!-- Sanctioned Post
                    ================================================== -->
                    <section id="sanctioned-post">

                        <div class="row-fluid">
                            <div class="span8">
                                <h4><a href="org_profile.php?org_code=<?php echo "$org_code"; ?>" target="_blank"><?php echo "$org_name ($org_code)"; ?></a></h4>
                                <?php
                                $total_post = getTotalSanctionedPostCountFromOrgCode($org_code);
                                $total_filled_up = getTotalFilledUpSanctionedPostCountFromOrgCode($org_code);
                                $total_vacant_post = $total_post - $total_filled_up;
                                ?>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td><strong>Total Sanctioned Post :</strong></td>
                                            <td><span class="label label-info"><?php echo $total_post; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Filled up Sanctioned Post :</strong></td>
                                            <td><span class="label label-info"><?php echo $total_filled_up; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Vacant Post  Sanctioned Post :</strong></td>
                                            <td><span class="label label-info"><?php echo $total_vacant_post; ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="span4">
                                <?php if ($isAdmin): ?>
                                    <a href="sanctioned_post_update.php?org_code=<?php echo "$org_code"; ?>&action=new_designation&step=3" class="btn btn-small btn-warning btn-block"><i class="icon-list-ul"></i> Add New Designation</a>
                                <?php endif; ?>
                                <div class="btn-group pull-right">
                                    <a class="btn" href="sanctioned_post_sorted.php?org_code=<?php echo $org_code; ?>"><i class="icon-sort-by-alphabet"></i> Sorted</a>
                                    <a class="btn"href="sanctioned_post2.php?org_code=<?php echo $org_code; ?>"><i class="icon-sitemap"></i> Tree View</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="span9">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <strong>Designation</strong>
                                                    </div>
                                                    <div class="span2">
                                                        <strong>Type of Post</strong>
                                                    </div>
                                                    <div class="span1">
                                                        <strong>Class</strong>
                                                    </div>
                                                    <div class="span1">
                                                        <strong>Payscale</strong>
                                                    </div>
                                                    <div class="span2">
                                                        <strong>Total Post</strong>
                                                    </div>
                                                    <div class="span2">
                                                        <strong>Action</strong>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($sp_data = mysql_fetch_assoc($result)): ?>
                                            <tr>
                                                <td>
                                                    <div class="row-fluid">
                                                        <div class="span4">
                                                            <?php $designation_div_id = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($sp_data['designation'])); ?>                    
                                                            <button id="sp-btn-<?php echo $designation_div_id; ?>" class="btn btn-link" onclick="showSanctionedPostDetails('<?php echo $sp_data['id']; ?>', '<?php echo $designation_div_id; ?>')">
                                                                <?php echo $sp_data['designation']; ?>
                                                            </button>
                                                        </div>
                                                        <div class="span2">
                                                            <?php echo getTypeOfPostNameFromCode($sp_data['type_of_post']); ?>
                                                        </div>
                                                        <div class="span1">
                                                            <?php echo $sp_data['class']; ?>
                                                        </div>
                                                        <div class="span1">
                                                            <?php echo $sp_data['payscale']; ?>
                                                        </div>
                                                        <div class="span2">
                                                            <?php echo $sp_data['sp_count']; ?>
                                                            <?php if (hasPermission('mod_sanctioned_post', 'manage', getLoggedUserName())): ?>
                                                            <form class="form-inline form-clear pull-right" action="sanctioned_post_update.php" method="get">
                                                                <input name="org_code" value="<?php echo $org_code; ?>" type="hidden" />
                                                                <input name="designation_code" value="<?php echo $sp_data['designation_code']; ?>" type="hidden" />
                                                                <input name="action" value="delete" type="hidden" />
                                                                <input type="hidden" id="step" name="step" value="2">
                                                                <button type="submit" class="btn btn-small btn-danger"><i class="icon-minus"></i></button>
                                                            </form>

                                                            <form class="form-inline form-clear pull-right" method="post">
                                                                <input name="org_code" value="<?php echo $org_code; ?>" type="hidden" />
                                                                <input name="sp_id" value="<?php echo $sp_data['id']; ?>" type="hidden" />
                                                                <input name="action" value="add" type="hidden" />
                                                                <button type="submit" class="btn btn-small btn-success"><i class="icon-plus"></i></button>
                                                            </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="span2">                                                            
                                                            <button type="submit" onclick="showDesignationList('<?php echo $sp_data['designation']; ?>', '<?php echo $designation_div_id; ?>');" value="<?php echo $sp_data['designation']; ?>" class="btn btn-info btn-small" >
                                                                <i class="icon-list-ul"></i> View Staff List
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row-fluid">
                                                        <div class="">
                                                            <div id="<?php echo $designation_div_id; ?>" class="collapse">
                                                                <div class="clearfix alert alert-info" id="list-<?php echo $designation_div_id; ?>">
                                                                    <div id="loading-<?php echo $designation_div_id; ?>"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</div>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="sp-<?php echo "$designation_div_id"; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3><?php echo $sp_data['designation']; ?></h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="sp-loading-<?php echo $designation_div_id; ?>"><i class="icon-spinner icon-spin icon-large"></i> Loading Content...</div>
                                                            <div id="sp-content-<?php echo $designation_div_id; ?>"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </section>
                </div>
            </div>
        </div> <!-- /container -->


        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>

        <script type="text/javascript" language="javascript">
            // show sanctioned post details on a modal
            function showSanctionedPostDetails(sp_id, designation_div) {
                var designation_div_id = "#sp-" + designation_div;
                var designation_div_content = "#sp-content-" + designation_div;
                var designation_div_loading = "#sp-loading-" + designation_div;

                $(designation_div_id).modal('show');

                $.ajax({
                    type: "POST",
                    url: "result-sp.php",
                    data: {id: sp_id},
                    dataType: 'json',
                    success: function(data) {
                        $(designation_div_loading).hide();
                        $(designation_div_content).html("");
                        $.each(data, function(k, v) {
                            var data_all = "<table class=\"table\">";
                            data_all += "<tr><td><b>Organizaion Code</b></td><td><?php echo "$org_code"; ?></td></tr>";
                            data_all += "<tr><td><b>Organizaion Name</b></td><td><?php echo "$org_name"; ?></td></tr>";
                            data_all += "<tr><td><b>First Level Name</b></td><td>" + v.first_level_name + "</td></tr>";
                            data_all += "<tr><td><b>Second Level Name</b></td><td>" + v.second_level_name + "</td></tr>";
                            data_all += "<tr><td><b>Class</b></td><td>" + v.class + "</td></tr>";
                            data_all += "<tr><td><b>Pay Scale</b></td><td>" + v.pay_scale + "</td></tr>";
                            data_all += "<tr><td><b>Type of Post</b></td><td>" + v.type_of_post + "</td></tr>";
                            data_all += "<tr><td><b>Discipline</b></td><td>" + v.discipline + "</td></tr>";
                            data_all += "<tr><td><b>Rank of the Post</b></td><td></td></tr>";
                            data_all += "<tr><td><b>Bangladesh Professional Category </b></td><td></td></tr>";
                            data_all += "<tr><td><b>WHO Major Health Occupation Group</b></td><td></td></tr>";
                            data_all += "<tr><td><b>WHO-ISCO Occupation Name </b></td><td></td></tr>";
                            data_all += "<tr><td><b>Year when the post created </b></td><td></td></tr>";
                            data_all += "<tr><td><b>Recruitment rule for the post</b></td><td></td></tr>";
                            data_all += "</table>";
                            $(designation_div_content).append(data_all);
                        });
                    }
                });
            }

            // show exployee/sanctioned post list
            function showDesignationList(designation, designation_div){
                var designation_div_id = "#" + designation_div;
                var designation_div_loading = "#loading-" + designation_div;
                var designation_div_list = "#list-" + designation_div;                
                var org_code = <?php echo $org_code; ?>;
                
                $(designation_div_id).collapse('toggle');
                
                $.ajax({
                    type: "POST",
                    url: "result.php",
                    data: {designation: designation, org_code:org_code},
                    dataType: 'json',
                    success: function(data) {
                        $(designation_div_loading).hide();
                        $(designation_div_list).html("");
                        $.each(data, function(k, v) {
                            var data_list = "<div class=\"row-fluid\">";
                            var staff_info = "";
                            if (v.staff_id_2 > 0) {
                                staff_info = " (Staff Name: <a href=\"employee.php?staff_id=" + v.staff_id_2 + "\" target=\"_blank\" ><i class=\"icon-user\"></i> " + v.staff_name + ", Id: " + v.staff_id_2 + "</a>)";
                            }
                            data_list += "<div class=\"span9\">Sanctioned PostId: " + v.sanctioned_post_id + staff_info + " </div>";
                            if (v.staff_id_2 > 0) {
                                data_list += "<div class=\"span3\">";
                                data_list += "<a href=\"#moveOut_" + v.sanctioned_post_id + "\" role=\"button\" data-toggle=\"modal\"  class=\"btn btn-primary btn-mini\" ><i class=\"icon-external-link\"></i> Move Out</a></div>";
                                data_list += "<div id=\"moveOut_" + v.sanctioned_post_id + "\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">;";
                                data_list += "<div class=\"modal-header\">";
                                data_list += "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>";
                                data_list += "<h3 id=\"myModalLabel\">Move Out Type</h3>";
                                data_list += "</div>";
                                data_list += "<div class=\"modal-body\">";
                                data_list += "<ul>";
                                data_list += "<li><a href=\"#\">Promotion</a></li>";
                                data_list += "<li><a href=\"move_staff.php?action=move_out&staff_id=" + v.staff_id_2 + "&sanctioned_post_id=" + v.sanctioned_post_id + "&org_code=<?php echo $org_code; ?>\" target=\"_blank\" >Transfer</a></li>";
                                data_list += "<li><a href=\"#\">Retirement2</a></li>";
                                data_list += "<li><a href=\"#\">Suspension</a></li>";
                                data_list += "<li><a href=\"#\">Termination</a></li>";
                                data_list += "<li><a href=\"#\">Death</a></li>";
                                data_list += "<li><a href=\"#\">Leaving Job</a></li>";
                                data_list += "<li><a href=\"#\">Unauthorised absent</a></li>";
                                data_list += "<li><a href=\"#\">Leave</a></li>";
                                data_list += "</ul>";
                                data_list += "</div>";
                                data_list += "<div class=\"modal-footer\">";
                                data_list += "<button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Close</button>";
                                data_list += "</div>";
                                data_list += "</div>";
                            }
                            else {
                                data_list += "<div class=\"span3\">";
                                data_list += "<a href=\"employee.php?sanctioned_post_id=" + v.sanctioned_post_id + "&action=new\" target=\"_blank\"  class=\"btn btn-success btn-mini\" ><i class=\"icon-edit\"></i> Add Profile</a>";
                                data_list += "<a href=\"move_staff.php?action=move_in&org_code=<?php echo "$org_code"; ?>\" target=\"_blank\"  class=\"btn btn-info btn-mini\" ><i class=\"icon-signin\"></i> Move In</a>";
                                data_list += "</div>";
                            }

                            data_list += "</div>";
                            $(designation_div_list).append(data_list);
                        });
                    }
                });
            }
            
        </script>
    </body>
</html>

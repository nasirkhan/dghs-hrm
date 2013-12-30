<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// session data
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];


// reassign org info
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
}

/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051){
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])){
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>
        <script>
            $.fn.editable.defaults.mode = 'inline';

            var org_code = <?php echo "$org_code"; ?>;
            var designation = "";


//            $(function() {
//                $('#match_staff a.text-input').editable({
//                    type: 'text',
//                    url: 'post/post_match_staff.php',
//                    params: function(params) {
//                        params.org_code = org_code;
//                        return params;
//                    }
//                });
//            });

            /* Table initialisation */
//            $(document).ready(function() {
//                $('#staff_list').dataTable({
//                    "sDom": "<'row'<'span5'l><'span4'f>r>t<'row'<'span4'i><'span5'p>>",
//                    "sPaginationType": "bootstrap"
//                });
//            });
//
//            $.extend($.fn.dataTableExt.oStdClasses, {
//                "sWrapper": "dataTables_wrapper form-inline",
//                "sSortAsc": "header headerSortDown",
//                "sSortDesc": "header headerSortUp",
//                "sSortable": "header"
//            });


        </script>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Navbar
        ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="./index.php"><?php echo $app_name; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active">
                                <a href="./index.html">Home</a>
                            </li>
                            <li class="">
                                <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo $org_name; ?></h1>
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
                        $active_menu = "match_employee";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- main
                    ================================================== -->
                    <section id="match_staff">

                        <?php
                        $sql = "SELECT
                                    old_tbl_staff_organization.staff_id,
                                    old_tbl_staff_organization.sanctioned_post_id,
                                    old_tbl_staff_organization.designation_id,
                                    old_tbl_staff_organization.department_id,
                                    old_tbl_staff_organization.staff_name,
                                    old_tbl_staff_organization.father_name,
                                    old_tbl_staff_organization.sp_id_2
                                FROM
                                    old_tbl_staff_organization
                                WHERE
                                    old_tbl_staff_organization.org_code = $org_code
                                ORDER BY
                                    old_tbl_staff_organization.staff_name ASC";
                        $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                        ?>

                        <table id="staff_list" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Father's Name</th>
                                    <th>Dept</th>
                                    <th>Designation(Old System)</th>
                                    <!--<th>Pay scale</th>-->
                                    <!--<th>Class</th>-->
                                    <!--<th>Staff Id</th>-->
                                    <th>Sanctioned Post Id(New System)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = mysql_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><a href="employee.php?staff_id=<?php echo $data['staff_id']; ?>"><?php echo $data['staff_name']; ?></a></td>
                                        <td><?php echo $data['father_name']; ?></td>
                                        <td><?php echo getDeptNameFromId($data['department_id']); ?></td>
                                        <?php
                                        $designation_info = getDesignationInfoFromCode($data['designation_id']);
                                        ?>
                                        <td><?php echo $designation_info['designation']; ?></td>
                                        <!--<td><?php echo $designation_info['payscale']; ?></td>-->
                                        <!--<td><?php echo $designation_info['class']; ?></td>-->
                                        <!--<td><a href="employee.php?staff_id=<?php echo $data['staff_id']; ?>"><?php echo $data['staff_id']; ?></a></td>-->
                                        <!--<td><a href="#" data-name="sanctioned_post_id" data-type="text" data-pk='<?php echo $data['staff_id']; ?>' class="text-input"><?php echo $data['sanctioned_post_id']; ?></a></td>-->

                                        <td>
                                            <?php
                                            if ($data['sp_id_2'] > 0) :
                                                echo getDesignationNameFormSanctionedPostId($data['sp_id_2']) . "(" . $data['sp_id_2'] . ")" ;
                                            else:
                                                ?>
                                            <a href="#" class="" id="sp_id-<?php echo $data['staff_id']; ?>" ><?php echo $data['sp_id_2']; ?></a>
                                            <script type="text/javascript">
                                            $(function() {
                                                $('#sp_id-<?php echo $data['staff_id']; ?>').editable({
                                                    type: 'select',
                                                    pk: org_code,
                                                    sourceCache: false,
                                                    url: 'post/post_match_staff_sp.php',
                                                    source: 'get/get_match_staff_sp_code_list.php?org_code=' + org_code + '&staff_id=<?php echo $data['staff_id'];?>&designation=<?php echo $designation_info['designation']; ?>',
                                                    params: function(params) {
                                                        params.staff_id = "<?php echo $data['staff_id']; ?>";
                                                        return params;
                                                    }
                                                });
                                            });
//                                            $('#sp_id-<?php echo $data['staff_id']; ?>').on('hidden', function() {
//                                                $(this).data().editable.input.sourceData = null;
//                                            });
                                            </script>
                                            <?php endif; ?>
                                        </td>
                                        <!--<td></td>-->
                                        <td><a href="move_staff.php?action=move_out&staff_id=<?php echo $data['staff_id']; ?>&org_code=<?php echo $org_code ?>" target="_blank">Move Out</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>
    </body>
</html>

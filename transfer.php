<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$user_name = $_SESSION['username'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_REQUEST['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_REQUEST['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
}
if ($_SESSION['user_type'] == "admin") {
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}
/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051) {
    $org_code = (int) mysql_real_escape_string(trim($_REQUEST['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])) {
        $org_code = (int) mysql_real_escape_string(trim($_REQUEST['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}
$org_name = getOrgNameFormOrgCode($org_code);



if (isset($_REQUEST['q'])) {

    $q = mysql_real_escape_string(trim($_REQUEST['q']));

    $data = getStaffDetails($q);
    
}


$show_selected_transfers = FALSE;
$staff_show = FALSE;


if ($_REQUEST['action'] == "") {
    $action = "add";
} else {
    $action = $_REQUEST['action'];
}


if (isset($_REQUEST['staff_select'])) {
    $show_selected_transfers = TRUE;

    $staff_id = mysql_real_escape_string(trim($_REQUEST['staff_id']));
    $from_org_code = mysql_real_escape_string(trim($_REQUEST['org_code']));
    $from_working_org_code = mysql_real_escape_string(trim($_REQUEST['org_code']));
    $from_designation = mysql_real_escape_string(trim($_REQUEST['org_code']));
    $to_posted_as = mysql_real_escape_string(trim($_REQUEST['org_code']));

    $to_org_code = mysql_real_escape_string(trim($_REQUEST['org_list']));
    $to_designation = mysql_real_escape_string(trim($_REQUEST['sanctioned_post']));
    $to_working_org_code = mysql_real_escape_string(trim($_REQUEST['working_org_list']));
    $to_working_designation = mysql_real_escape_string(trim($_REQUEST['working_sanctioned_post']));

    $to_posted_as = mysql_real_escape_string(trim($_REQUEST['org_code']));


    if ($action == "add") {
        $sql = "SELECT
                        *
                FROM
                        `transfer_queue`
                WHERE
                        staff_id = $staff_id
                AND active LIKE '1'";
        $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:2<br /><br /><b>Query:</b><br />___<br />$sql</p>");
        if (!mysql_num_rows($r) > 0) {
            $sql = "INSERT INTO `transfer_queue` SET 
                    `order_creater_by` = '$user_name', 
                    `staff_id` = $staff_id,
                    `from_org_code` = '$org_code',
                    `from_working_org_code` = '$working_org_code',
                    `to_org_code` = '$to_org_code',
                    `to_designation_code` = '$to_designation',
                    `to_working_org_code` = '$to_org_code',
                    `to_working_designation_code` = '$to_designation',
                    `to_posted_as` = '',
                    `updated_by` = '$user_name'";
            $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

            header("location:transfer.php?staff_show=true");
        } else {
            $duplicate_transfer = true;
        }
    } else if ($action == 'edit') {
        $sql = "UPDATE `transfer_queue` SET 
                    `order_creater_by` = '$user_name', 
                    `from_org_code` = '$org_code',
                    `from_working_org_code` = '$working_org_code',
                    `to_org_code` = '$to_org_code',
                    `to_designation_code` = '$to_designation',
                    `to_working_org_code` = '$to_org_code',
                    `to_working_designation_code` = '$to_designation',
                    `to_posted_as` = '',
                    `updated_by` = '$user_name' WHERE (`staff_id`='$staff_id') ";
        $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

        header("location:transfer.php?staff_show=true");
    }
    
    else if ($action == 'delete' && $_REQUEST['delete']== "confirm") {
        $staff_id = mysql_real_escape_string(trim($_REQUEST['staff_id']));
        $sql = "UPDATE `transfer_queue` SET 
                    `status` = 'cancel', 
                    `order_canceled_by` = '$user_name',
                    `updated_by` = '$user_name' WHERE (`staff_id`='$staff_id') ";
        $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:3<br /><br /><b>Query:</b><br />___<br />$sql</p>");

        header("location:transfer.php?staff_show=true");
    }
}
if (isset($_REQUEST['staff_show'])) {
    $show_selected_transfers = TRUE;
}

/**
 * 
 * Post and print
 */
function showPrintPreviewData($username) {
    $sql = "SELECT * FROM `transfer_queue` WHERE order_creater_by LIKE \"$username\" and `status` LIKE \"pending\"";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:showPrintPreviewData:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
    
    $data = mysql_fetch_assoc($result);
    
    return $data;
}

if ($_REQUEST['order_status'] == "create" || $_REQUEST['order_status'] == "preview") {
    $show_print_preview = TRUE;
    $print_preview_data = showPrintPreviewData($user_name);
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
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

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
            <div class="row-fluid">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Search main div
                    ================================================== -->
                    <section id="search_main">

                        <div class="text-center alert alert-info">
                            Search by Staff ID/PDS Code/ Mobile no
                            <form class="form-search" action="transfer.php" method="get">
                                <input type="text" name="q" placeholder="Staff ID/PDS Code/ Mobile no">
                                <button type="submit" class="btn btn-success">Search Staff</button>
                            </form>
                            <a href="transfer.php?staff_show=true" class="btn btn-default">Show selected staff</a>                            
                        </div>

                        <div class="row-fluid">
                            <?php if ($data['staff_id'] > 0 && $action != "delete"): ?>

                                <div class="span6">
                                    <p class="text-left">Current Information</p>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td><?php echo $data['staff_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>PDS Code</td>
                                                <td><?php echo $data['staff_pds_code']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Staff ID</td>
                                                <td><?php echo $data['staff_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td><?php echo $data['designation']; ?> (Code:<?php echo $data['designation_id']; ?>)</td>
                                            </tr>
                                            <tr>
                                                <td>Posting Status</td>
                                                <td><?php echo $data['posting_status']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Place of Posting</td>
                                                <td><?php echo $data['org_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Number</td>
                                                <td><?php echo $data['contact_no']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>      
                                <div class="span6">
                                    <p class="text-left">Transfer Information</p>
                                    <form method="post" action="">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Select Agency</td>
                                                    <td>
                                                        <input type="hidden" name="staff_id" value="<?php echo $data['staff_id']; ?>" />
                                                        <input type="hidden" name="staff_select" value="true" />
                                                        <input type="hidden" name="org_code" value="<?php echo $data['org_code']; ?>" />
                                                        <input type="hidden" name="action" value="<?php echo $action ?>" />

                                                        <select id="org_agency" name="org_agency">
                                                            <option value="0">Select Agency</option>
                                                            <?php
                                                            $sql = "SELECT
                                                        org_agency_code.org_agency_code,
                                                        org_agency_code.org_agency_name
                                                    FROM
                                                        org_agency_code
                                                    ORDER BY
                                                        org_agency_code.org_agency_code";
                                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadorg_agency:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                            while ($rows = mysql_fetch_assoc($result)) {
                                                                echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Division</td>
                                                    <td>
                                                        <select id="admin_division" name="admin_division">
                                                            <option value="0">__ Select Division __</option>
                                                            <?php
                                                            $sql = "SELECT admin_division.division_name, admin_division.division_bbs_code FROM admin_division";
                                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                            while ($rows = mysql_fetch_assoc($result)) {
                                                                echo "<option value=\"" . $rows['division_bbs_code'] . "\">" . $rows['division_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select District</td>
                                                    <td>
                                                        <select id="admin_district" name="admin_district">
                                                            <option value="0">__ Select District __</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Upazila</td>
                                                    <td>
                                                        <select id="admin_upazila" name="admin_upazila">
                                                            <option value="0">__ Select Upazila __</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Organization</td>
                                                    <td>
                                                        <select id="org_list" name="org_list">
                                                            <option value="0">Select Organization</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Designation</td>
                                                    <td>
                                                        <select id="sanctioned_post" name="sanctioned_post">
                                                            <option value="0">Select Designation</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Posted As</td>
                                                    <td>
                                                        <?php 
                                                        $sql = "SELECT
                                                                staff_job_posting.job_posting_id,
                                                                staff_job_posting.job_posting_name
                                                                FROM
                                                                staff_job_posting";
                                                        $r = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getJobPostingNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
                                                        ?>
                                                        <select id="staff_job_posting_id" name="staff_job_posting_id" >
                                                        <?php while ($data = mysql_fetch_assoc($r)): ?>
                                                          <option value="<?php echo $data['job_posting_id']; ?>"><?php echo $data['job_posting_name']; ?></option>
                                                        <?php endwhile; ?>
                                                      </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Agency</td>
                                                    <td>
                                                        <select id="working_org_agency" name="working_org_agency">
                                                            <option value="0">Select Agency</option>
                                                            <?php
                                                            $sql = "SELECT
                                                        org_agency_code.org_agency_code,
                                                        org_agency_code.org_agency_name
                                                    FROM
                                                        org_agency_code
                                                    ORDER BY
                                                        org_agency_code.org_agency_code";
                                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadorg_agency:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                            while ($rows = mysql_fetch_assoc($result)) {
                                                                echo "<option value=\"" . $rows['org_agency_code'] . "\">" . $rows['org_agency_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Division</td>
                                                    <td>
                                                        <select id="working_admin_division" name="working_admin_division">
                                                            <option value="0">__ Select Division __</option>
                                                            <?php
                                                            $sql = "SELECT admin_division.division_name, admin_division.division_bbs_code FROM admin_division";
                                                            $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>loadDivision:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

                                                            while ($rows = mysql_fetch_assoc($result)) {
                                                                echo "<option value=\"" . $rows['division_bbs_code'] . "\">" . $rows['division_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select District</td>
                                                    <td>
                                                        <select id="working_admin_district" name="working_admin_district">
                                                            <option value="0">__ Select District __</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Upazila</td>
                                                    <td>
                                                        <select id="working_admin_upazila" name="working_admin_upazila">
                                                            <option value="0">__ Select Upazila __</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Organization</td>
                                                    <td>
                                                        <select id="working_org_list" name="working_org_list">
                                                            <option value="0">Select Organization</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select Designation</td>
                                                    <td>
                                                        <select id="working_sanctioned_post" name="working_sanctioned_post">
                                                            <option value="0">Select Designation</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><button type="submit" class="btn btn-success">Select Staff</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            <?php elseif ($show_selected_transfers && $action != "delete"):
                                $sql = "SELECT * FROM `transfer_queue` WHERE order_creater_by LIKE \"$user_name\" and `status` LIKE \"pending\" ORDER BY `serial`";
                                $listed_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
                                ?>
                                <?php if ($duplicate_transfer): ?>
                                    <div class="alert alert-warning">
                                        A transfer order is pending for <em><strong><?php echo getStaffNameFromId($_REQUEST['staff_id']); ?></strong></em>. So your request was not added. 
                                    </div>
                                <?php endif; ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <td>#</td>
                                    <td>Current Information</td>
                                    <td>Transfer Information</td>
                                    <td>Action</td>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysql_fetch_assoc($listed_result)): ?>
                                            <tr>
                                                <td>
                                                    <a href="#" class="serial" id="serial" ><?php echo $row['serial']; ?></a>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('.serial').editable({
                                                                url: 'post/post_transfer_staff.php',
                                                                pk: '<?php echo $row['id']; ?>'
                                                            });
                                                        });
                                                    </script>
                                                </td>
                                                <td>
                                                    <?php echo getStaffNameFromId($row['staff_id']); ?>,
                                                    <?php echo $row['staff_id']; ?>,
                                                    <?php echo $row['staff_id']; ?>,
                                                    <?php echo getDesignationNameformCode($row['designation_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['org_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['working_org_code']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['to_posted_as']; ?>,
                                                    <?php echo getDesignationNameformCode($row['to_designation_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['to_org_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['to_working_org_code']); ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-info btn-small" href="transfer.php?q=<?php echo $row['staff_id']; ?>&action=update">Edit</a>
                                                        <a class="btn btn-danger btn-small" href="transfer.php?staff_id=<?php echo $row['staff_id']; ?>&staff_select=true&action=delete">Delete</a>
                                                    </div>                                                    
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <form class="form-horizontal">
                                            <div class="control-group">
                                                <label class="control-label" for="memo_no">Memo No</label>
                                                <div class="controls">
                                                    <input type="text" id="memo_no" name="memo_no" placeholder="Memo No">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="memo_date">Memo Date</label>
                                                <div class="controls">
                                                    <input type="text" id="memo_date" name="memo_date" placeholder="Memo Date">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="comment">Comment</label>
                                                <div class="controls">
                                                    <textarea id="comment" name="comment"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="order_status" value="create" />
                                            <div class="control-group">
                                                <div class="controls">                                            
                                                    <button type="submit" class="btn btn-success">Post and Print</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            <?php elseif ($action == "delete"):
                                $sql = "SELECT * FROM `transfer_queue` WHERE `staff_id` = $staff_id and `status` LIKE \"pending\"";
                                $listed_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getStaffDetails:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
                                ?>
                                <div class="alert alert-warnign">You are going to remove the previously selected transfer request.</div>
                                <table class="table table-bordered">
                                    <thead>
                                    <td>#</td>
                                    <td>Current Information</td>
                                    <td>Transfer Information</td>
                                    <td>Action</td>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysql_fetch_assoc($listed_result)): ?>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <?php echo getStaffNameFromId($row['staff_id']); ?>,
                                                    <?php echo $row['staff_id']; ?>,
                                                    <?php echo $row['staff_id']; ?>,
                                                    <?php echo getDesignationNameformCode($row['designation_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['org_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['working_org_code']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['to_posted_as']; ?>,
                                                    <?php echo getDesignationNameformCode($row['to_designation_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['to_org_code']); ?>,
                                                    <?php echo getOrgNameFormOrgCode($row['to_working_org_code']); ?>,
                                                    <?php echo $row['to_posted_as']; ?>
                                                </td>
                                                <td>
                                                    <a href="transfer.php?staff_id=<?php echo $row['staff_id']; ?>&staff_select=true&action=delete&delete=confirm" class="btn btn-danger btn-small" >Confirm Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table> <!-- /delete block -->
                                
                            <?php elseif ($data): ?>
                                <div class="span12">
                                    <div class="alert alert-warning">
                                        No result found, please search again. 
                                    </div>
                                </div>
                                <?php echo $staff_id; ?>
                            <?php endif; ?>
                        </div>                                                
                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <script>
//            $.fn.editable.defaults.mode = 'inline';
            
//            $('#serial').editable({
//                type: 'text',
//                url: 'post/post_transfer_staff.php',
//                pk: <?php echo $staff_id; ?>,
//                params: function(params) {
//                  params.org_code = <?php echo $org_code; ?>;
//                  return params;
//                }
//
//              });
              
            // load district
            $('#admin_division').change(function() {
                $("#loading_content").show();
                var div_code = $('#admin_division').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_districts.php',
                    data: {div_code: div_code},
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

            // load upazila
            $('#admin_district').change(function() {
                var dis_code = $('#admin_district').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_upazilas.php',
                    data: {dis_code: dis_code},
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

            // load organization
            $('#admin_upazila').change(function() {
                $("#loading_content").show();
                var div_code = $('#admin_division').val();
                var dis_code = $('#admin_district').val();
                var upa_code = $('#admin_upazila').val();
                var agency_code = $('#org_agency').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organizations.php',
                    data: {
                        div_code: div_code,
                        dis_code: dis_code,
                        upa_code: upa_code,
                        agency_code: agency_code
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var org_list = document.getElementById('org_list');
                        org_list.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            org_list.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load designation
            $('#org_list').change(function() {
                var organization_code = $('#org_list').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_designations.php',
                    data: {organization_code: organization_code},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var sanctioned_post = document.getElementById('sanctioned_post');
                        sanctioned_post.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            sanctioned_post.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load district
            $('#working_admin_division').change(function() {
                $("#loading_content").show();
                var div_code = $('#working_admin_division').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_districts.php',
                    data: {div_code: div_code},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var admin_district = document.getElementById('working_admin_district');
                        admin_district.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_district.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load upazila
            $('#working_admin_district').change(function() {
                var dis_code = $('#working_admin_district').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_upazilas.php',
                    data: {dis_code: dis_code},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var admin_upazila = document.getElementById('working_admin_upazila');
                        admin_upazila.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            admin_upazila.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load organization
            $('#working_admin_upazila').change(function() {
                $("#loading_content").show();
                var div_code = $('#working_admin_division').val();
                var dis_code = $('#working_admin_district').val();
                var upa_code = $('#working_admin_upazila').val();
                var agency_code = $('#working_org_agency').val();
                $.ajax({
                    type: "POST",
                    url: 'get/get_organizations.php',
                    data: {
                        div_code: div_code,
                        dis_code: dis_code,
                        upa_code: upa_code,
                        agency_code: agency_code
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var org_list = document.getElementById('working_org_list');
                        org_list.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            org_list.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });

            // load designation
            $('#working_org_list').change(function() {
                var organization_code = $('#working_org_list').val();
                $("#loading_content").show();
                $.ajax({
                    type: "POST",
                    url: 'get/get_designations.php',
                    data: {organization_code: organization_code},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#loading_content").hide();
                        var sanctioned_post = document.getElementById('working_sanctioned_post');
                        sanctioned_post.options.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var d = data[i];
                            sanctioned_post.options.add(new Option(d.text, d.value));
                        }
                    }
                });
            });
        </script>
    </body>
</html>

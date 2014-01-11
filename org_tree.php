<?php
require_once 'configuration.php';

$level = mysql_real_escape_string(trim($_GET['level']));
$code = (int) mysql_real_escape_string(trim($_GET['code']));
$dis_code = (int) mysql_real_escape_string(trim($_GET['dis_code']));

if (isset($_GET['level']) && isset($_GET['code'])) {
    if ($level == "div") {
        $division_name = getDivisionNameFromCode($code);
        $sql = "SELECT
                    organization.org_name,
                    organization.org_code,
                    organization.org_type_code,
                    org_type.org_type_name,
                    org_level.org_level_name,
                    organization.org_level_code,
                    organization.org_photo
                FROM
                    `organization`
                LEFT JOIN org_type ON organization.org_type_code = org_type.org_type_code
                LEFT JOIN org_level ON organization.org_level_code = org_level.org_level_code
                WHERE
                    organization.division_code = $code
                AND organization.active LIKE 1";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:divOrgList || Query:</b><br />___<br />$sql</p>");
        if (mysql_num_rows($result) > 0) {
            $showReportTable = TRUE;
        }
    } else if ($level == "dis") {
        $division_name = getDivisionNameFromDistrictCode($code);
        $division_code = getDivisionCodeFromDistrictCode($code);
        $district_name = getDistrictNameFromCode($code);
        $sql = "SELECT
                        organization.org_code,
                        organization.org_name,
                        organization.org_type_code,
                        org_type.org_type_name,
                        organization.org_level_code,
                        org_level.org_level_name,
                        organization.org_photo
                FROM
                        `organization`
                LEFT JOIN org_type ON organization.org_type_code = org_type.org_type_code
                LEFT JOIN org_level ON organization.org_level_code = org_level.org_level_code
                WHERE
                        organization.district_code = $code
                AND organization.active LIKE 1";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:divOrgList || Query:</b><br />___<br />$sql</p>");
        if (mysql_num_rows($result) > 0) {
            $showReportTable = TRUE;
        }
    } else if ($level == "upa") {

        $upa_info = getDisDivNameCodeFromUpazilaAndDistrictCode($code, $dis_code);
        $division_name = $upa_info['district_name'];
        $division_code = $upa_info['upazila_division_code'];
        $district_name = $upa_info['division_name'];
        $district_code = $upa_info['upazila_district_code'];
        $upazila_name = $upa_info['upazila_name'];

        $sql = "SELECT
                    organization.org_code,
                    organization.org_name,
                    organization.org_type_code,
                    org_type.org_type_name,
                    organization.org_level_code,
                    org_level.org_level_name,
                    organization.org_photo
                FROM
                    `organization`
                LEFT JOIN org_type ON organization.org_type_code = org_type.org_type_code
                LEFT JOIN org_level ON organization.org_level_code = org_level.org_level_code
                WHERE
                    organization.upazila_thana_code = $code
                AND organization.district_code = $dis_code
                AND organization.active LIKE 1";
        $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:divOrgList || Query:</b><br />___<br />$sql</p>");
        if (mysql_num_rows($result) > 0) {
            $showReportTable = TRUE;
        }
    }
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"  lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Organization Registry</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="assets/bootstrap3/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <style>
            body{
                font-size: 12px;
            }
        </style>

    </head>
    <body>
        <div class="container">


        </div>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="sidebar-nav">

                        <div id="org_list" style="min-height:280px;">
                            <ul>
                                <li id="tree_root">
                                    <a href="#" onclick="window.open('org_tree.php?level=country', '_self');">Bangladesh</a>
                                    <ul>
                                        <?php
                                        $sql = "SELECT
                                                    admin_division.division_name,
                                                    admin_division.division_bbs_code
                                                FROM
                                                    `admin_division`
                                                WHERE
                                                    admin_division.division_active LIKE 1";
                                        $div_result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1 || Query:</b><br />___<br />$sql</p>");
                                        while ($div_data = mysql_fetch_assoc($div_result)):
                                            ?>
                                            <li id="div_<?php echo $div_data['division_bbs_code']; ?>">
                                                <a href="#" onclick="window.open('org_tree.php?level=div&code=<?php echo $div_data['division_bbs_code']; ?>', '_self');"><?php echo $div_data['division_name']; ?></a>
                                                <ul>
                                                    <?php
                                                    $sql = "SELECT
                                                                district_name,
                                                                district_bbs_code
                                                            FROM
                                                                `admin_district`
                                                            WHERE
                                                                division_bbs_code = " . $div_data['division_bbs_code'] . "
                                                            AND active LIKE 1";
                                                    $dis_result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:2 || Query:</b><br />___<br />$sql</p>");
                                                    while ($dis_data = mysql_fetch_assoc($dis_result)):
                                                        ?>
                                                        <li id="div_<?php echo $dis_data['district_bbs_code']; ?>">
                                                            <a href="#" onclick="window.open('org_tree.php?level=dis&code=<?php echo $dis_data['district_bbs_code']; ?>', '_self');"><?php echo $dis_data['district_name']; ?></a>
                                                            <ul>
                                                                <?php
                                                                $sql = "SELECT
                                                                            upazila_name,
                                                                            upazila_bbs_code,
                                                                            upazila_district_code
                                                                        FROM
                                                                            `admin_upazila`
                                                                        WHERE
                                                                            upazila_district_code = " . $dis_data['district_bbs_code'] . "
                                                                        AND upazila_active LIKE 1;";
                                                                $uni_result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:3 || Query:</b><br />___<br />$sql</p>");
                                                                while ($uni_data = mysql_fetch_assoc($uni_result)):
                                                                    ?>
                                                                    <li id="upa_<?php echo $uni_data['upazila_bbs_code']; ?>">
                                                                        <a href="#" onclick="window.open('org_tree.php?level=upa&code=<?php echo $uni_data['upazila_bbs_code']; ?>&dis_code=<?php echo $uni_data['upazila_district_code']; ?>', '_self');"><?php echo $uni_data['upazila_name']; ?></a>
                                                                    </li>
                                                                <?php endwhile; ?>
                                                            </ul>
                                                        </li>
                                                    <?php endwhile; ?>
                                                </ul>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div><!--/.well -->

                </div>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <?php if ($showReportTable): ?>
                        <ol class="breadcrumb">
                            <li>Bangladesh</li>
                            <?php if ($level == "div"): ?>
                                <li class="active"><?php echo $division_name; ?></li>
                            <?php endif; ?>
                            <?php if ($level == "dis"): ?>
                                <li><a href="org_tree.php?level=div&code=<?php echo $division_code; ?>"><?php echo $division_name; ?></a></li>
                                <li class="active"><?php echo $district_name; ?></li>
                            <?php endif; ?>
                            <?php if ($level == "upa"): ?>
                                <li><a href="org_tree.php?level=div&code=<?php echo $division_code; ?>"><?php echo $division_name; ?></a></li>
                                <li><a href="org_tree.php?level=dis&code=<?php echo $district_code; ?>"><?php echo $district_name; ?></a></li>
                                <li class="active"><?php echo $upazila_name; ?></li>
                            <?php endif; ?>
                        </ol>
                        <!--<h2><?php echo $division_name; ?></h2>-->
<!--                    <div class="alert alert-info">
                        All Organizations under
                        <em>
                            <?php if ($level == "div") { echo "<strong>" . $division_name . "</strong> division"; } ?>
                            <?php if ($level == "dis") { echo "<strong>" . $division_name . "</strong> division" . " under " . "<strong>" .  $district_name . "</strong> district"; } ?>
                            <?php if ($level == "upa") {
                                echo "<strong>" . $division_name . "</strong> division";
                                echo " under " . "<strong>" .  $district_name . "</strong> district";
                                echo " under " . "<strong>" .  $district_name . "</strong> district";
                            } ?>
                        </em> <br />
                        Total <em><strong><?php echo mysql_num_rows($result); ?></strong></em> organization(s) found.
                    </div>-->
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td><strong>#</strong></td>
                                    <td><strong>Organization</strong></td>
                                    <td><strong>Code</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php while ($row = mysql_fetch_assoc($result)): ?>
                                    <?php $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><a href="org_profile.php?org_code=<?php echo $row['org_code']; ?>" target="_parent"><?php echo $row['org_name']; ?></a></td>
                                        <td><?php echo $row['org_code']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                    <?php endif; ?>


                </div>

            </div>
        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>


        <!--<script type="text/javascript" src="library/jstree-bootstrap-theme-master/jquery.js"></script>-->
        <script type="text/javascript" src="library/jstree-bootstrap-theme-master/jquery.cookie.js"></script>
        <script type="text/javascript" src="library/jstree-bootstrap-theme-master/jquery.hotkeys.js"></script>
        <script type="text/javascript" src="library/jstree-bootstrap-theme-master/jquery.jstree.js"></script>

        <script src="assets/bootstrap3/js/bootstrap.min.js"></script>

        <script type="text/javascript">
        $(function() {
            $("#org_list").jstree({
                "plugins": ["themes", "html_data", "ui", "crrm", "hotkeys"],
                "core": {
                    "animation": 100
                },
                "themes": {
                    "theme": "proton"
                },
            })
        });
        </script>

    </body>
</html>

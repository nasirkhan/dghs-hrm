<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}



// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$org_type_code = $_SESSION['org_type_code'];


$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
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
    $child_org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($child_org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])) {
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


$username = getUserNameFromOrgCode($org_code);
//get coordinates
$sql = "SELECT latitude, longitude FROM organization WHERE  org_code = $org_code LIMIT 1";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
$data = mysql_fetch_assoc($result);

$latitude = $data['latitude'];
$longitude = $data['longitude'];
$coordinate = $longitude . "," . $latitude;
if (!($latitude > 0) || !($longitude > 0)) {
    $map_popup = "";
} else {
    $map_popup = $org_name;
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
        <!--==leaflet for map==-->
        <script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js"></script>
        <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.css" />
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

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
                        $active_menu = "home";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- info area
                    ================================================== -->
                    <section id="organization-profile">

                        <div class="row">
                            <div class="span5">
                                <?php
                                $image_src = "uploads/" . $username . ".jpg";

                                if (file_exists($image_src)) {
                                    echo "<img src=\"$image_src\" class=\"img-polaroid\" />";
                                } else {
                                    echo "<img data-src=\"holder.js/480x360\"  class=\"img-polaroid\" />";
                                }
                                ?>
                            </div>
                            <div class="span4">
                                <div id="map" style="height: 360px"></div>
                            </div>
                        </div>

                    </section>
                    <section id="home-basic-info">
                        <div class="row">
                            <div class="lead span9">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td>Organization Name</td>
                                        <td><?php echo "$org_name"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Organization Code</td>
                                        <td><?php echo "$org_code"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Organization Type</td>
                                        <td><?php echo "$org_type_name"; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </section>
                    <?php
                    $org_type_code = getOrgTypeCodeFromOrgCode($org_code);
                    if ($org_type_code == 1029 || $org_type_code == 1051):
                        $org_info = getOrgInfoFromOrgCode($org_code);

                        $row_count = count($org_info);
                        ?>
                        <h3>List of Union Sub Center</h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td><strong>Organization Name</strong></td>
                                    <td><strong>Organization Code</strong></td>
                                    <td><strong>Email Address</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < $row_count; $i++): ?>
                                    <tr>

                                        <td><a href="home.php?org_code=<?php echo $org_info[$i]['org_code']; ?>" target="_blank"><?php echo $org_info[$i]['org_name']; ?></a></td>
                                        <td><?php echo $org_info[$i]['org_code']; ?></td>
                                        <td><?php echo $org_info[$i]['email']; ?></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Footer
        ================================================== -->
        <?php //include_once 'include/footer/footer.inc.php'; ?>
        <?php include_once 'include/footer/footer.inc.php'; ?>
        <!-- Map
        ================================================== -->

        <script>

            var map = L.map('map').setView([<?php echo $coordinate; ?>], 6);

            L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
            }).addTo(map);


            L.marker([<?php echo $coordinate; ?>]).addTo(map)
                    .bindPopup("<?php echo "$map_popup"; ?>").openPopup();




            var popup = L.popup();

            function onMapClick(e) {
                popup
                        .setLatLng(e.latlng)
                        .setContent("You clicked the map at " + e.latlng.toString())
                        .openOn(map);
            }

            map.on('click', onMapClick);

        </script>
    </body>
</html>

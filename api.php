<?php
require_once 'api_config.php';

$org_code = (int) mysql_real_escape_string(trim($_REQUEST['org_code']));
$staff_id = (int) mysql_real_escape_string($_GET['staff_id']);

$format = mysql_real_escape_string(trim($_REQUEST['format']));

function getOrganizationBasicInfo($org_code) {
    $sql = "SELECT * FROM organization WHERE  org_code =$org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrganizationBasicInfo:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data;
}

function getStaffBasicInfo($staff_id, $format) {
    $sql = "SELECT
                *
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id = $staff_id
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getStaffBasicInfo:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data;
}
?>


<?php
/*
 * Organization Information
 */
if ($org_code > 0) :
    $data = getOrganizationBasicInfo($org_code, $format);

    if ($format == ""):
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>HRM API</title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <style>
                    html {
                        font-family: sans-serif;
                        font-size: 12pt;
                    }
                    table {
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid #c0c0c0;
                        padding: 3px;
                    }
                    h1, h2, h3 {
                        text-transform: capitalize;
                    } 
                </style>
            </head>
            <body>
                <div id="main">                    
                    <h3><?php echo $data['org_name']; ?></h3>
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>Organization Code</td>
                                <td><?php echo $data['org_code']; ?></td>
                            </tr>
                            <tr>
                                <td>Organization Name</td>
                                <td><?php echo $data['org_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Agency code</td>
                                <td><?php echo $data['agency_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Agency Name</td>
                                <td><?php echo getAgencyNameFromAgencyCode($data['agency_code']); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Financial Code (Revenue Code)</td>
                                <td><?php echo $data['financial_revenue_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Year Established</td>
                                <td><?php echo $data['year_established']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Urban/Rural Location</td>
                                <td><?php // echo $data['org_code'];               ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Division Name</td>
                                <td><?php echo $data['division_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Division Code</td>
                                <td><?php echo $data['division_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">District Name</td>
                                <td><?php echo $data['district_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">District Code</td>
                                <td><?php echo $data['district_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Upazila Name</td>
                                <td><?php echo $data['upazila_thana_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Upazila Code</td>
                                <td><?php echo $data['upazila_thana_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Union Name</td>
                                <td><?php echo $data['union_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Union Code</td>
                                <td><?php echo $data['union_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Ward</td>
                                <td><?php echo $data['ward_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Village/Street</td>
                                <td><?php echo $data['village_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">House No</td>
                                <td><?php echo $data['house_number']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Longitude</td>
                                <td><?php echo $data['longitude']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Latitude</td>
                                <td><?php echo $data['latitude']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Last Updated on</td>
                                <td><?php echo $data['updated_datetime']; ?></td>
                            </tr>
                            <!--
                            <tr>
                                <td width="50%">Updated By</td>
                                <td><?php echo $data['updated_by']; ?></td>
                            </tr>
                            -->
                        </tbody>
                    </table>
                </div>
            </body>
        </html>

        <?php
    elseif ($format == "json"):
        $data_all = array();
        $data_all[] = array(
            'org_code' => $data['org_code'],
            'org_name' => $data['org_name'],
            'agency_code' => $data['agency_code'],
            'agency_name' => getAgencyNameFromAgencyCode($data['agency_code']),
            'financial_revenue_code' => $data['financial_revenue_code'],
            'year_established' => $data['year_established'],
            'division_name' => getDivisionNamefromCode($data['division_code']),
            'division_code' => $data['division_code'],
            'district_name' => getDistrictNamefromCode($data['district_code']),
            'district_code' => $data['district_code'],
            'upazila_thana_name' => getUpazilaNamefromCode($data['upazila_thana_code']),
            'upazila_thana_code' => $data['upazila_thana_code'],
            'union_name' => getUnionNamefromCode($data['union_code']),
            'union_code' => $data['union_code'],
            'ward_code' => $data['ward_code'],
            'village_code' => $data['village_code'],
            'house_number' => $data['house_number'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'updated_datetime' => $data['updated_datetime'],
            'updated_by' => $data['updated_by']
        );
        $json_data = json_encode($data_all);

        print_r($json_data);
        ?>    
    <?php endif; ?>

    <?php
/*
 * Staff Information
 */
elseif ($staff_id > 0):
    $data = getStaffBasicInfo($staff_id, $format);

    if ($format == ""):
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>HRM API</title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <style>
                    html {
                        font-family: sans-serif;
                        font-size: 12pt;
                    }
                    table {
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid #c0c0c0;
                        padding: 3px;
                    }
                    h1, h2, h3 {
                        text-transform: capitalize;
                    } 
                </style>
            </head>
            <body>
                <div id="main">
                    <?php 
//                     echo "<pre>"; 
//                    print_r($data); 
                    ?>
                    <h3><?php echo $data['staff_name']; ?></h3>
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>Staff Code</td>
                                <td><?php echo $data['staff_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Staff Name</td>
                                <td><?php echo $data['staff_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Sanctioned Post Id</td>
                                <td><?php echo $data['sanctioned_post_id']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Designation</td>
                                <td><?php echo getDesignationNameFormSanctionedPostId($data['sanctioned_post_id']); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Organization Code</td>
                                <td><?php echo $data['org_code']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Organization Name</td>
                                <td><?php echo getOrgNameFormOrgCode($data['org_code']); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Department Id</td>
                                <td><?php echo $data['department_id']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Department Name</td>
                                <td><?php echo getDeptNameFromId($data['department_id']); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Father Name</td>
                                <td><?php echo $data['father_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Mother Name</td>
                                <td><?php echo $data['mother_name']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Date of Birth</td>
                                <td><?php echo $data['birth_date']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Mailing Address</td>
                                <td><?php echo $data['mailing_address']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Permanent Address</td>
                                <td><?php echo $data['permanent_address']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Last Updated</td>
                                <td><?php echo $data['last_update']; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">Updated By</td>
                                <td><?php echo $data['updated_by']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </body>
        </html>

        <?php
    elseif ($format == "json"):        
        $data_all = array();
        $data_all[] = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'sanctioned_post_id' => $data['sanctioned_post_id'],
            'designation_name' => getDesignationNameFormSanctionedPostId($data['sanctioned_post_id']),
            'org_code' => $data['org_code'],
            'org_name' => getOrgNameFormOrgCode($data['org_code']),            
            'department_id' => $data['department_id'],
            'department_name' => getDeptNameFromId($data['department_id']),
            'father_name' => $data['father_name'],
            'mother_name' => $data['mother_name'],
            'birth_date' => $data['birth_date'],
            'mailing_address' => $data['mailing_address'],
            'permanent_address' => $data['permanent_address'],
            'last_update' => $data['last_update'],
            'updated_by' => $data['updated_by']
        );
        $json_data = json_encode($data_all);

        print_r($json_data);
        ?>    
    <?php endif; ?>

<?php 
/*
 * If there is no parameter mentioned
 */
else: ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>HRM API</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <style>
                html {
                    font-family: sans-serif;
                    font-size: 12pt;
                }
                table {
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid #c0c0c0;
                    padding: 3px;
                }
                h1, h2, h3 {
                    text-transform: capitalize;
                }
                #main_content{
                    width: 600px;
                    padding: 20px 20px 40px 20px;
                    margin: auto;
                    text-align: left;
                    border: 1px solid #dedede;
                }
                #main_content_header{
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div id="main_content">
                <div id="main_content_header">
                    <h3>Ministry of Health and Family Welfare</h3>
                    <h3>Web API of the HRM System</h3>
                </div>
                <br />
                <br />
                <strong> Parameter Structure:</strong>
                <p>
                    <br />
                    Organization Basic Information: <em>org_code=ORGANIZATION_CODE </em>
                    <br />                
                    example: <em>api.php?org_code=10000001</em>
                    <br /><br />
                    Staff Basic Information: <em>staff_id=STAFF_ID </em>
                    <br />                
                    example: <em>api.php?staff_id=49633</em>
                </p>
                <p>
                    <br />
                    Data format: <em>format=FORMAT </em>
                    <br />                
                    example: <em>format=json</em>
                </p>

                <p>
                    <br />
                    API call with multiple parameters example: 
                    <br />                
                    <em>api.php?org_code=10000001&format=json</em>
                    <br />                
                    <em>api.php?staff_id=49633&format=json</em>
                </p>
            </div>
        </body>
    </html>       
<?php endif; ?>

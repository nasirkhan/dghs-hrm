
<b>Select Administrative Unit</b><br/>
<table>
  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_division_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
    <tr>
      <td style="width: 170px;"><input name="f_division_code" value="1" checked="checked" type="checkbox"/> <b>Division</b></td>
      <td><?php createSelectOptions('admin_division', 'division_bbs_code', 'division_name', $customQuery, $_REQUEST['division_code'], "division_code", " id='admin_division'  class='pull-left' style='width:80px'", $optionIdField)
    ?></td>
    </tr>
  <?php } ?>
  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_district_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
    <tr>
      <td><input name="f_district_code" value="1" checked="checked" type="checkbox" /> <b>District</b></td>
      <td><?php createSelectOptions('admin_district', 'district_bbs_code', 'district_name', " WHERE division_bbs_code='" . $_REQUEST['division_code'] . "'", $_REQUEST['district_code'], "district_code", " id='admin_district' class='pull-left' style='width:80px' ", $optionIdField); ?></td>
    </tr>
  <?php } ?>
  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['admin_upazila'] == '1') || !isset($_REQUEST['submit'])) { ?>
    <tr>
      <td><input name="admin_upazila" value="1" checked="checked" type="checkbox"/> <b>Upazila</b></td>
      <td><?php createSelectOptions('admin_upazila', 'id', 'upazila_name', " WHERE upazila_district_code='" . $_REQUEST['district_code'] . "'", $_REQUEST['upazila_id'], "upazila_id", " id='admin_upazila'  class='pull-left' style='width:80px;' ", $optionIdField); ?></td>
    </tr>
  <?php } ?>

  <?php if (isset($_REQUEST['submit']) && (strlen($_REQUEST['upazila_id']) || strlen($_REQUEST['district_code']))) {
    ?>
    <tr>
      <td><b>Organizations</b></td>
      <td>
        <?php
        $customQuery = " WHERE 1 ";
        if (strlen($_REQUEST['division_code'])) {
          $customQuery.=" AND division_code='" . $_REQUEST['division_code'] . "'";
        }
        if (strlen($_REQUEST['district_code'])) {
          $customQuery.=" AND district_code='" . $_REQUEST['district_code'] . "'";
        }
        if (strlen($_REQUEST['upazila_id'])) {
          $customQuery.=" AND upazila_id='" . $_REQUEST['upazila_id'] . "'";
        }

        //echo "$customQuery";
        createMultiSelectOptions('organization', 'org_code', 'org_name', $customQuery, $csvs['org_code'], "org_code[]", " id='org_code'  class='multiselect'");
        $customQuery = '';
        ?></td>
    </tr>
    <?php
  } else {
    echo "<tr><td>Select District/Upazila to see organization list</td></tr>";
  }
  ?>
</table>

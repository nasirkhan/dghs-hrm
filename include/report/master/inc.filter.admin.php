
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
                  </table>

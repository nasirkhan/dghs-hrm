                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_agency_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_agency_code" value="1" checked="checked" type="checkbox"/> <b>Agency</b><br/>

                    <?php
                    createMultiSelectOptions('org_agency_code', 'org_agency_code', 'org_agency_name', $customQuery, $csvs['agency_code'], "agency_code[]", " id='agency_code'  class='multiselect' ");
                    echo "<br/>";
                  }
                  ?>
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_level_code" value="1" checked="checked" type="checkbox"/> <b>Org Level</b>
                    <?php
                    createMultiSelectOptions('org_level', 'org_level_code', 'org_level_name', $customQuery, $csvs['org_level_code'], "org_level_code[]", " id='org_level_code' class='multiselect' ");
                    echo "<br/>";
                  }
                  ?>
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_type_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_type_code" value="1" checked="checked" type="checkbox"/> <b>Org Type</b><br/>
                    <?php
                    createMultiSelectOptions('org_type', 'org_type_code', 'org_type_name', $customQuery, $csvs['org_type_code'], "org_type_code[]", " id='type_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

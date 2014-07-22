<?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_healthcare_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_healthcare_level_code" value="1" checked="checked" type="checkbox"/> <b>Healthcare Level</b><br/>
                    <?php
                    createMultiSelectOptions('org_healthcare_levels', 'healthcare_code', 'healthcare_name', $customQuery, $csvs['org_healthcare_level_code'], "org_healthcare_level_code[]", " id='org_healthcare_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_org_location_type'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_org_location_type" value="1" checked="checked" type="checkbox"/>
                    <b>Location Type</b><br/>
                    <?php
                    createMultiSelectOptions('org_location_type', 'org_location_type_code', 'org_location_type_name', $customQuery, $csvs['org_location_type'], "org_location_type[]", " id='org_location_type'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?><?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_ownership_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_ownership_code" value="1" checked="checked" type="checkbox"/>
                    <b>Ownership</b><br/>
                    <?php
                    createMultiSelectOptions('org_ownership_authority', 'org_ownership_authority_code', 'org_ownership_authority_name', $customQuery, $csvs['ownership_code'], "ownership_code[]", " id='ownership_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
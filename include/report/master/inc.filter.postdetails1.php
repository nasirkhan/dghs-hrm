


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_professional_discipline_of_current_designation'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_professional_discipline_of_current_designation" value="1" checked="checked" type="checkbox"/>
                    <b>Proffesional Discipline</b><br/>
                    <?php
                    createMultiSelectOptions('staff_profesional_discipline', 'discipline_id', 'discipline_name', $customQuery, $csvs['professional_discipline_of_current_designation'], "professional_discipline_of_current_designation[]", " id='professional_discipline_of_current_designation'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_type_of_educational_qualification'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_type_of_educational_qualification" value="1" checked="checked" type="checkbox"/>
                    <b>Edu qualification</b><br/>
                    <?php
                    createMultiSelectOptions('staff_educational_qualification', 'educational_qualifiaction_Id', 'educational_qualification', $customQuery, $csvs['type_of_educational_qualification'], "type_of_educational_qualification[]", " id='type_of_educational_qualification'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_govt_quarter'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_govt_quarter" value="1" checked="checked" type="checkbox"/>
                    <b>Govt. Quarter</b><br/>
                    <?php
                    createMultiSelectOptions('staff_govt_quater', 'govt_quater_id', 'govt_quater', $customQuery, $csvs['govt_quarter'], "govt_quarter[]", " id='govt_quarter'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
                </td>

                <td style="vertical-align: top">

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_designation'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_designation" value="1" checked="checked" type="checkbox"/>
                    <b>Designation</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'designation', 'designation', $customQuery, $csvs['designation'], "designation[]", " id='designation'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_group_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_group_code" value="1" checked="checked" type="checkbox"/>
                    <b>Designation Group</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'group_code', 'designation_group_name', $customQuery, $csvs['group'], "group_code[]", " id='group_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_bangladesh_professional_category_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_bangladesh_professional_category_code" value="1" checked="checked" type="checkbox"/>
                    <b>BD Proffesional Category</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_bangladesh_professional_category', 'bangladesh_professional_category_code', 'bangladesh_professional_category_name', $customQuery, $csvs['bangladesh_professional_category_code'], "bangladesh_professional_category_code[]", " id='bangladesh_professional_category_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_who_occupation_group_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_who_occupation_group_code" value="1" checked="checked" type="checkbox"/>
                    <b>WHO group</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_who_health_professional_group', 'who_health_professional_group_code', 'who_health_professional_group_name', $customQuery, $csvs['who_occupation_group_code'], "who_occupation_group_code[]", " id='who_occupation_group_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_who_isco_occopation_group_name'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_who_isco_occopation_group_name" value="1" checked="checked" type="checkbox"/>
                    <b>WHO ISCO</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_who_isco_occopation_name', 'who_isco_occopation_group_code', 'who_isco_occopation_group_name', $customQuery, $csvs['who_isco_occupation_name_code'], "who_isco_occupation_name_code[]", " id='who_isco_occupation_name_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_pay_scale'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_pay_scale" value="1" checked="checked" type="checkbox"/>
                    <b>Pay scale</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'payscale', 'payscale', $customQuery, $csvs['pay_scale'], "pay_scale[]", " id='pay_scale'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_class'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_class" value="1" checked="checked" type="checkbox"/>
                    <b>Class</b><br/>
                    <?php
                    createMultiSelectOptionsDistinct('sanctioned_post_designation', 'class', 'class', $customQuery, $csvs['class'], "class[]", " id='class'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_type_of_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_type_of_code" value="1" checked="checked" type="checkbox"/>
                    <b>Type</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_type_of_post', 'type_of_post_code', 'type_of_post_name', $customQuery, $csvs['type_of_code'], "type_of_code[]", " id='type_of_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_first_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_first_level_code" value="1" checked="checked" type="checkbox"/>
                    <b>First Level</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_first_level', 'first_level_code', 'first_level_name', $customQuery, $csvs['first_level_code'], "first_level_code[]", " id='first_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_second_level_code'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_second_level_code" value="1" checked="checked" type="checkbox"/>
                    <b>Second Level</b><br/>
                    <?php
                    createMultiSelectOptions('sanctioned_post_second_level', 'second_level_code', 'second_level_name', $customQuery, $csvs['second_level_code'], "second_level_code[]", " id='second_level_code'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



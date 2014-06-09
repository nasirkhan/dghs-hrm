
                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_tribal_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_tribal_id" value="1" checked="checked" type="checkbox"/>
                    <b>Tribal</b><br/>
                    <?php
                    createMultiSelectOptions('staff_tribal', 'tribal_id', 'tribal_value', $customQuery, $csvs['tribal_id'], "tribal_id[]", " id='tribal_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_working_status_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_working_status_id" value="1" checked="checked" type="checkbox"/>
                    <b>Working status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_working_status', 'working_status_id', 'working_status_name', $customQuery, $csvs['working_status_id'], "working_status_id[]", " id='working_status_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_draw_salary_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_draw_salary_id" value="1" checked="checked" type="checkbox"/>
                    <b>Salary place</b><br/>
                    <?php
                    createMultiSelectOptions('staff_draw_salaray_place', 'draw_salary_id', 'draw_salaray_place', $customQuery, $csvs['draw_salary_id'], "draw_salary_id[]", " id='draw_salary_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_sex'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_sex" value="1" checked="checked" type="checkbox"/>
                    <b>Sex</b><br/>
                    <?php
                    createMultiSelectOptions('staff_sex', 'sex_type_id', 'sex_name', $customQuery, $csvs['sex'], "sex[]", " id='sex'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_marital_status'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_marital_status" value="1" checked="checked" type="checkbox"/>
                    <b>Marital status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_marital_status', 'marital_status_id', 'marital_status', $customQuery, $csvs['marital_status'], "marital_status[]", " id='marital_status'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_religion'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_religion" value="1" checked="checked" type="checkbox"/>
                    <b>Religious group</b><br/>
                    <?php
                    createMultiSelectOptions('staff_religious_group', 'religious_group_id', 'religious_group_name', $customQuery, $csvs['religion'], "religion[]", " id='religion'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
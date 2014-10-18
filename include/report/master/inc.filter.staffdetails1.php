<?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_department_id'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_department_id" value="1" checked="checked" type="checkbox"/>
                    <b>Department</b><br/>
                    <?php
                    createMultiSelectOptions('very_old_departments', 'department_id', 'name', $customQuery, $csvs['department_id'], "department_id[]", " id='department_id'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>



                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_posting'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_posting" value="1" checked="checked" type="checkbox"/>
                    <b>Posting type</b><br/>
                    <?php
                    createMultiSelectOptions('staff_posting_type', 'staff_posting_type_id', 'staff_posting_type_name', $customQuery, $csvs['staff_posting'], "staff_posting[]", " id='staff_posting'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_posting_status'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_posting_status" value="1" checked="checked" type="checkbox"/>
                    <b>Posting Status</b><br/>
                    <?php
                    createMultiSelectOptions('staff_job_posting', 'job_posting_id', 'job_posting_name', $customQuery, $csvs['posting_status'], "posting_status[]", " id='posting_status'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>

                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_job_class'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_job_class" value="1" checked="checked" type="checkbox"/>
                    <b>Job Class</b><br/>
                    <?php
                    createMultiSelectOptions('staff_job_class', 'job_class_id', 'job_class_name', $customQuery, $csvs['staff_job_class'], "staff_job_class[]", " id='staff_job_class'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>


                  <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_staff_professional_category'] == '1') || !isset($_REQUEST['submit'])) { ?>
                    <input name="f_staff_professional_category" value="1" checked="checked" type="checkbox"/>
                    <b>Staff Proffesional category</b><br/>
                    <?php
                    createMultiSelectOptions('staff_professional_category_type', 'professional_type_id', 'professional_type_name', $customQuery, $csvs['staff_professional_category'], "staff_professional_category[]", " id='staff_professional_category'  class='multiselect'");
                    echo "<br/>";
                  }
                  ?>
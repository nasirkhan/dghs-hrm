<?php
require_once 'configuration.php'; // your config file
/**
 * crudFrame work relative location from this
 */
$crudFrameworkRelativePath = "scripts/crud_framework";
/**
 * Module config
 */
$moduleName = "mod_system_configuration"; // the module this page belongs to
$moduleTitle = "Designation"; // user friendly name
$cssPrefix = ""; //css prefix that is added before some identifiers
/**
 * checks whether current viewer has permission to access/view this page
 */
require_once "$crudFrameworkRelativePath/cf_check_view_permission.php";
/*
 * Log config
 */
$storeLogInDatabase = TRUE; // TURE if you want to use 'log' table
$loggedInUserKeyValue = $_SESSION['user_id']; // this variable store the primary identifier stored in session


/**
 * Database/table config
 */
$dbTableName = 'sanctioned_post_designation'; // database table to operate
$dbTablePrimaryKeyFieldName = 'id'; // primary key field name
$dbTablePrimaryKeyFieldVal = mysql_real_escape_string(trim($_REQUEST["$dbTablePrimaryKeyFieldName"])); // primary key field value that is passed as parameter or form post
/**
 * Database/table config for user/datetime record of this operation
 */
$updatedbyFieldName = 'updated_by'; // this is the fieldname where the user who updated this value is stored
$updatedbyFieldVal = getLoggedUserName(); // gets appropriate value.
$updatedDateTimeFieldName = 'updated_datetime';
$updatedDateTimeFieldVal = getDateTime();

/**
 * Form handling config
 */
$param = mysql_real_escape_string(trim($_REQUEST['param'])); // gets the actio param
$exception_field = array('submit', 'param', 'reset'); // array to store field names that needs to skipped in constructed query
$requiredFieldNames = array('designation'); // array for required fields

/* * ********************************************************************************************************************************************
 * Delete
 */
if ($param == 'delete') {
    require_once "$crudFrameworkRelativePath/cf_delete.php";
}
/* * *****************************************
 * Add/Edit
 */
if (!strlen($dbTablePrimaryKeyFieldVal)) {
    $param = "add";
} else {
    if ($a = getRowVal($dbTableName, $dbTablePrimaryKeyFieldName, $dbTablePrimaryKeyFieldVal)) {
        $param = "edit";
    } else {
        $valid = false;
        array_push($alert, "Invalid $dbTablePrimaryKeyFieldName. No such $dbTablePrimaryKeyFieldName found in database");
    }
}
if (isset($_POST[submit])) {
    if ($param == 'add' || $param == 'edit') {
        /*
         * 	server side validation
         */
        // Need to update this
        if (count($requiredFieldNames)) {
            require_once "$crudFrameworkRelativePath/cf_required_field_check.php";
        }

        /*         * ********************************** */
        if ($valid) {
            if ($param == 'add') {
                $str_k_additional = ""; // add updated_by,updated_datetime type field names here. start with comma
                $str_v_additional = ""; // add updated_by,updated_datetime type field values here. start with comma
                require_once "$crudFrameworkRelativePath/cf_add.php";
                // if success then $valid= TRUE
            } else if ($param == 'edit') {
                /*
                 * 	Check whether current user has edit
                 */
                $str_additioal = ""; // add updated_by,updated_datetime type ,field1=val1,field2=val2 names here Must start with comma
                require_once "$crudFrameworkRelativePath/cf_edit.php";
            }
            //echo $sql;
        }
    }
}

/* * **************************************** */
$dataRows = getRows($dbTableName, $condition);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <?php require_once "$crudFrameworkRelativePath/cf_jquery_modal_popup.php"; ?>

        <div class="<?= $cssPrefix ?>formTitle"><?= ucfirst($param) . " " . $moduleTitle ?></div>
        <div class="<?= $cssPrefix ?>alert"><?php printAlert($valid, $alert); ?></div>
        <div class="<?= $cssPrefix ?>addButton"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">[+] Add</a></div>
        <div id="<?= $cssPrefix ?>form">

            <?php
            if (hasPermission($moduleName, $param, getLoggedUserName())) {
                ?>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <input name="designation" type="text" value="<?= addEditInputField('designation') ?>"/>
                    <input name="submit" type="submit" class="" value="Save" />
                    <input name="reset" type="reset" class="" value="Reset" />
                    <?php if (strlen($dbTablePrimaryKeyFieldVal)) { ?>
                        <input type="hidden" name="<?= $dbTablePrimaryKeyFieldName ?>" value="<?php echo $dbTablePrimaryKeyFieldVal; ?>" />
                    <?php } ?>
                </form>
            <?php }
            ?>

        </div>
        <div id="right_m">
            <!--<h2>List of Departments</h2>-->
            <table id="datatable" width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>designation_code</td>
                        <td>designation</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($dataRows as $dataRow) {
                        ?>
                        <tr>
                            <td><a href="<?= $_SERVER['PHP_SELF'] ?>?param=edit&<?= $dbTablePrimaryKeyFieldName ?>=<?= $dataRow['id'] ?>"><?= $dataRow['id'] ?></td>
                            <td><?= $dataRow['designation_code'] ?></td>
                            <td><?= $dataRow['designation'] ?></td>
                            <td>
                                <?php if (hasPermission($moduleName, 'manage', getLoggedUserName())) { ?>
                                    <a class='cf_delete' id='<?= $dataRow[$dbTablePrimaryKeyFieldName] ?>"' href='#'>Delete</a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

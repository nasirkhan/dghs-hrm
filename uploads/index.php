<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
echo $org_code;

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
require('../configuration.php');

class CustomUploadHandler extends UploadHandler
{
protected function trim_file_name($name, $type) {
$name = parent::trim_file_name($name, $type);
// Your file name changes: $name = 'something';

$Ext = strrchr($name,".");

$Ext =strtolower($Ext);

$name = $_SESSION['username'];
$uploaded_by = $_SESSION['username'];
$upload_datetime=date('Y-m-d h:i:s');
$org_code = $_SESSION['org_code'];

$oldName=$name."$Ext";


$exists = file_exists($oldName);
if(!$exists) {
// do your processing
$name = $name."$Ext";
$sql="UPDATE organization 
SET org_photo='$name',uploaded_by='$uploaded_by',upload_datetime='$upload_datetime'
where org_code='$org_code'";
$result = mysql_query($sql);
}
else
{
unlink("$oldName");
$name = $name."$Ext";
$sql="UPDATE organization 
SET org_photo='$name',uploaded_by='$uploaded_by',upload_datetime='$upload_datetime'
where org_code='$org_code'";
$result = mysql_query($sql);
}



//$name = $name."$Ext";
return $name;
}
}

$upload_handler = new CustomUploadHandler();

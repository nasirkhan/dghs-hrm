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

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
require('../configuration.php');

class CustomUploadHandler extends UploadHandler
{
protected function trim_file_name($name, $type) {
$name = parent::trim_file_name($name, $type);
// Your file name changes: $name = 'something';

$Ext = strrchr($name,".");
$name = $_SESSION['username'];

$oldName=$name."$Ext";

$exists = file_exists($oldName);
if(!$exists) {
// do your processing
$name = $name."$Ext";
}
else
{
unlink("$oldName");
$name = $name."$Ext";
}

//$name = $name."$Ext";
return $name;
}
}

$upload_handler = new CustomUploadHandler();

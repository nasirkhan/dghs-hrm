<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}


// assign values from session array
$org_code =  (int) mysql_real_escape_string($_GET['org_code']);
$org_name = getOrgNameFormOrgCode($org_code);
$org_type_name = getOrgTypeNameFormOrgCode($org_code);

session_start();
$_SESSION['org_code'] = $org_code;
$_SESSION['username'] = getUserNameFromOrgCode($org_code);

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_GET['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_GET['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
}
/**
 * Reassign org_code and enable edit permission for Upazila and below
 *
 * Upazila users can edit the organizations under that UHC.
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051){
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));

    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);

    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])){
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


$upload_type = mysql_real_escape_string($_GET['upload']);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="assets/bootstrap3/css/bootstrap.min.css">
        <link rel="stylesheet" href="library/jQuery-File-Upload-master/css/jquery.fileupload-ui.css">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

        <noscript><link rel="stylesheet" href="library/jQuery-File-Upload-master/css/jquery.fileupload-ui-noscript.css"></noscript>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>
        <link rel="shortcut icon" href="assets/ico/favicon.png">

        <!--Google analytics code-->
        <?php include_once 'include/header/header_ga.inc.php'; ?>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar">

        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo $org_name . $echoAdminInfo; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- Navigation
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php if ($_SESSION['user_type'] == "admin"): ?>
                            <li><a href="admin_home.php?org_code=<?php echo $org_code; ?>"><i class="icon-chevron-right"></i><i class="icon-qrcode"></i> Admin Homepage</a>
                            <?php endif; ?>
                        <?php
                        $active_menu = "upload";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9" style="width:825px;">
                    <!-- main
                    ================================================== -->
                    <section>
                        <h3>Upload Organization Photo/ File</h3>

                        <div id="upoad_options">
                            <div class="row-fluid">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="upload.php?org_code=<?php echo $org_code; ?>&upload=photo" class="btn btn-large btn-warning">
                                                    <i class="icon-picture icon-2x pull-left"></i> Photo (jpg) Upload
                                                </a>
                                            </td>
                                            <td> Upload the organization photo by form here. If any photo is uploaded previously, then it will be replaced by new new uploaded image.</td>
                                        </tr>
                                        <!--<tr>
                                            <td>
                                                <a href="upload.php?org_code=<?php echo $org_code; ?>&upload=file" class="btn btn-large btn-info">
                                                    <i class="icon-copy icon-2x pull-left"></i> File (PDF/Doc) Upload
                                                </a>
                                            </td>
                                            <td> Upload different files related to the organization, click the button and go to the upload form. Details information is described there.</td>
                                        </tr>  -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php  if ($upload_type == "photo"){ ?>
                        <div class="row-fluid">
                            <div class="span12">

                                <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                      <i class="glyphicon glyphicon-plus"></i>
                                      <span>Add files...</span>
                                      <!-- The file input field used as target for the file upload widget -->
                                      <input id="fileupload" type="file" name="files[]" multiple>
                                  </span>
                                  <br>
                                  <br>
                                  <!-- The global progress bar -->
                                  <div id="progress" class="progress">
                                      <div class="progress-bar progress-bar-success"></div>
                                  </div>
                                  <!-- The container for the uploaded files -->
                                  <div id="files" class="files"></div>
                                <br>

                            </div>
                        </div>

                        <?php } ?>

                    </section>

                </div>
            </div>

        </div>



        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer_menu.inc.php'; ?>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/holder/holder.js"></script>
        <script src="assets/js/google-code-prettify/prettify.js"></script>

        <script src="assets/js/application.js"></script>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="library/jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
        <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>-->
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="library/jQuery-File-Upload-master/js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="library/jQuery-File-Upload-master/js/jquery.fileupload-validate.js"></script>
		<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
       <script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
		var url = window.location.hostname === 'http://gov.vd.com' ? '/fileupload/' : 'uploads/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Uploading..')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(jpe?g)$/i,
        maxFileSize: 500000,
        maxChunkSize: 500000 ,
//
//
//
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append(file.error);
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            var link = $('<a>')
                .attr('target', '_blank')
                .prop('href', file.url);
            $(data.context.children()[index])
                .wrap(link);
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.result.files, function (index, file) {
            var error = $('<span/>').text(file.error);
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
</body>

</html>

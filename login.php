<?php
require_once 'configuration.php';

if ($_SESSION['logged'] == true) {
    header("location:home.php?org_code=" . $_SESSION['org_code']);
}

$login_sussess = 2;
//cheak the login information
if (isset($_POST['email']) && isset($_POST['password']) && $_POST['login_key'] == $_SESSION['login_key']) {
    $form_uname = $_POST['email'];
    $form_passwd = $_POST['password'];
    unset($_POST);
    $form_uname = stripslashes($form_uname);
    $form_passwd = stripslashes($form_passwd);
    $form_uname = mysql_real_escape_string($form_uname);
    $form_passwd = mysql_real_escape_string($form_passwd);
    $form_passwd = md5($form_passwd);

    $sql = "SELECT user_id, username, user_type, organization_id, org_code FROM user WHERE username LIKE \"$form_uname\" AND password LIKE \"$form_passwd\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);


//    set session variables 
    if (mysql_num_rows($result) >= 1) {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['organization_id'] = $data['organization_id'];
        $_SESSION['org_code'] = $data['org_code'];
        $_SESSION['logged'] = TRUE;

        $login_sussess = 1;

        header("location:home.php?org_code=" . $_SESSION['org_code']);
    } else {
        $login_sussess = 0;
    }

//    echo "<pre>";
//    print_r($_SESSION);
} else {
    $_SESSION['login_key'] = mt_rand(1, 1000);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="DHGS HRM Application developed by Activation Ltd, http://activationltd.com">
        <meta name="author" content="nasir khan saikat">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 350px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .input-append, .input-prepend{
                width: 90%;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 9px 9px;
            }
            .input-append .add-on, .input-prepend .add-on{
                height: 29px;
            }
            .contact{
                margin-top: 20px;
                color: #0077b3;
            }
            .login-error{
                margin-top: 30px;
            }

        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">

    </head>

    <body>

        <div class="container">

            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];
hm ?>" method="post">
                <div class="">
                    <h2 class="form-signin-heading">Welcome to DGHS HRM Software</h2>

                    <input type="hidden" name="login_key" value="<?php echo $_SESSION['login_key'] ?>" />
                    <div class="input-append">
                        <input name="email" type="text" class="input-block-level" placeholder="Email address">
                        <span class="add-on"><i class="icon-envelope icon-2x"></i></span>
                    </div>
                    <div class="input-append">
                        <input name="password" type="password" class="input-block-level" placeholder="Password">
                        <span class="add-on"><i class="icon-key icon-2x"></i></span>
                    </div>
                </div>
                <button class="btn btn-large btn-primary" type="submit" value="submit">Sign in <i class="icon-signin"></i></button>

                <?php 
                if ($login_sussess ==0):
                ?>
                <div class="login-error">
                    <div class="alert alert-block alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="icon-minus-sign"></i> Warning!</strong><br />Your login Username or Password is incorrect. 
                        <br />Please try again.
                    </div>
                </div>
                <?php endif; ?>
                <div class="contact"><i class="icon-edit"></i> <a href="#">Contact us for any assistance.</a></div>

            </form>

        </div> <!-- /container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>  

    </body>
</html>

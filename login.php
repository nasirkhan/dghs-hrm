<?php
require_once 'configuration.php';

if ($_SESSION['logged'] == true) {
    header("location:home.php?org_code=" . $_SESSION['org_code']);
}

$login_sussess = 2;
//cheak the login information
if (isset($_POST['email']) && isset($_POST['password']) && $_POST['login_key'] == $_SESSION['login_key']) {
    $form_uname = mysql_real_escape_string(stripslashes($_POST['email']));
    $form_passwd = mysql_real_escape_string(stripslashes($_POST['password']));
    $form_passwd = md5($form_passwd);
    unset($_POST);
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
        $_SESSION['org_name'] = getOrgNameFormOrgCode($data['org_code']);
        $_SESSION['org_type_name'] = getOrgTypeNameFormOrgCode($data['org_code']);
        $_SESSION['logged'] = TRUE;

        session_write_close();
        $login_sussess = 1;

        if ($_SESSION['user_type'] == "admin") {
            header("location:admin_home.php?org_code=" . $_SESSION['org_code']);
        } else {
            header("location:home.php?org_code=" . $_SESSION['org_code']);
        }
    } else {
        $login_sussess = 0;
    }
} else {
    $_SESSION['login_key'] = mt_rand(1, 1000);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ministry of Health and Family Welfare HRM Application developed by Activation Ltd, http://activationltd.com">
        <meta name="author" content="nasir khan saikat (nasir8891 AT gmail DOT com)">

        <!-- Fav and touch icons -->
        <?php include_once 'include/header/header_icon.inc.php'; ?>    

        <title><?php echo $app_name; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="assets/css/signin.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
          <script src="assets/js/respond.min.js"></script>
        <![endif]-->

        <!--Google analytics code-->
        <?php include_once 'include/header/header_ga.inc.php'; ?>
    </head>

    <body>

        <div class="container">

            <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h2 class="form-signin-heading">Welcome to HRM Software<br /> <span class="mohfw">Ministry of Health and Family Welfare</span></h2>
                <input type="hidden" name="login_key" value="<?php echo $_SESSION['login_key'] ?>" />
                <input name="email" type="text" class="form-control" placeholder="Email address" autofocus>
                <input name="password" type="password" class="form-control" placeholder="Password">
                
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                
                <?php
                if ($login_sussess == 0):
                    ?>
                    <div class="login-error">
                        <div class="alert alert-danger">
                            <strong> Warning!</strong><br />Your login Username or Password is incorrect. 
                            <br />Please try again.
                        </div>
                    </div>
                <?php endif; ?>
                
                
                <div class="contact"> <a href="#">Contact us for any assistance.</a></div>
            </form>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
    </body>
</html>

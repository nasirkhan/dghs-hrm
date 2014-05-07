<?php
require_once 'configuration.php';
if ($_SESSION['logged'] == true) {
  header("location:index.php");
}
$login_sussess = 0;
//cheak the login information
if (isset($_POST['email']) && isset($_POST['password']) && $_POST['login_key'] == $_SESSION['login_key']) {
  $login_sussess = login($_POST);
  if ($login_sussess == 1) {
    if ($_SESSION['user_type'] == 'report_viewer') {
      $_SESSION['redirect_url'] = "report_index.php";
    }
    header("location:" . $_SESSION['redirect_url']);
  }
} else {
  $_SESSION['login_key'] = mt_rand(1, 1000);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $app_name; ?></title>
    <?php
    include_once 'include/header/header_css_js.inc.php';
    include_once 'include/header/header_ga.inc.php';
    ?>
    <link href="assets/css/login.css" rel="stylesheet"/>
  </head>
  <body>
    <div class="container">
      <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="" id="login_div">
          <h2 class="form-signin-heading">Welcome to HRM Software<br /> <span class="mohfw">Ministry of Health and Family Welfare</span></h2>

          <?php
          //echo "<pre>$login_sussess</pre>"; //debug
          //echo "<pre>".var_dump($_POST)."</pre>"; //debug
          if (isset($_POST['submit']) && $login_sussess != 1):
            ?>
            <div class="login-error">
              <div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon-minus-sign"></i> Warning!</strong><br />Your login Username or Password is incorrect.
                <br />Please try again.
              </div>
            </div>
          <?php endif; ?>
          <input type="hidden" name="login_key" value="<?php echo $_SESSION['login_key'] ?>" />
          <div class="input-append">
            <input name="email" type="text" class="input-block-level" placeholder="Email address" autofocus="">
            <span class="add-on"><i class="icon-envelope icon-2x"></i></span>
          </div>
          <div class="input-append">
            <input name="password" type="password" class="input-block-level" placeholder="Password">
            <span class="add-on"><i class="icon-key icon-2x"></i></span>
          </div>
        </div>
        <button name="submit" class="btn btn-large btn-success" type="submit" value="submit">Sign in <i class="icon-signin"></i></button>

        <div class="loginAdditionalLinks" style="float: right; width: 200px;">
          <div class="contact"><i class="icon-edit"></i> <a href="contact_us.php">Contact us for any assistance.</a></div>
          <div class="contact"><i class="icon-edit"></i> <a href="<?php echo "$urlAddOrganizationRequest"; ?>">Add your organization</a></div>
        </div>
        <ul class="nav nav-pills">
          <li class="tab-content-item"><a href="reset_password.php"><i class="icon-edit"></i> Reset Password</a></li>
        </ul>
      </form>


    </div> <!-- /container -->
  </body>
  <?php include_once 'include/footer/footer.inc.php'; ?>
</html>

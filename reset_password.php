<?php
$app_name = "Ministry of Health and Family Welfare";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $app_name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ministry of Health and Family Welfare HRM Application developed by Activation Ltd, http://activationltd.com">
        <meta name="author" content="nasir khan saikat (nasir8891 AT gmail DOT com)">

        <!-- Le styles -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="library/font-awesome/css/font-awesome.min.css" rel="stylesheet">


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

        <!--Google analytics code--> 
<?php include_once 'include/header/header_ga.inc.php'; ?>

        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            .form-contact {
                max-width: 570px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }


        </style>

    </head>

    <body>

        <div class="container">

            <div class="row-fluid">

                <form class="form-contact" action="" method="post" name="form1" id="form1">
                    <fieldset>
                        <legend><h2>Reset Password Form</h2></legend>
                        <label>Please Enter your organization email address to reset password.Please check your email and click the link to reset the password. <font color="red"> * </font> </label>
                        <input type="text" id="email" name="email"  class="input-block-level" placeholder="Your Organization Email Address …" required>
					<img src="captcha.php" /><br><br>
                        <input name="captcha" type="text" class="input-block-level" required placeholder="Captcha code…">
                       
                        <input type="submit" value="Submit" name="submit"  class="btn btn-info btn-large">
                    </fieldset>
                </form>

                <?php
require_once 'include/db_connection.php';
if(!empty($_GET))
{
$token=$_GET['token'];
$email=$_GET['email'];
$pass=md5('dghs123');

if(!empty($token)&&!empty($email))
{
   echo "Your Password has been reset.Please Login.";
    $sql= mysql_query("UPDATE user SET password='$pass' WHERE username= '$email' AND token='$token'")
	or die(mysql_error());
}else
{
   echo "Your username or tokencode is incorrect";
}

}
?>

        </div> <!-- /container -->

<?php

$email = $_POST['email'];
$ran = rand(0,10000000);
$token = $ran;

session_start();
if($_POST["submit"]){
if(isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
    $email = $_POST['email'];
    $EmailSubject = 'Password Reset';
    $ToEmail =  $email;

    $ran = rand(0, 10000000);
    $token = $ran;

    require_once 'include/db_connection.php';

    $sql= mysql_query("UPDATE user SET token='$token' WHERE username='$email'") or die(mysql_error());

    $reset_url = "http://test.dghs.gov.bd/hrmnew/reset_password.php?token=$token&email=$email";
    $message = "Please click the following URL to reset password. <a href=\"$reset_url\" >Click this link </a><br>";
    $message =$message."\n".$reset_url;

    $mailheader = "From: " . $_POST["email"] . "\r\n";
    $mailheader .= "Reply-To: " . $ToEmail . "\r\n";
    $mailheader .= "CC: " . $ToEmail . "\r\n";
    $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $MESSAGE_BODY .= "Subject: " . $EmailSubject . "<br>";
    $MESSAGE_BODY .= "Message: " . $message . "";

    //echo $message;
    //mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die ("Failure");
    mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die("Failure");
?>
        Your message was sent to mail.
        <?php
    } else {
        die("Wrong code entered");
    }
}


//}
    /*
      // we want to make sure that the form has actually been submitted
      if(isset($_POST['submit'])){
      require_once 'include/db_connection.php';
      // your database connection script
      //include('connect.php');

      // post the form variables with mysql escaping
      //$uname = mysql_real_escape_string($_POST['uname']);
      $email = mysql_real_escape_string($_POST['email']);

      // query the db for the user's account info.
      // you will put your own table name in, of course

      $sql = "SELECT username FROM user WHERE username='$email'";
      $result = mysql_query($sql);


      // if the user's info is not found, then they get a failure message
      if(!result){
      echo "Log in credentials not valid.";
      exit;
      }// if the user is found in the db, we continue
      else {

      // include the random password generator script
      //include('randomPass.php');


      // the generator script produces a random 7 character
      // password named $random_chars
      // we first want to have a variable ($passwd) that we can
      // pass to the email we send
      // then we give $random_chars a value of $password, and we encrypt
      // it using sha1

      $passwd = 'dghs12123';
      $password = md5($passwd);

      // next we update the user's password with the new encrypted password
      // of course, you will want to make sure that the password field in
      // your db is set to at least 40 characters and varchar

      $sql="UPDATE user SET password='$password' WHERE username='$email'";
      $result = mysql_query($sql);
      if(!$result) {
      echo "Password update failed.";

      // you can comment out the above echo after testing
      // if there are no updating problems, you can take out the if/else
      // in this portion
      // send email to user's account email, giving them their new
      // temporary password.
      // be sure to change the info inside to your own
      }
      else {
      $to = "$email";
      $subject = "Password Reset";
      $body = "You or someone else with your email address has requested
      to reset your password. Your temporary password is $passwd. \n \n
      Please go to http://test.dghs.gov.bd/reset_password.php and change
      your password to something easy to remember.\n\n Regards,\n Site Admin";
      $additionalheaders = "From: rajib1111@gmail.com";
      mail($to, $subject, $body, $additionalheaders);
      if(mail){
      echo "You have been sent a temporary password to $email";
      } // end if update failed
      } // end if mail
      } // close else
      } // end if submit

     */
        ?>
            </div>


        <!-- javascript
        ================================================== -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>  
        <script src="assets/jquery Validation/dist/jquery.validate.js"></script>

    </body>
</html>
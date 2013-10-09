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


             @media (min-width: 768px) and (max-width: 979px){
                .container{
                    width: 760px;
                }
            }
            @media (max-width: 767px){
                .container{
                    width: 760px;
                }
            }
            @media (max-width: 480px) {
                .container{
                    width: 300px;
                }
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
             

 <?php
require_once 'include/db_connection.php';

if(!empty($_GET))
{
$token=mysql_real_escape_string($_GET['token']);
$email=mysql_real_escape_string($_GET['email']);
$pass=mysql_real_escape_string(md5('dghs123'));

 $sql= mysql_query("select * from user WHERE username='$email' AND token='$token'") or die(mysql_error());
 $num_of_rows=  mysql_num_rows($sql);  

if(!empty($token)&&!empty($email)&&$num_of_rows==1)
{
    $sql= mysql_query("UPDATE user SET password='$pass',token='' WHERE username= '$email' AND token='$token'")
	or die(mysql_error());
    
    print "<script>";
    print " self.location='login.php'"; // Comment this line if you don't want to redirect
    print "</script>";

    //echo "Your Password has been reset.Please Login.";
    
}else
{
   echo "Your username or tokencode is incorrect";
}
}
?>
  
<?php
$email = $_POST['email'];
session_start();

if($_POST["submit"]){
    $email = mysql_real_escape_string($_POST['email']);
    $EmailSubject = 'Password Reset';
    $ToEmail =  $email;

    $sql= mysql_query("select * from user WHERE username='$email'") or die(mysql_error());
    $num_of_rows=  mysql_num_rows($sql);  
    
if(isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"] && $num_of_rows==1 ) {
  
     $ran = uniqid();
     $token = mysql_real_escape_string($ran);

    require_once 'include/db_connection.php';
   
    $sql= mysql_query("UPDATE user SET token='$token' WHERE username='$email'") or die(mysql_error());

    $reset_url = "http://test.dghs.gov.bd/hrmnew/reset_password.php?token=$token&email=$email";
    $message = "Please click the following URL to reset password. <a href=\"$reset_url\">Click this link </a><br>";
    $message =$message."\n".$reset_url;
    $mailheader .= 'MIME-Version: 1.0' . "\r\n";
    $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n";  
    $mailheader .= "From: " . $_POST["email"] . "\r\n";
    $mailheader .= "Reply-To: " . $ToEmail . "\r\n";
    $mailheader .= "CC: " . $ToEmail . "\r\n";
    $MESSAGE_BODY .= "Subject: " . $EmailSubject . "<br>";
    $MESSAGE_BODY .= "Message: " . $message . "";
    
    mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die("Failure");

       echo 'Your messge has been sent';
     
    } else {
         die("Wrong code or wrong email adress entered");
    }
}

        ?>
        
         </form>
 </div> <!-- /container -->

            </div>


        <!-- javascript
        ================================================== -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>  
        <script src="assets/jquery Validation/dist/jquery.validate.js"></script>

    </body>
</html>
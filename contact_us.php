
<?php
$app_name = "Ministry of Health and Family Welfare";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>
        <link href="assets/css/contact_us.css" rel="stylesheet"/>
        <script src="assets/jquery Validation/dist/jquery.validate.js"></script>
    </head>

    <body>
        <?php
        session_start();
        $username = $_SESSION['username'];
        $orgcode = $_SESSION['org_code'];
        $orgname = $_SESSION['org_name'];
        ?>
        <div class="container">

            <div class="row-fluid">

                <form class="form-contact" action="" method="post" name="form1" id="form1" >
                    <fieldset>
                        <legend><h2>Contact Us</h2></legend>

                        <input type="hidden" id="mailto" name="mailto" class="input-block-level" placeholder="Email Address…">

                        <input type="hidden" id="emailcc" name="emailcc" class="input-block-level"  value="moly@mis.dghs.gov.bd">

                        <label>From Email  <font color="red"> * </font></label>
                        <input type="text" id="email" name="email"  class="input-block-level"  value="<? echo $username; ?>">

                        <label>Name <font color="red"> * </font> </label>
                        <input type="text" id="name" name="name"  class="input-block-level" placeholder="Name" required>

                        <label>Organization Name (Optional) </label>
                        <input type="text" id="orgname" name="orgname" class="input-block-level" value="<? echo $orgname; ?>">

                        <label>Organization Code </label>
                        <input type="text" id="orgcode" name="orgcode"  class="input-block-level"  value="<? echo $orgcode; ?>">

                        <label>Reason <font color="red"> * </font> </label>
                        <select id="reason" name="reason" class="input-block-level" required>
                            <option value="Login Problem">Login Problem</option>
                            <option value="Complain">Complain</option>
                            <option value="Suggestion">Suggestion</option>
                            <option value="Other">Other</option>
                        </select>

                        <label>Subject <font color="red"> * </font> </label>
                        <input type="text" id="subject" name="subject" class="input-block-level" placeholder="Subject" required>

                        <label>Message <font color="red"> * </font> </label>
                        <textarea name="message" id="message" rows="10" class="input-block-level" cols="58" required ></textarea>

                        <label>Captcha <font color="red"> * </font> </label>
                        <input id="captcha" name="captcha" type="text" required>  <img src="captcha.php" class="responsive-image" /><br>

                        <button type="submit" class="btn-info btn-large">Submit</button>
                        <br/><br/>
                        <img src="assets/img/contact_us.png">
                    </fieldset>
                    <?php
                    session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','On');
                    if ($_POST["email"] <> '') {
                        if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
                            echo "";
//Do you stuff
                        } else {
                            die("Wrong Code Entered");
                        }

                        $EmailSubject = $_POST["subject"];
                        $ToEmail = "nasir.khan@activationltd.com,dr.bashar@mis.dghs.gov.bd,rajib@mis.dghs.gov.bd,enamul.haque@activationltd.com";


                        $mailheader .= 'MIME-Version: 1.0' . "\r\n";
                        $mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $mailheader .= "From: " . $_POST["email"] . "\r\n";
                        $mailheader .= "Reply-To: " . $_POST["email"] . "\r\n";
                        $mailheader .= "CC: " . $_POST["emailcc"] . "\r\n";
                        $MESSAGE_BODY .= "Name: " . $_POST["name"] . "<br>";
                        $MESSAGE_BODY .= "From Email: " . $_POST["email"] . "<br>";
                        $MESSAGE_BODY .= "Organization Name: " . $_POST["orgname"] . "<br>";
                        $MESSAGE_BODY .= "Organization Code: " . $_POST["orgcode"] . "<br>";
                        $MESSAGE_BODY .= "Reason: " . $_POST["reason"] . "<br>";
                        $MESSAGE_BODY .= "Subject: " . $_POST["subject"] . "<br>";
                        $MESSAGE_BODY .= "Message: " . $_POST["message"] . "";


                        mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die("Failure");
                        ?>


                        Your message was sent.


                        <?php
                        if ($_SESSION['logged'] != true) {
                            print "<script>";
                            print " self.location='login.php'"; // Comment this line if you don't want to redirect
                            print "</script>";
                        } else {
                            print "<script>";
                            print " self.location='home.php'"; // Comment this line if you don't want to redirect
                            print "</script>";
                        }
                    }
                    ?>

                </form>
            </div>

        </div> <!-- /container -->
    </body>
</html>

<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','On');
if ($_POST["email"] <> '') {
    if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"])
{
echo "";
//Do you stuff
}
else
{
die("Wrong Code Entered");
}

    $EmailSubject = $_POST["subject"];
   // $ToEmail = nasir.khan@activationltd.com,dr.bashar@mis.dghs.gov.bd,rajib@mis.dghs.gov.bd,enamul.haque@activationltd.com;
    $ToEmail ="rajib@mis.dghs.gov.bd,moly@mis.dghs.gov.bd";
    $mailheader = "From: " . $_POST["email"] . "\r\n";
    $mailheader .= "Reply-To: " . $_POST["email"] . "\r\n";
    $mailheader .= "CC: " . $_POST["emailcc"] . "\r\n";
    $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $MESSAGE_BODY .= "Name: " . $_POST["name"] . "<br>";
    $MESSAGE_BODY .= "From Email: " . $_POST["email"] . "<br>";
    $MESSAGE_BODY .= "Organization Name: " . $_POST["orgname"] . "<br>";
    $MESSAGE_BODY .= "Organization Code: " . $_POST["orgcode"] . "<br>";
    $MESSAGE_BODY .= "Reason: " . $_POST["reason"] . "<br>";
    $MESSAGE_BODY .= "Subject: " . $_POST["subject"] . "<br>";
    $MESSAGE_BODY .= "Captcha: " . $_POST["captcha"] . "<br>";
    $MESSAGE_BODY .= "Message: " . $_POST["message"] . "";


    //mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die ("Failure");
    mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die("Failure");
    ?>
    Your message was sent.

    <?php
}
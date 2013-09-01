<?php 
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn navbar-btn" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="./index.php"><?php echo $app_name; ?></a>
            <div class="navbar-collapse collapse">
                <ul class="nav">
                    <li class="active">
                        <a href="./index.php">Home</a>                                
                    </li>
                    <li class="">
                        <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php 
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

if($_SESSION['user_type_code'] == 3){
    $homepage_url = "admin_home.php";
}
else if($_SESSION['user_type_code'] == 1){
    $homepage_url = "home.php";
}
else {
    $homepage_url = "index.php";
}
?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="./index.php"><?php echo $app_name; ?></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active">
                        <a href="<?php echo $homepage_url; ?>">Home</a>                                
                    </li>
                    <li class="">
                        <a href="http://www.dghs.gov.bd" target="_brank">DGHS Website</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
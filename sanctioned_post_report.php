<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';
require_once './include/sanctioned_post/report/report.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $org_name . " | " . $app_name; ?></title>
        <?php
        include_once 'include/header/header_css_js.inc.php';
        include_once 'include/header/header_ga.inc.php';
        ?>

    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <!-- Top navigation bar
        ================================================== -->
        <?php include_once 'include/header/header_top_menu.inc.php'; ?>

        <!-- Subhead
        ================================================== -->
        <header class="jumbotron subhead" id="overview">
            <div class="container">
                <h1><?php echo "$org_name $echoAdminInfo"; ?></h1>
                <p class="lead"><?php echo "$org_type_name"; ?></p>
            </div>
        </header>


        <div class="container">

            <!-- nav
            ================================================== -->
            <div class="row">
                <div class="span3 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <?php
                        $active_menu = "";
                        include_once 'include/left_menu.php';
                        ?>
                    </ul>
                </div>
                <div class="span9">
                    <!-- Sanctioned Post
                    ================================================== -->
            <h3>Select Checkboxes from below to generate report</h3>      
                 <form action="" class="form-inline" role="form"  method="post">
              <div class="form-group">   

<?php
for($i = 0; $i < $fieldsToShowCount; $i ++) {
	?>
	             
				<label><input type='checkbox' name="<?php echo $fields[$i];?>" value="y" /> <?php echo $fields[$i];?></label>
				
				<?php

}
?>
</div>
<br/>
<input type="submit" class="btn btn-primary" name="columns" value=" Select Columns" />
</form>
<table class="table table-hover">

	<thead>
		<tr>
			<?php
			for($i = 0; $i < $fieldsToShowCount; $i ++) {
				if ($_REQUEST [$fields [$i]] == 'y') {
					echo "<th>";
					if(strlen($headingNameMap[$fields [$i]])){
						echo $headingNameMap[$fields [$i]];
					}
					else
						echo $fields [$i];
					echo "</th>";
				}
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $rows as $row ) {
			
			echo "<tr>";
			for($i = 0; $i < $fieldsToShowCount; $i ++) {
				if ($_REQUEST [$fields [$i]] == 'y') {
					echo "<td>";
					echo $row [$i];
					echo "</td>";
				}
			}
			echo "</tr>";
		}
		?>
	</tbody>
</table>
                 
                </div>
            </div>
        </div> <!-- /container -->


        <!-- Footer
        ================================================== -->
        <?php include_once 'include/footer/footer.inc.php'; ?>
       
    </body>
</html>

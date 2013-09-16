<?php
set_time_limit(120000);


// db connection 
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = '';
mysql_select_db($dbname, mysql_connect($dbhost, $dbuser, $dbpass)) or die(mysql_errno());


$sql = "SELECT org_name,org_code, pay_scale FROM total_manpower_imported_sanctioned_post_copy WHERE pay_scale <=9";
$result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:1 || Query:</b><br />___<br />$sql</p>");

$total_post = mysql_num_rows($result);
//echo "<br /><br /><pre>Total Nnumber of posts (Pay scale grater than payscale 9): $total_post<br>";


$sql = "SELECT
	designation,
	designation_code,
	pay_scale,
	COUNT(total_manpower_imported_sanctioned_post_copy.designation_code) as total_number
FROM
	total_manpower_imported_sanctioned_post_copy
WHERE
	pay_scale <= 9
GROUP BY
	pay_scale
ORDER BY
	pay_scale ASC";
$result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:2 || Query:</b><br />___<br />$sql</p>");

//echo "<br /><br />Total Nnumber of posts (Pay scale grater than payscale 9): " . mysql_num_rows($result);

$i = 0;
//while ($data = mysql_fetch_assoc($result)) {
//    print_r($data);
//
$i++;
//if ($i == 5) {
//    die();
//}
//}
echo "<pre>";
?>
<table>
    <tbody>
        <tr>
            <!--<td>Designation</td>-->
            <td>Pay Scale</td>
            <td>Total post</td>
        </tr>
        <?php while ($data = mysql_fetch_assoc($result)): ?>

            <tr>
                <!--<td><?php echo $data['designation']; ?></td>-->
                <td><?php echo $data['pay_scale']; ?></td>                
                <td><?php echo $data['total_number']; ?></td>                
            </tr>
            <?php
            $i++;
//            if ($i == 5) {
//                die();
//            }
            ?>
        <?php endwhile; ?>


    </tbody>
</table>

<?php echo "<br /><br />Total Nnumber of posts (Pay scale grater than payscale 9): $total_post<br>"; ?>

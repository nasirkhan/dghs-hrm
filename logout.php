<?php
	require_once 'configuration.php';
	/*
	$q="UPDATE user set user_logged='0' where user_id='".$_SESSION[current_user_id]."'";
	$r=mysql_query($q)or die(mysql_error());
	*/
	session_destroy();
	header('location:index.php');
?>
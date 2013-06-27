<?php
	require_once 'configuration.php';

	session_destroy();
	header('location:index.php');
?>
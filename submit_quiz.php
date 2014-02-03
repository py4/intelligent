<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	include 'templates/header.php';
	session_start();

	if(!isset($_SESSION['username']))
	{
		header("Location: login.php");
		$_SESSION['failure_message'] = 'باید وارد شوید!';
		die();
	}
	
?>
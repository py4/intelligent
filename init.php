<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);

if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();

mysqli_query($connection,"CREATE DATABASE IF NOT EXISTS ".$db_name) or die(mysqli_error($connection));
echo "<b> database created </b><br>";

mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));

$sql = "CREATE TABLE IF NOT EXISTS users(ID int NOT NULL AUTO_INCREMENT,primary key (id),username CHAR(20), password CHAR(50), 
	email CHAR(25), type INT, adviser_id INT)";

mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "<b> User table created </b>"
?>
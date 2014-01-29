<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
if(!$connection->set_charset("utf8"))
	printf("Error loading character set utf8: %s\n", mysqli_error($connection));
else
	printf("Current character set: %s\n", $connection->character_set_name());

if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();

mysqli_query($connection,"CREATE DATABASE IF NOT EXISTS ".$db_name." CHARACTER SET utf8 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT COLLATE utf8_general_ci") or die(mysqli_error($connection));
echo "<b> database created </b><br>";

mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));

$sql = "CREATE TABLE IF NOT EXISTS users(ID int NOT NULL AUTO_INCREMENT,primary key (id),username CHAR(20), password CHAR(50), 
	email CHAR(25), type INT, adviser_id INT) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "<b> User table created </b><br>";

$sql = "CREATE TABLE IF NOT EXISTS choices(ID int NOT NULL AUTO_INCREMENT,primary key (id), choice_count INT, choice1 CHAR(15), choice2 CHAR(15), choice3 CHAR(15), choice4 CHAR(15), choice5 CHAR(15))";
mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "<b> choice table created </b>";

?>
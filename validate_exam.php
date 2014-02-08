<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'templates/header.php';
include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));
if(!$connection->set_charset("utf8"))
	printf("Error loading character set utf8: %s\n", mysqli_error($connection));

if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();

if(!isset($_SESSION['username']))
{
	header("Location: login.php");
	$_SESSION['failure_message'] = 'باید وارد شوید!';
	die();
}

if(!isset($_GET['exam_name']))
{
	header("Location: user_profile.php");
	$_SESSION['failure_message'] = 'آزمون یافت نشد۱.';
	die();
}
$exam_name = $_GET['exam_name'];
$username = $_SESSION['username'];
$sql = "SELECT * FROM exams_list WHERE exam_name = '$exam_name'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
if(mysqli_num_rows($result) == 0)
{
	header("Location: user_profile.php");
	$_SESSION['failure_message'] = "آزمون یافت نشد۲.";
	die();
}

$sql = "SELECT * FROM user_exams WHERE exam_name = '$exam_name' AND username = '$username'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
if(mysqli_num_rows($result) == 0)
{
	header("Location: user_profile.php");
	$_SESSION['failure_message'] = 'آزمون یافت نشد۳';
	die();
}

$sql = "SELECT id FROM users WHERE username = '$username'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$user_id = mysqli_fetch_assoc($result)['id'];
$sql = "SELECT * FROM scores WHERE exam_name = '$exam_name' AND user_id = '$user_id'";
$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
if(mysqli_num_rows($result) != 0)
{
	header("Location: user_profile.php");
	$_SESSION['failure_message'] = 'قبلا آزمون را پاسخ داده‌اید.';
	die();
}

echo "fuck";
?>
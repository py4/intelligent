<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
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

if(isset($_SESSION['failure_message']) and $_SESSION['failure_message'] != "")
{
	?>
	<div class="alert alert-error message">
		<?php echo $_SESSION['failure_message']; ?>
	</div>
	<?
	$_SESSION['failure_message'] = "";
  //header("Location: inde.php");
  //die();
}

if (isset($_SESSSION['success_message']) and $_SESSION['success_message'] != "")
{
	?>
	<div class="alert alert-success message">
		<?php echo $_SESSION['success_message']; ?>
	</div>
	<?
	$_SESSION['success_message'] = "";
}

$user_name = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$user_name'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$user = mysqli_fetch_assoc($result);

?>

<br><br><br>
<div class="alert alert-info">
	پروفایل
</div>
<div class="profile_info">
	<div class="row">
		<div class="span1">
		</div>
		<div class="span4">
			<ul class="thumbnails">
				<li class="span3">
					<a href="#" class="thumbnail user_pic">
						<img src="img/avatar.png" alt="" class="user_pic">
					</a>
					<p class="username">
						<? echo $user['username']; ?>
					</p>
					<ul class="non_list profile_info_detail">
						<li class="items">	
							<i class="fa fa-question-circle"></i>
							<? echo $user['name']; ?>
							<? echo $user['family_name']; ?>
						</li>
						<li class="items" lang="en">
							<i class="fa fa-envelope"></i>
							<? echo $user['email']; ?>
						</li>
						<li class="items">
							<i class="fa fa-phone-square"></i>
							<? echo $user['phone_number']; ?>
						</li>
						<li class="items">
							<i class="fa fa-barcode"></i>
							<? echo $user['code']; ?>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="span3 with-border">
			<div class="alert alert-success">
				کاربران
			</div>
			<div class="row">
				<div class="span2">
					<ul class="adviser_users non_list">
					<?
						$code = $user['code'];
						$sql = "SELECT * FROM users WHERE adviser_code = '$code'";
						$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
						while($u = mysqli_fetch_assoc($result))
						{
							?>
							<li> <a href="show_client.php?client_username=<? echo $u['username']; ?>"> <? echo $u['name']." ".$u['family_name']."(".$u['username'].")"; ?> </a> </li>
							<?
						}
						?>
					</ul>
				</div>
				<div class="span4 profile_progress">
				</div>
			</div>
		</div>
		<div class="span4 with-border">
			<div class="alert alert-info">
				جست‌وجوی کاربران
			</div>
			<div class="row">
				<div class="span3 user_search">
					<form class="navbar-form form-search">
						<div class="input-append">
        					<input data-provide="typeahead" data-items="4"  type="text" class="span2 search-query">
        						<button class="btn btn-success">بیاب</button>
    					</div>
  					</form>
				</div>
			</div>
		</div>
		<div class="span4 with-border">
			<div class="alert alert-info">
				اضافه کردن کاربران
			</div>
			<div class="row">
				<div class="span3 user_add">
					<form class="navbar-form form-search">
						<div class="input-append">
						<span class="label label-inverse">کد کاربری</span>
        					<input data-provide="typeahead" data-items="4"  type="text" class="span2 search-query">
        						<button class="btn btn-success">بیاب</button>
    					</div>
  					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>
</div>
<?
include 'templates/footer.php';
?>
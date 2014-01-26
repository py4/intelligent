<script type="text/javascript">
	function validate()
	{
		if(document.signup_form.username.value == "") {
			alert("No username entered!");
			document.signup_form.username.focus();
			return false;
		}
		if(document.signup_form.password.value == "") {
			alert("No password entered!");
			document.signup_form.password.focus();
			return false;
		}
		//return true;
	}
</script>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'templates/header.php';
session_start();



if($_SESSION['username'] != "")
{
  $_SESSION['failure_message'] = "وارد سیستم هستید.";
  header("Location: index.php");
  die();  
}

function dump_signup()
{
	?>
	<div class="container-login">

      <form class="form-horizontal signup_form" name="signup_form" onsubmit="return validate()" action="<? echo htmlentities($_SERVER['PHP_SELF']) ?> " method="post">
  <div class="control-group">
    <label class="control-label" for="inputUsername">نام کاربری</label>
    <div class="controls">
      <input type="text" id="inputUsername" name="username" placeholder="نام کاربری">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">رمز عبور</label>
    <div class="controls">
      <input type="password" id="inputPassword" name="password" placeholder="رمز عبور">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> مرا به خاطر بسپار
      </label>
      <button type="submit" class="btn btn-success">ثبت نام</button>
    </div>
  </div>
</form>

    </div> <!-- /container -->
    <?
}

include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));


$value = "";

$username = "";
$email = "";
$password = "";
if(!isset($_POST['username']) || !isset($_POST['password']))
{
	dump_signup();
} else if($_POST['username'] == "" or $_POST['password'] == "") {
	?>
	<?php dump_signup(); ?>
	<script type="text/javascript">
		validate();
	</script>
	<?
}
else {
	$username = $_POST['username'];
	$result = mysqli_query($connection,"SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error($connection));
	if(mysqli_num_rows($result) != 0)
	{
		?>
		<div class="alert alert-error">
			نام کاربری، پیشتر گرفته شده است!
		</div>
		<?
		dump_signup();
	} else {
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$password = md5(sha1($password));
		$result = mysqli_query($connection,"INSERT INTO users (username,password) VALUES('$username','$password')") or die(mysqli_error($connection));
		$_SESSION['username'] = $username;
		$_SESSION['success_message'] = "عضو شدید!";
		header("Location: index.php");
		die();
	}
}
include 'templates/footer.php';
?> 
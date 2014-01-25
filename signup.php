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

function dump_signup()
{
	echo "<form name=\"signup_form\" onsubmit=\"return validate()\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\""." method=\"post\">
		username: <input type=\"text\" name=\"username\">
		password: <input type=\"text\" name=\"password\">
		<input type=\"submit\" value=\"submit\">
	</form>";
}

include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));


$file = fopen("config/user_attributes.txt","r") or die("Couldn't open");
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
		echo "username already exists";
		dump_signup();
	} else {
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$password = md5(sha1($password));
		$result = mysqli_query($connection,"INSERT INTO users (username,password) VALUES('$username','$password')") or die(mysqli_error($connection));
		echo "created";
	}
}
?> 
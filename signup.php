<script type="text/javascript">
	function validate()
	{
		if(document.signup_form.username.value == "") {
			alert("No username entered!");
			document.signup_form.username.focus();
			return "";
		}
		if(document.signup_form.password.value == "") {
			alert("No password entered!");
			document.signup_form.password.focus();
			return "";
		}
	}
</script>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
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
	?>
	<form name="signup_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		username: <input type="text" name="username">
		password: <input type="text" name="password">
		<input type="submit" onclick="validate()" value="submit">
	</form>
	<?php
} else {
	$result = mysqli_query($connection,"SELECT * FROM users WHERE username='$username'") or die(mysqli_error($connection));
	if(mysqli_num_rows($result) != 0)
	{
		echo "username already exists";
	?>
		<form name="signup_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			username: <input type="text" name="username">
			password: <input type="text" name="password">
			<input type="submit" onclick="validate()" value="submit">
		</form>
	<?php
	} else {
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$password = md5(sha1($password));
		#$query = "INSERT INTO users ('username','password') VALUES('$username','$password)";
		$result = mysqli_query($connection,"INSERT INTO users (username,password) VALUES(\"salam\",\"salam\")") or die(mysqli_error($connection));
		echo "created";
	}
}

// while(!feof($file))
// {
// 	$line = fgets($file);
// 	$value = mysql_real_escape_string($_POST[$value]);
// 	eval("$".$line." = ".$value.";");
// 	#eval("$".$line." = mysql_real_escape_string($_POST['".$line."']);");
// 	#echo "$".$line." = mysql_real_escape_string($_POST['\".$line.\"']);";
// 	#echo $syntax;
// 	#$sql = $sql.$line." CHAR(20), ";

// }
?> 
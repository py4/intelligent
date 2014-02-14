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
		if(document.signup_form.name.value == "") {
			alert("No name entered!");
			document.signup_form.name.focus();
			return false;
		}
		if(document.signup_form.family_name.value == "") {
			alert("No family_name entered!");
			document.signup_form.family_name.focus();
			return false;
		}
		if(document.signup_form.phone_number.value == "") {
			alert("No phone_number entered!");
			document.signup_form.phone_number.focus();
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



if(isset($_SESSION['username']) and $_SESSION['username'] != "")
{
	$_SESSION['failure_message'] = "وارد سیستم هستید.";
	header("Location: index.php");
	die();  
}

function generate_randon_string($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function dump_signup()
{
	?>
	<form id="msform" name="signup_form" onsubmit="return validate()" action="<? echo htmlentities($_SERVER['PHP_SELF']) ?> " method="post">
		<!-- progressbar -->
		<!-- fieldsets -->
		<fieldset>
			<h2 class="fs-title">ثبت نام</h2>
			<input type="text" name="name" placeholder="نام" />
			<input type="text" name="family_name" placeholder="نام خانوادگی" />
			<input type="text" name="phone_number" placeholder="شماره‌ی تماس" />
			<input type="text" name="email" placeholder="ایمیل" />
			<input type="text" name="username" placeholder="نام کاربری" />
			<input type="password" name="password" placeholder="رمز عبور" />
			<select name="type">
				<option value=0>داوطلب</option>
				<option value=1>مشاور</option>
			</select>
			<button type="submit" class="next action-button">ثبت نام</button>
		</fieldset>
	</form>
	<?
}

include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
$connection->set_charset("utf8");
if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));


$value = "";

$username = "";
$email = "";
$password = "";
$dump = 0;
$fields = array('username','password','type','name','family_name','phone_number','email');
for($i = 0; $i < count($fields) ; $i++)
	if(!isset($_POST[$fields[$i]]))
		$dump = 1;
	if($dump == 1)
	{
		dump_signup();
	} else if($_POST['username'] == "" or $_POST['password'] == "" or ($_POST['type'] != 0 and $_POST['type'] != 1) or $_POST['name'] == "" or $_POST['family_name'] == "" or $_POST['phone_number'] == "") {
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
			$type = $_POST['type'];
			$name = mysql_real_escape_string($_POST['name']);
			$family = mysql_real_escape_string($_POST['family_name']);
			$phone_number = mysql_real_escape_string($_POST['phone_number']);
			$email = mysql_real_escape_string($_POST['email']);
			$password = md5(sha1($password));
			$code = generate_randon_string();
			$result = mysqli_query($connection,"INSERT INTO users (username,password,type,code,name,family_name,phone_number,email) VALUES('$username','$password','$type','$code','$name','$family','$phone_number','$email')") or die(mysqli_error($connection));
			$_SESSION['username'] = $username;
			$_SESSION['type'] = $type;
			$_SESSION['success_message'] = "عضو شدید! کد کابربری شما '$code' است. آن را به مشاور بدهید تا به کاربران او اضافه شوید. این کد محرمانه است!";
			header("Location: index.php");
			die();
		}
	}
	include 'templates/footer.php';
	?> 
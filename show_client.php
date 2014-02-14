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

if(!isset($_GET['client_username']) and !isset($_POST['client_username']))
{
	$_SESSION['failure_message'] = 'کاربر یافت نشد.';
	header("Location: adviser.php");
	die();
}
if(isset($_GET['client_username']))	
	$client_username = $_GET['client_username'];
else
	$client_username = $_POST['client_username'];

$code = $user['code'];
$sql = "SELECT * FROM users where username = '$client_username' and adviser_code = '$code'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$client = mysqli_fetch_assoc($result);
if(count($client) == 0)
{
	$_SESSION['failure_message'] = 'کاربر یافت نشد.';
	header("Location: adviser.php");
	die();
}

//echo $_SERVER['REQUEST_METHOD'];
//die();

if(isset($_POST['command']))
{
	if($_POST['command'] == 'delete_exam_from_user')
	{
		if(isset($_POST['exam_name']))
		{
			$exam_name = $_POST['exam_name'];
			$sql = "DELETE FROM user_exams WHERE exam_name = '$exam_name'";
			$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
			header("Location: show_client.php?client_username=".$client_username);
			die();
		}
	}
	else if($_POST['command'] == 'add_exam_to_user')
	{
		if(isset($_POST['exam_name'])) /* TODO: check exam_name validity */
		{
			$exam_name = $_POST['exam_name'];
			$sql = "INSERT INTO user_exams(username,exam_name) VALUES('$client_username','$exam_name')";
			$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
			$_SESSION['success_message'] = 'اضافه شد';
			header("Location: show_client.php?client_username=".$client_username);
			die();
		}
	}
}
?>

<br><br><br>
<p class="show_client_title">
	مشاهده‌ی داوطلب
</p>
<div class="container-fluid client_view">
	<div class="row-fluid">
		<div class="span3 client_info">
			<img class="avatar user_pic" src="img/adviser.png">
			<p class="username">
				<? echo $client['username']; ?>
			</p>
			<ul class="non_list profile_info_detail">
				<li class="items">	
					<i class="fa fa-question-circle"></i>
					<? echo $client['name']; ?>
					<? echo $client['family_name']; ?>
				</li>
				<li class="items" lang="en">
					<i class="fa fa-envelope"></i>
					<? echo $client['email']; ?>
				</li>
				<li class="items" lang="en">
					<i class="fa fa-phone-square"></i>
					<? echo $client['phone_number']; ?>
				</li>
				<li class="items" lang="en">
					<i class="fa fa-barcode"></i>
					<? echo $client['code']; ?>
				</li>
			</ul>
		</div>
		<div class="span8">
			<table class="table table-striped">
				<thead>
					<tr>
						<th> وضعیت </th>
						<th> نام آزمون </th>
						<th> نتیجه </th>
						<th> عملیات </th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT * FROM user_exams WHERE username = '$client_username'";
					$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
					$exams = array();
					$not_answered = 0;
					$answered = 0;
					while($row = mysqli_fetch_assoc($result))
					{
						$exams[] = $row['exam_name'];
						?>
						<tr>
							<?
							$exam_name = $row['exam_name'];
							if($row['answered'])
							{
								$answered++;
								?>
								<td><span class="label label-success">داده</span></td>
								<td><? echo $exam_name ?></td>
								<td>
									<?php
									$client_id = $client['id'];
									$sql = "SELECT score from scores WHERE exam_name = '$exam_name' and user_id = '$client_id'";
									$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
									$data = mysql_fetch_assoc($result);
									echo $data['score'];
									?>
								</td>
								<?			
							}
							else
							{
								$not_answered++;
								?>
								<td><span class="label label-important">نداده</span></td>
								<td><? echo $exam_name ?></td>
								<td> ؟ </td>
								<?

							}
							?>
							<td> 
								<form id="delete_exam" action="<? echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST">
									<input name="command" type="hidden" value="delete_exam_from_user" />
									<input name="client_username" type="hidden" value="<?echo $client_username;?>"  />
									<input name="exam_name" type="hidden" value="<?echo $exam_name;?>"  />
									<a href="#" onclick="document.getElementById('delete_exam').submit();">حذف</a>
								</form>
							</td>
							
						</tr>
						<?
					}
					?>
				</tr>
			</tbody>
		</table>
		<div class="span3">
			<form name="add_exam_form" action="<? echo htmlentities($_SERVER['PHP_SELF']) ?> " method="post">
				<input name="client_username" type="hidden" value="<?echo $client_username;?>"  />
				<input name="command" type="hidden" value="add_exam_to_user"  />
				<p>آزمون جدید لازم است؟ </p> 
				<select name="exam_name">
					<?php
					$sql = "SELECT exam_name FROM exams_list";
					$result = mysqli_query($connection,$sql);
					$all_exams = array();
					while($row = mysqli_fetch_assoc($result))
						$all_exams[] = $row['exam_name'];
					$remained = array_diff($all_exams,$exams);
					foreach($remained as $value)
					{
						?><option value="<?php echo $value;?>"><?php echo $value; ?></option>
						<?
					}
					?>
				</select>

				<center><button type="submit" class="btn btn-primary">اضافه کن</button></center>
			</form>
		</div>
	</div>
</div>
</div>
<?
include 'templates/footer.php';
?>
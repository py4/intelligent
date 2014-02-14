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

if(isset($_POST['command']))
{
	if($_POST['command'] == 'add_client_to_adviser')
	{
		if(isset($_POST['client_code'])) // TODO: validate client code
		{
			$client_code = $_POST['client_code'];
			$sql = "SELECT * FROM users WHERE code = '$client_code' LIMIT 1";
			$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
			$client = mysqli_fetch_assoc($result);
			if(count($client) == 0)
			{
				$_SESSION['failure_message'] = 'کاربر یافت نشد.';
				header("Location: adviser.php");
				die();
			}
			if($client['adviser_code'] != NULL)
			{
				$_SESSION['failure_message'] = 'در حال حاضر، کاربر دارای مشاور می‌باشد.';
				header("Location: adviser.php");
				die();	
			}
			$code = $user['code'];
			$sql = "UPDATE users SET adviser_code='$code' WHERE code='$client_code' LIMIT 1";
			$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
			$_SESSION['success_message'] = 'با موفقیت اضافه شد';
			header("Location: adviser.php");
			die();
		}
	}
}

?>

<br><br><br>
<p class="show_adviser_title">
	پروفایل شما
</p>
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
		<div class="span5 with-border">
			<div class="alert alert-success">
				کاربران
			</div>
			<div class="row">
				<div class="span5">
					<table class="table table-striped">
						<thead>
							<tr>
								<th> نام </th>
								<th> نام خانوادگی </th>
								<th> نام کاربری </th>
								<th> عملیات </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$code = $user['code'];
							$sql = "SELECT * FROM users WHERE adviser_code = '$code'";
							$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
							while($u = mysqli_fetch_assoc($result))
							{
								?>
								<tr>
									<td><?echo $u['name'];?></td>
									<td><?echo $u['family_name'];?></td>
									<td><?echo $u['username'];?></td>
									<td><a href="show_client.php?client_username=<? echo $u['username']; ?>">مشاهده</a> | <a href="#">حذف</a> </td>
								</tr>
								<?
							}
							?>
						</tbody>
					</table>
					<div class="add_client_to_adviser">
						<p style="font-weight: bold;">
							اضافه کردن کاربر؟
						</p>
						<form class="navbar-form form-search" action="<? echo htmlentities($_SERVER['PHP_SELF']) ?> " method="post">
							<div class="input-append">
								<input data-provide="typeahead" data-items="4"  type="text" class="span2 search-query" placeholder="کد کاربری" name="client_code">
								<input name="command" type="hidden" value="add_client_to_adviser"  />
								<button type="submit" class="btn btn-info">اضافه کن</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?
include 'templates/footer.php';
?>
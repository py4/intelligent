<?php
session_start();
include 'templates/header.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
$connection->set_charset("utf8");
if (mysqli_connect_errno())
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));

if(isset($_SESSION['username']) and $_SESSION['username'] != "")
{
  $_SESSION['failure_message'] = "وارد سیستم هستید.";
  header("Location: index.php");
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

function dump_login()
{
  ?>
  <div class="container-login">

  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
        <button type="submit" class="btn btn-success">وارد شو!</button>
      </div>
    </div>
  </form>

</div> <!-- /container -->
<?
}

if(!isset($_POST['username']) or !isset($_POST['password']))
{
  dump_login();
} else {
  $username = mysql_real_escape_string($_POST['username']);
  $password = mysql_real_escape_string($_POST['password']);
  $password = md5(sha1($password));
  $result = mysqli_query($connection,"SELECT * FROM users WHERE username = '$username' AND password = '$password'") or die(mysqli_error($connection));
  if(mysqli_num_rows($result) !== 1)
  {
    $_SESSION['failure_message'] = 'نام کاربری یا رمز عبور اشتباه می‌باشد.';    
    header("Location: login.php");
    die();
    //dump_login();
  } else {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    die();
  }
}

include 'templates/footer.php';
?>

<?php
session_start();
include 'templates/header.php';
?>
<body class="special">
  <?
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
    <div class="span5 signin">
      <form id="msform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <!-- progressbar -->
        <!-- fieldsets -->
        <fieldset>
          <h2 class="fs-title">ورود</h2>
          <input type="text" name="username" placeholder="نام کاربری" />
          <input type="password" name="password" placeholder="رمز عبور" />
          <select name="type">
            <option value=0>داوطلب</option>
            <option value=1>مشاور</option>
          </select>
          <button type="submit" class="next action-button">وارد شو</button>
        </fieldset>
      </form>
    </div>
    <?
  }

  if(!isset($_POST['username']) or !isset($_POST['password']))
  {
    dump_login();
  } else {
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $password = md5(sha1($password));
    $type = $_POST['type'];
    $result = mysqli_query($connection,"SELECT * FROM users WHERE username = '$username' AND password = '$password' and type = '$type'") or die(mysqli_error($connection));
    if(mysqli_num_rows($result) !== 1)
    {
      $_SESSION['failure_message'] = 'نام کاربری یا رمز عبور اشتباه می‌باشد.';    
      header("Location: login.php");
      die();
    //dump_login();
    } else {
      $_SESSION['type'] = $type;
      $_SESSION['username'] = $username;
      header("Location: index.php");
      die();
    }
  }
  ?>
</body>
<?
include 'templates/footer.php';
?>

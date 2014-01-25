<!DOCTYPE html>
<html>
<head>
	<title> Intelligent </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css?v=1" rel="stylesheet">
	<link href="css/customize.css?v=1" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js?v=1"></script>
</head>
<body>
	 <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.php">Intelligent</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="index.php"><i class="fa fa-home"></i> خانه</a>
              </li>
              <?
              	if(isset($_SESSION['username']))
              	{
              		?>
              		<li class="active">
              			<a href="logout.php"><i class="fa fa-sign-out"></i> خروج </a>
              		</li>
              		<?
              	}
              	else {
              		?>

              		<li class="active">
                		<a href="signup.php"><i class="fa fa-lock"></i> ثبت نام</a>
              		</li>	
              		<li class="active">
                		<a href="login.php"><i class="fa fa-user"></i> ورود</a>
              		</li>

              		<?
              	}
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
</body>
</html>


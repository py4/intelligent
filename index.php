<?
	session_start();
	if(isset($_SESSION['username']))
		echo $_SESSION['username'];
	else
	{
?>
	<a href="http://mystatsviewer.com/signup.php"> Sign up</a>
	<a href="http://mystatsviewer.com/login.php"> Login</a>	
<?php
}
?>
<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	session_start();
	include 'templates/header.php';
	if(!isset($_SESSION['username']))
	{
		header("Location: login.php");
		$_SESSION['failure_message'] = 'باید وارد شوید!';
		die();
	}
	?>
		<br><br><br>
		<div class="alert alert-info">
			پروفایل
		</div>
		<div class="profile_info">
			<ul class="thumbnails">
				<li class="span2">
					<a href="#" class="thumbnail">
						 <img src="avatar.png" alt="">
					</a>
					<p class="username">
						ibtkm
					</p>
				</li>
				<li>
					<ul class="non_list profile_info_detail">
						<li class="items">	
							<i class="fa fa-question-circle"></i>
									پویا مرادی 
						</li>
						<li class="items">
							<i class="fa fa-envelope"></i>
							ibtkm2009@gmail.com
						</li>
						<li class="items">
							<i class="fa fa-phone-square"></i>
							09124584887
						</li>
					</ul>
				</li>
				
			</ul>
		</div>
		<div class="alert alert-info">
			آزمون‌ها
		</div>
		<div class="alert alert-info">
			مشاور
		</div>
	<?
	include 'templates/footer.php';
?>
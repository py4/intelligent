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

	?>
		<br><br><br>
		<div class="alert alert-info">
			پروفایل
		</div>
		<div class="profile_info">
			<div class="row">
				<div class="span1">
				</div>
				<div class="span4">
					<ul class="thumbnails">
						<li class="span3">
							<a href="#" class="thumbnail">
								 <img src="img/avatar.png" alt="">
							</a>
							<p class="username">
								ibtkm
							</p>
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
				<div class="span6 with-border">
					<div class="alert alert-success">
						آزمون‌ها
					</div>
					<div class="row">
						<div class="span2">
							<ul class="non_list exams">
								<li> <span class="label label-important">مانده</span> آزمون آیزنگ </li>
								<li> <span class="label label-important">مانده</span> آزمون هالند </li>
								<li> <span class="label label-success">دادید</span> آزمون فلان </li>
								<li> <span class="label label-important">مانده</span> آزمون فیشر </li>
								<li> <span class="label label-success">دادید</span> آزمون اکبر </li>
							</ul>
						</div>
						<div class="span4 profile_progress">
							<span class="label label-inverse"> پیشرفت: </span>
							<div class="progress progress-success">
								<div class="bar" style="width: 40%"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="span4 with-border">
					<div class="alert alert-error">
							مشاور
						</div>
						<ul class="thumbnails">
							<li class="span2">
								<a href="#" class="thumbnail">
									 <img src="img/adviser.png" alt="">
								</a>
								<p class="username">
									felani
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?
	include 'templates/footer.php';
?>
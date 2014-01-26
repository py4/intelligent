<?php
	session_start();
	include 'templates/header.php';
	if ($_SESSION['success_message'] != "")
	{
		?>
		<div class="alert alert-success message">
			<?php echo $_SESSION['success_message']; ?>
		</div>
		<?
		$_SESSION['success_message'] = "";
	}

	if($_SESSION['failure_message'] != "")
	{
		?>
		<div class="alert alert-error message">
			<?php echo $_SESSION['failure_message']; ?>
		</div>
		<?
		$_SESSION['failure_message'] = "";
	}

	?>

	<?
	include 'templates/footer.php';
?>

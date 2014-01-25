<?php
	session_start();
	include 'templates/header.php';
	?>

	<div class="container-login">

      <form class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputUsername">نام کاربری</label>
    <div class="controls">
      <input type="text" id="inputUsername" placeholder="نام کاربری">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">رمز عبور</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="رمز عبور">
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
	include 'templates/footer.php';
?>

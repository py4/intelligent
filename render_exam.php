<?php
$sql = "SELECT * FROM $exam_name";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$questions = array();
while($row = mysqli_fetch_assoc($result))
	$questions[] = $row;//['question_content'];
$sql = "SELECT * FROM choices WHERE exam_name = '$exam_name'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$choices = array();
while($row = mysqli_fetch_assoc($result))
{
	for($i = 0; $i < $row['choice_count']; $i++)
		$choices[] = $row['choice'.($i+1)];
}

if(isset($_POST['answers']))
{
	$score = 0;
	$answers = $_POST['answers'];
	for($i = 0; $i < count($answers); $i++)
		$score += $questions[$i]["choice".($answers[$i]+1)."_score"];
	$sql = "INSERT INTO scores(exam_name,user_id,score) VALUES('$exam_name','$user_id','$score')";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$sql = "UPDATE user_exams SET answered=1 WHERE exam_name='$exam_name'";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$_SESSION['success_message'] = "نتیجه‌ی آزمون با موفقیت ثبت شد.";
	header("Location: user_profile.php");
	die();
}
else
{
	?>
	<div class="questions">
		<form action="<?php echo $_SERVER['PHP_SELF']."?exam_name=".$exam_name; ?>" method="post" id="exam">
			<ul style="list-style: none;">
			<?php
			for($i = 0; $i < count($questions) ; $i++)
			{
				?>
				<li>
					<div class="question">
					<h3 class="question"><?php echo $questions[$i]['question_content']; ?></h3>
					<?php
					for($j = 0; $j < count($choices); $j++)
					{
						$label = 'question-'.$i.'-answers-'.$j;
						?>
						<div class="inline choices">
							<label for="<?php echo $label; ?>"><?php echo $j+1; ?>) <input type="radio" name="answers[<?php echo $i; ?>]" id="<?php echo $label; ?>" value="<?php echo $j; ?>"> <?php echo $choices[$j]; ?></label>
						</div>
						<?php

					}
					?>
					<br class="clear">
					</div>
				</li>
				<?php
			} ?>
			<center><input type="submit" value="ثبت کن" class="btn btn-success question_submit"/></center>
			</ul>
		</form>
	</div>
	<?php
}
	//getting questions
	//getting choices	
?>
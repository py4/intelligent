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
	header("Location: profile.php");
	die();
}
else
{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']."?exam_name=".$exam_name; ?>" method="post" id="exam">
		<?php

		for($i = 0; $i < count($questions) ; $i++)
		{
			?>
			<li>
				<h3><?php echo $questions[$i]['question_content']; ?></h3>
				<?php
				for($j = 0; $j < count($choices); $j++)
				{
					$label = 'question-'.$i.'-answers-'.$j;
					?>
					<div>
						<input type="radio" name="answers[<?php echo $i; ?>]" id="<?php echo $label; ?>" value="<?php echo $j; ?>">
						<label for="<?php echo $label; ?>"><?php echo $j+1; ?>) <?php echo $choices[$j]; ?> </label>
					</div>
					<?php

				}
				?>
			</li>
			<?php
		} ?>
		<input type="submit" value="Submit Quiz" />
	</form>
	<?php
}
	//getting questions
	//getting choices	
?>
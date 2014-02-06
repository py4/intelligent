<?php
if(isset($_POST['answers']))
{

}
else
{
	$sql = "SELECT * FROM $exam_name";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$questions = array();
	while($row = mysqli_fetch_assoc($result))
		$questions[] = $row['question_content'];
	$sql = "SELECT * FROM choices WHERE exam_name = '$exam_name'";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$choices = array();
	while($row = mysqli_fetch_assoc($result))
		for($i = 0; $i < $row['choice_count']; $i++)
			$choices[] = $row['choice'.($i+1)];
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="exam">
			<?php
			
			for($i = 0; $i < count($questions) ; $i++)
			{
				?>
				<li>
					<h3><?php echo $questions[$i]; ?></h3>
					<?php
					for($j = 0; $j < count($choices); $j++)
					{
						$label = 'question-'.$i.'-answers-'.$j;
						?>
						<div>
							<input type="radio" name="answers[<?php echo $i; ?>]" id="<?php echo $label; ?>" value="<?php echo $j; ?>">
							<label for="<?php echo $label; ?>"><?php echo $j; ?>) <?php echo $choices[$j]; ?> </label>
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
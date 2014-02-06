<?php
	if(isset($_POST['answers']))
	{

	}
	else
	{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="exam">
		<?php
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
			print_r($choices);
	}
	//getting questions
	//getting choices	
?>
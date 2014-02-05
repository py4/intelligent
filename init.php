<meta charset="UTF-8">
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("config/config.php");
$connection = mysqli_connect($host,$db_user,$db_password);
if(!$connection->set_charset("utf8"))
	printf("Error loading character set utf8: %s\n", mysqli_error($connection));
else
	printf("Current character set: %s\n", $connection->character_set_name());

if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();

mysqli_query($connection,"CREATE DATABASE IF NOT EXISTS ".$db_name." CHARACTER SET utf8 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT COLLATE utf8_general_ci") or die(mysqli_error($connection));
echo "<b> database created </b><br>";

mysqli_select_db($connection,$db_name) or die(mysqli_error($connection));

$sql = "CREATE TABLE IF NOT EXISTS users(ID int NOT NULL AUTO_INCREMENT,primary key (id),username CHAR(20), password CHAR(50), 
	email CHAR(25), type INT, adviser_id INT) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "<b> User table created </b><br>";

$sql = "CREATE TABLE IF NOT EXISTS user_exams(username CHAR(20), exam_name TEXT)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "=&gt; user_exams table created <br>";

$sql = "CREATE TABLE IF NOT EXISTS choices(ID int NOT NULL AUTO_INCREMENT,primary key (id), choice_count INT, exam_name TEXT(30), choice1 CHAR(15), choice2 CHAR(15), choice3 CHAR(15), choice4 CHAR(15), choice5 CHAR(15))";
mysqli_query($connection,$sql) or die(mysqli_error($connection));
echo "<b> choice table created </b><br>";

$sql = "CREATE TABLE IF NOT EXISTS scores(ID int not NULL AUTO_INCREMENT, primary key(id), exam_name TEXT, user_id INT, score INT)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

$sql = "CREATE TABLE IF NOT EXISTS exams_list(exam_name TEXT)";
mysqli_query($connection,$sql) or die(mysqli_error($connection));

$files = scandir("metadata/exams");
foreach ($files as $name)
{
	if($name == "." or $name == "..")
		continue;
	$lines = file("metadata/exams/".$name);
	$exam_name = trim($lines[0]);
	$exam_scores_name = $exam_name.'_scores';
	$choice_count = $lines[1];
	$choices = [];	

	mysqli_query($connection,"DROP TABLE ".$exam_name); //or die(mysqli_error($connection));
	mysqli_query($connection,"DROP TABLE ".$exam_scores_name);
	
	$sql = "CREATE TABLE IF NOT EXISTS $exam_name(ID int NOT NULL AUTO_INCREMENT, primary key (id), question_content TEXT(150), choice1_score INT DEFAULT 0, choice2_score INT DEFAULT 0, choice3_score INT DEFAULT 0, choice4_score INT DEFAULT 0, choice5_score INT DEFAULT 0)";
	mysqli_query($connection,$sql) or die(mysqli_error($connection));

	$sql = "INSERT INTO exams_list(exam_name) VALUES('$exam_name')";
	mysqli_query($connection,$sql) or die(mysqli_error($connection));

	$sql = "DELETE FROM choices WHERE exam_name='$exam_name'";
	mysqli_query($connection,$sql) or die(mysqli_error($connection));
	echo "=&gt; removed choices row with exam_name: ".$exam_name."<br>";
	for($i = 2; $i < 2+$choice_count; $i++)
		$choices[] = $lines[$i];
	for($i = 0; $i < 5; $i++)
		if(!isset($choices[$i]))
			$choices[$i] = NULL;
		$sql = "INSERT INTO choices(choice_count,exam_name,choice1,choice2,choice3,choice4,choice5) VALUES('$choice_count','$exam_name','$choices[0]','$choices[1]','$choices[2]','$choices[3]','$choices[4]')";
		mysqli_query($connection,$sql) or die(mysqli_error($connection));
		echo "=&gt; added ".$choice_count." choices for exam: ".$exam_name."<br>";
		$question_start_index = 2+$choice_count;
		for($i = $question_start_index; $i < count($lines); $i += $choice_count+1)
		{
			$scores = [];
			for($j = 0; $j < $choice_count; $j++)
				$scores[$j] = $lines[$i+$j+1];
			for($j=0; $j < 5; $j++)
				if(!isset($scores[$j]))
					$scores[$j] = NULL;
				$sql = "INSERT INTO $exam_name(question_content,choice1_score,choice2_score,choice3_score,choice4_score,choice5_score) VALUES('$lines[$i]','$scores[0]','$scores[1]','$scores[2]','$scores[3]','$scores[4]')";
				mysqli_query($connection,$sql) or die(mysqli_error());
			}
			echo "=&gt; ".((count($lines) - $question_start_index)/($choice_count+1))." questions added to exam ".$exam_name."<br>";
		}

		?>
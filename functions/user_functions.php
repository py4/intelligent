<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

function init_flow($username,$connection)
{
	$result = mysqli_query($connection,"SELECT * FROM `users` WHERE `username` = '$username' LIMIT 1") or die(mysqli_error($connection));
	$user = mysqli_fetch_assoc($result);
	$user_id = $user['ID'];
	$query = "SELECT * FROM flow_questions";
	($result = mysqli_query($connection,$query)) or die(mysqli_error($connection));
	while($row = mysqli_fetch_assoc($result))
	{
		$id = $row['ID'];
		$query = "INSERT INTO flow_values(flow_question_id,user_id,value) VALUES('$id','$user_id','0')";
		mysqli_query($connection,$query) or die(mysqli_error($connection));
	}
	$query = "INSERT INTO user_state_values(user_state_id,user_id) VALUES(1,'$user_id')";
	mysqli_query($connection,$query) or die(mysqli_error($connection));
}

//getting flow_questions
//getting flow_values
function get_user_flow_values($user_id,$connection)
{
	$sql = "SELECT * FROM flow_values where user_id = '$user_id'";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$flow_values = [];
	while($row = mysqli_fetch_assoc($result))
		$flow_values[] = $row;
	$result = mysqli_query($connection,"SELECT * FROM flow_questions") or die(mysqli_error($connection));
	$flow = Array();
	$temp = Array();
	while($row = mysqli_fetch_assoc($result))
	{
		$id = $row['ID'];
		$temp['id'] = $id;
		$temp['content'] = $row['content'];
		$temp['value'] = $flow_values[$id-1]['value'];
		$temp['value_id'] = $flow_values[$id-1]['ID'];
		$flow[] = $temp;
	}
	return $flow;
}

function get_user_state($user_id,$connection)
{
	$sql = "SELECT * FROM user_state_values where user_id = '$user_id' LIMIT 1";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$row = mysqli_fetch_assoc($result);
	$state_id = $row['user_state_id'];
	$sql = "SELECT * FROM user_states where id = $state_id LIMIT 1";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function get_states($user_id,$connection)
{
	$current_state = get_user_state($user_id,$connection);
	$sql = "SELECT * FROM user_states";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$states = Array();
	$temp = Array();
	while($row = mysqli_fetch_assoc($result))
	{
		//if($row['ID'] == $current_state['user_state_id'])
		//	continue;
		$temp['state_id'] = $row['ID'];
		$temp['content'] = $row['content'];
		$states[] = $temp;
	}
	return $states;
}

?>

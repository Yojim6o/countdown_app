<?php

//define database parameters
define('DB_NAME', 'forms1');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');

//define link which logs in to the database
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//Submit
if (isset($_POST['submit'])) {

	$title = $_POST['title'];
	$deadline = $_POST['deadline'];
	$message = $_POST['message'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	$sql = "INSERT INTO demo (title, deadline, message) VALUES ('$title', '$deadline','$message')";
	mysqli_query($link,$sql);
	$Pid = mysqli_insert_id($link);

	for ($i = 0; $i < count($start); $i++) {

		$schedule = $start[$i] .','. $end[$i];
		$sql2 = "INSERT INTO schedule (PID, schedule) VALUES ('$Pid','$schedule')";
		mysqli_query($link,$sql2);

	}

	buildJSON($link);
}

//Add sched
if (isset($_POST['add_sched'])) {
	$id = strip_tags($_POST['id']);

	$sql2 = "INSERT INTO schedule (PID) VALUES ('$id')";
	mysqli_query($link,$sql2);
}

//remove sched
if (isset($_POST['remove_sched'])) {
	$Nid = $_POST['sche_id'];
	$Npos = $Nid[$_POST['remove_sched']];

	 $sql2 = "DELETE FROM schedule WHERE ID = '$Npos' ";
	 mysqli_query($link,$sql2);
}

//Edit
if (isset($_POST['edit'])) {
	$id = strip_tags($_POST['id']);
	$title = strip_tags($_POST['title']);
	$deadline = strip_tags($_POST['deadline']);
	$message = strip_tags($_POST['message']);
	$start = $_POST['start'];
	$end = $_POST['end'];
	$Nid = $_POST['sche_id'];

	$sql = "UPDATE demo SET title='$title', deadline='$deadline', message='$message' WHERE ID = '$id' ";
	mysqli_query($link,$sql);

	for ($i = 0; $i < count($Nid); $i++) {

		$schedule = $start[$i] .','. $end[$i];
		$sch_id = $Nid[$i];
		$sql2 = "UPDATE schedule SET schedule='$schedule' WHERE ID = '$sch_id' ";
		mysqli_query($link,$sql2);

	}

	buildJSON($link);
}

//Delete
if (isset($_POST['delete'])) {
	$id = strip_tags($_POST['id']);
	$sql = "DELETE FROM demo WHERE ID = '$id' ";
	// mysqli_query($link,$sql);
	$Nid = $_POST['sche_id'];
	for ($i = 0; $i < count($Nid); $i++) {

		$sql2 = "DELETE FROM schedule WHERE PID = '$id' ";
		mysqli_query($link,$sql2);

	}
	mysqli_query($link,$sql);
	buildJSON($link);
}

//build json function
function buildJSON($link) {

	$sql = "SELECT * FROM demo";
	$res = mysqli_query($link,$sql);
	
	$AArray = array();

	while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$title = $row['title'];
		$deadline = $row['deadline'];
		$message = $row['message'];
		$id = $row['ID'];

		$sqlSched = "SELECT * FROM schedule WHERE PID = '$id'";
		$resSched = mysqli_query($link,$sqlSched);

		$CArray = array();
		while ($rowSched = mysqli_fetch_array($resSched, MYSQLI_ASSOC)) {

			$DArray = array();

			$schedule = strip_tags($rowSched['schedule']);
			$start_end = explode(',', $schedule);
			$start = $start_end[0];
			$end = $start_end[1];
			$DArray = array('start'=>$start, 'end'=>$end);
			array_push($CArray,$DArray);
		}
		$BArray = array('id'=>$id, 'title'=>$title,'deadline'=>$deadline, 'message'=>$message, 'schedule'=>$CArray);

		$AArray[$id] = $BArray;
		$BArray=array();
	}
	// print_r(json_encode($AArray));
	$json = json_encode($AArray);
	$fp = fopen('js/results.json', 'w');
	$txt = "var countdowns = ";
 	// print_r($txt.$json);
	fwrite($fp, $txt.$json);
	fclose($fp);
}

//log out of database
mysqli_close();

//return to the same page after performing an action
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
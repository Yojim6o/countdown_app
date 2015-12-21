<?php

//define database parameters
define('DB_NAME', 'forms1');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');

//define link which logs in to the database
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// $db_selected = mysqli_select_db(DB_NAME);

//Submit
if (isset($_POST['submit'])) {

	$title = $_POST['title'];
	$deadline = $_POST['deadline'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	$sql = "INSERT INTO demo (title, deadline) VALUES ('$title', '$deadline')";
	mysqli_query($link,$sql);
	$Pid = mysqli_insert_id($link);

	for ($i = 0; $i < count($start); ++$i) {

		$schedule = $start[$i] .','. $end[$i];
		$sql2 = "INSERT INTO schedule (PID, schedule) VALUES ('$Pid','$schedule')";
		mysqli_query($link,$sql2);

	}

	//buildJSON($link);
}

//Edit
if (isset($_POST['edit'])) {
	$id = strip_tags($_POST['id']);
	$title = strip_tags($_POST['title']);
	$deadline = strip_tags($_POST['deadline']);
	$start = strip_tags($_POST['start']);
	$end = strip_tags($_POST['end']);

	$sql = "UPDATE demo SET title='$title', deadline='$deadline', start='$start', end='$end' WHERE ID = '$id' ";
	mysqli_query($link,$sql);

	buildJSON($link);
}

//Delete
if (isset($_POST['delete'])) {
	$id = strip_tags($_POST['id']);
	$sql = "DELETE FROM demo WHERE ID = '$id' ";
	mysqli_query($link,$sql);
	// buildJSON($link);
}

function buildJSON($link) {
	$sql = "SELECT * FROM demo ORDER BY id ASC";
	$res = mysqli_query($link,$sql);
	$cdArray = array();

	$id = $_POST['ID'];
	$title = $_POST['title'];
	$deadline = $_POST['deadline'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	// while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	// 	$main = $row['title'];
	// 	$schedule = array($row['start'], $row['end']);
	// 	$mArray = array($main, $schedule);
	// 	array_push($cdArray, $mArray);
	// 	array_push($cdArray, $row);
	// }


	foreach( $title as $v) {
		print_r("");
	}
	// print_r($cdArray);
	// $myarray = mysql_fetch_array($res);
	// $json = json_encode($cdArray);
 	// print_r($json);
	// $fp = fopen('results.json', 'w');
	// $txt = "var countdowns = ";
	// fwrite($fp, $txt.$json);
	// fclose($fp);
}

//log out of database
mysqli_close();

//return to the same page after performing an action
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
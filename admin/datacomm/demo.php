<?php

//define databse parameters
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
	$start = $_POST['start'];
	$end = $_POST['end'];

	$sql = "INSERT INTO demo (title, start, end) VALUES ('$title', '$start', '$end')";
	mysqli_query($link,$sql);

	buildJSON($link);
}

//Edit
if (isset($_POST['edit'])) {
	$id = strip_tags($_POST['id']);
	$title = strip_tags($_POST['title']);
	$start = strip_tags($_POST['start']);
	$end = strip_tags($_POST['end']);

	$sql = "UPDATE demo SET title='$title', start='$start', end='$end' WHERE ID = '$id' ";
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

	while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		$main = $row['title'];
		$schedule = array($row['start'], $row['end']);
		$mArray = array($main, $schedule);
		array_push($cdArray, $mArray);

	}

	// print_r($cdArray);
	//$myarray = mysql_fetch_array($res);
	$json = json_encode($cdArray);
 	print_r($json);
	//$fp = fopen('results.json', 'w');
	// $txt = "var countdowns = ";
	//fwrite($fp, $txt.$json);
	//fclose($fp);
}

//log out of database
mysqli_close();

header('Location: '.$_SERVER['HTTP_REFERER']);
?>
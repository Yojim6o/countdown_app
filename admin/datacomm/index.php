<?php

	define('DB_NAME', 'forms1');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'root');
	define('DB_HOST', 'localhost');

	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// mysqli_select_db(DB_NAME);
?>

<!DOCTYPE html>
<html>
<head>
	<title>database</title>

</head>
<body>

	<div>
		<form action="demo.php" method="post" />
			<p>Title: <input type="text" name="title" /></p>
<!-- 			<p>Deadline: <input type="text" name="deadline" /></p> -->
			<p>Start: <input type="text" name="start" /></p>
			<p>End: <input type="text" name="end" /></p>
			<input name="submit" type="submit" value="Submit" />
		</form>
	</div>

	<?php
		$sqlMain = "SELECT * FROM main";
		$sqlSchedule = "SELECT * FROM schedule";
		$resMain = mysqli_query($link,$sqlMain);
		$resSchedule = mysqli_query($link,$sqlSchedule);
		$countdownArray = array();

		while ($row = mysqli_fetch_array($res)) {
			$id = $row['ID'];
			$title = $row['title'];
			$start = $row['start'];
			$end = $row['end'];
			echo "<form action='demo.php' method='post' />
				<p>Title: <input type='text' name='title' value='$title' /></p>
				<p>Start: <input type='text' name='start' value='$start' /></p>
				<p>End: <input type='text' name='end' value='$end' /></p>
				<input name='id' value='$id' style='display: none' />
				<input name='edit' type='submit' value='Edit' />
				<input name='delete' type='submit' value='Delete' />
				</form></br>";
		}
	?>

</body>
</html>
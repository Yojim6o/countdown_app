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
			<p>Start: <input type="text" name="start[]" /></p>
			<p>End: <input type="text" name="end[]" /></p>
			<p>Start: <input type="text" name="start[]" /></p>
			<p>End: <input type="text" name="end[]" /></p>
			<input name="submit" type="submit" value="Submit" />
		</form>
	</div>

	<?php
		//SQL statement for demo
		$sql = "SELECT * FROM demo";
		$res = mysqli_query($link,$sql);

		//while there are rows in demo
		while ($row = mysqli_fetch_array($res)) {

			//set variables for each parameter in demo
			$id = $row['ID'];
			$title = $row['title'];

			//SQL statement for schedule
			$sqlSched = "SELECT * FROM schedule WHERE PID = '$id'";
			$resSched = mysqli_query($link,$sqlSched);

			//display top of form
			echo "<form action='demo.php' method='post' />";
			echo "<p>Title: <input type='text' name='title' value='$title' /></p>";

			//while there are rows in schedule
			while ($rowSched = mysqli_fetch_array($resSched)) {

				//set variables for parameters in schedule
				$pid = $rowSched['PID'];
				$idSched = $rowSched['ID'];
				$start_end = explode(',', $rowSched['schedule']);
				$start = $start_end[0];
				$end = $start_end[1];

				//generate and start and end tag for each schedule
				echo "<input name='pid' value='$pid' style='display: none' />";
				echo "<p>Start: <input type='text' name='start[]' value='$start' /></p>";
				echo "<p>End: <input type='text' name='end[]' value='$end' /></p>";
			}

			//generate the buttons in the view for each countdown
			echo "<input name='id' value='$id' style='display: none' />";
			echo "<input name='edit' type='submit' value='Edit' />";
			echo "<input name='delete' type='submit' value='Delete' />";
			echo "</form></br>";

		}
	?>

</body>
</html>
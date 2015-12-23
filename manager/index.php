<?php
	//define database parameters
	define('DB_NAME', 'forms1');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'root');
	define('DB_HOST', 'localhost');

	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html>
<head>
	<title>database</title>
	<style>
	.timespan{position:relative; width:200px;}
	.delete{
		background-image:url(http://ezpro.co/blog/wp-content/uploads/2014/12/red-delete-button.jpg); 
		background-size:100%; 
		background-position:center center; 
		background-color:red; 
		color: transparent;  
		border:none;
		position: absolute;
		right:0px;
		top: 50%;
	}
	</style>
</head>
<body>
	<div>
		<form action="demo.php" method="post" />
			<p>Title: <input type="text" name="title" /></p>
			<p>Deadline: <input type="text" name="deadline" /></p>
			<p>Message: <input type="text" name="message" /></p>
			<div id="schedule_0">
				<div class="timespan">
					<p>Start: <input type="text" name="start[]" /></p>
					<p>End: <input type="text" name="end[]" /></p>
				</div>
			</div>
			<button id="but" onClick="addSchedule('0')" type="button">Add Schedule</button>
			<input name="submit" type="submit" value="Submit" />
		</form>
	</div>

	<?php
		//SQL statement for demo
		$sql = "SELECT * FROM demo";
		$res = mysqli_query($link,$sql);
		$i = 1;

		//while there are rows in demo
		while ($row = mysqli_fetch_array($res)) {

			//set variables for each parameter in demo
			$id = $row['ID'];
			$title = $row['title'];
			$deadline = $row['deadline'];
			$message = $row['message'];

			//SQL statement for schedule
			$sqlSched = "SELECT * FROM schedule WHERE PID = '$id'";
			$resSched = mysqli_query($link,$sqlSched);

			//display top of form
			echo "<hr>";
			echo "<p>Countdown ID: ".$id."</p>";
			echo "<form action='demo.php' method='post' />";
			echo "<p>Title: <input type='text' name='title' value='$title' /></p>";
			echo "<p>Deadline: <input type='text' name='deadline' value='$deadline' /></p>";
			echo "<p>Message: <input type='text' name='message' value='$message' /></p>";
			echo "<div id='schedule_".$i."' >";
			$k = 0;
			//while there are rows in schedule
			while ($rowSched = mysqli_fetch_array($resSched)) {

				//set variables for parameters in schedule
				$pid = $rowSched['ID'];
				// $idSched = $rowSched['ID'];
				$start_end = explode(',', $rowSched['schedule']);
				$start = $start_end[0];
				$end = $start_end[1];

				//generate and start and end tag for each schedule
				echo "<div class='timespan'>";
				echo "<input name='sche_id[]' value='$pid' style='display: none' />";
				echo "<p>Start: <input type='text' name='start[]' value='$start' /></p>";
				echo "<p>End: <input type='text' name='end[]' value='$end' /></p>";
				echo "<input class='delete' type='submit' name='remove_sched' value='$k'/>";
				echo "</div>";
				$k++;
			}

			//generate the buttons in the view for each countdown
			echo "</div>";
			echo "<input name='id' value='$id' style='display: none' />";
			echo "<input style='background-color:green; border:none' type='submit' name='add_sched' value='+'/>";
			echo "<input name='edit' type='submit' value='Edit' />";
			echo "<input name='delete' type='submit' value='Delete' />";
			echo "</form></br>";
			$i++;
		}
	?>
	<script>

		var addSchedule = function(e){
			var schedule = document.getElementById("schedule_"+e);
			var timespan = document.createElement("div");
			timespan.className = 'timespan';
			timespan.innerHTML = "<p>Start: <input type='text' name='start[]' /></p>" 
				+ "<p>End: <input type='text' name='end[]'' /></p>";
			schedule.appendChild(timespan);
		}
	</script>
</body>
</html>
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
	<title>countdown maker</title>
	<link rel="stylesheet" href="./css/style.css" />
</head>
<body>
	<div class="header">
		<form action="demo.php" method="post" />
			<h1>Countdown Title</h1><input class="title" type="text" name="title" />
			<p>Deadline: <input class="deadline" type="text" name="deadline" /> <em>(format like so: December 11 2015 16:32:00)</em></p>
			<p>Message: <input class="message" type="text" name="message" /> <em>(what the countdown says after the deadline)</em></p>
			<div id="schedule"></div>
			<div class="button-row">
				<button onClick="addSchedule()" type="button">Add Schedule</button>
				<div class="scheduleTool">
					<a href="" class="anchor">?</a>
					<p class="helptool">A Schedule allows you to determine the timespan of when a countdown is active.  You can add multiple schedules so that when one expires, the next one will activate. Leave the "Deadline" and "Message" fields blank if you use this feature.</p>
				</div>
			</div>
			<div class="submitButton">
				<input class="button" id="submit" name="submit" type="submit" value="Submit" />
			</div>
		</form>
	</div>

	<?php
		//SQL statement for demo
		$sql = "SELECT * FROM demo";
		$res = mysqli_query($link,$sql);
		$i = 1;

		echo "<div class='master'>";

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
			echo "<div class='content'>";
			echo "<p>Countdown ID: ".$id."</p>";
			echo "<form action='demo.php' method='post' />";
			echo "<p>Title: <input class='title' type='text' name='title' value='$title' /></p>";
			echo "<p>Deadline: <input class='deadline' type='text' name='deadline' value='$deadline' /></p>";
			echo "<p>Message: <input class='message' type='text' name='message' value='$message' /></p>";
			echo "<div id='schedule_".$i."' >";
			$k = 0;
			//while there are rows in schedule
			while ($rowSched = mysqli_fetch_array($resSched)) {

				//set variables for parameters in schedule
				$pid = $rowSched['ID'];
				$start_end = explode(',', $rowSched['schedule']);
				$start = $start_end[0];
				$end = $start_end[1];

				//generate and start and end tag for each schedule
				echo "<div class='timespan ts'>";
				echo "<input name='sche_id[]' value='$pid' style='display: none' />";
				echo "<p>Start Time: <input type='text' name='start[]' value='$start' /></p>";
				echo "<p>End Time: <input type='text' name='end[]' value='$end' /></p>";
				echo "<input class='delete' type='submit' name='remove_sched' value='$k'/>";
				echo "</div>";
				$k++;
			}

			//generate the buttons in the view for each countdown
			echo "</div>";
			echo "<input name='id' value='$id' style='display: none' />";
			echo "<input class='button' type='submit' name='add_sched' value='Add Schedule'/>";
			echo "<div class='button-row'>";
			echo "<div class='deleteButton'>";
			echo "<input id='delete' class='button' name='delete' type='submit' value='Delete Countdown' />";
			echo "</div>";
			echo "<div class='saveButton'>";
			echo "<input id='save' class='button' name='edit' type='submit' value='Save Changes' />";
			echo "</div>";
			echo "</div>";
			echo "</form></div><br>";
			$i++;
		}

		echo "</div>";
	?>
	<script>

		var t = 0;
		var addSchedule = function(){
			var schedule = document.getElementById("schedule");
			var timespan = document.createElement("div");
			timespan.id = 'timespan_'+t;
			timespan.className = 'ts';
			timespan.innerHTML = "<button class='timespan-delete' onClick=deleteTimespan(" + t + ") type='button'>X</button>"
				+ "<p>Start Time: <input type='text' name='start[]' /></p>" 
				+ "<p>End Time: <input type='text' name='end[]' /></p>";
			schedule.appendChild(timespan);
			t++;
		}

		var deleteTimespan = function(e) {
			var timespan = document.getElementById("timespan_"+e);
			timespan.parentNode.removeChild(timespan);
		}
	</script>
</body>
</html>
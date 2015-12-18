<!DOCTYPE html>
<html>
<head>
	<title>Countdown app</title>
	<link rel="stylesheet" href="./css/style.css" />
	<script src="js/main.js"></script>
</head>
<body>
	<div class="master">
		<header>
			<div class="page-title">
				<h1>Countdown App</h1>
			</div>
			<div class="navbar">
				<button>New</button>
				<button>View</button>
			</div>
		</header>
		<form action="basic/demo.php" method="post" />
			<div class="create">
				<div class="title">
					<input type="text" name="title" />
				</div>
				<hr>
				<div class="deadline">
					<h3>Deadline</h3>
					<p>Date: <input type="text" name="deadline" /></p>
					<div class="right">
						Or: <button>Schedule</button>
					</div>
				</div>
				<hr>
				<div class="schedule">
					<h3>Schedule</h3>
					<p>Start: <input></input> End: <input></input></p>
					<button>Add</button>
					<div class="right">
						Or: <button>Deadline</button>
					</div>
				</div>
				<hr>
				<div class="styling">
					<h3>Styling</h3>
					<div class="font">
						<p>Font Color: 
							<input></input>
						</p>
					</div>
					<div class="background">
						<p>Background Color: 
						<input></input>
						</p>
					</div>
					<div class="hexicodes">
						<p>For colors, use primary color names or hexicodes.
						<a href="http://www.color-hex.com/" target="_blank">Search Hexicodes</a>
						</p>
					</div>
					<div class="size">
						<h4>Choose size</h4>
						<button>Top Wide</button>
						<button>Primary</button>
						<button>Secondary</button>
						<!--
						<div class="preview" id="top"></div>
		 				<div class="preview" id="pri"></div>
						<div class="preview" id="sec"></div> -->
					</div>
				</div>
				<hr>
				<div class="create-button">
					<input type="submit" value="Submit" />
				</div>
			</div>
		</form>
		<footer></footer>
	</div>
</body>
</html>
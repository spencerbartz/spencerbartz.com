<html>
	<head>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div class="logo-container">
			<img src="logo.png"/>
		</div>
		
		<div class="app-container">
			<div class="canvas-container">
				<canvas id="graph" width="800" height="600">Sorry, your browser does not support HTML5 canvas</canvas>
			</div>
	
			<div class="form-container">
				<form id="input-form">
					Initial velocity of projectile:<br/>
					<input id="initial-velocity" name="v0" type="text" value="50" /> m/s<br/>
					Angle:<br/>
					<input id="angle" name="theta" type="text" value="45" /> degrees<br/><br/>
					 <button id="fire-button" type="submit">Fire Projectile!</button>
					 <button id="clear-button" type="button">Clear</button>
				</form>
			</div>
		</div>
		
		<script type="text/javascript" src="../jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../underscore-min.js"></script>
		<script type="text/javascript" src="graph.js"></script>
		<script type="text/javascript" src="projectile.js"></script>
	</body>
</html>
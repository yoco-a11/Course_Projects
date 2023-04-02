<!DOCTYPE html> <html lang="en">
<head> <title>Registration</title>
</head>
<body> <center>
	<?php
		ini_set('display_errors', 1); error_reporting(-1); ?>
		<h1>User Registration Page</h1>
		<form action="insert.php" method="post">
			<p>
				<label for="fname">First name:</label>
				<input type="text" name="fname" id="fname">
			</p>
			<p>
				<label for="lname">Last name:</label>
				<input type="text" name="lname" id="lname">
			</p>
			<p>
				<label for="email">Email:</label>
				<input type="email" name="email" id="email">
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" id="password">
			</p> <p>
				<label for="cnfpassword">Confirm Password:</label>

				<input type="password" name="cnfpassword" id="password">
			</p>
			<input type="submit" value="Submit"> </form>
		</center> </body>
		</html>
<?php
ini_set('display_errors', 1);
error_reporting(-1);
ini_set('display_errors', 1);
error_reporting(-1);
session_start();
// servername => localhost
// username => root
// password => empty
// database name => staff
$conn = mysqli_connect('localhost', 'root', 'your_password', 'db'); // Check connection
if ($conn === false) {
	echo 'ERROR: Could not connect. ';
	die('ERROR: Could not connect. ' . mysqli_connect_error()); }
	if (isset($_POST['email']) && isset($_POST['password'])) { function validate($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			
			$data = htmlspecialchars($data);
			return $data; }
			$email = validate($_POST['email']);
			$pass = validate($_POST['password']);
			if (empty($email)) {
				header('Location: login.php?error=User Name is required');
				exit();
			} elseif (empty($pass)) {
				header('Location: login.php?error=password is required');
				exit(); } else {
					$sql = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) === 1) { $row = mysqli_fetch_assoc($result);
						if ($row['email'] === $email && $row['password'] === $pass) { echo 'Logged in!';
						$_SESSION['logged_in'] = true;
						$_SESSION['email'] = $row['email'];
						$_SESSION['ID'] = $row['ID']; $_SESSION['fname'] = $row['fname']; $_SESSION['lname'] = $row['lname'];

$_SESSION['password'] = $row['passw']; // echo "$email";
header('Location: home.php'); } else {
	header(
		'Location: login.php?error=Incorect User name or
		password' );
	exit(); }
} else { header(
	'Location: login.php?error=Incorect User name or password' );
exit(); }
}
} else {
	header('Location: login.php');
	exit(); }
	?>
	<br>
<!-- <label>Name</label>
<input type="text" name="name" placeholder="name"><br> <label>Department</label>

<input type="text" name="Department" placeholder="department"><br> -->
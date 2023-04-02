<?php
session_start(); ini_set('display_errors', 1); error_reporting(-1); ini_set('display_errors', 1);

error_reporting(-1);
$ID = $_SESSION['ID'];
// servername => localhost
// username => root
// Department => empty
// database name => staff
$conn = mysqli_connect('localhost', 'root', 'your_password', 'db'); // Check connection
if ($conn === false) {
	echo 'ERROR: Could not connect. ';
	die('ERROR: Could not connect. ' . mysqli_connect_error()); }
	if ( isset($_POST['password']) && isset($_POST['cnfpassword'])) { function validate($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data; }
			$password = validate($_POST['password']); $cnfpassword = validate($_POST['cnfpassword']); if (empty($password)) {
				header('Location: change.php?error=First Name is required');
				exit();
			} elseif (empty($cnfpassword)) {
				header('Location: change.php?error=Last name is required');

				exit(); } else {
					$sql = "SELECT * FROM user WHERE ID='$ID'";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) === 1) { $row = mysqli_fetch_assoc($result);
// printf("%s \n Name: \n", $row['password']); if($cnfpassword !== $password){
						echo("Password Not Matched");
						exit(); }
						$sql = "UPDATE user SET password='$password' WHERE ID='$ID'";
						$result = mysqli_query($conn, $sql); if ($result) {
							echo '<h3>Details Updated</h3>';
							echo '<span>Password: </span> ', $password;
						} else {
							echo 'Not Updated';
						}
					} else {
						header(
							'Location: home.php?error=Incorect User name or
							Department' );
						exit(); }

					}
					else {
						header('Location: home.php');
						exit(); }
						?>
						<form action="logout.php"> <button type="submit">
						Log out </button>
					</form>
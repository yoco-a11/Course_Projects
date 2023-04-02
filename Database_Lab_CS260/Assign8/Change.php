<?php
session_start(); ini_set('display_errors', 1); error_reporting(-1); ini_set('display_errors', 1); error_reporting(-1);
$ID = $_SESSION['ID'];

// servername => localhost
// username => root
// Department => empty
// database name => staff
$conn = mysqli_connect('localhost', 'root', 'your_password', 'db'); // Check connection
// alert("JavaScript Alert Box by PHP"); echo '<script type ="text/JavaScript">'; echo 'alert("JavaScript Alert Box by PHP")'; echo '</script>';
function createConfirmationmbox() {
	echo '<script type="text/javascript"> ';
	echo ' function openulr(newurl) {';
	echo ' if (confirm("Are you sure you want to open new URL")) {'; echo ' document.location = newurl;';
	echo ' }';
	echo '}';
	echo '</script>';
}
if ($conn === false) {
	echo 'ERROR: Could not connect. ';
	die('ERROR: Could not connect. ' . mysqli_connect_error()); }
	if ( isset($_POST['fname']) && isset($_POST['lname'])) { function validate($data)
		{
			$data = trim($data);
			$data = stripslashes($data); $data = htmlspecialchars($data);

			return $data; }
			$fname = validate($_POST['fname']);
			$lname = validate($_POST['lname']);
			if (empty($fname)) {
				header('Location: change.php?error=First Name is required');
				exit();
			} elseif (empty($lname)) {
				header('Location: change.php?error=Last name is required');
				exit();
			} else {
				$sql = "SELECT * FROM user WHERE ID='$ID'";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) === 1) { $row = mysqli_fetch_assoc($result);
// printf("%s \n Name: \n", $row['fname']);
					$sql = "UPDATE user SET fname='$fname', lname='$lname' WHERE ID='$ID'";
					$result = mysqli_query($conn, $sql);
					if ($result) {
						$SESSION['fname'] = $fname;
						$SESSION['lname'] = $lname;
						echo '<h3>Details Updated</h3>';
						echo '<span>First name: </span> ', $fname;
						echo '</br>';
						echo '</br>';

echo '<span>Last name: </span> ', $lname; // header('Location: home.php');
} else {
	echo 'Not Updated';
}
} else {
	header(
		'Location: home.php?error=Incorect User name or Department' );
	exit();
}
}
} else {
	header('Location: home.php');
	exit();
}
?><form action="logout.php">
	<button type="submit"> Log out
	</button> </form>
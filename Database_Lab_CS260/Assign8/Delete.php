<body>
	<?php
	?>
	</body><?php
	session_start();
	ini_set('display_errors', 1);
	error_reporting(-1);
	ini_set('display_errors', 1);
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
	$sql = "delete from user where ID = $ID ";
	$result = mysqli_query($conn, $sql);
	if($result){
		header("Location: after_delete.php");
	}
	?>
<!-- <form action="logout.php">
<button type="submit"> Log out
</button> </form> -->
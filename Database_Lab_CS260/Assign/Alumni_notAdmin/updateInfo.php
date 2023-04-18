<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $company = $_POST['company'];
        $job_role = $_POST['job_role'];
        $job_desc = $_POST['job_desc'];
        $ctc = $_POST['ctc'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $domain = $_POST['domain'];

        $rollno = $_SESSION['rollno'];

        $host = 'localhost';
        $username = 'root';
        $dbname = 'TPC';
        $password = '';

        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "insert into alumni_experience values 
                ('$rollno', '$job_role', '$company', '$job_desc', '$start_date', '$end_date', $ctc, '$domain')";

        if ($conn->query($sql) === TRUE) {
            header("Location: alumniProfile.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Experience</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
    body {
    background-image: url('');
    background-size: cover;
    }
    /* CSS for the navigation bar */
    .navigation {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 220px;
      background-color: #f2f2f2;
      overflow-x: hidden;
      padding-top: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .navigation a {
      display: block;
      padding: 16px;
      color: #333;
      text-decoration: none;
      transition: 0.3s;
      font-size: 18px;
      font-weight: bold;
      border-left: 5px solid transparent;
    }

    .navigation a:hover {
      background-color: #ddd;
      border-left: 5px solid #4caf50;
    }

    .navigation a.active {
      background-color: #4caf50;
      color: #fff;
      border-left: 5px solid #fff;
    }

    .navigation h2 {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    </style>
</head>
<body>
    <div class="navigation">
        <h2>Navigation</h2>
        <a href="alumniProfile.php">Profile</a>
        <a href="updateInfo.php" class="active">Update Info</a>
    </div>
	<h1>Experience</h1>
	<form method="post" action="">
        <div>
            <label for="domain">Domain</label>
            <select id="domain" name="domain" required>
                <option value="">Select an option</option>
                <option value="Machine Learning">Machine Learning</option>
                <option value="Software Development">Software Development</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="Robotics">Robotics</option>
                <option value="Finance">Finance</option>
                <option value="Production">Production</option>
            </select>
        </div>
        <div>
            <label for="company">Company</label>
            <select id="company" name="company" required>
            <option value="">Select an option</option>
            <option value="lol">lol</option>
            </select>
		</div>
        <div>
            <label for="job_role">Job Role</label>
            <select id="job_role" name="job_role" required>
                <option value="">Select an option</option>
                <option value="lol">lol</option>
            </select>
        </div>
        <div>
            <label for="job_desc">Job Description</label>
            <textarea id="job_desc" name="job_desc" rows="3" cols="40" maxlength="250"></textarea>
		</div>
        <div>
			<label for="ctc">CTC (LPA)</label>
			<input type="number" id="ctc" name="ctc">
		</div>
		<div>
            <label for="start_date">Starting Date</label>
            <input type="date" id="start_date" name="start_date">
		</div>
        <div>
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date">
		</div>
		<button>Add Experience</button>
	</form>
</body>
</html>
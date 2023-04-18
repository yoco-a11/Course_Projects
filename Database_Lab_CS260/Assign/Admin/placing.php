<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        $rollno = $_POST['rollno'];
        $company = $_POST['company'];
        $job_role = $_POST['job_role'];
        $year = date('Y');

        $conn = new mysqli('localhost', 'root', '', 'TPC');

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO alumni_placement (rollno, company, job_role, year) VALUES ('$rollno', '$company', '$job_role', '$year')";

        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $conn->error;
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Placements</title>
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
        <a href="home.php">Home</a>
        <a href="placing.php" class="active">Placing</a>
        <a href="logout.php">Log Out</a>
    </div>
    <h1>Current Students</h1>
    <form method="post" action="">
        <div>
            <label for="rollno">Roll No</label>
            <input type="text" id="rollno" name="rollno">
        </div>
        <div>
            <label for="company">Company</label>
            <input type="text" id="company" name="company">
        </div>
        <div>
            <label for="job_role">Job Role</label>
            <input type="text" id="job_role" name="job_role">
        </div>
        <div>
            <button>Submit</button>
        </div>
    </form>
</body>
</html>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        $_SESSION['domain'] = $_POST['domain'];
        $_SESSION['branch'] = $_POST['branch'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['cpi'] = $_POST['cpi'];

        $conn = new mysqli('localhost', 'root', '', 'TPC');

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        header("Location: currentStudentsList.php");
        exit;

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
        <a href="http://localhost/Projects/Assign/Admin/home.php">Home</a>
        <a href="http://localhost/Projects/Assign/Admin/Student/currentStudents.php" class="active">Students</a>
        <a href="http://localhost/Projects/Assign/Admin/logout.php">Log Out</a>
    </div>
    <h1>Current Students</h1>
    <form method="post" action="">
        <div>
            <label for="domain">Domain</label>
            <select id="domain" name="domain" required>
                <option value="">Select an option</option>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'TPC');
                    if ($conn->connect_error){
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "select distinct interest from interest";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        echo "<option value='".$row['interest']."'>".$row['interest']."</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="branch">Branch</label>
            <select id="branch" name="branch" required>
                <option value="">Select an option</option>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'TPC');
                    if ($conn->connect_error){
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "select distinct branch from student";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        echo "<option value='".$row['branch']."'>".$row['branch']."</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select an option</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label for="cpi">Minimum CPI</label>
            <input type="numeric" id="cpi" name="cpi">
        </div>
        <div>
            <button>Submit</button>
        </div>
    </form>
</body>
</html>
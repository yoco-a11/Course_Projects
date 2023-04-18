<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $conn = new mysqli('localhost', 'root', '', 'TPC');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        $_SESSION['year'] = $_POST['year'];
        $_SESSION['company'] = $_POST['company'];

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        header("Location: companyStatsShow.php");
        exit;

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <h1>Company</h1>
	<form method="post" action="">
        <div>
            <label for="company">Company</label>
            <select id="company" name="company" required>
                <option value="">Select an option</option>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'TPC');
                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "select distinct company from prev_jobs";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row['company']."'>".$row['company']."</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="year">Year</label>
            <select id="year" name="year" required>
                <option value="">Select an option</option>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'TPC');
                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "select distinct year from prev_jobs order by year";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row['year']."'>".$row['year']."</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <button>Show</button>
        </div>
	</form>
</body>
</html>
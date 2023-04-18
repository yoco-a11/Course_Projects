<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        $_SESSION['domain'] = $_POST['domain'];
        $_SESSION['l_ctc'] = $_POST['l_ctc'];
        $_SESSION['h_ctc'] = $_POST['h_ctc'];
        $_SESSION['l_batch'] = $_POST['l_batch'];
        $_SESSION['h_batch'] = $_POST['h_batch'];

        $conn = new mysqli('localhost', 'root', '', 'TPC');

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        header("Location: alumniExperienceList.php");
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
        <a href="incomingCompany.php">Companies</a>
        <a href="prevCompanies.php" class="active">Past Companies</a>
        <a href="LogOut.php">Log Out</a>
    </div>
    <h1>Past Companies</h1>
    <form>
        <div>
            <label for="domain">Domain</label>
            <select id="domain" name="domain" required>
                <option value="">Select an option</option>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'TPC');
                    if ($conn->connect_error){
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "select distinct domain from alumni_placement";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['domain'] . '">' . $row['domain'] . '</option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="l_ctc">Package(LPA) lower bound</label>
            <input type="number" id="l_ctc" name="l_ctc">
        </div>
        <div>
            <label for="u_ctc">Package(LPA) upper bound</label>
            <input type="number" id="u_ctc" name="u_ctc">
        </div>
        <div>
            <label for="l_batch">Earliest Batch</label>
            <input type="number" id="l_batch" name="l_batch">
        </div>
        <div>
            <label for="u_batch">Recent Batch</label>
            <input type="number" id="u_batch" name="u_batch">
        </div>
        <div>
            <button>Submit</button>
        </div>
    </form>
</body>
</html>
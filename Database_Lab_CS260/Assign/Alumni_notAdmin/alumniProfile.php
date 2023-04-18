<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Work Experience</title>
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
        <a href="alumniProfile.php" class="active">Profile</a>
        <a href="updateInfo.php">Update Info</a>
        <a href="logout.php">Log Out</a>
    </div>
    <h1>Work Experience</h1>
    <table>
        <thead>
            <tr>
                <th>Company</th>
                <th>Job Role</th>
                <th>Job Description</th>
                <th>CTC</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            $rollno = $_SESSION['rollno'];

            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "TPC";
            $conn = mysqli_connect($host, $username, $password, $database);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Query the database for all entries in the experience table
            $sql = "SELECT * FROM alumni_experience where rollno = '$rollno'";
            $result = mysqli_query($conn, $sql);

            // Display the results in a table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["company"] . "</td>";
                echo "<td>" . $row["job_role"] . "</td>";
                echo "<td>" . $row["job_desc"] . "</td>";
                echo "<td>" . $row["ctc"] . "</td>";
                echo "<td>" . $row["start_date"] . "</td>";
                echo "<td>" . $row["end_date"] . "</td>";
                echo "</tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>

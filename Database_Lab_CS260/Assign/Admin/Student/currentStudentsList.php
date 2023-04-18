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
        <a href="http://localhost/Projects/Assign/Admin/Student/currentStudents.php">Students</a>
        <a href="http://localhost/Projects/Assign/Admin/logout.php">Log Out</a>
    </div>
    <h1>Current Students</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Roll No</th>
                <th>Email</th>
                <th>CPI</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            $domain = $_SESSION['domain'];
            $branch = $_SESSION['branch'];
            $cpi = $_SESSION['cpi'];
            $gender = $_SESSION['gender'];

            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "TPC";
            $conn = mysqli_connect($host, $username, $password, $database);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "select name, rollno, email, cpi from student natural join interest
                    where
                    cpi >= $cpi
                    and gender = '$gender'
                    and branch = '$branch'
                    and interest = '$domain'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td><a href='http://localhost/Projects/Assign/student/{$row["rollno"]}'>" . $row["rollno"] . "</a></td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["cpi"] . "</td>";
                echo "</tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>

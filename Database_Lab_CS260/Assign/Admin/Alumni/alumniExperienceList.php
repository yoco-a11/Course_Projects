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
            <a href="http://localhost/Projects/Assign/Admin/Alumni/alumniExperience.php">Alumni</a>
            <a href="http://localhost/Projects/Assign/Admin/logout.php">Log Out</a>
    </div>
    <h1>Alumni</h1>
    <h1>Placement Data</h1>
    <table>
        <thead>
            <tr>
                <th>RollNo</th>
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
            $domain = $_SESSION['domain'];
            $p_lower = $_SESSION['p_lower'];
            $p_upper = $_SESSION['p_upper'];
            $company = $_SESSION['company'];
            $gender = $_SESSION['gender'];
            $b_lower = $_SESSION['b_lower'];
            $b_higher = $_SESSION['b_higher'];
            $branch = $_SESSION['branch'];

            $conn = mysqli_connect("localhost", "root", "", "TPC");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "select rollno, company, job_role, job_desc, ctc, start_date, end_date
                    from alumni_experience natural join alumni where 
                    company = '$company'
                    and domain = '$domain'
                    and branch = '$branch'
                    and gender = '$gender'
                    and batch >= $b_lower
                    and batch <= $b_higher
                    and ctc >= $p_lower
                    and ctc <= $p_upper";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='student.php?rollno=" . $row["rollno"] . "'>" . $row["rollno"] . "</a></td>";
                echo "<td>" . $row["company"] . "</td>";
                echo "<td>" . $row["job_role"] . "</td>";
                echo "<td>" . $row["job_desc"] . "</td>";
                echo "<td>" . $row["ctc"] . "</td>";
                echo "<td>" . $row["start_date"] . "</td>";
                echo "<td>" . $row["end_date"] . "</td>";
                echo "</tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>

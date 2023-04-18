<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $conn = new mysqli('localhost', 'root', '', 'TPC');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();
    $year = $_SESSION['year'];
    $company = $_SESSION['company'];
    $sql = "SELECT job_role, AVG(ctc) as avg_ctc FROM prev_jobs 
            where company = '$company' and year = $year GROUP BY job_role";
    $result = $conn->query($sql);

    $job_roles = [];
    $average_ctc = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $job_roles[] = $row['job_role'];
            $average_ctc[] = $row['avg_ctc'];
        }
    } else {
        echo "0 results";
    }

    $conn->close();
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
    <div>
        <h2>Statistics</h2>
        <?php
            $year = $_SESSION['year'];
            $company = $_SESSION['company'];
            $conn = new mysqli('localhost', 'root', '', 'TPC');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "select count(*) as total, avg(ctc) as average, max(ctc) as highest from prev_jobs where year = $year and company = '$company'";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();
        ?>
        <div>
            <h3>Placement Statistics for <?php echo $year ?></h3>
            <p>Total Placements: <?php echo $row['total'] ?></p> 
            <p>Average CTC: <?php echo number_format($row['average'], 2) ?></p>
            <p>Highest CTC: <?php echo number_format($row['highest'], 2) ?></p>
        </div>
        <canvas id="barChartBranch"></canvas>
        <script>
            const job_roles = <?php echo json_encode($job_roles); ?>;
            const average_ctc = <?php echo json_encode($average_ctc); ?>;

            const ctx = document.getElementById('barChartBranch').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: job_roles,
                    datasets: [{
                        label: 'Average CTC',
                        data: average_ctc,
                        backgroundColor: 'blue'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
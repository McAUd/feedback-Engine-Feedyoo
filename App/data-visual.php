<?php
session_start();
include('inc/config.php');
include('inc/checklog.php');
check_login(); // Assuming this function includes necessary checks
$userId = $_SESSION['userId'];

// Initialize counts
$feedback_count = $suggestions_count = $unique_email_count = $unique_name_count = 0;
$total_polls = 0; // Add total polls count initialization

// Assuming the database connection is already established above this point
// Assuming $userId holds the signed-in userId
if (isset($_SESSION['login_user'])) {
    $userLoggedIn = $_SESSION['login_user'];
    $userId = $_SESSION['userId']; // Assuming user ID is stored in the session

    // Query to count feedback, suggestions, email, and name for the signed-in userId
    $sql = "SELECT 
                COUNT(feedback) AS feedback_count, 
                COUNT(suggestions) AS suggestions_count, 
                COUNT(DISTINCT email) AS unique_email_count, 
                COUNT(DISTINCT name) AS unique_name_count,
                COUNT(DISTINCT poll.id) AS total_polls 
            FROM feed 
            INNER JOIN poll ON feed.poll_id = poll.id
            WHERE poll.user_id = $userId"; // Assuming user_id is the column name in your 'poll' table

    // Execute the query
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch the result
        $row = $result->fetch_assoc();

        // Assign counts if available
        $feedback_count = $row['feedback_count'];
        $suggestions_count = $row['suggestions_count'];
        $unique_email_count = $row['unique_email_count'];
        $unique_name_count = $row['unique_name_count'];
        $total_polls = $row['total_polls']; // Assign total polls count
    }
}

// Collect count data into an array
$countData = array(
    'Feedbacks' => $feedback_count,
    'Suggestions' => $suggestions_count,
    'Emails' => $unique_email_count,
    'Participants' => $unique_name_count,
    'Total Polls' => $total_polls
);

// Convert PHP array to JSON for JavaScript consumption
$countDataJSON = json_encode($countData);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Page Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar -->
        <?php include('inc/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="body-wrapper">
            <?php include('inc/header.php'); ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Overview</h5>
                                    </div>
                                </div>
                                <div id="countGraphContainer">
                                    <canvas id="countGraph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Your other content here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- PHP Count Data to JavaScript -->
<!-- PHP Count Data to JavaScript -->
<!-- PHP Count Data to JavaScript -->
<script>
    // Parse the count data JSON passed from PHP
    var countData = <?php echo $countDataJSON; ?>;
    console.log(countData); // Debug statement

    // Check if countData is an empty object
    if (Object.keys(countData).length === 0 && countData.constructor === Object) {
        console.log("No data received from PHP."); // Debug statement
    }

    // Get canvas context
    var ctx = document.getElementById('countGraph').getContext('2d');

    // Create gradient fill for bars
    var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, "rgba(255, 99, 132, 0.6)");
    gradientFill.addColorStop(1, "rgba(255, 99, 132, 0.1)");

    // Create a new chart
    var countChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(countData), // Use count data keys as labels
            datasets: [{
                label: 'Count',
                data: Object.values(countData), // Use count data values as dataset
                backgroundColor: gradientFill,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 14,
                            family: 'Arial'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 14,
                            family: 'Arial'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14,
                            family: 'Arial'
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuad'
            }
        }
    });
</script>


</body>
        </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>

</html>

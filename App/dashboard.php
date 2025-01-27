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
                COUNT(CASE WHEN suggestions IS NOT NULL AND suggestions <> '' THEN 1 END) AS suggestions_count, 
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
?>

<!doctype html>
<html lang="en">
<head>
    
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
                        <div class="table-responsive">
                                
                                  
                         <?php
// Include your database connection
include('inc/config.php');

// Prepare and execute the query to fetch the username of the logged-in user
$query = "SELECT username FROM user WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display the copy instruction text
    echo "<p class='copy-text'>Copy your profile link then share it to people you want feedback from</p>";

    // Display the username link of the logged-in user (hidden)
    $row = $result->fetch_assoc();
    $username = htmlspecialchars($row['username']);
    $profileLink = 'https://feedyoo.xyz/fprofile?username=' . urlencode($username);
    // Add copy button
    echo "<button class='copy-button' onclick='copyLink(\"$profileLink\")'>Copy</button>";
    // Add success message
    echo "<p class='success-message' id='successMessage'>Link copied successfully!</p>";
} else {
    echo "No user found for the logged-in user.";
}

$stmt->close();
$mysqli->close();
?>
                 
<script>
function copyLink(link) {
  var textArea = document.createElement("textarea");
  textArea.value = link;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("Copy");
  document.body.removeChild(textArea);
  // Show success message
  var successMessage = document.getElementById("successMessage");
  successMessage.style.display = "block";
  setTimeout(function(){
    successMessage.style.display = "none";
  }, 2000); // Hide after 2 seconds
}
</script>
                                
                            <!-- Total Polls Count -->
                            <div class="notification-item">
                                <div class="icon-container">
                                    <img src="img/polling.png" alt="Poll Icon">
                                </div>
                                <div class="content">
                                    <h2><?php echo $total_polls; ?></h2>
                                    <p>Total Polls</p>
                                </div>
                            </div>
                            <!-- Feedbacks -->
                            <a href="feedbacks" class="notification-item">
                                <div class="icon-container">
                                    <img src="img/feedback.png" alt="Feedback Icon">
                                </div>
                                <div class="content">
                                    <h2><?php echo $feedback_count; ?></h2>
                                    <p>Feedbacks</p>
                                </div>
                            </a>
                            <!-- Suggestions -->
                            <a href="suggestions" class="notification-item">
                                <div class="icon-container">
                                    <img src="img/suggestion.png" alt="Suggestion Icon">
                                </div>
                                <div class="content">
                                    <h2><?php echo $suggestions_count; ?></h2>
                                    <p>Suggestions</p>
                                </div>
                            </a>
                            <!-- Emails -->
                            <a href="#" class="notification-item">
                                <div class="icon-container">
                                    <img src="img/email.png" alt="Email Icon">
                                </div>
                                <div class="content">
                                    <h2><?php echo $unique_email_count; ?></h2>
                                    <p>Emails</p>
                                </div>
                            </a>
                            <!-- Participants -->
                            <a href="#" class="notification-item">
                                <div class="icon-container">
                                    <img src="img/user.png" alt="Email Icon">
                                </div>
                                <div class="content">
                                    <h2><?php echo $unique_name_count; ?></h2>
                                    <p>Participants</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/sidebarmenu.js"></script>
        <script src="../assets/js/app.min.js"></script>
        <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    </body>
    <style>
.copy-text{
     font-size: small;       
            }
            
    .container {
    text-align: center;
    }

    .username-link {
    text-decoration: none;
    color: #0366d6;
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
    }

    .copy-button {
    background-color: #4caf50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
    }

    .copy-button:hover {
    background-color: #45a049;
    }

    .success-message {
    display: none;
    color: #4caf50;
    font-size: 16px;
    margin-top: 10px;
    }


    .card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    }

    .card-title {
    font-size: 20px;
    margin-bottom: 15px;
    }

    .message-center {
    overflow-y: auto;
    }

    .notification-item {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    }

    .notification-item:hover {
    background-color: #f9f9f9;
    }

    .icon-container {
    margin-right: 15px;
    }

    .icon-container img {
    height: 40px;
    }

    .content h2 {
    margin: 0;
    font-size: 24px;
    }

    .content p {
    margin: 0;
    font-size: 14px;
    color: #777;
    }
    </style>
</html>

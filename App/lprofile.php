<?php 
    session_start();
    include('inc/config.php'); 
    include('inc/checklog.php');
    check_login(); // Assuming this function includes necessary checks
    $userId = $_SESSION['userId'];
?>
<!doctype html>
<html lang="en">

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
   
    <?php include('inc/sidebar.php'); ?>
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <?php include('inc/header.php'); ?>
    <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4"> </h5>
            <?php
// Check if a username is provided in the URL
if (isset($_GET['username'])) {
    include('inc/config.php');

    $username = $_GET['username'];

    // Prepare and execute a query to retrieve user information based on the username
    $queryUser = "SELECT * FROM user WHERE username = ?";
    $stmtUser = $mysqli->prepare($queryUser);
    $stmtUser->bind_param('s', $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    // Check if the user exists
    if ($resultUser->num_rows > 0) {
        // Display the user details
        while ($rowUser = $resultUser->fetch_assoc()) {
            echo "<p><strong>Name:</strong> " . htmlspecialchars($rowUser['username']) . "</p>";

            // Fetch and display questions from the poll table based on the user's id
            $userId = $rowUser['id'];

            $queryPoll = "SELECT id, question FROM poll WHERE user_id = ?";
            $stmtPoll = $mysqli->prepare($queryPoll);
            $stmtPoll->bind_param('i', $userId);
            $stmtPoll->execute();
            $resultPoll = $stmtPoll->get_result();

            // Check if there are questions for the user
            if ($resultPoll->num_rows > 0) {
                echo "<h2>Available Polls</h2>";
                while ($rowPoll = $resultPoll->fetch_assoc()) {
                    // Add a link to the poll page for each available poll with poll_id parameter
                    echo "<a href='feedback?poll_id=" . htmlspecialchars($rowPoll['id']) . "'>";
                    echo "<p><strong>Poll:</strong> " . htmlspecialchars($rowPoll['question']) . "</p>";
                    echo "</a>";
                    
                    // Add other details you want to display
                }
            } else {
                echo "<p>No poll found from this user.</p>";
            }

            // Close the statement for the poll query
            $stmtPoll->close();
        }
    } else {
        echo "<p>No user found with the username: " . htmlspecialchars($username) . "</p>";
    }

    // Close the statements and connection
    $stmtUser->close();
    $mysqli->close();
}
?>

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

</html>
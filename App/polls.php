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
            <h5 class="card-title fw-semibold mb-4">Available Polls</h5>
            <p class="mb-0">POLLS</p>
               
                <?php
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve user_id from the session
$user_id = $_SESSION['userId'];

// Fetch poll for the given user_id
$query = "SELECT question FROM poll WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);

// Execute the statement
if ($stmt->execute() === false) {
    echo "Error: " . $stmt->error;
} else {
    // Bind result variables
    $stmt->bind_result($question);

    // Display the questions
    while ($stmt->fetch()) {
        echo '<div class="poll-question">';
        echo "<p>$question</p>";
        echo '</div>';
    }
}

// Close the statement
$stmt->close();

// Close connection
$mysqli->close();
?>

            </div>
        </div>
    </div>
</div>
<style>
.card {
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.5rem;
    color: #007bff;
}

.card-text {
    font-size: 1.1rem;
    color: #333;
}

.poll-question {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 5px;
}

.poll-question p {
    margin-bottom: 0;
}

</style>

       
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
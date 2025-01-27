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
            <h5 class="card-title fw-semibold mb-4">Manage Polls</h5>
            <p class="mb-0">Polls </p>
            <?php
$userId = $_SESSION['userId'];

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve user_id from the session
$user_id = $_SESSION['userId'];

// Fetch poll for the given user_id
$query = "SELECT id, question FROM poll WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);

// Execute the statement
if ($stmt->execute() === false) {
    echo "Error: " . $stmt->error;
} else {
    // Bind result variables
    $stmt->bind_result($question_id, $question);

    // Display the poll with edit and delete options
    while ($stmt->fetch()) {
        echo "<div class='card mt-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Poll</h5>";
        echo "<p class='card-text'>$question</p>";
        echo "<a href='edit_poll?id=$question_id' class='btn btn-primary mr-2'>Edit</a>";
        echo "<a href='delete_poll?id=$question_id' class='btn btn-danger'>Delete</a>";
        echo "</div>";
        echo "</div>";
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
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>
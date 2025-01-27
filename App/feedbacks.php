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
            <h5 class="card-title fw-semibold mb-4">Feedbacks</h5>
            <p class="mb-0">Random Feedbacks </p>
            <?php
if (isset($_SESSION['login_user'])) {
    $userLoggedIn = $_SESSION['login_user'];
    $userId = $_SESSION['userId']; // Assuming user ID is stored in the session

    // Modify the SQL query to include a WHERE clause for the current user
    $resultPoll = mysqli_query($con, "SELECT * FROM poll WHERE user_id = '$userId'");

    // Check if there are rows in the result set
    if (mysqli_num_rows($resultPoll) > 0) {
        echo "<table class='table' id='polls'>
                <thead>
                    <tr>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>";

        while ($rowPoll = mysqli_fetch_array($resultPoll)) {
            $pollId = $rowPoll['id'];
            echo "<tr>";
            echo "<td><strong>" . $rowPoll['question'] . "</strong></td>"; // Change 'poll' to the correct column name
            echo "</tr>";

            // Fetch and display feedbacks for each poll
            $resultFeedback = mysqli_query($con, "SELECT * FROM feed WHERE poll_id = '$pollId'");
            if (mysqli_num_rows($resultFeedback) > 0) {
                echo "<tr>
                        <td>
                            <h4>Feedbacks</h4>
                            <ul>";
                
                while ($rowFeedback = mysqli_fetch_array($resultFeedback)) {
                    echo "<li>{$rowFeedback['feedback']}</li>";
                }

                echo "</ul>
                        </td>
                    </tr>";
            }
        }

        echo "</tbody></table>";
    } else {
        echo "<p>You have no polls at the moment.</p>";
    }
} else {
    // Uncomment the line below if you want to redirect to index
    // header("Location: index");
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
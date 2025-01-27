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
            <h5 class="card-title fw-semibold mb-4">All</h5>
            <p class="mb-0">Datasheet</p>
            <div class="table-responsive">
                                    <table class="table">
                            <?php
                           
                           if (isset($_SESSION['login_user'])) {
                            $userLoggedIn = $_SESSION['login_user'];
                            $userId = $_SESSION['userId']; // Assuming user ID is stored in the session
                        
                            // Modify the SQL query to include a JOIN clause for the current user's polls and feedbacks
                            $query = "SELECT poll.*, feed.name, feed.email, feed.feedback, feed.suggestions FROM poll LEFT JOIN feed ON poll.id = feed.poll_id WHERE poll.user_id = '$userId'";
                            $result = mysqli_query($con, $query);
                        
                            // Check if there are rows in the result set
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table' id='polls'>
                                        <thead>
                                            <tr>
                                                <th>Polls</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Feedback</th>
                                                <th>Suggestions</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                        
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['question']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['email']}</td>";
                                    echo "<td>{$row['feedback']}</td>";
                                    echo "<td>{$row['suggestions']}</td>";
                                    echo "</tr>";
                                }
                        
                                echo "</tbody></table>";
                            } else {
                                echo "<p>You have no polls at the moment.</p>";
                            }
                        } else {
                            // Redirect to index if user is not logged in
                            // header("Location: index");
                        }?>
                            
                                    </table>
                                </div>
                            </div>


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

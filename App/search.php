<?php 
    session_start();
    include('inc/config.php'); 
    include('inc/checklog.php');
    check_login(); // Assuming this function includes necessary checks
    $userId = $_SESSION['userId'];
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


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
            <h5 class="card-title fw-semibold mb-4">Search</h5>
           

            
            <form class="app-search" action="search" method="GET">
    <input type="text" class="form-control" name="username" placeholder="Search & enter">
    <button type="submit" class="srh-btn"><i class="fas fa-search"></i></button>

</form>

                           

       
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['username'])) {
    // Include your database connection
    include('inc/config.php');

    $username = $_GET['username'];

    // Prepare and execute the query to search for the User by username
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display the search results
        while ($row = $result->fetch_assoc()) {
            // Display the retrieved username information
            echo "User: <a href='lprofile?username=" . urlencode($row['username']) . "'>" . htmlspecialchars($row['username']) . "</a><br>";
            echo "User Email: " . htmlspecialchars($row['email']) . "<br>";
            // ... display other relevant information
        }
    } else {
        echo "No user found with the username: " . htmlspecialchars($username);
    }

    $stmt->close();
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
<style>
/* Style for the search form */
.app-search {
    position: relative;
}

.app-search .form-control {
    width: 250px;
    padding: 10px;
    border: none;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    outline: none;
    transition: box-shadow 0.3s ease;
}

.app-search .form-control:focus {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

.app-search .srh-btn {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background-color: #3498db;
    border: none;
    border-radius: 50%;
    color: #fff;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.app-search .srh-btn:hover {
    background-color: #2980b9;
}

/* Optional: Clear search button styles */
.app-search .clear-search {
    position: absolute;
    top: 50%;
    right: 35px;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #ccc;
    cursor: pointer;
    font-size: 18px;
    transition: color 0.3s ease;
}

.app-search .clear-search:hover {
    color: #666;
}

    </style>


</html>
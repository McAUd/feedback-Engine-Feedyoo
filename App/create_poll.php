<?php
session_start();
include('inc/config.php');
include('inc/checklog.php');
check_login(); // Assuming this function includes necessary checks
$userId = $_SESSION['userId'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user_id from the form
    $user_id = $_POST['user_id'];

    // Process questions
    $questions = array();
    foreach ($_POST as $key => $value) {
        // Check if the input name starts with 'question_'
        if (strpos($key, 'question_') === 0) {
            // Extract the question number
            $question_number = substr($key, strlen('question_'));

            // Add the question and its answer to the $questions array
            $questions[$question_number] = $value;
        }
    }

    // Assuming you have a valid database connection
    $mysqli = new mysqli("fdb1034.atspace.me", "4441160_base", "(paI6E]jv5{xzyt", "4441160_base");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Insert or update data in the poll table
    foreach ($questions as $question) {
        // Use INSERT ... ON DUPLICATE KEY UPDATE to handle insertion or update
        $query = "INSERT INTO poll (user_id, question) 
                  VALUES (?, ?) 
                  ON DUPLICATE KEY UPDATE question = VALUES(question)";
        
        // Prepare and bind the SQL statement
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("is", $user_id, $question);

        // Execute the statement
        if ($stmt->execute() === false) {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();

    // Echo a success message or perform other actions
    echo "";
}
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
                        <h5 class="card-title fw-semibold mb-4">Poll submitted</h5>

                        <!-- Success Message -->
                        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                            Poll created successfully!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <form class="form-horizontal form-material" id="pollForm" action="create_poll" method="post">
                    <div class="form-group">
                        <div id="questionsContainer">
                            <!-- Container for dynamically added questions -->
                        </div>

                        <div class="form-group">
                            <div class="text-center">
                                <button type="button" onclick="addQuestion()" class="btn btn-primary add-question-btn">Add poll</button>
                            </div>
                        </div>

                        <!-- Include user_id in the form if you have it available in the session -->
                        <input class="form-control form-control-line" type="hidden" name="user_id" value="<?php echo $_SESSION['userId']; ?>">

                        <button class="btn btn-success btn-block submit-btn" type="submit">Create Poll</button>
               
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
        .poll-container {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }

        .question-container {
            margin-bottom: 10px;
        }

        .add-question-btn {
            margin-top: 10px;
        }

        .submit-btn {
            margin-top: 20px;
        }

        .custom-alert {
            position: relative;
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</html>
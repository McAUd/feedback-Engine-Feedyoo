<?php
session_start();
include('inc/config.php');
include('inc/checklog.php');
check_login(); // Assuming this function includes necessary checks
$userId = $_SESSION['userId'];

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure the question ID is provided in the URL
if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    // Check if the user is the owner of the question
    $ownership_query = "SELECT user_id, question FROM poll WHERE id = ?";
    $ownership_stmt = $mysqli->prepare($ownership_query);
    $ownership_stmt->bind_param("i", $question_id);
    $ownership_stmt->execute();
    $ownership_stmt->bind_result($question_owner, $question_text);
    $ownership_stmt->fetch();
    $ownership_stmt->close();

    // If the user is the owner, allow editing
    if ($question_owner == $userId) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Update the question
            $new_question_text = $_POST['new_question_text'];

            $update_query = "UPDATE poll SET question = ? WHERE id = ?";
            $update_stmt = $mysqli->prepare($update_query);
            $update_stmt->bind_param("si", $new_question_text, $question_id);

            if ($update_stmt->execute()) {
                // Redirect back to manage_polls
                header("Location: manage_polls");
                exit();
            } else {
                echo "Error updating question: " . $update_stmt->error;
            }

            $update_stmt->close();
        }

        // Display the form for editing the question
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
            <h5 class="card-title fw-semibold mb-4">Poll</h5>

            <h2>Edit poll</h2>
            <form method="post" action="">
                <label for="new_question_text">Question:</label>
                <textarea name="new_question_text" rows="4" required><?php echo $question_text; ?></textarea><br>
                <input type="submit" value="Update Poll">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "You don't have permission to edit this question.";
    }
} else {
    echo "Question ID not provided.";
}

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
<style>
        
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

</html>
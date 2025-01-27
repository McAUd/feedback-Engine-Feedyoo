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
            <h5 class="card-title fw-semibold mb-4">Poll HQ</h5>
            <p class="mb-0">create poll </p>
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

                       <center> <button class="btn btn-success btn-block submit-btn" type="submit">Create Poll</button></center>
                    </div>
                </form>
         


          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
        // Counter for dynamic question IDs
        let questionCount = 1;

        function addQuestion() {
            const questionsContainer = document.getElementById('questionsContainer');

            // Create a new question container
            const questionContainer = document.createElement('div');
            questionContainer.classList.add('question-container');

            // Create input field for the question
            const questionInput = document.createElement('input');
            questionInput.type = 'text';
            questionInput.name = `question_${questionCount}`;
            questionInput.placeholder = 'Enter your question';
            questionInput.classList.add('form-control');
            questionInput.required = true;

            // Append input field to the question container
            questionContainer.appendChild(questionInput);

            // Append the question container to the main container
            questionsContainer.appendChild(questionContainer);

            // Increment the question counter for unique IDs
            questionCount++;
        }
    </script>
    
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>
<style>
  
  </style>

</html>
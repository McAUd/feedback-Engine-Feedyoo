<?php
session_start();
include('inc/config.php');
include('inc/checklog.php');
check_login(); // Assuming this function includes necessary checks

$userId = $_SESSION['userId'];

// Assuming you have a valid database connection
$mysqli = new mysqli("fdb1034.atspace.me", "4441160_base", "(paI6E]jv5{xzyt", "4441160_base");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure the question ID is provided in the URL
if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    // Check if the user is the owner of the question
    $query = "SELECT user_id FROM poll WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->bind_result($question_owner);
    $stmt->fetch();
    $stmt->close();

    // If the user is the owner, delete the question
    if ($question_owner == $userId) {
        $delete_query = "DELETE FROM poll WHERE id = ?";
        $delete_stmt = $mysqli->prepare($delete_query);
        $delete_stmt->bind_param("i", $question_id);

        if ($delete_stmt->execute()) {
            // Redirect back to manage_questions
            header("Location: manage_polls");
            exit();
        } else {
            echo "Error deleting question: " . $delete_stmt->error;
        }

        $delete_stmt->close();
    } else {
        echo "You don't have permission to delete this question.";
    }
} else {
    echo "Question ID not provided.";
}

// Close connection
$mysqli->close();
?>

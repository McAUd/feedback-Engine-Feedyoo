<?php
session_start();
ob_start();
include('inc/config.php');


$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

// Check for empty email or password
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Please enter both email and password";
    header("Location: index");
    exit();
}

$query = "SELECT * FROM `user` WHERE email = '$email'";
$result_query = mysqli_query($con, $query);

if (!$result_query) {
    die('Query failed: ' . mysqli_error($con));
}

$count_query = mysqli_num_rows($result_query);

if ($count_query != 0) {
    $row = mysqli_fetch_array($result_query);
    $storedPasswordHash = $row['password'];

    // Verify password
    if (password_verify($password, $storedPasswordHash)) {
        // Password is correct
        $_SESSION['userId'] = $row['id']; // Use a consistent session variable name
        $_SESSION['login_user'] = $row['email'];
        header("Location: dashboard");
        exit();
    } else {
        // Incorrect password
        $_SESSION['login_error'] = "Incorrect Password Entered";
        header("Location: index");
        exit();
    }
} else {
    // User not found
    $_SESSION['login_error'] = "User not found";
    header("Location: index");
    exit();
}

ob_end_flush();
?>

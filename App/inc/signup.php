<?php
session_start();
ob_start();

require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Add validation and password hashing here if needed
    // Example validation: Ensure that the fields are not empty
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['signup_error'] = "Please fill in all fields";
    } else {
        // Check if the username already exists
        $check_username_query = "SELECT * FROM `user` WHERE username = '$username'";
        $check_email_query = "SELECT * FROM `user` WHERE email = '$email'";
        $username_result = mysqli_query($con, $check_username_query);
        $email_result = mysqli_query($con, $check_email_query);

        if (mysqli_num_rows($username_result) > 0) {
            $_SESSION['signup_error'] = "Username is already taken. Please choose a different username.";
        } elseif (mysqli_num_rows($email_result) > 0) {
            $_SESSION['signup_error'] = "Email is already registered. Please use a different email.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Set default profile picture URL
            $defaultProfilePic = 'img/default-profile-pic.png';

            // Insert the user into the database
            $query = "INSERT INTO `user` (username, email, password, profile_pic) VALUES ('$username', '$email', '$hashedPassword', '$defaultProfilePic')";
            $result = mysqli_query($con, $query);

            if (!$result) {
                $_SESSION['signup_error'] = "Error creating user";
            } else {
                $_SESSION['signup_success'] = "User registered successfully. You can now login.";
            }
        }
    }
    
    // Redirect back to the registration page after processing the form
    header("Location: ../register");
    exit();
}

ob_end_flush();
?>

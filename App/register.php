<?php
session_start();
ob_start();

require('inc/config.php');

// Handle form submission
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

            // Insert the user into the database
            $query = "INSERT INTO `user` (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
            $result = mysqli_query($con, $query);

            if (!$result) {
                $_SESSION['signup_error'] = "Error creating user";
            } else {
                $_SESSION['signup_success'] = "User registered successfully. You can now login.";
            }
        }
    }
    
    // Redirect back to the registration page after processing the form
    header("Location: register.php");
    exit();
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedyoo</title>
</head>
<body>
<div class="login-container">
<img  src="img/logo-icon.png" style="height: 90px;" class="logo" id="header-img">
<form action="inc/signup.php" method="POST" class="login-form">
    <p>Create an Account! It's simple..</p>
        <div class="register-container">
    
    <!-- Error Message -->
    <?php if(isset($_SESSION['signup_error'])): ?>
        <div class="alert alert-danger" role="alert"><?= $_SESSION['signup_error'] ?></div>
        <?php unset($_SESSION['signup_error']); ?>
    <?php endif; ?>

    <div class="input-group">
        <input type="text" id="username" title="Username" placeholder="Username" name="username" required>
    </div>

    <div class="input-group">
        <input type="email" id="email" title="Email" placeholder="Email" name="email" required>
    </div>

    <div class="input-group">
        <input type="password" id="password" title="Password" name="password" placeholder="Password" required>
    </div>

    <!-- Success Message -->
    <?php if(isset($_SESSION['signup_success'])): ?>
        <div class="alert alert-success" role="alert"><?= $_SESSION['signup_success'] ?></div>
        <?php unset($_SESSION['signup_success']); ?>
    <?php endif; ?>
                
    <button type="submit">Sign Up</button>

    <div class="bottom-text">
        <p>Already have an account? <a href="index">Log In</a></p>
            </div>
    </div>
</form>
</div>
</body>

<style>
  .alert {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    /* Reset CSS */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f2f2f2;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.login-container {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  padding: 40px;
  max-width: 400px;
  width: 90%;
  text-align: center;
  margin: 0 auto;
}

.login-form {
  display: flex;
  flex-direction: column;
}

.login-form h1 {
  margin-bottom: 10px;
  color: #333;
}

.login-form p {
  margin-bottom: 20px;
  color: #777;
}

.input-group {
  margin-bottom: 20px;
}

.input-group input {
  padding: 15px;
  border-radius: 8px;
  border: 1px solid #ddd;
  width: 100%;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.input-group input:focus {
  border-color: #007bff;
  outline: none;
}

button {
  padding: 15px;
  border: none;
  border-radius: 8px;
  background-color: #007bff;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}

.bottom-text {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
  color: #777;
}

.bottom-text p {
  margin-bottom: 10px;
}

.bottom-text a {
  color: #007bff;
  text-decoration: none;
  transition: color 0.3s ease;
}

.bottom-text a:hover {
  color: #0056b3;
}

/* Responsive */
@media screen and (max-width: 600px) {
  .login-container {
    width: 100%;
    border-radius: 0;
  }
}

</style>
</html>

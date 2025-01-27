<?php
session_start();
ob_start();
require('inc/config.php');

// Check if email and password are provided in the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check for empty email or password
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both email and password";
    } else {
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
            }
        } else {
            // User not found
            $_SESSION['login_error'] = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Your CSS links here -->
        <meta name="description" content="Feedyoo offers an easier way to collect and gather feedback online. With Feedyoo, you can streamline your feedback collection process and make it simple for your audience to share their opinions.">
  <meta name="keywords" content="Feedyoo, feedback, collect feedback, gather feedback, online feedback, opinion, survey, questionnaire">
  <meta name="author" content="feedyoo">

        
        <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
     
        
</head>
<body>
<div class="login-container">
    <img src="img/logo-icon.png" style="height: 90px;" class="logo" id="header-img">
    <form action="checklogin" method="POST" class="login-form">
        <p>Login to your account</p>

      
        <!-- Email Input -->
        <div class="input-group">
            <input type="email" id="email" title="Email" name="email" placeholder="Email" required>
        </div>

        <!-- Password Input -->
        <div class="input-group">
            <input type="password" id="password" title="Password" name="password" placeholder="Password" required>
        </div>
            
              <!-- Error Message -->
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']);
        }
        ?>


        <!-- Submit Button -->
        <button type="submit">Login</button>

        <!-- Bottom Text -->
        <div class="bottom-text">
            <p>Don't have an account? <a href="register">Sign Up</a></p>
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

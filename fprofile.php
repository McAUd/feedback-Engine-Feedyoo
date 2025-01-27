<?php
session_start();
include('inc/config.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedyoo</title>
    <link rel="stylesheet" href="styles.css">

    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <meta charset="utf-8">
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
     
    <title>Feedfy</title>
    <!-- Bootstrap Core CSS -->
    <link href="app/assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="app/assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="app/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="app/assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="app/css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="app/css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="app/css/colors/default.css" id="theme" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>


</head>

<body>
    <section class="masthead">
        <header id="header" class="header">
            <div class="container flex header-menu">
                <img  src="img/white.png" style="height: 90px;" class="logo" id="header-img">
            
                <nav>
                    <ul>
                        <li><a class="nav-link" href="home">home</a></li>
                        <li><a class="nav-link" href="#about">About</a></li>
                    </ul>
                </nav>
               
            </div>
        </header>

        <div class="flex justify-center">
    <div class="form-container">

    <?php
// Check if a username is provided in the URL
if (isset($_GET['username'])) {
    include('inc/config.php');

    $username = $_GET['username'];

    // Prepare and execute a query to retrieve user information based on the username
    $queryUser = "SELECT * FROM user WHERE username = ?";
    $stmtUser = $mysqli->prepare($queryUser);
    $stmtUser->bind_param('s', $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    // Check if the user exists
    if ($resultUser->num_rows > 0) {
        // Display the user details
        while ($rowUser = $resultUser->fetch_assoc()) {
            echo "<p class='user-info'><strong>From:</strong> " . htmlspecialchars($rowUser['username']) . "</p>";

            // Fetch and display questions from the poll table based on the user's id
            $userId = $rowUser['id'];

            $queryPoll = "SELECT id, question FROM poll WHERE user_id = ?";
            $stmtPoll = $mysqli->prepare($queryPoll);
            $stmtPoll->bind_param('i', $userId);
            $stmtPoll->execute();
            $resultPoll = $stmtPoll->get_result();

            // Check if there are questions for the user
            if ($resultPoll->num_rows > 0) {
                echo "<h2>Available Polls</h2>";
                while ($rowPoll = $resultPoll->fetch_assoc()) {
                    // Add a link to the poll page for each available poll with poll_id parameter
                    echo "<a href='app/feedback.php?poll_id=" . htmlspecialchars($rowPoll['id']) . "'>";
                    echo "<p><strong>Poll:</strong> " . htmlspecialchars($rowPoll['question']) . "</p>";
                    echo "</a>";
                    
                    // Add other details you want to display
                }
            } else {
                echo "<p>No poll found from this user.</p>";
            }

            // Close the statement for the poll query
            $stmtPoll->close();
        }
    } else {
        echo "<p>No user found with the username: " . htmlspecialchars($username) . "</p>";
    }

    // Close the statements and connection
    $stmtUser->close();
    $mysqli->close();
}
?>


        
</div>
            </div>


</body>
<style>
    
.user-info {
    color: #333;
    font-size: 16px;
    margin-bottom: 8px;
}


.powered-by {
    margin-top: 4rem;
    font-size: 14px;
    color: #888;
}

.powered-by a {
    color: #1e90ff;
    text-decoration: none;
    transition: color 0.3s;
}

.powered-by a:hover {
    color: #0c7cdf;
}


h5 {
    color: #000;
    font-size: large;
}
.flex {
    display: flex;
}

.justify-center {
    justify-content: center;
}




/* Cool CSS for the form container */
.form-container {
    background-color: #f8f9fa; /* Light gray background */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Shadow effect */
}

.user-info {
    font-size: 18px;
    color: #333; /* Dark text color */
    margin-bottom: 10px;
}

h2 {
    font-size: 24px;
    color: #007bff; /* Blue color for headers */
    margin-top: 20px;
    margin-bottom: 10px;
}

a {
    text-decoration: none;
    color: #007bff; /* Blue color for links */
    transition: color 0.3s ease;
}

a:hover {
    color: #0056b3; /* Darker shade of blue on hover */
}

p {
    font-size: 16px;
    color: #555; /* Gray text color */
    margin-bottom: 10px;
}

/* Form container styling */
.form-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    max-width: 400px; /* Adjust as needed */
    width: 100%;
    margin-top: 2rem; /* Adjust as needed */
}


@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

:root {
    --color-white: #F3F3F3;
    --color-black: #101010;
    --color-primary: rgb(37, 150, 190);
}

*,
*::before,
*::after {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    height: 100%;
    font-family: Inter, sans-serif;
    font-weight: 400;
}

h1 {
    margin: 0;
    line-height: 1.4;
    font-size: 32px;
}

h2 {
    margin: 0;
    line-height: 1.25;
    font-size: 28px;
}

p {
    margin: 0;
    line-height: 1.5;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.text-center {
    text-align: center;
}

.flex {
    display: flex;
}

.description {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}

.description p {
    max-width: 36rem;
    text-align: center;
    margin: 1rem 0;
}


/* Page */

.masthead {
    background-color: var(--color-primary);
    padding-bottom: 8rem;
    margin-bottom: 2rem;
    position: relative;
    color: var(--color-white);
}

.header {
    padding-top: 2rem;
}

.header-menu {
    justify-content: space-between;
    align-items: center;
}

@media (max-width: 640px) {
    .header-menu {
        flex-direction: column;
    }
}

.header-menu nav ul {
    display: flex;
    list-style: none;
    padding-left: 0;
}

.header-menu nav ul > li {
    margin: 0 1.25rem;
}

.header-menu nav ul > li a {
    text-decoration: none;
    color: var(--color-white);
}

.header-menu .header-cta {
    background-color: var(--color-white);
    color: var(--color-primary);
    text-decoration: none;
    padding: .625rem 1.25rem;
    border-radius: 4px;
}

.logo {
    font-weight: 600;
    margin: 0;
}

.masthead::after {
    content: '';
    display: block;
    width: 100%;
    height: 100px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1920' height='135.212' viewBox='0 0 1920 135.212'%3E%3Cpath id='Path_2' data-name='Path 2' d='M0,1070V979.431s287.752,78.186,927.752,0S1920,949.536,1920,949.536V1070Z' transform='translate(0 -934.788)' fill='%23fff'/%3E%3C/svg%3E");
    background-size: cover;
    background-repeat: no-repeat;
    position: absolute;
    bottom: 0;
}

.masthead .content {
    margin-top: 3rem;
}

@media (max-width: 640px) {
    .content-container {
        flex-direction: column;
    }
}

.masthead .left-column {
    position: relative;
}

@media (max-width: 640px) {
    .masthead .left-column .hero-img {
        text-align: center;
        margin-bottom: 2rem;
    }
}

.masthead .left-column .img-device {
    height: 30rem;
    object-fit: contain;
}

.masthead .right-column .hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    max-width: 70%;
    margin: 0 auto;
}

.hero-content p {
    margin-top: 1rem;
}

.app-btn {
  width: 50%;
  max-width: 160px;
  color: var(--color-white);
  margin: 20px 0;
  text-align: left;
  border-radius: 5px;
  text-decoration: none;
  font-size: 10px;
  text-transform: uppercase;
    background-color: var(--color-black);
  transition: background-color 0.25s linear;
    display: flex;
    justify-content: center;
    align-items: center;
}

.input-group {
    display: flex;
    justify-content: center;
}

footer {
    padding: 2rem 0;
}


</style>
</html>

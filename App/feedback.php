<?php
session_start();
include('inc/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if anonymous option is selected
    if (isset($_POST['anonymousName']) && isset($_POST['anonymousEmail'])) {
        $name = $_POST['anonymousName'];
        $email = $_POST['anonymousEmail'];
    } else {
        // If not anonymous, use the provided name and email
        $name = $_POST['name'];
        $email = $_POST['email'];
    }
    
    $feedback = $_POST['feedback'];
    $suggestions = $_POST['suggestions'];
    $pollId = $_POST['poll_id'];

    $stmt = mysqli_prepare($con, "INSERT INTO `feed` (`poll_id`, `name`, `email`, `feedback`, `suggestions`) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issss", $pollId, $name, $email, $feedback, $suggestions);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Thank You! Your feedback has been sent.";
        header("Location: ".$_SERVER['PHP_SELF']."?poll_id=".$pollId);
        exit();
    } else {
        $_SESSION['message'] = "Error recording feedback. Please try again. " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

$pollIdFromURL = isset($_GET['poll_id']) ? $_GET['poll_id'] : null;

$query = mysqli_query($con, "SELECT `question` FROM `poll` WHERE `id` = '$pollIdFromURL'");
$row = mysqli_fetch_assoc($query);
$question = isset($row['question']) ? $row['question'] : 'unknown Poll';

// Get message from session and unset it
$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedyoo</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <section class="masthead">
        <header id="header" class="header">
            <div class="container flex header-menu">
                <img  src="img/white.png" style="height: 90px;" class="logo" id="header-img">
            
                <nav>
                    <ul>
                        <li><a class="nav-link" href="https://feedyoo.xyz/home">Home</a></li>
                        <li><a class="nav-link" href="#about">About</a></li>
                    </ul>
                </nav>
               
            </div>
            <style>
        .message-container {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
        </header>
        <div class="flex justify-center">
        <div class="form-container">
        <?php if ($message): ?>
                <!-- Display the message on top of the form -->
                <div class="message-container">
                    <p><?php echo $message; ?></p>
                </div>
                <?php endif; ?>
    <?php
    // Fetch the user's profile picture
    $query = "SELECT profile_pic FROM `user` WHERE id = (SELECT user_id FROM poll WHERE id = $pollIdFromURL)";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
        $profilePic = $userData['profile_pic'];

        // Display the profile picture if available
        if ($profilePic) {
            echo '<div class="profile-pic-container">';
            echo '<img src="' . $profilePic . '" alt="User Profile Picture" class="user-profile-pic">';
            echo '</div>';
        } else {
            // Display the default profile picture
            echo '<div class="profile-pic-container">';
            echo '<img src="assets/images/default-profile-pic.png" alt="Default Profile Picture" class="user-profile-pic">';
            echo '</div>';
        }
    }
    ?>

    <p class="form-description">Your opinions matter. Unleash growth with dynamic feedback.</p>
    <form id="feedbackForm" action="feedback.php" method="post" onsubmit="return validateForm()">
    <?php if (!empty($question)): ?>
        <div class="form-group">
            <h5><?php echo $question; ?></h5>
        </div>
    <?php endif; ?>
    <div class="form-group" id="nameGroup">
        <input type="text" id="name" name="name" class="form-input" placeholder="Name" required>
    </div>
    <div class="form-group" id="emailGroup">
        <input type="email" id="email" name="email" class="form-input" placeholder="Email" required>
    </div>
    <!-- Hidden input fields to store anonymous values -->
    <input type="hidden" id="anonymousName" name="anonymousName" value="">
    <input type="hidden" id="anonymousEmail" name="anonymousEmail" value="">
    <!-- Original hidden input field for poll_id -->
    <input type="hidden" name="poll_id" value="<?php echo $pollIdFromURL; ?>">
    <div class="form-group">
        <textarea id="feedback" name="feedback" rows="4" class="form-input" placeholder="Feedback" required></textarea>
    </div>
    <div class="form-group">
        <textarea id="suggestions" name="suggestions" rows="4" class="form-input" placeholder="Suggestions" ></textarea>
    </div>
    <div class="form-buttons">
        <div class="form-group">
            <button type="submit" class="form-submit">Submit Feedback</button>
        </div>
        <div class="form-group">
            <button type="button" class="form-submit" id="stayAnonymous">Stay Anonymous</button>
        </div>
    </div>
    <br>
    <p class="text-center powered-by mt-4">Powered by <a href="#" target="_blank" class="text-indigo-600 hover:underline">Feedyoo</a></p>
</form>

<script>
function validateForm() {
    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    var anonymousNameInput = document.getElementById('anonymousName');
    var anonymousEmailInput = document.getElementById('anonymousEmail');
    var stayAnonymousButton = document.getElementById('stayAnonymous');
    
    // Check if the user has chosen to stay anonymous
    if (!stayAnonymousButton.classList.contains('anonymous-selected')) {
        // If not, ensure that name and email fields are filled
        if (nameInput.value.trim() === '' || emailInput.value.trim() === '') {
            alert('Please provide your name and email, or select Stay Anonymous.');
            return false; // Prevent form submission
        }
    }

    // Change input values to "anonymous" if the user has chosen to stay anonymous
    anonymousNameInput.value = stayAnonymousButton.classList.contains('anonymous-selected') ? 'anonymous' : nameInput.value;
    anonymousEmailInput.value = stayAnonymousButton.classList.contains('anonymous-selected') ? 'anonymous' : emailInput.value;

    return true; // Allow form submission
}

document.getElementById('stayAnonymous').addEventListener('click', function() {
    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    
    // Toggle anonymous class on the Stay Anonymous button
    this.classList.toggle('anonymous-selected');

    // If the user chooses to stay anonymous, clear name and email fields and disable them
    if (this.classList.contains('anonymous-selected')) {
        nameInput.value = '';
        emailInput.value = '';
        nameInput.disabled = true;
        emailInput.disabled = true;
    } else {
        // If the user changes their mind, enable the fields
        nameInput.disabled = false;
        emailInput.disabled = false;
    }
});
</script>

    </div>
</div>       </div>
    </section>
</body>

<style>

/* Additional CSS for styling the form buttons */
.form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.form-submit,
#stayAnonymous {
    flex: 1; /* Each button takes up equal width */
    margin-right: 10px; /* Adjust as needed for spacing between buttons */
    border-radius: 8px;
    padding: 12px 24px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.form-submit {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.form-submit:hover {
    background-color: #45a049;
}

#stayAnonymous {
    background-color: #f44336;
    color: white;
    border: none;
}

#stayAnonymous:hover {
    background-color: #d32f2f;
}
    


.profile-pic-container {
    text-align: center;
    margin-bottom: 20px;
}

.user-profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Make the image circular */
    border: 2px solid #ccc; /* Add a border */
    padding: 5px; /* Add some padding */
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

.container {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 1rem;
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
/* Form Styles */
.form-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.form-title {
    font-size: 24px;
    margin-bottom: 1.5rem;
    color: var(--color-primary);
}

.form-description {
    font-size: 16px;
    color: #555;
}

.form-input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}

.form-submit {
    background-color: var(--color-primary);
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 12px 20px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.form-submit:hover {
    background-color: #1e91d6;
}

.form-submit:active {
    background-color: #0e6ea0;
}

.submit-button {
    height: 2.375rem;
    padding: 0 1rem;
    border: none;
    background-color: var(--color-primary);
    color: var(--color-white);
    border-radius: 4px;
    cursor: pointer;
    margin-left: .75rem;
    transition: background-color .2s ease;
}

.submit-button:hover {
    background-color: #000000;
    margin-left: 1rem;
}

footer {
    padding: 2rem 0;
}


</style>
</html>

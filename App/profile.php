<?php
session_start();
include('inc/config.php');
include('inc/checklog.php');

check_login();

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    
    $query = "SELECT * FROM `user` WHERE id = $userId";
    $result = mysqli_query($con, $query);
    
    if (!$result) {
        die('Query failed: ' . mysqli_error($con));
    }
    
    if (mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $message = mysqli_real_escape_string($con, $_POST['message']);
            
            // Check if the selected username already exists
            $checkUsernameQuery = "SELECT * FROM `user` WHERE username = '$username' AND id != $userId";
            $checkUsernameResult = mysqli_query($con, $checkUsernameQuery);
            if (mysqli_num_rows($checkUsernameResult) > 0) {
                // Username already exists, set an error message
                $usernameError = "Username is already in use.";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $profilePic = null;
                if (isset($_POST['remove_profile_pic']) && $_POST['remove_profile_pic'] == '1') {
                    // User wants to remove profile picture, assign default profile picture
                    $profilePic = '../assets/images/default-profile-pic.png';
                } elseif ($_FILES['profile_pic']['name']) {
                    // User uploads a new profile picture
                    $profilePicName = $_FILES['profile_pic']['name'];
                    $profilePicTemp = $_FILES['profile_pic']['tmp_name'];
                    $profilePic = "uploads/" . $profilePicName;
                    move_uploaded_file($profilePicTemp, $profilePic);
                }
                
                $updateQuery = "UPDATE `user` SET username='$username', email='$email', password='$hashedPassword', message='$message'";
                if ($profilePic !== null) {
                    $updateQuery .= ", profile_pic='$profilePic'";
                }
                $updateQuery .= " WHERE id=$userId";
                
                if (mysqli_query($con, $updateQuery)) {
                    $_SESSION['success_message'] = "Profile updated successfully";
                    header("Location: profile");
                    exit;
                } else {
                    // Log the error and display a generic message
                    error_log("Error updating profile: " . mysqli_error($con));
                    $_SESSION['error_message'] = "username is arleady used.";
                    header("Location: profile");
                    exit;
                }
            }
        }
    } else {
        // Redirect the user or display a message indicating that the user was not found
        header("Location: 404");
        exit;
    }
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
            <h5 class="card-title fw-semibold mb-4">My Profile</h5>
            <p class="mb-0"></p>

         
            <?php
                                    if ($userData['profile_pic']) {
                                        // If the user has a profile picture, display it
                                        echo '<img src="' . $userData['profile_pic'] . '" class="img-circle" width="150" />';
                                    } else {
                                        // If the user doesn't have a profile picture, display a default placeholder
                                        echo '<img src="../assets/images/default-profile-pic.png" class="img-circle" width="150" />';
                                    }
                                    ?>
                                
                                    <h4 class="card-title m-t-10"><?php echo $userData['username']; ?></h4>
                                    <div class="col-lg-8 col-xlg-9 col-md-7">
                            <div class="card-body">
                                <!-- Your form starts here -->
                                <form class="form-horizontal form-material" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-md-12">Username</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Username" class="form-control form-control-line" name="username" value="<?php echo $userData['username']; ?>">
                                            <?php if(isset($usernameError)) { echo '<p class="text-danger">' . $usernameError . '</p>'; } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" placeholder="Email" class="form-control form-control-line" name="email" id="example-email" value="<?php echo $userData['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="Password" class="form-control form-control-line" name="password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" placeholder="Your message" class="form-control form-control-line" name="message"><?php echo $userData['message']; ?></textarea>
                                        </div>
                                    </div>                           <!-- Input field for profile photo upload -->
                                    <div class="form-group">
                                        <label class="col-md-12">Profile Photo</label>
                                        <div class="col-md-12">
                                            <input type="file" class="form-control form-control-line" name="profile_pic">
                                        </div>
                                    </div>
                                    <!-- Checkbox to remove profile picture -->
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" id="remove_profile_pic" name="remove_profile_pic" value="1">
                                            <label for="remove_profile_pic">Remove Profile Picture</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success">Update Profile</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            
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

</html>
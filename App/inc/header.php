  
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedyoo</title>
           <meta charset="utf-8">
  <meta name="description" content="Feedyoo offers an easier way to collect and gather feedback online. With Feedyoo, you can streamline your feedback collection process and make it simple for your audience to share their opinions.">
  <meta name="keywords" content="Feedyoo, feedback, collect feedback, gather feedback, online feedback, opinion, survey, questionnaire">
  <meta name="author" content="feedyoo">

        
        <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
<link rel="manifest" href="../img/site.webmanifest">
<link rel="mask-icon" href="../img/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
     
        
        
        
  <link rel="shortcut icon" type="image/png" href="../assets/images/logo-icon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 

</head>
  
  <!--  Header Start -->
  <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <?php 
      if (isset($_SESSION['login_user'])) {
          $userLoggedIn = $_SESSION['login_user'];
          $query = mysqli_query($con, "SELECT username, profile_pic FROM user WHERE email = '$userLoggedIn'");
          $row = mysqli_fetch_array($query);
          $username = $row['username'];
          $profilePic = $row['profile_pic'];
      
          // Check if the user has a profile picture
          if ($profilePic) {
              // If the user has a profile picture, display it
              echo '<li class="nav-item dropdown">
                      <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="' . $profilePic . '" alt="user" width="35" height="35" class="rounded-circle">
                      </a>
                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                          <div class="message-body">
                              <a href="profile" class="d-flex align-items-center gap-2 dropdown-item">
                                  <i class="bx bxs-user-circle bx-flashing"></i>
                                  <p class="mb-0 fs-3">My Profile</p>
                              </a>
                              <a href="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                          </div>
                      </div>
                  </li>';
          } else {
              // If the user doesn't have a profile picture, set the default profile picture and update the database
              $defaultProfilePic = 'assets/images/default-profile-pic.png';
              $queryUpdatePic = mysqli_query($con, "UPDATE user SET profile_pic = '$defaultProfilePic' WHERE email = '$userLoggedIn'");
      
              if ($queryUpdatePic) {
                  // Display the default profile picture
                  echo '<li class="nav-item dropdown">
                          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="' . $defaultProfilePic . '" alt="default-profile-pic" width="35" height="35" class="rounded-circle">
                          </a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                              <div class="message-body">
                                  <a href="profile" class="d-flex align-items-center gap-2 dropdown-item">
                                      <i class="bx bxs-user-circle bx-flashing"></i>
                                      <p class="mb-0 fs-3">My Profile</p>
                                  </a>
                                  <a href="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                              </div>
                          </div>
                      </li>';
              } else {
                  // Handle error if unable to update the database
                  echo "Error: Unable to update profile picture";
              }
          }
      }
      ?>
      
    </ul>
</div>

        </nav>
      </header>
      <!--  Header End -->
    
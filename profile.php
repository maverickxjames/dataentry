<?php
session_start();
$pageid=7;

// Include database connection
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM user_info WHERE user_id='$user_id'";
$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
if (!$user) {
    die("No user found with ID $user_id");
}

$wallet_amount = $user['wallet_amount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 5px;
            padding: 5px;
        }
        .containerr {
            width: 100%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header h2 {
            margin: 0;
        }
        .profile-info {
            display: flex;
            justify-content: center;
        }
        .profile-picture {
            margin-right: 20px;
            text-align: center;
        }
        .profile-picture img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .btn-change-photo,
        .btn-remove-photo {
            display: block;
            margin-top: 10px;
            background-color: #ddd;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .profile-details {
            position: relative;
            flex-grow: 1;
        }
        .profile-details label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .profile-details .field-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .profile-details input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex-grow: 1;
        }
        .profile-details .edit-icon {
            margin-left: 10px;
            cursor: pointer;
            color: #777;
        }
        .btn-save {
            display: inline-block;
            width: 32%;
            background-color: #28a745; /* Change this to green */
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            width: 150px; /* Adjust width as needed */
        }
        .button-container {
            display: flex;
            gap: 10px; /* Adjust the gap value as needed */
        }
        .btn-home {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
        }
        .btn-logout {
            background-color: #d92618;
            color: white;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
            float: right;
            margin-top: 0;
            text-decoration: none; /* Remove underline */
        }
        .btn-change-password {
            display: inline-block;
            width: auto;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
        }
        .btn-home {
            background-color: #3498db;
            margin-right: 2%;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
            text-decoration: none; /* Remove underline */
        }
        .btn-change-password {
            background-color: #e67e22;
            width: 100%;
        }
        .password-fields {
            display: none;
            margin-top: 20px;
        }
        .password-toggle {
            cursor: pointer;
            color: #777;
            margin-left: 10px;
        }
        .model1 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .model1-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        .model1-content img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 5px;
            cursor: pointer;
        }
         /* Your existing CSS */
        .disabled-field {
            background-color: #f0f0f0; /* Light grey background */
            border: 1px solid #ddd; /* Light grey border */
            color: #999; /* Light grey text color */
            cursor: not-allowed; /* Cursor indicating no action */
        }
        .edit-icon {
            cursor: pointer; /* Ensure pencil icon is clickable */
            color: #777; /* Color for the pencil icon */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="#">
          <div class="wallet">
            <i class="fas fa-wallet wallet-icon"></i>
            <span class="right badge badge-info right">$<?php echo htmlspecialchars(number_format($wallet_amount, 2)); ?></span>
          </div>
        </a>
      </li> 
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include('./sidebar.php') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        
        <div class="card-body">
        <div class="containerr">
        <div class="profile-header">
            <h2>My Profile</h2>
            <div class="button-container">
                <a href="home" class="btn-home">Home</a>
                <a href="login/logout" class="btn-logout">Logout</a>
            </div>
        </div>
        <div class="profile-info">
            <div class="profile-picture">
                <img src="user_pic/<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" id="profile_pic1">
                <button class="btn-change-photo" onclick="openModal()">Change Photo</button>
            </div>
            <div class="profile-details">
                <label for="wallet_amount">Wallet Balance</label>
                <div class="field-container">
                    <input type="text" id="wallet_amount" name="wallet_amount" value="<?php echo htmlspecialchars($user['wallet_amount']); ?>" disabled>
                </div>
                <form id="profileForm" action="update_profile.php" method="POST" onsubmit="removeDisabledFields()">
                    <label for="user_id">User ID</label>
                    <div class="field-container">
                        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" disabled>
                    </div>
                    <label for="username">Username</label>
                    <div class="field-container">
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="disabled-field">
                        <span class="edit-icon" onclick="confirmEdit('username')">&#9998;</span>
                    </div>
                    <label for="email">Email</label>
                    <div class="field-container">
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email_id']); ?>" class="disabled-field">
                        <span class="edit-icon" onclick="confirmEdit('email')">&#9998;</span>
                    </div>
                    <label for="phone">Phone Number</label>
                    <div class="field-container">
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_no']); ?>" class="disabled-field">
                        <span class="edit-icon" onclick="confirmEdit('phone')">&#9998;</span>
                    </div>
                    <input type="hidden" id="selectedProfilePic1" name="profile_pic" value="<?php echo htmlspecialchars($user['profile_pic']); ?>">
                    <button type="button" class="btn-change-password" onclick="togglePasswordFields()">Change Password</button>
                    <div class="password-fields">
                        <label for="current_password">Current Password</label>
                        <div class="field-container">
                            <input type="password" id="current_password" name="current_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('current_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <label for="new_password">New Password</label>
                        <div class="field-container">
                            <input type="password" id="new_password" name="new_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('new_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="field-container">
                            <input type="password" id="confirm_password" name="confirm_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('confirm_password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for Profile Picture Selection -->
    
   
        </div>
        <!-- /.card-body -->
        <!-- <div class="card-footer">
          Footer
        </div> -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div id="profileModal1" class="model1">
        <div class="model1-content">
            <?php
            $dir = 'user_pic/';
            $images = array_diff(scandir($dir), array('..', '.'));

            foreach ($images as $image) {
                echo "<img src='$dir$image' onclick='selectPhoto(\"$image\")'>";
            }
            ?>
        </div>
    </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>

function openModal() {
    document.getElementById("profileModal1").style.display = "flex";
}

function closeModal() {
    document.getElementById("profileModal1").style.display = "none";
}

function selectPhoto(image) {
    console.log(image);
    document.getElementById("selectedProfilePic1").value = image;
    document.getElementById("profile_pic1").src = "user_pic/" + image;
    closeModal();
}


function togglePasswordFields() {
    const passwordFields = document.querySelector('.password-fields');
    passwordFields.style.display = passwordFields.style.display === 'block' ? 'none' : 'block';
}

function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const passwordToggle = passwordField.nextElementSibling.firstElementChild;
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordToggle.classList.remove('fa-eye');
        passwordToggle.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordToggle.classList.remove('fa-eye-slash');
        passwordToggle.classList.add('fa-eye');
    }
}



function confirmEdit(fieldId) {
    // Disable all other input fields
    document.querySelectorAll('.field-container input').forEach(input => {
        if (input.id !== fieldId) {
            input.disabled = true;
            input.classList.add('disabled-field');
        }
    });

    // Enable the selected input field
    const field = document.getElementById(fieldId);
    field.classList.remove('disabled-field');
    field.disabled = false;
}

function removeDisabledFields() {
    document.querySelectorAll('.field-container input').forEach(input => {
        if (input.disabled) {
            input.removeAttribute('name'); // Remove the name attribute to prevent it from being submitted
        }
    });
}
</script>
<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
</body>
</html>

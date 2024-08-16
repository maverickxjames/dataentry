<?php
session_start();
$pageid=1;

// Include database connection
include('db.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login');
    exit;
}

// Fetch contact message details
$msg_sql = "SELECT `s.no`, `date`, `username`, `email_id`, `phone_no`, `msg`, `status` FROM contact_msg WHERE user_id='$user_id'";
$msg_result = mysqli_query($conn, $msg_sql);

if (!$msg_result) {
    die("Error fetching contact message details: " . mysqli_error($conn));
}

$messages = [];
while ($msg_row = mysqli_fetch_assoc($msg_result)) {
    $messages[] = $msg_row;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminPod | messages </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <style>
    .navbar .wallet {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }
    
    .wallet-icon {
        margin-right: 5px;
    }

    /* // Maintenance page styles */

    .maintenance {
    background-image: url(https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-1.jpg);
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: scroll;
    background-size: cover;
}

.maintenance {
    width: 100%;
    height: 100%;
    min-height: 100vh;
}

.maintenance {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
}

.maintenance_contain {
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    width: 100%;  
    padding: 15px;  
}
.maintenance_contain img {
    width: auto;
    max-width: 100%;
}
.pp-infobox-title-prefix {
    font-weight: 500;
    font-size: 20px;
    color: #000000;
    margin-top: 30px;
    text-align: center;
}

.pp-infobox-title-prefix {
    font-family: sans-serif;
}

.pp-infobox-title {
    color: #000000;
    font-family: sans-serif;
    font-weight: 700;
    font-size: 40px;
    margin-top: 10px;
    margin-bottom: 10px;
    text-align: center;
    display: block;
    word-break: break-word;  
}

.pp-infobox-description {
    color: #000000;
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-size: 18px;
    margin-top: 0px;
    margin-bottom: 0px;
    text-align: center;
}

.pp-infobox-description p {
    margin: 0;
}

.title-text.pp-primary-title {
    color: #000000;
    padding-top: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    padding-right: 0px;
    font-family: sans-serif;
    font-weight: 500;
    font-size: 18px;
    line-height: 1.4;
    margin-top: 50px;
    margin-bottom: 0px;
}

.pp-social-icon {
    margin-left: 10px;
    margin-right: 10px;
    display: inline-block;
    line-height: 0;
    margin-bottom: 10px;
    margin-top: 10px;
    text-align: center;
}

.pp-social-icon a {
    display: inline-block;
    height: 40px;
    width: 40px;
}

.pp-social-icon a i {
    border-radius: 100px;
    font-size: 20px;
    height: 40px;
    width: 40px;
    line-height: 40px;
    text-align: center;
}

.pp-social-icon:nth-child(1) a i {
    color: #4b76bd;
}
.pp-social-icon:nth-child(1) a i {
    border: 2px solid #4b76bd;
}
.pp-social-icon:nth-child(2) a i {
    color: #00c6ff;
}
.pp-social-icon:nth-child(2) a i {
    border: 2px solid #00c6ff;
}
.pp-social-icon:nth-child(3) a i {
    color: #fb5245;
}
.pp-social-icon:nth-child(3) a i {
    border: 2px solid #fb5245;
}
.pp-social-icon:nth-child(4) a i {
    color: #158acb;
}
.pp-social-icon:nth-child(4) a i {
    border: 2px solid #158acb;
}

.pp-social-icons {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    justify-content: center;
}
</style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
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

<?php include('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">messages </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">messages </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- User Info Section -->
            <div class="col-lg-6">
                <h2>User Information</h2>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email_id']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone_no']); ?></p>
                <p><strong>Join Date:</strong> <?php echo htmlspecialchars($user['join_date']); ?></p>
                <p><strong>Wallet Amount:</strong> $<?php echo htmlspecialchars(number_format($wallet_amount, 2)); ?></p>
            </div>

            <!-- Contact Messages Section -->
            <div class="col-lg-6">
                <h2>Contact Messages</h2>
                <?php if (empty($messages)): ?>
                    <p>No contact messages found.</p>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Email ID</th>
                                <th>Phone No</th>
                                <th>Message</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($msg['s.no']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['date']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['username']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email_id']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['phone_no']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['msg']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminPod.io">AdminPod.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>
</body>
</html>

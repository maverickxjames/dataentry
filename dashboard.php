<?php
session_start();
$pageid=1;

// Include database connection
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

$wallet_amount = 0;
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminPod | Dashboard </title>

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
  <?php include_once('navbar.php') ?>
  <!-- /.navbar -->

<?php include('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="maintenance">
  <div class="maintenance_contain">
    <img src="https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-vector.png" alt="maintenance">
    <span class="pp-infobox-title-prefix">WE ARE COMING SOON</span>
    <div class="pp-infobox-title-wrapper">
		  <h3 class="pp-infobox-title">This Page under maintenance!</h3>
	  </div> 
  <div class="pp-infobox-description">
		<p>Someone has kidnapped our site. We are negotiation ransom and<br>will resolve this issue in 6 hours</p>			</div>    
    <span class="title-text pp-primary-title">We are social</span>
    <div class="pp-social-icons pp-social-icons-center pp-responsive-center">
	<span class="pp-social-icon">
		<link itemprop="url" href="#">
		<a itemprop="sameAs" href="#" target="_blank" title="Facebook" aria-label="Facebook" role="button">
			<i class="fa fa-facebook"></i>
		</a>
	</span>
	<span class="pp-social-icon">
		<link itemprop="url" href="#">
		<a itemprop="sameAs" href="#" target="_blank" title="Twitter" aria-label="Twitter" role="button">
			<i class="fa fa-twitter"></i>
		</a>
	</span>
	<span class="pp-social-icon">
		<link itemprop="url" href="#">
		<a itemprop="sameAs" href="#" target="_blank" title="Google Plus" aria-label="Google Plus" role="button">
			<i class="fa fa-google-plus"></i>
		</a>
	</span>
	<span class="pp-social-icon">
		<a itemprop="sameAs" href="#" target="_blank" title="LinkedIn" aria-label="LinkedIn" role="button">
			<i class="fa fa-linkedin"></i>
		</a>
	</span>
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

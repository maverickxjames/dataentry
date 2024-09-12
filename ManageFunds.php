<?php
session_start();
ob_start();
$pageid=9;

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

  <title>AdminPod | Manage Funds</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <style>
    .navbar .wallet {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }
    
    .wallet-icon {
        margin-right: 5px;
    }

    /* main css */
    body {
        font-family: 'Source Sans Pro', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
  

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="submit"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }
    .breadcrumb-item a {
        color: #007bff;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
  </style>
</head>
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
            <h1 class="m-0 text-dark">Manage Funds</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container">
      <h2>Transaction Form</h2>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          include 'db.php'; // Include your database connection file

          $user_id = $_POST['user_id'];
          $work_id = $_POST['work_id'];
          $amount = $_POST['amount'];

          // Generate random alphanumeric transaction ID
          $transection_id = generateRandomString();

          // Set the current date and time
          $date = date('Y-m-d H:i:s');

          // Set a default status value
          $status = 'success'; // Change this to the desired default status

          // Insert into the transactions table
          $sql = "INSERT INTO transections (user_id, work_id, date, transection_id, amount, status) VALUES (?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssssss", $user_id, $work_id, $date, $transection_id, $amount, $status);

          if ($stmt->execute()) {
              $_SESSION['message'] = "New transaction inserted successfully";
              $_SESSION['msg_type'] = "success";
          } else {
              $_SESSION['message'] = "Error: " . $stmt->error;
              $_SESSION['msg_type'] = "error";
          }

          $stmt->close();
          $conn->close();

          // Redirect to the same page to avoid resubmission
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
      }

      // Function to generate a random alphanumeric string
      function generateRandomString($length = 10) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
      }

      // Display the message if it exists
      if (isset($_SESSION['message'])): ?>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  let messageType = "<?php echo $_SESSION['msg_type']; ?>";
                  let message = "<?php echo $_SESSION['message']; ?>";

                  if (messageType === "success") {
                      Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: message,
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: message,
                      });
                  }
              });
          </script>
          <?php
          unset($_SESSION['message']);
          unset($_SESSION['msg_type']);
          ?>
      <?php endif; ?>

      <form method="post" action="">
          <label for="user_id">User ID:</label>
          <input type="text" id="user_id" name="user_id" required><br><br>
          <label for="work_id">Work ID:</label>
          <input type="text" id="work_id" name="work_id" required><br><br>
          <label for="amount">Amount:</label>
          <input type="text" id="amount" name="amount" required><br><br>
          <input type="submit" value="Submit">
      </form>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminPod.io">AdminPod.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.1
    </div>
  </footer> -->
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


<?php
ob_end_flush(); ?>


</body>
</html>

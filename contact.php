<?php
session_start();
$pageid = 11;

// Include database connection
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/");
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

if(isset($_POST['send'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
    } else {
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $last_name = mysqli_real_escape_string($conn, $last_name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $message = mysqli_real_escape_string($conn, $message);
        
        $status = 'unread';

        $sql = "INSERT INTO contact_msg (date,userid, username, email_id, phone_no, msg, status) 
                VALUES (NOW(),'$user_id', '$first_name $last_name', '$email', '$phone', '$message', '$status')";
        
        if (mysqli_query($conn, $sql)) {
            $status =  "sent";
        } else {
          $status = "error";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}




?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminPod | Dashboard </title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .containerr {
            display: flex;
            width: 100%;
            /* margin: 50px auto; */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 0 15px;
        }

        .contact-info {
            flex: 1;
            position: relative;
            background: url('contact-bg.jpg') no-repeat center center;
            background-size: cover;
            padding: 40px;
            color: #fff;
            display: flex;
            align-items: center;
            left:-16px;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .contact-info .info-container {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .contact-info .info {
            margin-bottom: 30px;
        }

        .contact-info h4 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #fff;
        }

        .contact-info p {
            margin: 0;
            font-size: 16px;
            color: #bfbfbf;
        }

        .contact-info a {
            color: #28a745;
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-info a:hover,
        .contact-info a:active {
            color: #fff;
        }

        .contact-form {
            flex: 1.5;
            padding: 40px;
            background-color: #fff;
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form .form-group.full-width {
            width: 100%;
        }

        .contact-form .form-group input,
        .contact-form .form-group textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .contact-form .form-group input {
            width: calc(100% - 22px);
        }

        .contact-form .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .contact-form .name-group {
            display: flex;
            justify-content: space-between;
        }

        .contact-form .name-group input {
            width: calc(50% - 10px);
            margin-right: 10px;
        }

        .contact-form .name-group input:last-child {
            margin-right: 0;
        }

        .contact-form textarea {
            height: 100px;
            resize: none;
        }

        .contact-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-form button:hover {
            background-color: #218838;
        }

        /* Animation */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes underline {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        .char {
            display: inline-block;
            opacity: 0;
            animation: fadeIn 0.7s forwards;
        }

        .space {
            margin-right: 0.2em;
        }

        .underline {
            display: inline-block;
            position: relative;
            font-weight: bold;
        }

        .underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 2px;
            width: 100%;
            background-color: currentColor;
            animation: underline 0.7s forwards;
        }
        /* for wallet icon */
       .navbar .wallet {
           display: flex;
           align-items: center;
           margin-right: 10px;
       }
       
       .wallet-icon {
           margin-right: 5px;
       }

       @media (max-width: 768px) {
           .containerr{
                flex-direction: column;
           }
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
            <h1 class="m-0 text-dark">Help</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Help</li>
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
          <div class="col-lg-12">
            <div class="card">
            <main>
<?php
if (isset($status)) {
    if ($status === "sent") {
        ?>
        <script>
          swal.fire({
            title: 'Message Sent',
            text: 'Your message has been sent successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
          });
        </script>
        <?php 
    } elseif ($status === "error") {
        ?>
        <script>
          swal.fire({
            title: 'Error',
            text: 'There was an error sending your message. Please try again later.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        </script>
        <?php
    }
}
?>

    <div class="containerr">
        <div class="contact-info">
            <div class="info-container">
                <div class="info">
                    <h1 id="get-in-touch"></h1>
                </div>
                <div class="info">
                    <h4>Call Support</h4>
                    <p><a href="tel:+918239954479">+91 8239954479</a></p>
                </div>
                <div class="info">
                    <h4>Whatsapp Support</h4>
                    <p><a href="https://wa.me/918239954479?text=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services." class="whatsapp-link">+91 8239954479</a></p>
                </div>
                <div class="info">
                    <h4>Email Support</h4>
                    <p><a href="mailto:contact@example.com?subject=Inquiry">contact@example.com</a></p>
                </div>
                <div class="info">
                    <h4>Address</h4>
                    <p>Riddhi Siddhi Data Solutions*1-CH-15, Opposit Brijwasi Misthan Bhandar, Dadabari, Kota, Rajasthan-324009</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <h2>Send Us A Message</h2>
            <form method="post">
                <div class="form-group full-width">
                    <label for="name">TELL US YOUR NAME *</label>
                    <div class="name-group">
                        <input type="text" name="first_name" placeholder="First name" required>
                        <input type="text" name="last_name" placeholder="Last name" required>
                    </div>
                </div>
                <div class="form-group full-width">
                    <label for="email">ENTER YOUR EMAIL *</label>
                    <input type="email" name="email" placeholder="Eg. example@email.com" required>
                </div>
                <div class="form-group full-width">
                    <label for="phone">ENTER PHONE NUMBER</label>
                    <input type="text" name="phone" placeholder="Eg. +1 800 000000">
                </div>
                <div class="form-group full-width">
                    <label for="message">MESSAGE *</label>
                    <textarea name="message" placeholder="Write us a message" required></textarea>
                </div>
                <button type="submit" name="send">SEND MESSAGE</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const getInTouchText = "Get In Touch";
            const getInTouchContainer = document.getElementById('get-in-touch');

            function createSpans(text, container, startDelay) {
                Array.from(text).forEach((char, index) => {
                    const span = document.createElement('span');
                    span.className = 'char underline';
                    if (char === ' ') {
                        span.classList.add('space');
                    }
                    span.style.animationDelay = `${startDelay + index * 0.1}s`;
                    span.textContent = char;
                    container.appendChild(span);
                });
            }

            function animateText() {
                getInTouchContainer.innerHTML = '';
                createSpans(getInTouchText, getInTouchContainer, 0);
            }

            animateText();

            setInterval(animateText, getInTouchText.length * 100 + 2000); // Reduced repeat time
        });
    </script>
</main>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
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

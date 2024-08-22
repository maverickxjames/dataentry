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
$workid = $_GET['task'];

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
  <title>AdminLTE 3 | Blank Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <style>
        .dataTables_filter {
      float: right;
      text-align: right;
    }

    .dataTables_filter label {
      display: flex;
      align-items: center;
      justify-content: flex-end;
    }

    .dataTables_filter label input {
      margin-left: 5px;
    }

    .dataTables_paginate {
      float: right;
      text-align: right;
    }

    table th {
      background-color: #34495e;
      color: white;
    }

    .btn-group, .btn-group-vertical{
        margin: 0 0 10px 0;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar.php') ?>
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
            <h1>Task Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Task Report</li>
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
        <main>
        <div >
            <?php
           

            // Fetch data from the active_task table
            $sql = "SELECT user_id, created_at, work_id, pdf_id, status FROM active_task WHERE user_id = '$user_id' AND work_id = '$workid'";
            $result = mysqli_query($conn, $sql);

            $tasks = [];

            while ($row = $result->fetch_assoc()) {
                if($row['status'] != 'submitted') {
                    exit("Task not submitted yet");
                }
                $tasks[] = $row;
            }

            foreach ($tasks as $task) {
                echo "<div>";
                echo "<p>Work ID: " . htmlspecialchars($task['work_id']) . "</p>";
                echo "</div>";

                // Fetch data from the data_entry table based on work_id
                $sql = "SELECT * FROM data_entry WHERE work_id = '$workid' AND user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);

                echo "<div>";
                echo "<table id='example1' class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>S.No.</th>"; // Serial Number Header
                echo "<th>Column 1</th>";
                echo "<th>Column 2</th>";
                echo "<th>Column 3</th>";
                echo "<th>Column 4</th>";
                echo "<th>Column 5</th>";
                echo "<th>Column 6</th>";
                echo "<th>Column 7</th>";
                echo "<th>Column 8</th>";
                echo "<th>Column 9</th>";
                echo "<th>Column 10</th>";
                echo "<th>Column 11</th>";
                echo "<th>Column 12</th>";
                echo "<th>Column 13</th>";
                echo "<th>Column 14</th>";
                echo "<th>Column 15</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $serial_number = 1; // Initialize serial number

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='background-color: #34495e;color: white;'>" . $serial_number . "</td>"; // Greyish background for serial number
                        for ($i = 1; $i <= 15; $i++) {
                            echo "<td>" . htmlspecialchars($row['col_' . $i]) . "</td>";
                        }
                        echo "</tr>";
                        $serial_number++; // Increment serial number
                    }
                } else {
                    echo "<tr><td colspan='15'>No data available</td></tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";

                echo "<p>Status: " . htmlspecialchars($task['status']) . "</p>";
                echo "<br>";
            }

            $conn->close();
            ?>
        </div>
    </main>
        </div>
        <!-- /.card-body -->
       
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
   $(function() {
  $("#example1").DataTable({
    "responsive": false,
    "lengthChange": true,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": false,
  });
});
</script>
</body>
</html>

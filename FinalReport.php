<?php
session_start();
$pageid = 2;
$user_type = $_SESSION['user_type'];
$uid = $_SESSION['user_id'];

// Include database connection
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login/.php");
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
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>TASK LIST | Dashboard 3</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
  </script>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .navbar .wallet {
      display: flex;
      align-items: center;
      margin-right: 10px;
    }

    .wallet-icon {
      margin-right: 5px;
    }

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

    <?php
    include('sidebar.php')
    ?>

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
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sr. No</th>
                        <th>Task ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      if ($user_type == 'user') {
                        $query = "SELECT * FROM active_task WHERE status = 'completed' AND user_id = '$uid' ORDER BY id DESC";
                        $run = mysqli_query($conn, $query);
                        while ($data = mysqli_fetch_assoc($run)) {
                      ?>
                          <tr>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['work_id'] ?></td>
                            <td><?= $data['created_at'] ?></td>
                            <td>
                              <?php

                              if ($data['status'] == 'pending') {
                              ?>
                                <p>Start</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'working') {
                          ?>
                            <p>Still Working</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'submitted') {
                          ?>
                            <p>Work Submitted need to be review</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'completed') {
                          ?>
                            <p>Work Done Successfully</p>
                            </td>
                          <?php
                              }
                          ?>
                          </td>
                          <td>
                            <input id="taskid" type="hidden" name="task" value="<?= $data['work_id'] ?>">
                            <?php
                            if ($data['status'] == 'pending') {
                            ?>
                              <button class="btn btn-primary" onclick="start()">Start</button>
                          </td>
                        <?php
                            } elseif ($data['status'] == 'working') {
                        ?>
                          <button class="btn btn-danger" disabled>Working</button></td>
                        <?php
                            } elseif ($data['status'] == 'submitted') {
                        ?>
                          <button onclick="window.location.href='./reports?task=<?= $data['work_id'] ?>'" class="btn btn-warning">Review Task</button></td>
                        <?php
                            } elseif ($data['status'] == 'completed') {
                        ?>
                          <button class="btn btn-success" disabled>Completed</button></td>
                        <?php
                            }
                        ?>
                        </td>
                          </tr>
                        <?php
                        }
                      }

                      if ($user_type == 'admin') {
                        $query = "SELECT * FROM active_task ORDER BY id DESC";
                        $run = mysqli_query($conn, $query);
                        while ($data = mysqli_fetch_assoc($run)) {
                        ?>
                          <tr>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['work_id'] ?></td>
                            <td><?= $data['created_at'] ?></td>
                            <td>
                              <?php

                              if ($data['status'] == 'pending') {
                              ?>
                                <p>Start</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'working') {
                          ?>
                            <p>Still Working</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'submitted') {
                          ?>
                            <p>Work Submitted need to be review</p>
                            </td>
                          <?php
                              } elseif ($data['status'] == 'completed') {
                          ?>
                            <p>Work Done Successfully</p>
                            </td>
                          <?php
                              }
                          ?>
                          </td>
                          <td>
                            <input id="taskid" type="hidden" name="task" value="<?= $data['work_id'] ?>">
                            <?php
                            if ($data['status'] == 'pending') {
                            ?>
                              <button class="btn btn-primary" onclick="start()">Start</button>
                          </td>
                        <?php
                            } elseif ($data['status'] == 'working') {
                        ?>
                          <button class="btn btn-danger" disabled>Working</button></td>
                        <?php
                            } elseif ($data['status'] == 'submitted') {
                        ?>
                          <button onclick="window.location.href='./reports?task=<?= $data['work_id'] ?>'" class="btn btn-warning">Review Task</button></td>
                        <?php
                            } elseif ($data['status'] == 'completed') {
                        ?>
                          <button class="btn btn-success" disabled>Completed</button></td>
                        <?php
                            }
                        ?>
                        </td>
                          </tr>
                      <?php
                        }
                      }




                      ?>

                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
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

  <!-- OPTIONAL SCRIPTS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/pages/dashboard3.js"></script>
  <script>
    // function start(){



    //     var formData = {
    //                 task: $("#taskid").val()
    //             };

    //     $.ajax({
    //                 type: "POST",
    //                 url: "startTask.php",
    //                 data: formData,
    //                 dataType: "json",
    //                 encode: true,
    //             }).done(function(data) {
    //                 $("#response").html(data.message);
    //             }).fail(function(jqXHR, textStatus) {
    //                 $("#response").html("Request failed: " + textStatus);
    //             });

    //             swal("Success", "Task Started Succesfully", "success", {
    //       button: "OK",
    //     }).then(()=> {
    //       location.reload();
    //     });


    // }


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
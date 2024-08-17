<?php
include 'db.php';
session_start();
$pageid = 3;

if (isset($_POST['submit'])) {
  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('pdf', 'xlsx');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 10000000) {
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = './uploads/' . $fileNameNew; // Adjusted folder path
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
          $pdf_id = uniqid();
          $update_status = 'pending'; // Default status
          $sql = "INSERT INTO files (pdf_id, file_name, file_type, file_path, created_at, updated_at, update_status) VALUES (?, ?, ?, ?, NOW(), NOW(), ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sssss", $pdf_id, $fileName, $fileActualExt, $fileDestination, $update_status);
          if ($stmt->execute()) {
            header("Location: upload?uploadsuccess=1");
          } else {
            echo "There was an error uploading your file!";
          }
        } else {
          echo "There was an error moving your file!";
        }
      } else {
        echo "Your file is too big!";
      }
    } else {
      echo "There was an error uploading your file!";
    }
  } else {
    echo "You cannot upload files of this type!";
  }
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Assing Task | Dashboard 3</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
  </script>
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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



    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 28px;
    }

    .select2-container {
      width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
      background-color: #fff;
      border: 1px solid #aaa;
      border-radius: 4px;
      height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px;
      position: absolute;
      top: 1px;
      right: 1px;
      width: 20px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      border-color: #888 transparent transparent transparent;
      border-style: solid;
      border-width: 5px 4px 0 4px;
      height: 0;
      left: 50%;
      margin-left: -4px;
      margin-top: -2px;
      position: absolute;
      top: 50%;
      width: 0;
    }

    .select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear {
      float: left;
    }

    .select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow {
      left: 1px;
      right: auto;
    }

    .select2-container--default.select2-container--disabled .select2-selection--single {
      background-color: #f9f9f9;
      cursor: default;
    }

    .select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear {
      display: none;
    }

    .select2-container--default.select2-container--open.select2-container--above .select2-selection--single .select2-selection__arrow b {
      border-color: transparent transparent #888 transparent;
      border-width: 0 4px 5px 4px;
    }

    .select2-container--default.select2-container--open.select2-container--below .select2-selection--single .select2-selection__arrow b {
      border-color: #888 transparent transparent transparent;
      border-width: 5px 4px 0 4px;
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
  <?php
    include('sidebar.php');
    ?>
    <!-- Navbar -->
    <?php include_once('navbar.php') ?>
    <!-- /.navbar -->

    

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

      <div class="content">

        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                
                <br>
                
                  <form action="upload" method="post" enctype="multipart/form-data">
                  <div class="form-group container">
                  <!-- <label for="customFile">Custom File</label> -->
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="file" id="fileInput" required><br><br>
                      <input type="text" class="form-control" id="fileNameField" readonly value="No File Selected">
                      <label class="custom-file-label" for="fileInput">Choose file</label>
                    </div>
                    <div class="col-md-3">
                      <input class="btn btn-success" type="submit" value="Upload File" name="submit" style="margin-top: 30px;">
                    </div>
                  

                </div>
                <div class="form-group">
                  </div>
                  </form>

              </div>
            </div>
          </div>
        </div>

      </div>

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
                        <th>Sl. No</th>
                        <th>File Type</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>PDF ID</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $fetch = "SELECT * FROM files";
                      $result = mysqli_query($conn, $fetch);
                      if ($result->num_rows > 0) {
                        $sl_no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                          $icon = '';
                          $btn = '';
                          if ($row['file_type'] == 'pdf') {
                            $icon = '<img src="https://cdn-icons-png.flaticon.com/512/3143/3143500.png" width="60" alt="PDF Icon" class="icon">';
                           
                          } elseif ($row['file_type'] == 'xlsx') {
                            $icon = '<img src="https://cdn-icons-png.flaticon.com/512/15465/15465638.png" width="60" alt="Excel Icon" class="icon">';
  
                          }

                          if($row['update_status'] == 'pending') {
                            $btn = '<button class="btn btn-warning">Upload</button>';
                          } elseif($row['update_status'] == 'success') {
                            $btn = '<button class="btn btn-success">Uploaded</button>';
                          } elseif($row['update_status'] == 'failed') {
                            $btn = '<button class="btn btn-danger">Failed</button>';
                          }
                          echo '<tr>
                            <td>' . $sl_no++ . '</td>
                            <td>' . $icon . '</td>
                            <td><a href="' . $row['file_path'] . '" target="_blank" class="file-link">' . $row['file_name'] . '</a></td>
                            <td>' . $row['created_at'] . '</td>
                            <td>' . $row['pdf_id'] . '</td>
                            <td>' . $row['update_status'] . '</td>
                            <td>'.$btn.'</td>
                        </tr>';
                        }
                      } else {
                        echo "<tr><td colspan='6'>No files found.</td></tr>";
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
    $(document).ready(function() {
      $('.select').select2();
    });

    const fileInput = document.getElementById('fileInput');
const fileNameField = document.getElementById('fileNameField');

fileInput.addEventListener('change', function() {
    fileNameField.value = this.files[0].name;
});

  </script>

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": false,
        "scrollX": true, 
        "lengthChange": true,
        "autoWidth": true,
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
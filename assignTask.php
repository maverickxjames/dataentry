<?php 
session_start();
$pageid=2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Assing Task | Dashboard 3</title>
  <script src=
"https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
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
 include('sidebar.php') 
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
                <th>Assign User</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = "SELECT * FROM active_task WHERE status = 'pending' ORDER BY id DESC";
            $run = mysqli_query($conn, $query);
            $id = 1;
            while($data = mysqli_fetch_assoc($run)){
                ?>
                <tr>
                    <td><?=$id ?></td>
                    <td><?=$data['work_id'] ?></td>
                    <td><?=$data['created_at'] ?></td>
                    <td>
                        <?php 
                        if($data['user_id'] == null || $data['username'] == null){
                           ?>
                           <select name="assign<?=$id ?>" class="select form-control">
                            <option value="">Select User</option>
                            <?php 
                            $query1 = "SELECT * FROM user_info";
                            $run1 = mysqli_query($conn, $query1);
                            while($data1 = mysqli_fetch_assoc($run1)){
                                ?>
                                <option value="<?=$data1['user_id'] ?>"><?=$data1['username'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                           <?php 
                        } else {
                            echo $data['username'] . " (ID: " . $data['user_id'] . ")";
                        }
                        ?>
                        
                    </td>
                    <td>
                        <input type="hidden" name="work_id<?=$id?>" value="<?=$data['work_id'] ?>">
                        <?php 
                        if($data['user_id'] == "" || $data['username'] == ""){
                            ?>
                            <button class="btn btn-primary" onclick="assignTask(<?=$id?>)">Assign</button>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-success">Assigned</button>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $id++;
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

function assignTask(id) {
            var formData = {
                task: $("select[name=assign" + id + "]").val(),
                work_id: $("input[name=work_id" + id + "]").val()
            };

            $.ajax({
                type: "POST",
                url: "assignTasks",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function(data) {
                $("#response").html(data.message);
            }).fail(function(jqXHR, textStatus) {
                $("#response").html("Request failed: " + textStatus);
            });

            swal("Success", "Task Assigned", "success", {
                button: "OK",
            }).then(() => {
                location.reload();
            });
        }



  $(document).ready(function() {
    $('.select').select2();
  });
</script>

<script>




$(function () {
    $("#example1").DataTable({
      "responsive": false, "scrollX": true, "lengthChange": true, "autoWidth": false,
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

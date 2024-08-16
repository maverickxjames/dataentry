<?php
session_start();
$pageid=1;

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
  <title>AdminLTE 3 | Blank Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file for styling -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
    -webkit-touch-callout: none; /* Disable callout, e.g., on iOS */
    -webkit-user-select: none;   /* Disable selection */
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
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
            <h1>Work</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Work Page</li>
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

<?php

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];
// Fetch fixed data from the database
$sql = "SELECT col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13, col14, col15 FROM fixed_data";
$result = $conn->query($sql);

$fixed_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fixed_data[] = $row;
    }
}



if (isset($_POST['SAVE_DRAFT'])) {
    $work_id = $_POST['work_id'];
    $user_id = $_POST['user_id'];
    // $date = $_POST['date'];
    $col1 = $_POST['col1'];
    $col2 = $_POST['col2'];
    $col3 = $_POST['col3'];
    $col4 = $_POST['col4'];
    $col5 = $_POST['col5'];
    $col6 = $_POST['col6'];
    $col7 = $_POST['col7'];
    $col8 = $_POST['col8'];
    $col9 = $_POST['col9'];
    $col10 = $_POST['col10'];
    $col11 = $_POST['col11'];
    $col12 = $_POST['col12'];
    $col13 = $_POST['col13'];
    $col14 = $_POST['col14'];
    $col15 = $_POST['col15'];
    $status = $_POST['status'];

    $sql = "INSERT INTO data_entry (work_id, user_id, col_1, col_2, col_3, col_4, col_5, col_6, col_7, col_8, col_9, col_10, col_11,col_12, col_13, col_14, col_15, status) VALUES ('$work_id', '$user_id', '$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8', '$col9', '$col10', '$col11', '$col12', '$col13', '$col14', '$col15','working')";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            Swal.fire({
                title: 'Data Saved',
                text: 'Data saved successfully',
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        </script>
        <?php
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['FINAL_SUBMIT'])) {
    $work_id = $_POST['work_id'];
    $user_id = $_POST['user_id'];

    $query = "UPDATE active_task SET status = 'submitted' WHERE work_id = '$work_id' AND user_id = '$user_id'";
    if ($conn->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<div class="container">
    <h3 style="text-align: left;color:red">Task ID :
        <?php
        if (isset($_GET['task'])) {
            echo $_GET['task'];
        } else {
            echo "No task selected";
        }
        ?>
    </h3>
    <h6 style="text-align: left;">
        <?php
        if (isset($_GET['task'])) {
            $task_id = $_GET['task'];
            $getWork = "SELECT * FROM active_task WHERE work_id = '$task_id' AND user_id = '$user_id' ";
            $runWork = mysqli_fetch_assoc(mysqli_query($conn, $getWork));

            if ($runWork == '') {
                echo "No task found";
            } else {
                echo "Task Started on : " . $runWork['created_at'];
                echo "<br>";
                echo "Last updated on : " . $runWork['updated_at'];
            }
        } else {
            echo "No task selected";
        }
        ?>
    </h6>
    <div class="fixed-data">
        <table>
            <?php
            foreach ($fixed_data as $row) {
            ?>
                <tr>
                    <td><span><?= $row['col1'] ?></span></td>
                    <td><span><?= $row['col2'] ?></span></td>
                    <td><span><?= $row['col3'] ?></span></td>
                    <td><span><?= $row['col4'] ?></span></td>
                    <td><span><?= $row['col5'] ?></span></td>
                    <td><span><?= $row['col6'] ?></span></td>
                    <td><span><?= $row['col7'] ?></span></td>
                    <td><span><?= $row['col8'] ?></span></td>
                    <td><span><?= $row['col9'] ?></span></td>
                    <td><span><?= $row['col10'] ?></span></td>
                    <td><span><?= $row['col11'] ?></span></td>
                    <td><span><?= $row['col12'] ?></span></td>
                    <td><span><?= $row['col13'] ?></span></td>
                    <td><span><?= $row['col14'] ?></span></td>
                    <td><span><?= $row['col15'] ?></span></td>
                </tr>
            <?php
            }
            ?>

        </table>

    </div>
    <br>
    <hr>
    <div class="col-xxl-12 col-md-12 col-sm-12">
        <div class="">
            <div class="">
                <div class="table-data">
                    <div class="col-md-12 row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">

                            <?php
                            if (isset($_GET['task'])) {
                                $task_id = $_GET['task'];
                                $getWork = "SELECT * FROM active_task WHERE work_id = '$task_id' AND user_id = '$user_id' ";
                                $runWork = mysqli_fetch_assoc(mysqli_query($conn, $getWork));

                                if ($runWork == '') {
                            ?>
                                    <div class="card">
                                        <center>
                                            <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Something Went Wrong</h3>
                                        </center>
                                    </div>
                                <?php
                                } elseif ($runWork['status'] == 'working') {
                                ?>
                                    <form id="form" action="" method="post" class="p-3 ">
                                        <div class="card">
                                            <center>
                                                <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Enter data</h3>
                                            </center>
                                        </div>
                                        <div class="card">
                                            <p>Column 1</p>
                                            <input type="text" name="col1" id="col1" class="form-control" placeholder="Column 1">
                                        </div>

                                        <div class="card">
                                            <p>Column 2</p>
                                            <input type="text" name="col2" id="col2" class="form-control" placeholder="Column 2">

                                        </div>
                                        <div class="card">
                                            <p>Column 3</p>
                                            <input type="text" name="col3" id="col3" class="form-control" placeholder="Column 3">
                                        </div>
                                        <div class="card">
                                            <p>Column 4</p>
                                            <input type="text" name="col4" id="col4" class="form-control" placeholder="Column 4">
                                        </div>
                                        <div class="card">
                                            <p>Column 5</p>
                                            <input type="text" name="col5" id="col5" class="form-control" placeholder="Column 5">
                                        </div>
                                        <div class="card">
                                            <p>Column 6</p>
                                            <input type="text" name="col6" id="col6" class="form-control" placeholder="Column 6">
                                        </div>
                                        <div class="card">
                                            <p>Column 7</p>
                                            <input type="text" name="col7" id="col7" class="form-control" placeholder="Column 7">
                                        </div>
                                        <div class="card">
                                            <p>Column 8</p>
                                            <input type="text" name="col8" id="col8" class="form-control" placeholder="Column 8">
                                        </div>
                                        <div class="card">
                                            <p>Column 9</p>
                                            <input type="text" name="col9" id="col9" class="form-control" placeholder="Column 9">
                                        </div>
                                        <div class="card">
                                            <p>Column 10</p>
                                            <input type="text" name="col10" id="col10" class="form-control" placeholder="Column 10">
                                        </div>
                                        <div class="card">
                                            <p>Column 11</p>
                                            <input type="text" name="col11" id="col11" class="form-control" placeholder="Column 11">
                                        </div>
                                        <div class="card">
                                            <p>Column 12</p>
                                            <input type="text" name="col12" id="col12" class="form-control" placeholder="Column 12">
                                        </div>
                                        <div class="card">
                                            <p>Column 13</p>
                                            <input type="text" name="col13" id="col13" class="form-control" placeholder="Column 13">
                                        </div>
                                        <div class="card">
                                            <p>Column 14</p>
                                            <input type="text" name="col14" id="col14" class="form-control" placeholder="Column 14">
                                        </div>
                                        <div class="card">
                                            <p>Column 15</p>
                                            <input type="text" name="col15" id="col15" class="form-control" placeholder="Column 15">
                                            <input type="hidden" name="status" value="pending">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            <input type="hidden" name="work_id" value="<?= $_GET['task'] ?>">
                                            <!-- <input type="hidden" name="date" value="w001"> -->
                                        </div>

                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card p-2">
                <center>
                    <input type="submit" name="lastEntry" value="View Last Entry" class="btn btn-danger">
                    <input type="reset" id="reset" value="" style="display: none;">
                    <input type="button" value="CLEAR DATA" class="btn btn-secondary" onclick="clearForm()">
                    <input type="submit" name="SAVE_DRAFT" id="save" value="" style="display: none;">
                    <input type="button" value="Save & Next" class="btn btn-warning" onclick="saveNext()">
                    <input id="final_submit" type="submit" style="display: none;" name="FINAL_SUBMIT">
                    </form>
                    <button onclick="final_submit()" class="btn btn-success">FINAL SUBMIT</button>
                </center>
            </div>
            
        <?php
                                } elseif ($runWork['status'] == 'submitted') {
        ?>
            <div class="card">
                <center>
                    <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Final Submitted Done</h3>
                </center>
            </div>
        <?php
                                }
        ?>

    <?php
                            } else {
    ?>
        <div class="card">
            <center>
                <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Something Went Wrong</h3>
            </center>
        </div>
    <?php
                            }
    ?>






        </div>
    </div><!-- End Sales Card -->

    <script>

        function saveNext(){
            swal.fire({
                title: 'Are you sure?',
                text: "You want to save this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("save").click();
                }
            });
        }


        function clearForm() {
            swal.fire({
                title: 'Are you sure?',
                text: "You want to clear this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("reset").click();
                }
            });
        }

        function final_submit(){
            swal.fire({
                title: 'Are you sure?',
                text: "You want to submit this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("final_submit").click();
                }
            });
        }




        document.addEventListener('DOMContentLoaded', function() {
// Disable paste and show error message
document.querySelectorAll('input, textarea').forEach(function(element) {
element.onpaste = function(e) {
    e.preventDefault();
    alert('Pasting is disabled!');
};
});

// Disable CTRL + V and show error message
document.addEventListener('keydown', function(e) {
if (e.ctrlKey && e.key === 'v') {
    e.preventDefault();
    alert('Pasting is disabled!');
}
});
});



document.addEventListener('contextmenu', function(e) {
e.preventDefault();
});

document.addEventListener('keydown', function(e) {
// Disable F12, CTRL + SHIFT + I, and CTRL + U
if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I') || (e.ctrlKey && e.key === 'U')) {
e.preventDefault();
}
});

    </script>

</main>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
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
</body>
</html>

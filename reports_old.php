<?php
include('header.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];
$workid = $_GET['task'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    <style>
    
    </style>
</head>
<body>
   
    <main>
        <div class="container">
            <?php
            include 'db.php';

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
                        echo "<td style='background-color: #f0f0f0;'>" . $serial_number . "</td>"; // Greyish background for serial number
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
    <script src="plugins/jquery/jquery.min.js"></script>

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

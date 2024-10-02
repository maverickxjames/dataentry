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
        /* Ensure consistent styling for the table columns */
        table th, table td {
            text-align: center;
            vertical-align: middle;
            padding: 8px; /* Add some padding for better spacing */
        }
        table th:first-child, table td:first-child {
            width: 80px; /* Adjust width if needed */
            background-color: #f0f0f0; /* Greyish background color for S.No. column */
        }
        table th {
            background-color: #f8f9fa; /* Light background color for headers */
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternate row background color */
        }
    </style>
</head>
<body>
   
    <main>
        <div class="container">
            <h1>Raw Data | Today</h1>
            <?php
            include 'db.php';

            // Fetch data from the active_task table
            $sql = "SELECT user_id, created_at, work_id, pdf_id, status FROM active_task WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $tasks = [];

            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }

            foreach ($tasks as $task) {
                echo "<div>";
                echo "<p>User ID: " . htmlspecialchars($task['user_id']) . "</p>";
                echo "<p>Date: " . htmlspecialchars($task['created_at']) . "</p>";
                echo "<p>Work ID: " . htmlspecialchars($task['work_id']) . "</p>";
                echo "<p>PDF ID: " . htmlspecialchars($task['pdf_id']) . "</p>";
                echo "</div>";

                // Fetch data from the data_entry table based on work_id
                $sql = "SELECT * FROM data_entry WHERE work_id = ? AND user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $task['work_id'], $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                

                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
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
</body>
</html>

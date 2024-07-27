<?php include('header.php'); 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
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

    <script>
        function saveForm() {
            // Add JavaScript logic for saving form data here
            document.getElementById('myForm').submit(); // Example: submit form
        }
    </script>
</head>
<body>
   
    <main>
        <div class="container">
            <h1>Raw Data | Today</h1>
            <div class="fixed-data">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th> <!-- Serial Number Header -->
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                            <th>Column 4</th>
                            <th>Column 5</th>
                            <th>Column 6</th>
                            <th>Column 7</th>
                            <th>Column 8</th>
                            <th>Column 9</th>
                            <th>Column 10</th>
                            <th>Column 11</th>
                            <th>Column 12</th>
                            <th>Column 13</th>
                            <th>Column 14</th>
                            <th>Column 15</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include 'db.php';

                    // Fetch fixed data from the database
                    $sql = "SELECT col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13, col14, col15 FROM fixed_data";
                    $result = $conn->query($sql);

                    $serial_number = 1; // Initialize serial number

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='background-color: #f0f0f0;'>" . $serial_number . "</td>"; // Greyish background for serial number
                            foreach ($row as $value) {
                                echo "<td>" . htmlspecialchars($value) . "</td>";
                            }
                            echo "</tr>";
                            $serial_number++; // Increment serial number
                        }
                    } else {
                        echo "<tr><td colspan='15'>No data available</td></tr>";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </main>
</body>
</html>

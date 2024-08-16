<?php
// Start the session at the very beginning of the file
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
    <style>
        /* Basic styles for the menu */
        .navbar {
            background-color: #333;
            padding: 10px 20px;
        }

        .nav-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-list li {
            display: inline;
            margin-right: 10px;
        }

        .nav-list li a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
        }

        .nav-list li a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar">
        <ul class="nav-list">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="index.php">Start Working</a></li>
            <li><a href="profile.php">Profile</a></li> <!-- Profile contains the user data with amount -->
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="task.php">Task History</a></li>
            <li><a href="reports.php">Final Reports</a></li>
            <li><a href="about.php">About</a></li>
            
            <?php
            // Check if user is logged in
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="login/logout">Logout</a></li>';
            } else {
                echo '<li><a href="login/login">Login</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
</body>
</html>

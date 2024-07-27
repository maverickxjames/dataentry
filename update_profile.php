<?php
session_start();

// Include database connection
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "User is not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    
    // Check if form fields are set
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['phone'])) {
        echo "All fields are required.";
        exit();
    }

    // Retrieve and sanitize form data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    // Validate the data
    if (empty($username) || empty($email) || empty($phone)) {
        echo "All fields are required.";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Prepare and execute SQL statement
    $sql = "UPDATE user_info SET username=?, email_id=?, phone_no=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $username, $email, $phone, $user_id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Profile updated successfully!";
            } else {
                echo "No changes were made.";
            }
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login");
    exit();
}

$user_id = $_SESSION['user_id'];
$errors = [];

// Process profile picture update
if (isset($_POST['profile_pic'])) {
    $profile_pic = mysqli_real_escape_string($conn, $_POST['profile_pic']);
    $sql = "UPDATE user_info SET profile_pic='$profile_pic' WHERE user_id='$user_id'";
    if (!mysqli_query($conn, $sql)) {
        $errors[] = "Failed to update profile picture.";
    }
}

// Handle other profile details update
$update_user_sql = "UPDATE user_info SET ";

// Build update SQL query based on non-empty POST values
$fields_to_update = [];

if (!empty($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fields_to_update[] = "username='$username'";
}

if (!empty($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fields_to_update[] = "email_id='$email'";
}

if (!empty($_POST['phone'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $fields_to_update[] = "phone_no='$phone'";
}

// If there are fields to update, proceed with the SQL query
if (!empty($fields_to_update)) {
    $update_user_sql .= implode(', ', $fields_to_update) . " WHERE user_id='$user_id'";

    if (!mysqli_query($conn, $update_user_sql)) {
        $errors[] = "Failed to update user details.";
    }
}

// Handle password change
if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Verify current password
    $sql = "SELECT password FROM user_info WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE user_info SET password='$new_password_hashed' WHERE user_id='$user_id'";
            if (!mysqli_query($conn, $sql)) {
                $errors[] = "Failed to update password.";
            }
        } else {
            $errors[] = "New password and confirm password do not match.";
        }
    } else {
        $errors[] = "Current password is incorrect.";
    }
}

// Redirect to profile page with success or error messages
$_SESSION['errors'] = $errors;
header("Location: profile");
exit();
?>

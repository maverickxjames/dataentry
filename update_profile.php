<!DOCTYPE html>
<html>
<head>
<title>Profile Update</title>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
</script>

</head>
<body>
    
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
        ?>
        <script>
            swal("Error", "All Fields Required", "error", {
                button: "Go Back",

}).then(() => {
    window.location = "profile.php";
});
        </script>
        <?php 
        exit();
    }

    // Retrieve and sanitize form data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    // Validate the data
    if (empty($username) || empty($email) || empty($phone)) {
        ?>
        <script>
            swal("Error", "All Fields Required", "error", {
                button: "Go Back",

}).then(() => {
    window.location = "profile.php";
});
        </script>
        <?php 
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ?>
        <script>
            swal("Error", "Invalid Email Format", "error", {
                button: "Go Back",

}).then(() => {
    window.location = "profile.php";
});
        </script>
        <?php 
        exit();
    }

    // Prepare and execute SQL statement
    $sql = "UPDATE user_info SET username='$username', email_id='$email', phone_no='$phone' WHERE user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            swal("Success", "Profile Updated Successfully", "success", {
	button: "Go Back",

	}).then(() => {
        window.location = "profile.php";
    });
        </script>
        <?php 
    } else {
        ?>
        <script>
            swal("Error", "<?=$conn->error ?>", "error", {
                button: "Go Back",

}).then(() => {
    window.location = "profile.php";
});
        </script>
        <?php 
       
    }

    $conn->close();
} else {
    ?>
        <script>
            swal("Error", "Invalid Request Method", "error", {
                button: "Go Back",

}).then(() => {
    window.location = "profile.php";
});
        </script>
        <?php 
}
?>


</body>
</html>

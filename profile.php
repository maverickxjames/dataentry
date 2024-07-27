<?php
session_start();

// Include database connection
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM user_info WHERE user_id='$user_id'";
$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
if (!$user) {
    die("No user found with ID $user_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 5px;
            padding: 5px;
        }
        .container {
            width: 60%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .profile-header h2 {
            margin: 0;
        }
        .profile-info {
            display: flex;
            justify-content: center;
        }
        .profile-picture {
            margin-right: 20px;
            text-align: center;
        }
        .profile-picture img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .btn-change-photo,
        .btn-remove-photo {
            display: block;
            margin-top: 10px;
            background-color: #ddd;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .profile-details {
            position: relative;
            flex-grow: 1;
        }
        .profile-details label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .profile-details .field-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .profile-details input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex-grow: 1;
        }
        .profile-details .edit-icon {
            margin-left: 10px;
            cursor: pointer;
            color: #777;
        }
        .btn-save {
            display: inline-block;
            width: 32%;
            background-color: #28a745; /* Change this to green */
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            width: 150px; /* Adjust width as needed */
          
        }

        .button-container {
            display: flex;
            gap: 10px; /* Adjust the gap value as needed */
        }
        
        .btn-home {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
         }

        .btn-logout {
            background-color: #d92618;
            color: white;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
            float: right;
            margin-top: 0;
            text-decoration: none; /* Remove underline */
         }

        .btn-change-password {
            display: inline-block;
            width: auto;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
        }
        .btn-home {
            background-color: #3498db;
            margin-right: 2%;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: auto; /* Adjust width as needed */
            /* margin-right: 10px; Add margin to separate from the Logout button */
            text-decoration: none; /* Remove underline */
        }
        
        .btn-change-password {
            background-color: #e67e22;
            width: 100%;
        }
        .password-fields {
            display: none;
            margin-top: 20px;
        }
        .password-toggle {
            cursor: pointer;
            color: #777;
            margin-left: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h2>My Profile</h2>
            <div class="button-container">
                <a href="home.php" class="btn-home">Home</a>
                <a href="login/logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        <div class="profile-info">
            <div class="profile-picture">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Picture">
                <button class="btn-change-photo">Change Photo</button>
                <button class="btn-remove-photo">Remove</button>
            </div>
            <div class="profile-details">
                <label for="wallet_amount">Wallet Balance</label>
                <div class="field-container">
                    <input type="text" id="wallet_amount" name="wallet_amount" value="<?php echo htmlspecialchars($user['wallet_amount']); ?>" disabled>
                </div>
                <form id="profileForm" action="update_profile.php" method="POST">
                    <label for="user_id">User ID</label>
                    <div class="field-container">
                        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" disabled>
                    </div>
                    <label for="username">Username</label>
                    <div class="field-container">
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <span class="edit-icon">&#9998;</span>
                    </div>
                    <label for="email">Email</label>
                    <div class="field-container">
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email_id']); ?>">
                        <span class="edit-icon">&#9998;</span>
                    </div>
                    <label for="phone">Phone Number</label>
                    <div class="field-container">
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_no']); ?>">
                        <span class="edit-icon">&#9998;</span>
                    </div>
                    <button type="button" class="btn-change-password" onclick="togglePasswordFields()">Change Password</button>
                    <div class="password-fields">
                        <label for="current_password">Current Password</label>
                        <div class="field-container">
                            <input type="password" id="current_password" name="current_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('current_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <label for="new_password">New Password</label>
                        <div class="field-container">
                            <input type="password" id="new_password" name="new_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('new_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="field-container">
                            <input type="password" id="confirm_password" name="confirm_password">
                            <span class="password-toggle" onclick="togglePasswordVisibility('confirm_password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = field.nextElementSibling.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.querySelectorAll('.edit-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                var input = this.previousElementSibling;
                input.disabled = !input.disabled;
                if (!input.disabled) {
                    input.focus();
                }
            });
        });

        document.querySelector('.btn-save').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to save the changes?')) {
                document.getElementById('profileForm').submit();
            }
        });

        function togglePasswordFields() {
            var passwordFields = document.querySelector('.password-fields');
            passwordFields.style.display = passwordFields.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>

<?php
session_start();
// $_SESSION['user_id'] = $fetched_user_id;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dataentry";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    try {
        $username = $_POST['username'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

        // Ensure wallet_amount is set to a default value
        $wallet_amount = 0.00;

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO `user_info` (`user_id`, `join_date`, `username`, `phone_no`, `email_id`, `pass`, `wallet_amount`) VALUES (NULL, NOW(), :username, :phone_number, :email, :password, :wallet_amount)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':wallet_amount', $wallet_amount, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Registration successful
            $_SESSION['success_message'] = "Registration successful. You can now login.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Registration failed. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    try {
        $identifier = $_POST['username']; // This can be username, email, phone number, or user ID
        $password = $_POST['password'];

        // Retrieve user from database based on identifier
        $stmt = $conn->prepare("SELECT * FROM `user_info` WHERE `username` = :identifier OR `email_id` = :identifier OR `phone_no` = :identifier OR `user_id` = :identifier");
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $user['pass'];

            if (password_verify($password, $stored_password)) {
                // Login successful
                $_SESSION['user_id'] = $user['user_id'];
                header("Location: ../index.php"); // Redirect to dashboard or home page
                exit();
            } else {
                $_SESSION['error_message'] = "Incorrect password.";
            }
        } else {
            $_SESSION['error_message'] = "User not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("https://images.unsplash.com/photo-1485470733090-0aae1788d5af?q=80&w=1517&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .form-container {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container .btn {
            width: 100%;
            padding: 10px;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        .success-message {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-form {
            display: block; /* Initially show login form */
        }
        .registration-form {
            display: none; /* Initially hide registration form */
        }
        .input-group .form-control {
            border-right: 0;
        }
        .input-group .btn {
            border-left: 0;
            padding: 0 10px;
            font-size: 0.9rem;
        }
        .input-group .btn i {
            font-size: 1rem;
        }
        .password-toggle {
            cursor: pointer;
            color: #777;
            margin-left: -30px;
            margin-top: 10px;
        }

        .input-group-append{
            position: absolute;
    right: 10px;
    top: 8px;
    z-index: 100;
        }
        .input-group-append button{
            border: none;
        }
        .input-group-append button:focus{
            border: none;
        }

       
        @media (max-width: 576px) {
            .form-container {
                width: 100%;
                height: 30%;
                padding: 10px;
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
    <script>
        function showRegistrationForm() {
            var loginForm = document.getElementById("loginForm");
            var registrationForm = document.getElementById("registrationForm");

            loginForm.style.display = "none";
            registrationForm.style.display = "block";
        }

        function showLoginForm() {
            var loginForm = document.getElementById("loginForm");
            var registrationForm = document.getElementById("registrationForm");

            loginForm.style.display = "block";
            registrationForm.style.display = "none";
        }

        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var eyeIcon = document.getElementById("eyeIcon" + inputId.charAt(0).toUpperCase() + inputId.slice(1));

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<body>
    <div class="form-container">
        <div id="loginForm" class="login-form">
            <h2>User Login</h2>

            <!-- Login Form -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username, Email, Phone Number, or User ID" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Password" required>
                        <div class="input-group-append">
                            <button class="btn" type="button" onclick="togglePassword('loginPassword')">
                                <i class="fa fa-eye" id="eyeIconLoginPassword"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="login">Login</button>
            </form>

            <!-- Error Messages -->
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="error-message">
                    <?php echo $_SESSION['error_message']; ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <!-- Register Link -->
            <div class="register-link">
                <p>Don't have an account? <a href="#" onclick="showRegistrationForm()">Register here</a></p>
            </div>
        </div>

        <!-- Registration Form -->
        <div id="registrationForm" class="registration-form">
            <h2>User Registration</h2>

            <!-- Registration Form -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Password" required>
                        <div class="input-group-append">
                            <button class="btn" type="button" onclick="togglePassword('registerPassword')">
                                <i class="fa fa-eye" id="eyeIconRegisterPassword"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="register">Register</button>
            </form>

            <!-- Success/Error Messages -->
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="success-message">
                    <?php echo $_SESSION['success_message']; ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Login Link -->
            <div class="register-link">
                <p>Already have an account? <a href="#" onclick="showLoginForm()">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

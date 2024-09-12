<!DOCTYPE html>
<html>
<head>
    <title>Transaction Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 320px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
            
        }
    </style>
</head>
<body>
  <div class="container">
    <h2>Transaction Form</h2>
    <?php
    session_start(); // Start the session

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db.php'; // Include your database connection file

        $user_id = $_POST['user_id'];
        $work_id = $_POST['work_id'];
        $amount = $_POST['amount'];

        // Generate random alphanumeric transaction ID
        $transection_id = generateRandomString();

        // Set the current date and time
        $date = date('Y-m-d H:i:s');

        // Set a default status value
        $status = 'success'; // Change this to the desired default status

        // Insert into the transactions table
        $sql = "INSERT INTO transections (user_id, work_id, date, transection_id, amount, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $user_id, $work_id, $date, $transection_id, $amount, $status);

        if ($stmt->execute()) {
            $_SESSION['message'] = "New transaction inserted successfully";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['msg_type'] = "error";
        }

        $stmt->close();
        $conn->close();

        // Redirect to the same page to avoid resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Function to generate a random alphanumeric string
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Display the message if it exists
    if (isset($_SESSION['message'])): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let messageType = "<?php echo $_SESSION['msg_type']; ?>";
                let message = "<?php echo $_SESSION['message']; ?>";

                if (messageType === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                }
            });
        </script>
        <?php
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
        ?>
    <?php endif; ?>

    <form method="post" action="">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br><br>
        <label for="work_id">Work ID:</label>
        <input type="text" id="work_id" name="work_id" required><br><br>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

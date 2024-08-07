<!DOCTYPE html>
<html>
<head>
    <title>Transaction Form</title>
</head>
<body>
    <h2>Transaction Form</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db.php'; // Include your database connection file

        $user_id = $_POST['user_id'];
        $amount = $_POST['amount'];

        // Generate random alphanumeric transaction ID
        $transection_id = generateRandomString();


        // Set a default status value
        $status = 'success'; // Change this to the desired default status

        // Insert into the transections table
        $sql = "INSERT INTO transections (user_id, date, transection_id, amount, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $user_id, $date, $transection_id, $amount, $status);

        if ($stmt->execute()) {
            echo "New transaction inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
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
    ?>

    <form method="post" action="">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br><br>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

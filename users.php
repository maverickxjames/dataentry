<?php
// Include the database connection file
include 'db.php'; // Make sure this path is correct

// Fetch user details from the database where status is 'user'
$sql = "SELECT sl_no, user_id, join_date, username, phone_no, email_id, pass, wallet_amount, status FROM user_info WHERE status = 'user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>User Details</h2>
    <table>
        <tr>
            <th>SL No</th>
            <th>User ID</th>
            <th>Join Date</th>
            <th>Username</th>
            <th>Phone No</th>
            <th>Email ID</th>
            <th>Wallet Amount</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["sl_no"] . "</td>
                    <td>" . $row["user_id"] . "</td>
                    <td>" . $row["join_date"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["phone_no"] . "</td>
                    <td>" . $row["email_id"] . "</td>
                    <td>" . $row["wallet_amount"] . "</td>
                    <td>" . $row["status"] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No users found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>

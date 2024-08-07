<?php 
include 'db.php';

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'xlsx');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = './uploads/' . $fileNameNew; // Adjusted folder path
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $pdf_id = uniqid();
                    $update_status = 'pending'; // Default status
                    $sql = "INSERT INTO files (pdf_id, file_name, file_type, file_path, created_at, updated_at, update_status) VALUES (?, ?, ?, ?, NOW(), NOW(), ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $pdf_id, $fileName, $fileActualExt, $fileDestination, $update_status);
                    if ($stmt->execute()) {
                        header("Location: upload.php?uploadsuccess=1");
                    } else {
                        echo "There was an error uploading your file!";
                    }
                } else {
                    echo "There was an error moving your file!";
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        label {
            margin-right: 10px;
        }
        input[type="file"] {
            flex-grow: 1;
        }
        input[type="submit"] {
            margin-left: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .icon {
            width: 20px;
            height: 20px;
        }
        .file-link {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php 
        if (isset($_GET['uploadsuccess'])) {
            echo '<script>
            swal("Success", "File Uploaded", "success", {
              button: "Ok",
            });
            </script>';
        }   
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Select file to upload:</label>
            <input type="file" name="file" id="file" required>
            <input type="submit" value="Upload File" name="submit">
        </form>

        <div class="file-list">
            <h2>Uploaded Files:</h2>
            <table>
                <tr>
                    <th>Sl. No</th>
                    <th>File Type</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>PDF ID</th>
                    <th>Status</th>
                </tr>
                <?php 
                $fetch = "SELECT * FROM files";
                $result = mysqli_query($conn, $fetch);
                if ($result->num_rows > 0) {
                    $sl_no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $icon = '';
                        if ($row['file_type'] == 'pdf') {
                            $icon = '<img src="https://cdn-icons-png.flaticon.com/512/3143/3143500.png" alt="PDF Icon" class="icon">';
                        } elseif ($row['file_type'] == 'xlsx') {
                            $icon = '<img src="https://cdn-icons-png.flaticon.com/512/15465/15465638.png" alt="Excel Icon" class="icon">';
                        }
                        echo '<tr>
                            <td>' . $sl_no++ . '</td>
                            <td>' . $icon . '</td>
                            <td><a href="' . $row['file_path'] . '" target="_blank" class="file-link">' . $row['file_name'] . '</a></td>
                            <td>' . $row['created_at'] . '</td>
                            <td>' . $row['pdf_id'] . '</td>
                            <td>' . $row['update_status'] . '</td>
                        </tr>';
                    }
                } else {
                    echo "<tr><td colspan='6'>No files found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

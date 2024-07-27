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
                    $sql = "INSERT INTO files (file_name, file_path, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $fileName, $fileDestination);
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
</head>
<body>
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
        <?php 
        $fetch = "SELECT * FROM files WHERE update_status IN ('success', 'pending', 'failed')";
        $result = mysqli_query($conn, $fetch);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<a href="' . $row['file_path'] . '" download="' . $row['file_name'] . '">' . $row['file_name'] . '</a><br>';
            }
        } else {
            echo "No files found.";
        }
        ?>
    </div>
</body>
</html>

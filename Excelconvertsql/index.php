<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include '../db.php';

// Function to check if the file is already processed or pending
function isFilePending($conn, $fileName) {
    $sql = "SELECT COUNT(*) as count FROM files WHERE file_name = ? AND update_status IN ('pending', 'success', 'failed')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $fileName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Function to mark the file as processed
function markFileAsProcessed($conn, $fileName, $status) {
    $sql = "UPDATE files SET update_status = ?, updated_at = now() WHERE file_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $status, $fileName);
    $stmt->execute();
}

// Function to generate a unique xlsx_id
function generateUniqueXlsxId($conn) {
    $sql = "SELECT MAX(CAST(pdf_id AS UNSIGNED)) as max_id FROM fixed_data";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'];

    if ($maxId === null) {
        // If no records exist yet, start with 0001
        return '0001';
    } else {
        // Increment the max id and format it as 4 digits
        $nextId = str_pad($maxId + 1, 4, '0', STR_PAD_LEFT);
        return $nextId;
    }
}

// Function to process XLSX files
function processXlsx($filePath) {
    $reader = new Xlsx();
    $spreadsheet = $reader->load($filePath);
    return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
}

// Function to generate a unique work ID
function generateUniqueWorkId($conn) {
    do {
        $work_id = 'w' . rand(10000, 999999); // Generate a work_id starting with 'w' followed by 5-6 digits
        $sql = "SELECT COUNT(*) as count FROM active_task WHERE work_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $work_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    } while ($row['count'] > 0); // Repeat until a unique work_id is found

    return $work_id;
}

// Function to insert data into active_task table
function insertIntoActiveTask($conn, $pdf_id) {
    $work_id = generateUniqueWorkId($conn);
    $created_at = date('Y-m-d H:i:s');
    $status = 'pending';

    $sql = "INSERT INTO active_task (work_id, pdf_id, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $work_id, $pdf_id, $created_at, $created_at, $status);
    $stmt->execute();
    $stmt->close();
}

// Main script logic
$directory = '../uploads/';
$files = array_diff(scandir($directory, SCANDIR_SORT_DESCENDING), array('..', '.'));

foreach ($files as $file) {
    $filePath = $directory . $file;

    if (isFilePending($conn, $file)) {
        continue; // Skip files that are already processed or pending
    }

    $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if ($fileExt === 'xlsx') {
        // Insert the file into the files table with a pending status if not exists
        $sql = "INSERT INTO files (file_name, file_type, file_path, created_at, updated_at, update_status) 
                VALUES (?, ?, ?, now(), now(), 'pending')
                ON DUPLICATE KEY UPDATE update_status='pending', updated_at=now()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $file, $fileExt, $filePath);
        $stmt->execute();

        $data = processXlsx($filePath);
        $pdf_id = generateUniqueXlsxId($conn); // Ensure $conn is passed to generateUniqueXlsxId()

        $insertQuery = "INSERT INTO fixed_data (pdf_id, col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13, col14, col15) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $success = true; // Initialize the success variable
        foreach ($data as $row) {
            $params = array($pdf_id);
            foreach ($row as $value) {
                $params[] = $value;
            }
            while (count($params) < 16) {
                $params[] = null; // Fill missing columns with null
            }
            $stmt->bind_param('ssssssssssssssss', ...$params);

            if (!$stmt->execute()) {
                $success = false; // Update success variable if there is an error
            }
        }

        if ($success) {
            markFileAsProcessed($conn, $file, 'success');
            insertIntoActiveTask($conn, $pdf_id); // Ensure the function is called here
        } else {
            markFileAsProcessed($conn, $file, 'failed');
        }

        $stmt->close();
    } else {
        continue; // Skip unsupported file types
    }
}

$conn->close();
?>

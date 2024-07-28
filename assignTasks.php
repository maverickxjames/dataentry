<?php
require 'db.php';
session_start();



if (isset($_POST['task'])) {

    $user_id = $_POST['task'];
    if ($user_id == "") {
        echo "0";
        exit();
    } else {
        $query = "SELECT * FROM user_info WHERE user_id = '$user_id'";
        $data = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $username = $data['username'];
        $task = $_POST['task'];
        $work_id = $_POST['work_id'];
        $date = date('Y-m-d H:i:s');
        $update = "UPDATE active_task SET username = '$username',user_id = '$user_id', updated_at = '$date', status = 'pending' WHERE work_id = '$work_id'";

        if (mysqli_query($conn, $update)) {
            echo "1";
        }else{
            echo "0";
        }
    }
} else {
    echo "0";
}

<?php 
require 'db.php';
session_start();

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_info WHERE user_id = '$user_id'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
$username = $data['username'];

if(isset($_POST['task'])){
    $task = $_POST['task'];
    $date = date('Y-m-d H:i:s');
    $update = "UPDATE active_task SET username = '$username',user_id = '$user_id', updated_at = '$date', status = 'working' WHERE work_id = '$task'";

    if(mysqli_query($conn, $update)){
        echo "1";}
    }
    else{
        echo "0";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php include('header.php') ?>
    <main>

        <?php

        include 'db.php';

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login/login.php");
            exit();
        }

        // Get the logged-in user's ID
        $user_id = $_SESSION['user_id'];
        // Fetch fixed data from the database
        $sql = "SELECT col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13, col14, col15 FROM fixed_data";
        $result = $conn->query($sql);

        $fixed_data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fixed_data[] = $row;
            }
        }



        if (isset($_POST['SAVE_DRAFT'])) {
            $work_id = $_POST['work_id'];
            $user_id = $_POST['user_id'];
            // $date = $_POST['date'];
            $col1 = $_POST['col1'];
            $col2 = $_POST['col2'];
            $col3 = $_POST['col3'];
            $col4 = $_POST['col4'];
            $col5 = $_POST['col5'];
            $col6 = $_POST['col6'];
            $col7 = $_POST['col7'];
            $col8 = $_POST['col8'];
            $col9 = $_POST['col9'];
            $col10 = $_POST['col10'];
            $col11 = $_POST['col11'];
            $col12 = $_POST['col12'];
            $col13 = $_POST['col13'];
            $col14 = $_POST['col14'];
            $col15 = $_POST['col15'];
            $status = $_POST['status'];

            $sql = "INSERT INTO data_entry (work_id, user_id, col_1, col_2, col_3, col_4, col_5, col_6, col_7, col_8, col_9, col_10, col_11,col_12, col_13, col_14, col_15, status) VALUES ('$work_id', '$user_id', '$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8', '$col9', '$col10', '$col11', '$col12', '$col13', '$col14', '$col15','working')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        if (isset($_POST['FINAL_SUBMIT'])) {
            $work_id = $_POST['work_id'];
            $user_id = $_POST['user_id'];

            $query = "UPDATE active_task SET status = 'submitted' WHERE work_id = '$work_id' AND user_id = '$user_id'";
            if ($conn->query($query) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        ?>

        <div class="container">
            <h1>Raw Data | Today</h1>
            <div class="fixed-data">
                <table>
                    <?php
                    foreach ($fixed_data as $row) {
                    ?>
                        <tr>
                            <td><span><?= $row['col1'] ?></span></td>
                            <td><span><?= $row['col2'] ?></span></td>
                            <td><span><?= $row['col3'] ?></span></td>
                            <td><span><?= $row['col4'] ?></span></td>
                            <td><span><?= $row['col5'] ?></span></td>
                            <td><span><?= $row['col6'] ?></span></td>
                            <td><span><?= $row['col7'] ?></span></td>
                            <td><span><?= $row['col8'] ?></span></td>
                            <td><span><?= $row['col9'] ?></span></td>
                            <td><span><?= $row['col10'] ?></span></td>
                            <td><span><?= $row['col11'] ?></span></td>
                            <td><span><?= $row['col12'] ?></span></td>
                            <td><span><?= $row['col13'] ?></span></td>
                            <td><span><?= $row['col14'] ?></span></td>
                            <td><span><?= $row['col15'] ?></span></td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>

            </div>
            <br>
            <hr>
            <div class="col-xxl-12 col-md-12 col-sm-12">
                <div class="">
                    <div class="">
                        <div class="table-data">
                            <div class="col-md-12 row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">

                                    <?php
                                    if (isset($_GET['task'])) {
                                        $task_id = $_GET['task'];
                                        $getWork = "SELECT * FROM active_task WHERE work_id = '$task_id' AND user_id = '$user_id' ";
                                        $runWork = mysqli_fetch_assoc(mysqli_query($conn, $getWork));

                                        if ($runWork == '') {
                                    ?>
                                            <div class="card">
                                                <center>
                                                    <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Something Went Wrong</h3>
                                                </center>
                                            </div>
                                        <?php
                                        } elseif ($runWork['status'] == 'working') {
                                        ?>
                                            <form action="" method="post" class="p-3 ">
                                                <div class="card">
                                                    <center>
                                                        <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Enter data</h3>
                                                    </center>
                                                </div>
                                                <div class="card">
                                                    <p>Column 1</p>
                                                    <input type="text" name="col1" id="col1" class="form-control" placeholder="Column 1">
                                                </div>

                                                <div class="card">
                                                    <p>Column 2</p>
                                                    <input type="text" name="col2" id="col2" class="form-control" placeholder="Column 2">

                                                </div>
                                                <div class="card">
                                                    <p>Column 3</p>
                                                    <input type="text" name="col3" id="col3" class="form-control" placeholder="Column 3">
                                                </div>
                                                <div class="card">
                                                    <p>Column 4</p>
                                                    <input type="text" name="col4" id="col4" class="form-control" placeholder="Column 4">
                                                </div>
                                                <div class="card">
                                                    <p>Column 5</p>
                                                    <input type="text" name="col5" id="col5" class="form-control" placeholder="Column 5">
                                                </div>
                                                <div class="card">
                                                    <p>Column 6</p>
                                                    <input type="text" name="col6" id="col6" class="form-control" placeholder="Column 6">
                                                </div>
                                                <div class="card">
                                                    <p>Column 7</p>
                                                    <input type="text" name="col7" id="col7" class="form-control" placeholder="Column 7">
                                                </div>
                                                <div class="card">
                                                    <p>Column 8</p>
                                                    <input type="text" name="col8" id="col8" class="form-control" placeholder="Column 8">
                                                </div>
                                                <div class="card">
                                                    <p>Column 9</p>
                                                    <input type="text" name="col9" id="col9" class="form-control" placeholder="Column 9">
                                                </div>
                                                <div class="card">
                                                    <p>Column 10</p>
                                                    <input type="text" name="col10" id="col10" class="form-control" placeholder="Column 10">
                                                </div>
                                                <div class="card">
                                                    <p>Column 11</p>
                                                    <input type="text" name="col11" id="col11" class="form-control" placeholder="Column 11">
                                                </div>
                                                <div class="card">
                                                    <p>Column 12</p>
                                                    <input type="text" name="col12" id="col12" class="form-control" placeholder="Column 12">
                                                </div>
                                                <div class="card">
                                                    <p>Column 13</p>
                                                    <input type="text" name="col13" id="col13" class="form-control" placeholder="Column 13">
                                                </div>
                                                <div class="card">
                                                    <p>Column 14</p>
                                                    <input type="text" name="col14" id="col14" class="form-control" placeholder="Column 14">
                                                </div>
                                                <div class="card">
                                                    <p>Column 15</p>
                                                    <input type="text" name="col15" id="col15" class="form-control" placeholder="Column 15">
                                                    <input type="hidden" name="status" value="pending">
                                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                                    <input type="hidden" name="work_id" value="<?= $_GET['task'] ?>">
                                                    <!-- <input type="hidden" name="date" value="w001"> -->
                                                </div>

                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card p-2">
                        <center>
                            <input type="submit" name="lastEntry" value="View Last Entry" class="btn btn-danger" onclick="clearForm()">
                            <input type="reset" value="CLEAR DATA" class="btn btn-secondary" onclick="clearForm()">
                            <input type="submit" name="SAVE_DRAFT" value="Save & Next" class="btn btn-warning">
                            <input type="submit" name="FINAL_SUBMIT" value="FINAL SUBMIT" class="btn btn-success">
                        </center>
                    </div>
                    </form>
                <?php
                                        } elseif ($runWork['status'] == 'submitted') {
                ?>
                    <div class="card">
                        <center>
                            <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Final Submitted Done</h3>
                        </center>
                    </div>
                <?php
                                        }
                ?>

            <?php
                                    } else {
            ?>
                <div class="card">
                    <center>
                        <h3 style="font-weight:bold;text-transform:uppercase;color:blue">Something Went Wrong</h3>
                    </center>
                </div>
            <?php
                                    }
            ?>






                </div>
            </div><!-- End Sales Card -->

            <script>
                function clearForm() {
                    document.getElementById("myForm").reset(); // Reset the form fields
                }
            </script>

    </main>
</body>

</html>
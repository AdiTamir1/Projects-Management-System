<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

$e_id = $_REQUEST['e_id'];
$t_id = $_REQUEST['t_id'];

if( isset( $_REQUEST['duration'] ) ) {
    $desc = $_REQUEST['description'];
    $duration = $_REQUEST['duration'];


    // get all tasks
    $result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
    $row = $result->fetch_assoc();
    $tasksObj = json_decode( $row['tasks' ] );

    // update the selected task
    $tasksObj->tasks[$t_id]->description = $desc;
    $tasksObj->tasks[$t_id]->duration = $duration;

    // convert into JSON
    $tasksJson = json_encode( $tasksObj );

    // update employee table
    $conn->query("UPDATE `employee` SET tasks='$tasksJson' WHERE e_id=$e_id");
    header("location:edit_task.php?e_id=$e_id&t_id=$t_id" );
}

$result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
$row = $result->fetch_assoc();
$tasksObj = json_decode( $row['tasks' ] );

$selectedTask = $tasksObj->tasks[$t_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<table align="center" style="width: 1000px;">
    <tr>
        <td colspan="2">
             Name: Adi Tamir, ID: 208547208        </td>
    </tr>
    <tr>
        <td>
            <h1>
                Edit Task
            </h1>
        </td>
        <td>
            Hello: <?php echo $_SESSION['login'];?> | Role: <?php echo $_SESSION['role'];?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php include 'menu.php'; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="content">
            <form action="edit_task.php" method="post">
                <input type="hidden" name="e_id" value="<?php echo $e_id;?>">
                <input type="hidden" name="t_id" value="<?php echo $t_id;?>">
                <table>
                    <tr>
                        <td>Description</td>
                        <td><input type="text" name="description" value="<?php echo $selectedTask->description ?>"></td>
                    </tr>
                    <tr>
                        <td>Duration</td>
                        <td><input type="text" name="duration" value="<?php echo $selectedTask->duration ?>"></td>
                    </tr>
                    <tr>
                        <td><button type="reset">Reset</button></td>
                        <td><button type="submit">Update</button></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>

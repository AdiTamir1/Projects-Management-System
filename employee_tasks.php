<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

if( isset( $_REQUEST['t_id'] ) ) {
    // get all tasks
    $e_id = $_REQUEST['e_id'];
    $t_id = $_REQUEST['t_id'];
    $result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
    $row = $result->fetch_assoc();
    $tasksObj = json_decode( $row['tasks' ] );

    // delete the selected task
    array_splice( $tasksObj->tasks, $t_id, 1 );
    // $arr = [ 1, 2, 3, 4, 5]
    // array_splice( $arr, 2, 2 )
    // convert into JSON
    $tasksJson = json_encode( $tasksObj );

    // update employee table
    $conn->query("UPDATE `employee` SET tasks='$tasksJson' WHERE e_id=$e_id");
    header("location:employee_tasks.php?e_id=$e_id" );
}

if( isset( $_REQUEST['e_id'] ) ) {
    $e_id = $_REQUEST['e_id'];
    $result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
    $row = $result->fetch_assoc();
    $tasksObj = json_decode( $row['tasks' ] );
    // $tasksObj->tasks an array of object
    // $tasksObj->tasks[2] one task
    /*
     {
        tasks: [ { start : ""}, {}, {} ]
     }
     */
}


// gel all employees
$query = "SELECT user.login, employee.e_id FROM `employee` INNER JOIN user ON user.id=employee.e_id";
$result = $conn->query( $query );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Tasks</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<table align="center" style="width: 1000px;">
    <tr>
        <td colspan="2">
            Name: Adi Tamir, ID: 208547208
        </td>
    </tr>
    <tr>
        <td>
            <h1>
                Employee Tasks
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
            <p>Display all employee's tasks in order to <strong>Edit</strong> OR <strong>Delete</strong></p>
            <form action="employee_tasks.php" method="post">
                <table>
                    <tr>
                        <td>Employee</td>
                        <td>
                            <select name="e_id">
                                <?php
                                while ( $employee = $result->fetch_assoc() ) { ?>
                                    <option value="<?php echo $employee['e_id'];?>"><?php echo $employee['login'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td><button type="submit">All Tasks</button></td>
                    </tr>
                </table>
            </form>

            <?php
            if( isset( $tasksObj )) { ?>
            <table>
                <tr>
                    <td>Description</td>
                    <td>Status</td>
                    <td>Edit</td>
                    <td>Delete</td>
                </tr>
                <?php
                for( $i=0; $i<sizeof($tasksObj->tasks); $i++ ){ ?>
                    <tr>
                        <td><?php echo $tasksObj->tasks[$i]->description ;?></td>
                        <td><?php echo $tasksObj->tasks[$i]->status ;?></td>
                        <td><button onclick="window.location.href='edit_task.php?e_id=<?php echo $e_id; ?>&t_id=<?php echo $i; ?>'">Edit</button></td>
                        <td><button onclick="delete_task(<?php echo $e_id; ?>, <?php echo $i; ?>);">Delete</button></td>
                    </tr>
                <?php
                }
            echo '</table>';
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>

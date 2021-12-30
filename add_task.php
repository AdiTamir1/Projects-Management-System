<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

$e_id = $_SESSION['e_id'];


if( isset($_REQUEST['e_id'] )) {
    $e_id = $_REQUEST['e_id'];
    $description = $_REQUEST['description'];
    $duration = $_REQUEST['duration'];
    $status = $_REQUEST['status'];
    $newTask = [ 'start' => '', 'description' => $description, 'duration' => $duration, 'status' => $status ];

    $result = $conn->query("SELECT * FROM employee WHERE e_id=$e_id");
    $employee = $result->fetch_assoc();
    $tasks = $employee['tasks'];
    //echo $tasks."<br>";
    $tasksObj = json_decode( $tasks );

    array_push($tasksObj->tasks, $newTask );

    // save back to employee table
    $tasks = json_encode( $tasksObj );
    //echo $tasks."<br>";
    $conn->query("UPDATE employee SET tasks='$tasks' WHERE e_id=$e_id");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>

    <script>
        function get_employees() {
            // 1. JS SEnd request to PHP file
            // 2. PHP send response back to JS

            // get the project id
            var p_id = document.getElementById('p_id').value;

            var xhttp = new XMLHttpRequest();
            // callback function: waiting for a response from the PHP file
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //var response = this.responseText; // php echo: goes to this.responseText
                    document.getElementById('employee_select').innerHTML = this.responseText;
                }
            };
            // 1. send request to ajax_get_employees_by_project.php
            xhttp.open("GET", 'ajax_get_employees_by_project.php?p_id='+p_id, true);
            xhttp.send();
        }
    </script>

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
                Add task
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
            <?php
            $query = 'SELECT * FROM `project`';
            $result = $conn->query( $query );
            
            ?>
            <form action="add_task.php" method="post">
                <table>
                    <tr>
                        <td>Choose project:</td>
                        <td>
                            <select name="p_id" id="p_id" onchange="get_employees()">
                                <option value="0">Choose</option>
                                <?php
                                while( $project = $result->fetch_assoc()) {
                                    $p_data = json_decode($project['p_data']);
                                ?>
                                <option value="<?php echo $project['p_id'];?>"><?php echo $p_data->name;?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Choose employee:</td>
                        <td id="employee_select">

                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td>
                            <input type="text" name="description" >
                        </td>
                    </tr>
                    <tr>
                        <td>Duration:</td>
                        <td>
                            <input type="text" name="duration" >
                        </td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>
                            <select name="status">
                                <option value="Not started">Not started</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><button type="reset">Reset</button></td>
                        <td><button type="submit">Add</button></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>

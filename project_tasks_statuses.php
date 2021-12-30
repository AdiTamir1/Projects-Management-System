<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Statuses Report</title>
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
                Tasks Statuses Report
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
            <form action="project_tasks_statuses.php" method="post">
                <table>
                    <tr>
                        <td>Project:</td>
                        <td>
                            <select name="p_id" id="p_id">
                                <option value="0">Select</option>
                                <?php
                                $result = $conn->query( "SELECT * FROM `project`");
                                while ($p = $result->fetch_array(MYSQLI_ASSOC)) {
                                    $json = json_decode($p['p_data']);
                                    ?>
                                    <option value="<?php echo $p['p_id'];?>"><?php echo $json->name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="Display tasks statuses">
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            // select the project
            if( isset( $_REQUEST['p_id']) && $_REQUEST['p_id'] > 0 ) {
                $p_id = $_REQUEST['p_id'];
                // select all employees that related to the selected project
                $query = "SELECT user.login, e_p.e_id FROM `e_p` INNER JOIN user 
                    ON user.id=e_p.e_id
                    WHERE e_p.p_id=$p_id
                    ORDER BY user.login";
                $result = $conn->query( $query );
                ?>
                <table>
                    <tr>
                        <td>Employee Name</td>
                        <td>Task Description</td>
                        <td>Task Status</td>
                    </tr>
                    <?php

                    // get tasks of each employee in this project
                    while( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
                        $e_id = $row['e_id'];
                        $login = $row['login'];
                        $results1 = $conn->query( "SELECT tasks FROM employee WHERE e_id=$e_id");
                        $row1 = $results1->fetch_array( MYSQLI_ASSOC );
                        $tasksObject = json_decode( $row1['tasks'] );
                        for( $i=0; $i < sizeof($tasksObject->tasks); $i++ ) { ?>
                        <tr>
                            <td><?php echo $login;?></td>
                            <td><?php echo $tasksObject->tasks[$i]->description; ?></td>
                            <td><?php echo $tasksObject->tasks[$i]->status; ?></td>
                        </tr>
                        <?php
                        }
                    }
            }

            ?>
        </td>
    </tr>
</table>
</body>
</html>

<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

$msg = "";
if( isset( $_REQUEST['e_id'])) {
    $e_id = $_REQUEST['e_id'];
    $d_id = $_REQUEST['d_id'];

    $tasksArr = ['tasks' => [] ];
    $tasks = json_encode( $tasksArr ); // {"tasks": []}
    $conn->query("INSERT INTO employee (e_id, tasks) VALUES ( $e_id, '$tasks' )");
    $conn->query("INSERT INTO e_d(e_id, d_id) VALUES ( $e_id, $d_id)");
    $msg = "New employee added";
}

$result = $conn->query( "SELECT * FROM `user` WHERE id NOT IN ( SELECT e_id FROM employee )");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Employee</title>
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
                New Employee
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
            <form action="new_employee.php" method="post">
                <table>
                    <tr>
                        <td colspan="2">
                            <?php echo $msg;?>
                        </td>
                    </tr>
                    <tr>
                        <td>Employee:</td>
                        <td>
                            <select name="e_id">
                                <option value="0">Select</option>
                                <?php
                                while( $employee = $result->fetch_assoc() ) {
                                    $info = json_decode( $employee['info'] );
                                    if( $info->role != "ad" ) {
                                    ?>
                                        <option value="<?php echo $employee['id'];?>"><?php echo $employee['login'];?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="d_id">
                                <option value="0">Select</option>
                                <?php
                                $result = $conn->query( "SELECT * FROM `department`");
                                while ($department = $result->fetch_assoc()) {
                                    $json = json_decode($department['d_data']);
                                    ?>
                                    <option value="<?php echo $department['d_id'];?>"><?php echo $json->name;?></option>
                                    <?php
                                }
                                ?>
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

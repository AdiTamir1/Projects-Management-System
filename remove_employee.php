<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}
// print_r( $_REQUEST );
if( isset( $_REQUEST['e_id'])) {
    $e_id = $_REQUEST['e_id'];
    $conn->query("DELETE FROM employee WHERE e_id=$e_id");
    $conn->query("DELETE FROM e_d WHERE e_id=$e_id");
    $conn->query("DELETE FROM e_p WHERE e_id=$e_id");
    header('location:remove_employee.php');
}

$result = $conn->query( "SELECT * FROM `user` WHERE id IN ( SELECT e_id FROM employee )");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Employee</title>
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
                Remove Employee
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
            <table>
                <tr>
                    <td>Name</td>
                    <td>Remove</td>
                </tr>
                <?php
                while( $employee = $result->fetch_assoc() ) { ?>
                    <tr>
                        <td><?php echo $employee['login'];?></td>
                        <td><button onclick="remove_employee(<?php echo $employee['id']; ?> );">Remove</button></td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <button onclick="window.location.href='employees.php'">Back</button>
        </td>
    </tr>
</table>
</body>
</html>

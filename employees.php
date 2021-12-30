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
    <title>Manage Employees</title>
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
                Manage Employees
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
            <br><br>
            <table style="width: 100%; text-align: center;">
                <tr>
                    <td>
                        <button onclick="window.location.href='new_employee.php'">New Employee</button>
                    </td>
                    <td>
                        <button onclick="window.location.href='employee_tasks.php'">Update Tasks</button>
                    </td>
                    <td>
                        <button onclick="window.location.href='remove_employee.php'">Remove Employee</button>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

if( isset( $_REQUEST['action'] ) ) {
    $d_id = $_REQUEST['d_id'];
    $conn->query("DELETE FROM department WHERE d_id=$d_id");
    $conn->query("DELETE FROM c_d WHERE d_id=$d_id");
    $conn->query("DELETE FROM e_d WHERE d_id=$d_id");
    header('location:departments.php');
}

$e_id = $_SESSION['e_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
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
                Manage Departments
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
            <button onclick="window.location.href='add_department.php'">Add</button>
            <?php
            $query = "SELECT * FROM `department`";
            $result = $conn->query( $query );
            ?>
            <table border="1">
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Edit</td>
                    <td>Delete</td>
                </tr>
                <?php
                while ( $depart = $result->fetch_assoc() ) {
                    $d_data = json_decode( $depart['d_data'] );
                    ?>
                    <tr>
                        <td><?php echo $depart['d_id'];?></td>
                        <td><?php echo $d_data->name;?></td>
                        <td><button onclick="window.location.href='edit_department.php?action=edit&d_id=<?php echo $depart['d_id'];?>'">Edit</button></td>
                        <td><button onclick="delete_department( <?php echo $depart['d_id'];?> )">Delete</button></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

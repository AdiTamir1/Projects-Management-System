<?php
session_start();
include "inc_db.php";

// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

// isset() - if we get data is null
if( isset( $_REQUEST['action'] ) ) {
    $c_id = $_REQUEST['c_id'];
    $conn->query("DELETE FROM company WHERE c_id=$c_id");
    $conn->query("DELETE FROM c_d WHERE c_id=$c_id");
    $conn->query("DELETE FROM c_p WHERE c_id=$c_id");
    header('location:companies.php');
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
                Manage Companies
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
            <button onclick="window.location.href='add_company.php'">Add</button>
            <?php
            $query = "SELECT * FROM `company`";
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
                while ( $compa = $result->fetch_assoc() ) {
                    $c_data = json_decode( $compa['c_data'] );
                    ?>
                    <tr>
                        <td><?php echo $compa['c_id'];?></td>
                        <td><?php echo $c_data->name;?></td>
                        <td><button onclick="window.location.href='edit_company.php?action=edit&c_id=<?php echo $compa['c_id'];?>'">Edit</button></td>
                        <td><button onclick="delete_company( <?php echo $compa['c_id'];?> )">Delete</button></td>
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

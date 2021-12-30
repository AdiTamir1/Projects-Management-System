<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

// fetch the department data to display in the form
if( isset( $_REQUEST['action'] ) ) {
    $d_id = $_REQUEST['d_id'];
    $select = "SELECT * FROM department WHERE d_id=$d_id";
    $result = $conn->query($select);
    $row = $result->fetch_assoc();
    $d_data =  json_decode( $row['d_data'] );
}

// update the department data in the DB
if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "update" ) {
    $d_id = $_REQUEST['d_id'];
    $name = $_REQUEST['name'];
    $d_data = json_encode( ['name' => $name ]); // "{"name": "CSS" }"
    $result = $conn->query("UPDATE department SET d_data='$d_data' WHERE d_id=$d_id");
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
<table align="center" style="width: 1000px;" border="1">
    <tr>
        <td colspan="2">
            Name: Adi Tamir, ID: 208547208
        </td>
    </tr>
    <tr>
        <td>
            <h1>
                Edit Department
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
            <form action="edit_department.php" method="post">
                <table>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="name" value="<?php echo $d_data->name; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit">UPDATE</button>
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="d_id" value="<?php echo $d_id;?>">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>

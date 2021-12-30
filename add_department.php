<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}


// add new department to the DB
if( isset($_REQUEST['name']) ) {
    $name = $_REQUEST['name'];
    $c_id = $_REQUEST['c_id'];
    $d_data = json_encode( ['name' => $name ]); // "{"name": "CSS" }"
    $conn->query("INSERT INTO department (d_data) VALUES('$d_data')");

    $new_d_id = $conn->insert_id; // last PK inserted
    // Insert a new row into table c_d ( c_id, d_id )
    $conn->query("INSERT INTO c_d (c_id, d_id) VALUES($c_id, $new_d_id)");
    header('location:departments.php');
}

// fetch all companies
$result = $conn->query( 'SELECT * FROM `company`');

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
<table align="center" style="width: 1000px;" >
    <tr>
        <td colspan="2">
            Name: Adi Tamir, ID: 208547208
        </td>
    </tr>
    <tr>
        <td>
            <h1>
                Add Department
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
            <form action="add_department.php" method="post">
                <table>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <td>Choose company:</td>
                        <td>
                            <select name="c_id">
                                <?php
                                while( $company = $result->fetch_assoc() ) {
                                    $c_data = json_decode( $company['c_data'] );
                                    //echo '<option value="'.$company['c_id'].'">'.$c_data->name.'</option>';
                                    ?>
                                    <option value="<?php echo $company['c_id'];?>"><?php echo $c_data->name;?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit">ADD</button>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>

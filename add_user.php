<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

$msg = "";
if( isset( $_REQUEST['d_id'] ) ) {
    $d_id = $_REQUEST['d_id'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $role = $_REQUEST['role'];
    $arr = [ 'role' => $role ]; // [ 'role' => 'pm' ]
    $info = json_encode( $arr ); // convert the array into JSON: {"role": "pm"}
    $conn->query("INSERT INTO user (login, password, info ) VALUES ('$username', '$password', '$info')");

    // get the NEW user id
    $u_id = $conn->insert_id;

    $tasksArr = ['tasks' => [] ];
    $tasks = json_encode( $tasksArr ); // {"tasks": []}
    $conn->query("INSERT INTO employee (e_id, tasks) VALUES ( $u_id, '$tasks' )");
    $conn->query("INSERT INTO e_d(e_id, d_id) VALUES ( $u_id, $d_id)");
    $msg = "New user created successfully";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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
                Add Employee
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
            <form action="add_user.php" method="post">
                <table>
                    <tr>
                        <td colspan="2">
                            <?php echo $msg;?>
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
                        <td>Username:</td>
                        <td><input type="text" name="username"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td>
                            <select name="role">
                                <option value="0">Select</option>
                                <option value="pm">Project manager</option>
                                <option value="tl">Team leader</option>
                                <option value="tw">Team worker</option>
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
    <tr><td><button onclick="window.location.href='new_employee.php'" style="">New Employee</button></td></tr>
</table>
</body>
</html>

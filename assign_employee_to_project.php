<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

if( isset( $_REQUEST['e_id'] ) ){
    $p_id = $_REQUEST['p_id'];
    $e_id = $_REQUEST['e_id'];
    if( $p_id > 0 && $e_id > 0 ) {
        $result = $conn->query("SELECT * FROM e_p WHERE e_id=$e_id AND p_id=$p_id");
        if( $result->num_rows == 0 ) {
            $conn->query("INSERT INTO e_p (e_id, p_id) VALUES ($e_id, $p_id)");
        }
        // redirect to add_task.php
        header('location:add_task.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assign Employee to Project</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script>
        function get_department_employees() {
            // d_id from the select in the form
            d_id = document.getElementById('d_id').value;
            if( d_id > 0 ) {
                var xhttp = new XMLHttpRequest();
                // callback function: waiting for a response from the PHP file
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // php echo goes to this.responseText
                        document.getElementById('employee_select').innerHTML = this.responseText;
                    }
                };
                // send request to 'ajax_get_employees_by_department.php?p_id=0
                xhttp.open("GET", 'ajax_get_employees_by_department.php?d_id=' + d_id, true);
                xhttp.send();
            } else {
                alert("Please select department");
            }
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
                Assign Employee to Project
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
            <form action="assign_employee_to_project.php" method="post">
                <table>
                    <tr>
                        <td>Project:</td>
                        <td>
                            <select name="p_id" id="p_id">
                                <option value="0">Select</option>
                                <?php
                                $result = $conn->query( "SELECT * FROM `project`");
                                while ($project = $result->fetch_assoc()) {
                                    $json = json_decode($project['p_data']);
                                    ?>
                                    <option value="<?php echo $project['p_id'];?>"><?php echo $json->name;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="d_id" id="d_id" onchange="get_department_employees();">
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
                        <td>Employees:</td>
                        <td id="employee_select"></td>
                    </tr>
                    <tr>
                        <td><button type="reset">Reset</button></td>
                        <td><button type="submit">Assign</button></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>

<?php
session_start();
include "inc_db.php";
// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

if( isset($_REQUEST['t_id'])) {
    $e_id = $_SESSION['e_id'];

    $t_id = $_REQUEST['t_id'];
    $status = $_REQUEST['status'];

    $result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
    $row = $result->fetch_assoc();
    $tasksObj = json_decode( $row['tasks' ] );

    // update status
    if( $tasksObj->tasks[$t_id]->status == "Not started" && $status == "Started" ) {
        $tasksObj->tasks[$t_id]->start = $_REQUEST['datetime'];
    }
    $tasksObj->tasks[$t_id]->status = $status;

    // convert into JSON
    $tasksJson = json_encode( $tasksObj );

    // update employee table
    $conn->query("UPDATE `employee` SET tasks='$tasksJson' WHERE e_id=$e_id");
    header("location:my_tasks.php" );
}

$statuses = ["Not started", "Started", "In hold", "Finished" ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
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
                My Tasks
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
            <?php
            $e_id = $_SESSION['e_id'];
            $result = $conn->query("SELECT tasks FROM `employee` WHERE e_id=$e_id");
            $row = $result->fetch_assoc();
            $tasksObj = json_decode( $row['tasks' ] );
            for( $i=0; $i< sizeof($tasksObj->tasks); $i++ ){ ?>
                <div class="task-form">
                    <form action="my_tasks.php" method="post">
                        <input type="hidden" name="t_id" value="<?php echo $i;?>">
                        <input type="hidden" name="datetime" class="datetime" value="">
                        <table>
                            <tr>
                                <td>Description</td>
                                <td><?php echo $tasksObj->tasks[$i]->description; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <select name="status">
                                        <?php
                                        for( $j=0; $j<sizeof($statuses); $j++){
                                            if( $tasksObj->tasks[$i]->status == $statuses[$j] ) { ?>
                                                <option selected="selected"><?php echo $statuses[$j];?></option>
                                            <?php
                                            } else { ?>
                                            <option><?php echo $statuses[$j];?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Start</td>
                                <td><?php echo $tasksObj->tasks[$i]->start; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit">Update Status</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <?php
            }
            ?>
        </td>
    </tr>
</table>
<script>
    var datetime = get_today();
    var elems = document.getElementsByClassName('datetime');
    for( var i=0; i<elems.length; i++ ){
        elems[i].value = datetime;
    }
</script>
</body>
</html>

<?php
session_start();
include "inc_db.php";

// if the user not logged in - redirect to login page
if( empty( $_SESSION['is_login'])) {
    header('location:index.php');
}

$e_id = $_SESSION['e_id'];






// get the department data of the employee
$select = "SELECT e_d.*,department.d_data FROM e_d INNER JOIN department ON e_d.d_id= department.d_id WHERE e_d.e_id=$e_id";
$result = $conn->query($select);
if( $result->num_rows > 0 ) {
    $row = $result->fetch_assoc();
    $d_data = json_decode($row['d_data']);
    //echo $d_data->name;

    // through the d_id, we fetch the company name
    $d_id = $row['d_id'];
    $select = "SELECT c_d.*, company.c_data FROM c_d INNER JOIN company ON c_d.c_id= company.c_id WHERE c_d.d_id=$d_id";
    $result = $conn->query($select);
    $row2 = $result->fetch_assoc();
    $c_data = json_decode($row2['c_data']);
}



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
        <td style="height: 79px">
            <h1>
                Main page
            </h1>
        </td>
        <td style="height: 79px">
            Welcome: <?php echo $_SESSION['login'];?> | Role: <?php echo $_SESSION['role'];?><br>
        	<?php $dt_query = "SELECT dt FROM user WHERE id=$e_id";
    			
				$dt_query_result = $conn->query($dt_query); 
				$dt_result = $dt_query_result->fetch_assoc();
				$old_date = new DateTime($_SESSION['dt']);
				$new_date = new DateTime($dt_result['dt']);
				$dates_diff = $old_date->diff($new_date);
				$days_diff = $dates_diff->days;
						
				if($days_diff >= 1) {
					echo 'Welcome Back!';
				}
				else {
					echo 'Continued fruitful work';
				}
			?>

                       
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
          //  if( isset( $c_data )) {
          //      echo "<p>Company name: $c_data->name</p>";
          //  }
          //  if( isset( $d_data )) {
          //      echo "<p>Department name: $d_data->name</p>";
          //  }
          //  ?>
            <p>
        </td>
    </tr>
</table>
</body>
</html>

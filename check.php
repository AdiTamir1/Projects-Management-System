<?php
session_start();
include "inc_db.php";

// get the form's data
$login = $_REQUEST['login'];
$pass = $_REQUEST['password'];

// run the query
$query = "SELECT * FROM user WHERE login='$login' AND password='$pass'";
$result = $conn->query( $query );

// check the result
if( $result->num_rows === 1 ) {
    $row = $result->fetch_assoc(); 			// return the first row
    $info = json_decode( $row['info'] ); 	// {"role": "pm"}
    
    // save some data in session for later use
    $_SESSION['is_login'] = true;
    $_SESSION['login'] = $row['login']; // save 'gk' in session
    $_SESSION['role'] = $info->role;
    $_SESSION['e_id'] = $row['id'];
    $_SESSION['dt'] = $row['dt'];



    //$now = date('Y-m-d H:i:s');	// server side 2021-09-15 10:39:23
    $now = $_REQUEST['dt']; 		// client side
    
    // 	Update last used with current date time
    $query = "UPDATE user SET dt='$now' where id=".$_SESSION['e_id']; // no \" number
    
    //	echo($query); die();
    $result = $conn->query($query);	// update

    // redirect to main page
    header("location:main.php");
    $now = $_SESSION['dt'];
} else {

    // echo "Failed";
    // redirect back to login page
    $_SESSION['error'] = "Incorrect login or password";
    header("location:index.php");
}


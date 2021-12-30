<?php

$host="localhost";
$husername = "root";
$hpassword = "";
$hdatabase="gkpm";
$conn = new mysqli( $host,$husername,$hpassword,$hdatabase );
$conn->set_charset("utf8");		// enable Hebrew letters
?>
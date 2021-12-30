<?php
session_start();
include 'inc_db.php';

// 2 send response to JS
$d_id = $_REQUEST['d_id'];

// get all employees in a single project
$query = "SELECT user.login, e_d.e_id FROM `e_d` INNER JOIN user ON e_d.e_id=user.id WHERE e_d.d_id=$d_id";
$result = $conn->query( $query );

$html = '<select name="e_id">';
while( $emp = $result->fetch_assoc() ) {
    $html .= '<option value="'.$emp['e_id'].'">'.$emp['login'].'</option>';
}
$html .= "</select>";
echo $html;
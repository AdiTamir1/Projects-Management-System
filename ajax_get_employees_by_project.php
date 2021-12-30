<?php
session_start();
include 'inc_db.php';
// 2 send response to JS
$p_id = $_REQUEST['p_id'];
// get all employees in a single project
$query = "SELECT user.login, e_p.e_id FROM `e_p` INNER JOIN user ON e_p.e_id=user.id WHERE e_p.p_id=$p_id";
$result = $conn->query($query);

$html = '<select name="e_id">';
while( $emp = $result->fetch_assoc() ) {
    $html .= '<option value="'. $emp['e_id'] . '">' . $emp['login'] . '</option>';
}
$html .= "</select>";
echo $html;
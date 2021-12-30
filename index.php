<?php
session_start();
include "inc_db.php";
$conn->query("SELECT * FROM user");

$error = "";
if ( isset($_SESSION['error']) ) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
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
        <td>
            <h1>
                Login
            </h1>
        </td>
    </tr>
    <tr>
        <td>
            <form action="check.php" method="post">
                <input type="hidden" name="dt" id="dt" value="">
               <table>
                   <tr>
                       <td colspan="2" style="color:red">
                           <?php echo $error;?>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Username:
                       </td>
                       <td>
                           <input type="text" name="login">
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Password:
                       </td>
                       <td>
                           <input type="password" name="password">
                       </td>
                   </tr>
                   <tr>
                       <td>
                           <button type="reset">RESET</button>
                       </td>
                       <td>
                           <button type="submit">LOGIN</button>
                       </td>
                   </tr>
               </table>
            </form>
        </td>
    </tr>
</table>
<script>
    var datetime = get_today();
    var elems = document.getElementById('dt').value = datetime;
</script>
</body>
</html>

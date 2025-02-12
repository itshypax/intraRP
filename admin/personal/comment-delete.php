<?php
session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
}

if ($notadmincheck && !$perkomdelete) {
    header("Location: /admin/users/list.php?message=error-2");
}

include '../../assets/php/mysql-con.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$id = $_GET['id'];
$pid = $_GET['pid'];

$sql = "DELETE FROM personal_log WHERE logid = $id";
mysqli_query($conn, $sql);
header('Location: /admin/personal/profile.php?id=' . $pid)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


</body>

</html>
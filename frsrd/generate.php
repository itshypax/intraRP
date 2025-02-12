<?php
session_start();
require_once '../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
}

if ($notadmincheck && !$frsrd) {
    header("Location: /admin/users/list.php?message=error-2");
}

include '../assets/php/mysql-con.php';

$hash = substr(md5(rand()), 0, 4);
$testnr = rand(1, 2);
$sql = "INSERT INTO cirs_frs_exams (hash, test) VALUES ('$hash', '$testnr')";
mysqli_query($conn, $sql);
header('Location: /frsrd/admin.php')

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
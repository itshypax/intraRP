<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
}

if ($notadmincheck && !$usdelete) {
    header("Location: /admin/users/list.php?message=error-2");
}

require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

header('Location: /admin/users/list.php');
exit;

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    header("Location: /admin/login.php");
    exit();
}
if ($notadmincheck) {
    header("Location: /admin/users/list.php?message=error-2");
}

require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
$userid = $_SESSION['userid'];
$id = $_GET['id'];

$newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT username FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch();

// Passwort aktualisieren
$stmt = $pdo->prepare("UPDATE intra_users SET passwort = :passwort WHERE id = :id");
$stmt->bindParam(':passwort', $hashedPassword);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: /admin/users/list.php?message=success-1&user=" . urlencode($user['username']) . "&pass=" . urlencode($newPassword));
exit;

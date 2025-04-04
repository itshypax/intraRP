<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    header("Location: /admin/login.php");
    exit();
}

use App\Auth\Permissions;
use App\Helpers\Flash;

if (!Permissions::check('admin')) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/users/list.php");
}

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

Flash::set('user', 'new-password', ['username' => $user['username'], 'pass' => $newPassword]);
header("Location: /admin/users/list.php");
exit;

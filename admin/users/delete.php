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

if (!Permissions::check(['admin', 'users_delete'])) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/users/list.php");
}

$userid = $_SESSION['userid'];

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

Flash::set('user', 'deleted');
header('Location: /admin/users/list.php');
exit;

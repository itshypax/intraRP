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
use App\Utils\AuditLogger;

if (!Permissions::check(['admin', 'personal_kommentar_delete'])) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/users/list.php");
}

$userid = $_SESSION['userid'];

$id = $_GET['id'];
$pid = $_GET['pid'];

$stmt = $pdo->prepare("DELETE FROM personal_kommentare WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$auditlogger = new AuditLogger($pdo);
$auditlogger->log($userid, 'Profil-Kommentar gelöscht [ID: ' . $id . ']', NULL, 'Mitarbeiter', 1);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

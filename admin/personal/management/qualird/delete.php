<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

use App\Auth\Permissions;
use App\Helpers\Flash;
use App\Utils\AuditLogger;
use App\Localization\Lang;

Lang::setLanguage(LANG ?? 'de');

if (!Permissions::check('admin')) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/personal/management/qualird/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id <= 0) {
        Flash::set('qualification', 'invalid-id');
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    }

    try {
        $checkStmt = $pdo->prepare("SELECT id FROM intra_mitarbeiter_rdquali WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        if (!$checkStmt->fetch()) {
            Flash::set('qualification', 'not-found');
            header("Location: /admin/personal/management/qualird/index.php");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM intra_mitarbeiter_rdquali WHERE id = :id");
        $stmt->execute([':id' => $id]);

        Flash::set('qualification', 'deleted');
        $auditLogger = new AuditLogger($pdo);
        $auditLogger->log($_SESSION['userid'], lang('auditlog.rdqualifications_deleted', [$id]), NULL, lang('auditlog.qualifications'), 1);
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Delete Error: " . $e->getMessage());
        Flash::set('error', 'exception');
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    }
} else {
    header("Location: /admin/personal/management/qualird/index.php");
    exit;
}

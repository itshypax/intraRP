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
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $name_m = trim($_POST['name_m'] ?? '');
    $name_w = trim($_POST['name_w'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $none = isset($_POST['none']) ? 1 : 0;
    $trainable = isset($_POST['trainable']) ? 1 : 0;

    if ($id <= 0 || empty($name)) {
        Flash::set('error', 'missing-fields');
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE intra_mitarbeiter_rdquali SET 
            name = :name, 
            name_m = :name_m, 
            name_w = :name_w, 
            priority = :priority, 
            none = :none, 
            trainable = :trainable 
            WHERE id = :id
        ");

        $stmt->execute([
            ':name' => $name,
            ':name_m' => $name_m,
            ':name_w' => $name_w,
            ':priority' => $priority,
            ':none' => $none,
            ':trainable' => $trainable,
            ':id' => $id
        ]);

        Flash::set('success', 'updated');
        $auditLogger = new AuditLogger($pdo);
        $auditLogger->log($_SESSION['userid'], lang('auditlog.rdqualifications_edited'), NULL, lang('auditlog.qualifications'), 1);
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        Flash::set('error', 'exception');
        header("Location: /admin/personal/management/qualird/index.php");
        exit;
    }
} else {
    header("Location: /admin/personal/management/qualird/index.php");
    exit;
}

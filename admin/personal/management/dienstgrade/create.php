<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

if ($notadmincheck) {
    header("Location: /admin/personal/management/dienstgrade/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $name_m = trim($_POST['name_m'] ?? '');
    $name_w = trim($_POST['name_w'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $badge = isset($_POST['badge']) && trim($_POST['badge']) !== '' ? trim($_POST['badge']) : NULL;
    $archive = isset($_POST['archive']) ? 1 : 0;

    if (empty($name) || empty($name_m) || empty($name_w)) {
        header("Location: /admin/personal/management/dienstgrade/index.php?error=invalid-input");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_dienstgrade 
            (name, name_m, name_w, priority, badge, archive) 
            VALUES (:name, :name_m, :name_w, :priority, :badge, :archive)");

        $stmt->execute([
            ':name' => $name,
            ':name_m' => $name_m,
            ':name_w' => $name_w,
            ':priority' => $priority,
            ':badge' => $badge,
            ':archive' => $archive
        ]);

        header("Location: /admin/personal/management/dienstgrade/index.php?success=created");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error (create dienstgrad): " . $e->getMessage());
        header("Location: /admin/personal/management/dienstgrade/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/personal/management/dienstgrade/index.php");
    exit;
}

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

if ($notadmincheck) {
    header("Location: /admin/personal/management/qualifw/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $shortname = trim($_POST['shortname'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $name_m = trim($_POST['name_m'] ?? '');
    $name_w = trim($_POST['name_w'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $none = isset($_POST['none']) ? 1 : 0;

    if ($id <= 0 || empty($name)) {
        header("Location: /admin/personal/management/qualifw/index.php?error=invalid");
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE intra_mitarbeiter_fwquali SET 
            shortname = :shortname, 
            name = :name, 
            name_m = :name_m, 
            name_w = :name_w, 
            priority = :priority, 
            none = :none 
            WHERE id = :id
        ");

        $stmt->execute([
            ':shortname' => $shortname,
            ':name' => $name,
            ':name_m' => $name_m,
            ':name_w' => $name_w,
            ':priority' => $priority,
            ':none' => $none,
            ':id' => $id
        ]);

        header("Location: /admin/personal/management/qualifw/index.php?success=updated");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        header("Location: /admin/personal/management/qualifw/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/personal/management/qualifw/index.php");
    exit;
}

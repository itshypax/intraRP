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
    $shortname = trim($_POST['shortname'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $name_m = trim($_POST['name_m'] ?? '');
    $name_w = trim($_POST['name_w'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $none = isset($_POST['none']) ? 1 : 0;

    if (empty($name) || empty($name_m) || empty($name_w)) {
        header("Location: /admin/personal/management/qualifw/index.php?error=invalid-input");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_fwquali 
            (shortname, name, name_m, name_w, priority, none) 
            VALUES (:shortname, :name, :name_m, :name_w, :priority, :none)");

        $stmt->execute([
            ':shortname' => $shortname,
            ':name' => $name,
            ':name_m' => $name_m,
            ':name_w' => $name_w,
            ':priority' => $priority,
            ':none' => $none
        ]);

        header("Location: /admin/personal/management/qualifw/index.php?success=created");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error (create dienstgrad): " . $e->getMessage());
        header("Location: /admin/personal/management/qualifw/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/personal/management/qualifw/index.php");
    exit;
}

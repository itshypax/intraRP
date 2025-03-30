<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

if ($notadmincheck) {
    header("Location: /admin/edivi/management/fahrzeuge/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id <= 0) {
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=invalid-id");
        exit;
    }

    try {
        $checkStmt = $pdo->prepare("SELECT id FROM intra_edivi_fahrzeuge WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        if (!$checkStmt->fetch()) {
            header("Location: /admin/edivi/management/fahrzeuge/index.php?error=not-found");
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM intra_edivi_fahrzeuge WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: /admin/edivi/management/fahrzeuge/index.php?success=deleted");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Delete Error: " . $e->getMessage());
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/edivi/management/fahrzeuge/index.php");
    exit;
}

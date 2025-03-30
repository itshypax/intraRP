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
    $name = trim($_POST['name'] ?? '');
    $veh_type = trim($_POST['veh_type'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $doctor = isset($_POST['doctor']) ? 1 : 0;
    $active = isset($_POST['active']) ? 1 : 0;
    $identifier = trim($_POST['identifier'] ?? '');

    if ($id <= 0 || empty($name) || empty($veh_type) || empty($identifier)) {
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=invalid");
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE intra_edivi_fahrzeuge SET name = :name, veh_type = :veh_type, identifier = :identifier, priority = :priority, doctor = :doctor, active = :active WHERE id = :id");

        $stmt->execute([
            ':name' => $name,
            ':veh_type' => $veh_type,
            ':identifier' => $identifier,
            ':priority' => $priority,
            ':doctor' => $doctor,
            ':active' => $active,
            ':id' => $id
        ]);

        header("Location: /admin/edivi/management/fahrzeuge/index.php?success=updated");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/edivi/management/fahrzeuge/index.php");
    exit;
}

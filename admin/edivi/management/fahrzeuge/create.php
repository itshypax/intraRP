<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

if ($notadmincheck) {
    header("Location: /admin/edivi/management/fahrzeuge/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $veh_type = trim($_POST['veh_type'] ?? '');
    $identifier = trim($_POST['identifier'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $doctor = isset($_POST['doctor']) ? 1 : 0;
    $active = isset($_POST['active']) ? 1 : 0;

    if (empty($name) || empty($veh_type) || empty($identifier)) {
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=invalid-input");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_edivi_fahrzeuge (name, veh_type, identifier, priority, doctor, active) VALUES (:name, :veh_type, :identifier, :priority, :doctor, :active)");
        $stmt->execute([
            ':name' => $name,
            ':veh_type' => $veh_type,
            ':identifier' => $identifier,
            ':priority' => $priority,
            ':doctor' => $doctor,
            ':active' => $active
        ]);

        header("Location: /admin/edivi/management/fahrzeuge/index.php?success=created");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Insert Error: " . $e->getMessage());
        header("Location: /admin/edivi/management/fahrzeuge/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/edivi/management/fahrzeuge/index.php");
    exit;
}

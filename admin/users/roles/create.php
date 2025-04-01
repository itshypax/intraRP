<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

if (!$fadmin) {
    header("Location: /admin/users/roles/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $color = trim($_POST['color'] ?? '');
    $permissions = $_POST['permissions'] ?? [];

    if (empty($name) || empty($color)) {
        header("Location: /admin/users/roles/index.php?error=invalid-input");
        exit;
    }

    $permissions_json = json_encode($permissions);

    try {
        $stmt = $pdo->prepare("INSERT INTO intra_users_roles (name, priority, color, permissions) VALUES (:name, :priority, :color, :permissions)");
        $stmt->execute([
            ':name' => $name,
            ':priority' => $priority,
            ':color' => $color,
            ':permissions' => $permissions_json
        ]);

        header("Location: /admin/users/roles/index.php?success=created");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Insert Error (roles): " . $e->getMessage());
        header("Location: /admin/users/roles/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/users/roles/index.php");
    exit;
}

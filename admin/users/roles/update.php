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

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $priority = isset($_POST['priority']) ? (int)$_POST['priority'] : 0;
    $color = trim($_POST['color'] ?? '');
    $permissions = $_POST['permissions'] ?? [];

    // Validate required fields
    if ($id <= 0 || empty($name) || empty($color)) {
        header("Location: /admin/users/roles/index.php?error=invalid-input");
        exit;
    }

    // Make sure permissions is an array
    if (!is_array($permissions)) {
        $permissions = [];
    }

    // Encode permissions as JSON
    $permissions_json = json_encode(array_values($permissions));

    try {
        $stmt = $pdo->prepare("UPDATE intra_users_roles SET name = :name, priority = :priority, color = :color, permissions = :permissions WHERE id = :id");

        $stmt->execute([
            ':name' => $name,
            ':priority' => $priority,
            ':color' => $color,
            ':permissions' => $permissions_json,
            ':id' => $id
        ]);

        header("Location: /admin/users/roles/index.php?success=updated");
        exit;
    } catch (PDOException $e) {
        error_log("PDO Error (roles update): " . $e->getMessage());
        header("Location: /admin/users/roles/index.php?error=exception");
        exit;
    }
} else {
    header("Location: /admin/users/roles/index.php");
    exit;
}

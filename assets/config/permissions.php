<?php
function retrievePermissionsFromDatabase($userId)
{
    try {
        require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userStmt = $pdo->prepare("SELECT role, full_admin FROM intra_users WHERE id = :userId");
        $userStmt->execute(['userId' => $userId]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (!empty($user['full_admin'])) {
                $_SESSION['role_id'] = '99';
                $_SESSION['role_name'] = 'Admin+';
                $_SESSION['role_color'] = 'danger';
                $_SESSION['role_priority'] = '0';
                return ['full_admin'];
            }

            $roleStmt = $pdo->prepare("SELECT permissions, name, color, priority FROM intra_users_roles WHERE id = :roleId");
            $roleStmt->execute(['roleId' => $user['role']]);
            $role = $roleStmt->fetch(PDO::FETCH_ASSOC);

            if ($role && isset($role['permissions'])) {
                $_SESSION['role_id'] = $user['role'];
                $_SESSION['role_name'] = $role['name'];
                $_SESSION['role_color'] = $role['color'];
                $_SESSION['role_priority'] = $role['priority'];

                $permissions = json_decode($role['permissions'], true);
                if (is_array($permissions)) {
                    return $permissions;
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return [];
}

if (isset($_SESSION['userid'])) {
    $_SESSION['permissions'] = retrievePermissionsFromDatabase($_SESSION['userid']);
}


function checkPermission($requiredPermission)
{
    if (isset($_SESSION['permissions']) && in_array($requiredPermission, $_SESSION['permissions'])) {
        return true;
    } else {
        return false;
    }
}

// ADMIN
$fadmin = checkPermission('full_admin');
$admin = checkPermission('admin');
$admincheck = $fadmin || $admin;
$notadmincheck = !$fadmin && !$admin;
// ANTRÄGE
$anview = checkPermission('antraege_view');
$anedit = checkPermission('antraege_edit');
// EDIVI
$edview = checkPermission('edivi_view');
$ededit = checkPermission('edivi_edit');
// MITARBEITER
$perview = checkPermission('personal_view');
$peredit = checkPermission('personal_edit');
$perdoku = checkPermission('intra_mitarbeiter_dokumente');
$perdelete = checkPermission('personal_delete');
$perkomdelete = checkPermission('personal_kommentar_delete');
// BENUTZER
$usview = checkPermission('users_view');
$usedit = checkPermission('users_edit');
$uscreate = checkPermission('users_create');
$usdelete = checkPermission('users_delete');
// FILES
$filupload = checkPermission('files_upload');
$fillog = checkPermission('files_log');

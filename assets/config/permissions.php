<?php
function retrievePermissionsFromDatabase($userId)
{
    try {
        require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT permissions FROM intra_users WHERE id = :userId");
        $statement->execute(['userId' => $userId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $permissions = json_decode($result['permissions'], true);
            if ($permissions !== null) {
                return $permissions;
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
// CIRS TEAM
$cteam = checkPermission('cirs_team');
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
// SCHULE
$frsrd = checkPermission('frs_rd');

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
}

if ($notadmincheck && !$usedit) {
    header("Location: /admin/users/list.php?message=error-2");
}

require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$stmt = $pdo->prepare("SELECT * FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row['id'] == $userid) {
    header("Location: /admin/users/list.php?message=error-1");
}

$user_permissions = json_decode($row['permissions'], true) ?? [];

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['id'];
    $username = $_REQUEST['username'];
    $fullname = $_REQUEST['fullname'];
    $aktenid = $_REQUEST['aktenid'];
    $selected_permissions = $_POST['permissions'];
    $permissions_json = json_encode($selected_permissions);

    $sql = "UPDATE intra_users 
        SET fullname = :fullname, 
            aktenid = :aktenid, 
            permissions = :permissions 
        WHERE id = :id";

    $stmti = $pdo->prepare($sql);
    $stmti->execute([
        'fullname' => $fullname,
        'aktenid' => $aktenid,
        'permissions' => $permissions_json,
        'id' => $id
    ]);

    header("Refresh: 0");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $row['username'] ?> &rsaquo; Administration &rsaquo; <?php echo SYSTEM_NAME ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/jquery/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="<?php echo SYSTEM_NAME ?>" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />
    <!-- Metas -->
    <meta name="theme-color" content="<?php echo SYSTEM_COLOR ?>" />
    <meta property="og:site_name" content="<?php echo SERVER_NAME ?>" />
    <meta property="og:url" content="https://<?php echo SYSTEM_URL ?>/dash.php" />
    <meta property="og:title" content="<?php echo SYSTEM_NAME ?> - Intranet <?php echo SERVER_CITY ?>" />
    <meta property="og:image" content="<?php echo META_IMAGE_URL ?>" />
    <meta property="og:description" content="Verwaltungsportal der <?php echo RP_ORGTYPE . " " .  SERVER_CITY ?>" />

</head>

<body data-bs-theme="dark" data-page="benutzer">
    <?php include "../../assets/components/navbar.php"; ?>
    <div class="container-full position-relative" id="mainpageContainer">
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1 class="mb-3">Benutzer bearbeiten <span class="mx-3"></span> <button class="btn btn-main-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash fa-sm"></i> Benutzer löschen</button></h1>
                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <input name="id" type="hidden" value="<?= $row['id'] ?>" />
                        <?php if (in_array('full_admin', $user_permissions)) { ?>
                            <input type="hidden" name="permissions[]" value="full_admin">
                        <?php } ?>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="username" class="form-label fw-bold">Benutzername <span class="text-main-color">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?= $row['username'] ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label for="fullname" class="form-label fw-bold">Vor- und Zuname <span class="text-main-color">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" value="<?= $row['fullname'] ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                <input type="number" class="form-control" id="aktenid" name="aktenid" placeholder="" value="<?= $row['aktenid'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <h5>Berechtigungen</h5>
                            <div class="col mb-3">
                                <div class="fw-bold">CIRS</div>
                                <label><input type="checkbox" name="permissions[]" value="cirs_team" <?php if (in_array('cirs_team', $user_permissions)) echo 'checked'; ?> <?php if (!$cteam && $notadmincheck) echo 'disabled'; ?>> CIRS Team</label><br><br>
                                <div class="fw-bold">Antragsverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="antraege_view" <?php if (in_array('antraege_view', $user_permissions)) echo 'checked'; ?> <?php if (!$anview && $notadmincheck) echo 'disabled'; ?>> Anträge ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="antraege_edit" <?php if (in_array('antraege_edit', $user_permissions)) echo 'checked'; ?> <?php if (!$anedit && $notadmincheck) echo 'disabled'; ?>> Anträge bearbeiten</label><br><br>
                                <div class="fw-bold">eDIVI Verwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="edivi_view" <?php if (in_array('edivi_view', $user_permissions)) echo 'checked'; ?> <?php if (!$edview && $notadmincheck) echo 'disabled'; ?>> Protokolle ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="edivi_edit" <?php if (in_array('edivi_edit', $user_permissions)) echo 'checked'; ?> <?php if (!$ededit && $notadmincheck) echo 'disabled'; ?>> Protokolle prüfen</label>
                            </div>
                            <div class="col mb-3">
                                <div class="fw-bold">Mitarbeiterverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="personal_view" <?php if (in_array('personal_view', $user_permissions)) echo 'checked'; ?> <?php if (!$perview && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_edit" <?php if (in_array('personal_edit', $user_permissions)) echo 'checked'; ?> <?php if (!$peredit && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter bearbeiten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="intra_mitarbeiter_dokumente" <?php if (in_array('intra_mitarbeiter_dokumente', $user_permissions)) echo 'checked'; ?> <?php if (!$perdoku && $notadmincheck) echo 'disabled'; ?>> Dokumente verwalten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_delete" <?php if (in_array('personal_delete', $user_permissions)) echo 'checked'; ?> <?php if (!$perdelete && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter löschen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_kommentar_delete" <?php if (in_array('personal_kommentar_delete', $user_permissions)) echo 'checked'; ?> <?php if (!$perkomdelete && $notadmincheck) echo 'disabled'; ?>> Notizen löschen</label><br>
                                <div class="fw-bold">FRS - RD</div>
                                <label><input type="checkbox" name="permissions[]" value="frs_rd" <?php if (in_array('frs_rd', $user_permissions)) echo 'checked'; ?> <?php if (!$frsrd && $notadmincheck) echo 'disabled'; ?>> FRS Rettungsdienst</label><br>
                            </div>
                            <div class="col mb-3">
                                <div class="fw-bold">Intranet - Admin</div>
                                <label><input type="checkbox" name="permissions[]" value="admin" <?php if (in_array('admin', $user_permissions)) echo 'checked'; ?> <?php if ($notadmincheck) echo 'disabled'; ?>> Administrator</label><br><br>
                                <div class="fw-bold">Benutzerverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="users_view" <?php if (in_array('users_view', $user_permissions)) echo 'checked'; ?> <?php if (!$usview && $notadmincheck) echo 'disabled'; ?>> Benutzer ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_edit" <?php if (in_array('users_edit', $user_permissions)) echo 'checked'; ?> <?php if (!$usedit && $notadmincheck) echo 'disabled'; ?>> Benutzer bearbeiten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_create" <?php if (in_array('users_create', $user_permissions)) echo 'checked'; ?> <?php if (!$uscreate && $notadmincheck) echo 'disabled'; ?>> Benutzer erstellen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_delete" <?php if (in_array('users_delete', $user_permissions)) echo 'checked'; ?> <?php if (!$usdelete && $notadmincheck) echo 'disabled'; ?>> Benutzer löschen</label>
                                <div class="fw-bold">Dateien / Upload</div>
                                <label><input type="checkbox" name="permissions[]" value="files_upload" <?php if (in_array('files_upload', $user_permissions)) echo 'checked'; ?> <?php if (!$filupload && $notadmincheck) echo 'disabled'; ?>> Dateien hochladen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="files_log" <?php if (in_array('files_log', $user_permissions)) echo 'checked'; ?> <?php if (!$fillog && $notadmincheck) echo 'disabled'; ?>> Datei-Log ansehen</label><br>
                            </div>
                            <div class="col mb-3"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-3 mx-auto">
                                <input class="btn btn-outline-success btn-sm" name="submit" type="submit" value="Änderungen speichern" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bestätigung erforderlich</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Willst du wirklich den Benutzer <span class="fw-bold"><?= $row['fullname'] ?></span> löschen?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-color" data-bs-dismiss="modal">Ne, Upsi</button>
                    <button type="button" class="btn btn-main-color" onclick="window.location.href='delete.php?id=<?= $row['id'] ?>';">Benutzer endgültig löschen</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
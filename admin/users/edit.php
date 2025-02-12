<?php
session_start();
require_once '../../assets/php/permissions.php';
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

include '../../assets/php/mysql-con.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$result = mysqli_query($conn, "SELECT * FROM cirs_users WHERE id = " . $_GET['id']) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);

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

    mysqli_query($conn, "UPDATE cirs_users SET fullname = '$fullname', aktenid = '$aktenid', permissions = '$permissions_json' WHERE id = '$id'") or die(mysqli_error($conn));

    header("Refresh: 0");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/jquery/jquery-3.7.0.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />


</head>

<body data-page="benutzer">
    <!-- PRELOAD -->
    <?php include "../../assets/php/preload.php"; ?>
    <?php include "../../assets/components/c_topnav.php"; ?>
    <!-- NAVIGATION -->
    <div class="container shadow rounded-3 position-relative bg-light mb-3" style="margin-top:-50px;z-index:10" id="mainpageContainer">
        <?php include '../../assets/php/admin-nav-v2.php' ?>
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1 class="mb-3">Benutzer bearbeiten <span class="mx-3"></span> <button class="btn btn-sh-red btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash fa-sm"></i> Benutzer löschen</button></h1>
                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <input name="id" type="hidden" value="<?= $row['id'] ?>" />
                        <?php if (in_array('full_admin', $user_permissions)) { ?>
                            <input type="hidden" name="permissions[]" value="full_admin">
                        <?php } ?>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="username" class="form-label fw-bold">Benutzername <span class="text-sh-red">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?= $row['username'] ?>" required>
                            </div>
                            <div class="col mb-3">
                                <label for="fullname" class="form-label fw-bold">Vor- und Zuname <span class="text-sh-red">*</span></label>
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
                                <label><input type="checkbox" name="permissions[]" value="personal_dokumente" <?php if (in_array('personal_dokumente', $user_permissions)) echo 'checked'; ?> <?php if (!$perdoku && $notadmincheck) echo 'disabled'; ?>> Dokumente verwalten</label><br>
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
                    <button type="button" class="btn btn-sh-blue" data-bs-dismiss="modal">Ne, Upsi</button>
                    <button type="button" class="btn btn-sh-red" onclick="window.location.href='delete.php?id=<?= $row['id'] ?>';">Benutzer endgültig löschen</button>
                </div>
            </div>
        </div>
    </div>
    <div class="floating-button">
        <button id="dark-mode-toggle" class="btn btn-primary">
            <i id="mode-icon" class="fa-solid fa-lightbulb"></i>
        </button>
    </div>
    <script>
        // Function to toggle dark mode
        function toggleDarkMode() {
            const html = document.querySelector('html');
            const isDarkMode = html.getAttribute('data-bs-theme') === 'dark';

            if (isDarkMode) {
                html.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('darkMode', 'false');
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('darkMode', 'true');
            }
        }

        // Function to check and set the theme based on user preference
        function checkThemePreference() {
            const savedDarkMode = localStorage.getItem('darkMode');
            const html = document.querySelector('html');

            if (savedDarkMode === 'true') {
                html.setAttribute('data-bs-theme', 'dark');
            } else {
                html.setAttribute('data-bs-theme', 'light');
            }
        }

        // Event listener for dark mode toggle
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        darkModeToggle.addEventListener('click', toggleDarkMode);

        // Initialize theme preference
        checkThemePreference();
    </script>
</body>

</html>
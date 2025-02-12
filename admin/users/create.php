<?php
session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$uscreate) {
    header("Location: /admin/users/list.php?message=error-2");
}

include '../../assets/php/mysql-con.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $username = $_REQUEST['username'];
    $fullname = $_REQUEST['fullname'];
    $aktenid = $_REQUEST['aktenid'];
    if ($aktenid == 0) {
        $aktenid = NULL;
    }
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
    $selected_permissions = $_POST['permissions'];
    $permissions_json = json_encode($selected_permissions);
    $jetzt = date("Y-m-d H:i:s");

    mysqli_query($conn, "INSERT INTO cirs_users (username, fullname, aktenid, passwort, created_at, permissions) VALUES ('$username', '$fullname', '$aktenid', '$password', '$jetzt', '$permissions_json')") or die(mysqli_error($conn));
    header("Location: /admin/users/list.php");
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
                    <h1>Benutzer anlegen</h1>
                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <div class="row">
                            <div class="col mb-3">
                                <label for="username" class="form-label fw-bold">Benutzername <span class="text-sh-red">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                            </div>
                            <div class="col mb-3">
                                <label for="fullname" class="form-label fw-bold">Vor- und Zuname <span class="text-sh-red">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" required>
                            </div>
                            <div class="col mb-3">
                                <label for="password" class="form-label fw-bold">Passwort <span class="text-sh-red">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                                    <button title="Passwort anzeigen" class="btn btn-outline-warning" type="button" id="show-password-btn"><i class="fa-solid fa-eye"></i></button>
                                    <button title="Passwort generieren" class="btn btn-outline-primary" type="button" id="generate-password-btn"><i class="fa-solid fa-shuffle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                <input type="text" class="form-control" id="aktenid" name="aktenid" placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <h5>Berechtigungen</h5>
                            <div class="col mb-3">
                                <div class="fw-bold">CIRS</div>
                                <label><input type="checkbox" name="permissions[]" value="cirs_team" <?php if (!$cteam && $notadmincheck) echo 'disabled'; ?>> CIRS Team</label><br><br>
                                <div class="fw-bold">Antragsverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="antraege_view" <?php if (!$anview && $notadmincheck) echo 'disabled'; ?>> Anträge ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="antraege_edit" <?php if (!$anedit && $notadmincheck) echo 'disabled'; ?>> Anträge bearbeiten</label><br><br>
                                <div class="fw-bold">eDIVI Verwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="edivi_view" <?php if (!$edview && $notadmincheck) echo 'disabled'; ?>> Protokolle ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="edivi_edit" <?php if (!$ededit && $notadmincheck) echo 'disabled'; ?>> Protokolle prüfen</label>
                            </div>
                            <div class="col mb-3">
                                <div class="fw-bold">Mitarbeiterverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="personal_view" <?php if (!$perview && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_edit" <?php if (!$peredit && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter bearbeiten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_dokumente" <?php if (!$perdoku && $notadmincheck) echo 'disabled'; ?>> Dokumente verwalten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_delete" <?php if (!$perdelete && $notadmincheck) echo 'disabled'; ?>> Mitarbeiter löschen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="personal_kommentar_delete" <?php if (!$perkomdelete && $notadmincheck) echo 'disabled'; ?>> Notizen löschen</label>
                                <div class="fw-bold">FRS - RD</div>
                                <label><input type="checkbox" name="permissions[]" value="frs_rd" <?php if (!$frsrd && $notadmincheck) echo 'disabled'; ?>> FRS Rettungsdienst</label>
                            </div>
                            <div class="col mb-3">
                                <div class="fw-bold">Intranet - Admin</div>
                                <label><input type="checkbox" name="permissions[]" value="admin" <?php if ($notadmincheck) echo 'disabled'; ?>> Administrator</label><br><br>
                                <div class="fw-bold">Benutzerverwaltung</div>
                                <label><input type="checkbox" name="permissions[]" value="users_view" <?php if (!$usview && $notadmincheck) echo 'disabled'; ?>> Benutzer ansehen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_edit" <?php if (!$usedit && $notadmincheck) echo 'disabled'; ?>> Benutzer bearbeiten</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_create" <?php if (!$uscreate && $notadmincheck) echo 'disabled'; ?>> Benutzer erstellen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="users_delete" <?php if (!$usdelete && $notadmincheck) echo 'disabled'; ?>> Benutzer löschen</label>
                                <div class="fw-bold">Dateien / Upload</div>
                                <label><input type="checkbox" name="permissions[]" value="files_upload" <?php if (!$filupload && $notadmincheck) echo 'disabled'; ?>> Dateien hochladen</label><br>
                                <label><input type="checkbox" name="permissions[]" value="files_log" <?php if (!$fillog && $notadmincheck) echo 'disabled'; ?>> Datei-Log ansehen</label><br>
                            </div>
                            <div class="col mb-3"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-3 mx-auto">
                                <input class="btn btn-outline-success btn-sm" name="submit" type="submit" value="Benutzer anlegen" />
                            </div>
                        </div>
                    </form>
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
    <script>
        // Get a reference to the generate password button
        const generatePasswordBtn = document.getElementById('generate-password-btn');

        // Add a click event listener to the generate password button
        generatePasswordBtn.addEventListener('click', function() {
            // Define the characters that can be used in the generated password
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+~`|}{[]\\:;?><,./-=';

            // Generate a random password of length 12
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            // Set the value of the password input to the generated password
            const passwordInput = document.getElementById('password');
            passwordInput.value = password;
        });
    </script>
    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordButton = document.getElementById('show-password-btn');

        showPasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>
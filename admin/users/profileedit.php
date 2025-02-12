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

$result = mysqli_query($conn, "SELECT * FROM cirs_users WHERE id = " . $userid) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);


if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['id'];
    $aktenid = $_REQUEST['aktenid'];

    $new_password = $_REQUEST['passwort'];
    $new_password_2 = $_REQUEST['passwort2'];

    if (!empty($new_password) && !empty($new_password_2) && $new_password === $new_password_2) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE cirs_users SET passwort = '$new_password_hash' WHERE id = '$id'") or die(mysqli_error($conn));
        header("Location: ?message=success-1");
    } else {
        header("Location: /admin/users/profileedit.php?message=error-1");
    }

    mysqli_query($conn, "UPDATE cirs_users SET fullname = '$fullname', aktenid = '$aktenid' WHERE id = '$id'") or die(mysqli_error($conn));

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

<body>
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
                    <h1 class="mb-3">Eigene Daten bearbeiten</h1>
                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <input name="id" type="hidden" value="<?= $row['id'] ?>" />
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                <input type="number" class="form-control" id="aktenid" name="aktenid" placeholder="" value="<?= $row['aktenid'] ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 mb-3">
                                <label for="passwort" class="form-label fw-bold">Neues Passwort</label>
                                <input type="password" class="form-control" id="passwort" name="passwort" placeholder="Leerlassen um nichts zu ändern">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="passwort2" class="form-label fw-bold">Passwort wiederholen</label>
                                <input type="password" class="form-control" id="passwort2" name="passwort2" placeholder="Passwort wiederholen">
                            </div>
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
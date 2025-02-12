<?php

include("../../assets/php/mysql-con.php");

session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) && !isset($_SESSION['permissions'])) {
    die('Bitte zuerst <a href="/admin/login.php">einloggen</a>');
}

if ($notadmincheck && !$anedit) {
    header("Location: /admin/index.php?message=error-2");
}

$caseid = $_GET['antrag'];

// MYSQL QUERY
$result = mysqli_query($conn, "SELECT * FROM cirs_antraege_be WHERE uniqueid = '$caseid'") or die();
$row = mysqli_fetch_array($result);

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['case_id'];
    $cirs_manager = $_SESSION['cirs_user'] ?? "Fehler Fehler";
    $cirs_status = $_REQUEST['cirs_status'];
    $cirs_text = $_REQUEST['cirs_text'];
    $jetzt = date("Y-m-d H:i:s");
    // MYSQL QUERY TO UPDATE CASE
    $update = "UPDATE cirs_antraege_be SET cirs_manager='$cirs_manager', cirs_status='$cirs_status', cirs_text='$cirs_text', cirs_time='$jetzt' WHERE id='$id'";
    mysqli_query($conn, $update) or die(mysqli_error($conn));
    header("Refresh:0");
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Anträge &rsaquo; intraRP</title>
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

<body data-page="antrag">
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
                    <h1>Antrag sichten und bearbeiten</h1>
                    <hr class="text-light my-3">
                    <form action="" id="cirs-form" method="post">
                        <input type="hidden" name="new" value="1" />
                        <input type="hidden" name="case_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="cirs_manger" value="<?= $_SESSION['cirs_user'] ?? "Fehler Fehler" ?>">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name_dn" class="form-label fw-bold">Name und Dienstnummer <span class="text-sh-red">*</span></label>
                                <input type="text" class="form-control" id="name_dn" name="name_dn" placeholder="" value="<?= $row['name_dn'] ?>" required disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="dienstgrad" class="form-label fw-bold">Aktueller Dienstgrad <span class="text-sh-red">*</span></label>
                                <input type="text" class="form-control" id="dienstgrad" name="dienstgrad" placeholder="" value="<?= $row['dienstgrad'] ?>" required disabled>
                            </div>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Schriftlicher Antrag</h5>
                        <div class="mb-3">
                            <textarea class="form-control" id="freitext" name="freitext" rows="5" disabled><?= $row['freitext'] ?></textarea>
                        </div>
                        <hr class="text-light my-3">
                        <div class="mb-3">
                            <?php if ($row['cirs_manager'] != NULL) { ?>
                                <h5>Antrag bearbeitet von: <?= $row['cirs_manager'] ?></h5>
                            <?php } else { ?>
                                <h5>Noch kein Bearbeiter festgelegt.</h5>
                            <?php } ?>
                        </div>
                        <hr class="text-light my-3">
                        <hr class="text-light my-3">
                        <h5>Bemerkung durch Bearbeiter</h5>
                        <div class="mb-3">
                            <textarea class="form-control" id="cirs_text" name="cirs_text" rows="5"><?= $row['cirs_text'] ?></textarea>
                        </div>
                        <h5>Status setzen</h5>
                        <div class="mb-3">
                            <select class="form-select" id="cirs_status" name="cirs_status" autocomplete="off">
                                <option value="0" <?php if ($row['cirs_status'] == "0") echo 'selected'; ?>>in Bearbeitung</option>
                                <option value="1" <?php if ($row['cirs_status'] == "1") echo 'selected'; ?>>Abgelehnt</option>
                                <option value="2" <?php if ($row['cirs_status'] == "2") echo 'selected'; ?>>Aufgeschoben</option>
                                <option value="3" <?php if ($row['cirs_status'] == "3") echo 'selected'; ?>>Angenommen</option>
                            </select>
                        </div>
                        <p><input class="mt-4 btn btn-lg rounded-3 btn-sh-red btn-sm" name="submit" type="submit" value="Änderungen speichern" /></p>
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
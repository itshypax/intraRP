<?php

include("../../assets/php/mysql-con.php");

session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) && !isset($_SESSION['permissions'])) {
    die('Bitte zuerst <a href="/admin/login.php">einloggen</a>');
}

if ($notadmincheck && !$cteam) {
    header("Location: /cirs/index.php?message=error-2");
}

$caseid = $_GET['case'];

// MYSQL QUERY
$result = mysqli_query($conn, "SELECT * FROM cirs_cases WHERE uniqueid = '$caseid'") or die();
$row = mysqli_fetch_array($result);

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['case_id'];
    $cirs_manager = $_SESSION['cirs_user'] ?? "Fehler Fehler";
    if ($_REQUEST['cirs_text'] ==  "") {
        $cirs_text = NULL;
    } else {
        $cirs_text = $_REQUEST['cirs_text'];
    }
    if ($_REQUEST['cirs_title'] ==  "") {
        $cirs_title = NULL;
    } else {
        $cirs_title = $_REQUEST['cirs_title'];
    }
    $cirs_status = $_REQUEST['cirs_status'];
    $jetzt = date("Y-m-d H:i:s");
    // MYSQL QUERY TO UPDATE CASE
    $update = "UPDATE cirs_cases SET cirs_manager='$cirs_manager', cirs_title='$cirs_title', cirs_text='$cirs_text', cirs_status='$cirs_status', cirs_time='$jetzt' WHERE id='$id'";
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
    <title>CIRS &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/css/cirs.min.css" />
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

<body data-page="cirs">
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
                    <h1>Meldung sichten und bearbeiten</h1>
                    <hr class="text-light my-3">
                    <form action="" id="cirs-form" method="post">
                        <input type="hidden" name="new" value="1" />
                        <input type="hidden" name="case_id" value="<?= $row['id'] ?>">
                        <h5>Meldung betrifft</h5>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <?php if ($row['btr_bf'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="btr_bf" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="btr_bf" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="btr_bf">
                                        Berufsfeuerwehr
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <?php if ($row['btr_rd'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="btr_rd" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="btr_rd" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="btr_rd">
                                        Rettungsdienst
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Was hat das Problem ausgelöst?</h5>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <?php if ($row['r_mitarbeiter'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_mitarbeiter" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_mitarbeiter" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="r_mitarbeiter">
                                        Mitarbeiter
                                    </label>
                                </div>
                                <div class="form-check">
                                    <?php if ($row['r_fahrzeug'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_fahrzeug" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_fahrzeug" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="r_fahrzeug">
                                        Fahrzeug
                                    </label>
                                </div>
                                <div class="form-check">
                                    <?php if ($row['r_geraet'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_geraet" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_geraet" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="r_geraet">
                                        Gerät
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <?php if ($row['r_zivilisten'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_zivilisten" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_zivilisten" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="r_zivilisten">
                                        Außenstehende / Dritte (Zivilisten)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <?php if ($row['r_bos'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_bos" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="r_bos" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="r_bos">
                                        Andere Behörden / Organisationen (BOS)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="r_sonst">
                                    <label class="form-check-label" for="r_sonst">
                                        Sonstiges (Bitte im Text ausführen)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Art der Meldung</h5>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <?php if ($row['t_beschwerde'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_beschwerde" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_beschwerde" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="t_beschwerde">
                                        Beschwerde
                                    </label>
                                </div>
                                <div class="form-check">
                                    <?php if ($row['t_mangel'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_mangel" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_mangel" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="t_mangel">
                                        Mängelmeldung
                                    </label>
                                </div>
                                <div class="form-check">
                                    <?php if ($row['t_wunsch'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_wunsch" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_wunsch" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="t_wunsch">
                                        Wunsch der Besserung
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <?php if ($row['t_sonst'] == "1") { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_sonst" checked disabled>
                                    <?php } else { ?>
                                        <input class="form-check-input" type="checkbox" value="1" id="t_sonst" disabled>
                                    <?php } ?>
                                    <label class="form-check-label" for="t_sonst">
                                        Sonstiges (Bitte im Text ausführen)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Meldung</h5>
                        <div class="mb-3">
                            <textarea class="form-control" id="freitext" name="freitext" rows="5" readonly><?= $row['freitext'] ?></textarea>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Titel festlegen</h5>
                        <div class="mb-3">
                            <?php if ($row['cirs_title'] != NULL) { ?>
                                <input type="texte" class="form-control" id="cirs_title" name="cirs_title" value="<?= $row['cirs_title'] ?>">
                            <?php } else { ?>
                                <input type="texte" class="form-control" id="cirs_title" name="cirs_title">
                            <?php } ?>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Bemerkung durch CIRS-Team</h5>
                        <div class="mb-3">
                            <textarea class="form-control" id="cirs_text" name="cirs_text" rows="5"><?= $row['cirs_text'] ?></textarea>
                            <?php if ($row['cirs_manager'] != NULL) { ?>
                                <small>Zuletzt bearbeitet von: <?= $row['cirs_manager'] ?></small>
                            <?php } else { ?>
                                <small>Noch kein Bearbeiter.</small>
                            <?php } ?>
                        </div>
                        <hr class="text-light my-3">
                        <h5>Status setzen</h5>
                        <div class="mb-3">
                            <select class="form-select" id="cirs_status" name="cirs_status" autocomplete="off">
                                <option value="0" <?php if ($row['cirs_status'] == "0") echo 'selected'; ?>>Kein CIRS-Fall</option>
                                <option value="1" <?php if ($row['cirs_status'] == "1") echo 'selected'; ?>>Offen</option>
                                <option value="2" <?php if ($row['cirs_status'] == "2") echo 'selected'; ?>>In Prüfung</option>
                                <option value="3" <?php if ($row['cirs_status'] == "3") echo 'selected'; ?>>Archiviert - Öffentlich</option>
                                <option value="4" <?php if ($row['cirs_status'] == "4") echo 'selected'; ?>>Archiviert - Privat</option>
                            </select>
                        </div>
                        <p><input class="mt-4 btn btn-lg rounded-3 btn-sh-red" name="submit" type="submit" value="Änderungen speichern" /></p>
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
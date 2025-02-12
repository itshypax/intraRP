<?php
session_start();
include_once '../assets/php/permissions.php';

include("../assets/php/mysql-con.php");

$caseid = $_GET['case'];

// MYSQL QUERY
$result = mysqli_query($conn, "SELECT * FROM cirs_cases WHERE uniqueid = '$caseid'") or die();
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CIRS &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/cirs.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />

</head>

<body>
    <!-- NAVIGATION -->
    <nav class="navbar bg-sh-red" id="cirs-nav">
        <div class="container-fluid">
            <div class="container">
                <div class="row w-100">
                    <div class="col d-flex align-items-center justify-content-end text-light" id="pageTitle">
                        Critical Incident Reporting System (CIRS)
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- ------------ -->
    <!-- PAGE CONTENT -->
    <!-- ------------ -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 border-2 border-top border-sh-semigray bg-sh-gray" id="cirs-links">
                <hr class="text-sh-gray my-3">
                <?php include '../assets/php/cirs-nav.php' ?>
            </div>
            <div class="col"></div>
            <div class="col-6 my-5">
                <hr class="text-light my-3">
                <?php
                if ($row['cirs_status'] == "0") {
                    $badge_color = "bg-danger";
                    $badge_text = "Kein Fall für CIRS";
                } elseif ($row['cirs_status'] == "1") {
                    $badge_color = "bg-secondary";
                    $badge_text = "Offen";
                } elseif ($row['cirs_status'] == "2") {
                    $badge_color = "bg-info";
                    $badge_text = "In Prüfung";
                } elseif ($row['cirs_status'] == "3") {
                    $badge_color = "bg-success";
                    $badge_text = "Abgeschlossen - Öffentlich";
                } elseif ($row['cirs_status'] == "4") {
                    $badge_color = "bg-warning";
                    $badge_text = "Abgeschlossen - Privat";
                } else {
                    $badge_color = "bg-dark";
                    $badge_text = "Fehler";
                }
                ?>
                <h1>Meldung ansehen <span class="badge text-<?= $badge_color ?>"><?= $badge_text ?></span></h1>
                <hr class="text-light my-3">
                <form action="" id="cirs-form" method="post">
                    <input type="hidden" name="new" value="1" />
                    <input type="hidden" name="case_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="cirs_manger" value="<?= $_SESSION['cirs_user'] ?? "Fehler Fehler" ?>">
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
                    <h5>Bemerkung durch CIRS-Team</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="cirs_text" name="cirs_text" rows="5" readonly><?= $row['cirs_text'] ?></textarea>
                        <?php if ($row['cirs_manager'] != NULL) { ?>
                            <small>Bearbeiter: <?= $row['cirs_manager'] ?></small>
                        <?php } else { ?>
                            <small>Noch kein Bearbeiter festgelegt.</small>
                        <?php } ?>
                    </div>
                    <hr class="text-light my-3">
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>

</html>
<?php
session_start();
?>

<?php

include("../assets/php/mysql-con.php");

$caseid = $_GET['antrag'];

// MYSQL QUERY
$result = mysqli_query($conn, "SELECT * FROM cirs_antraege_be WHERE uniqueid = '$caseid'") or die();
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Anträge &rsaquo; intraRP</title>
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
                        Antragsmanagement
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
                <?php include '../assets/php/antrag-nav.php' ?>
            </div>
            <div class="col"></div>
            <div class="col-6 my-5">
                <hr class="text-light my-3">
                <?php
                if ($row['cirs_status'] == "0") {
                    $badge_color = "bg-info";
                    $badge_text = "in Bearbeitung";
                } elseif ($row['cirs_status'] == "1") {
                    $badge_color = "bg-danger";
                    $badge_text = "Abgelehnt";
                } elseif ($row['cirs_status'] == "2") {
                    $badge_color = "bg-warning";
                    $badge_text = "Aufgeschoben";
                } elseif ($row['cirs_status'] == "3") {
                    $badge_color = "bg-success";
                    $badge_text = "Angenommen";
                } else {
                    $badge_color = "bg-dark";
                    $badge_text = "Fehler";
                }
                ?>
                <h1>Antrag ansehen <span class="badge text-<?= $badge_color ?>"><?= $badge_text ?></span></h1>
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
                    <h5>Bemerkung durch Bearbeiter</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="cirs_text" name="cirs_text" rows="5" disabled><?= $row['cirs_text'] ?></textarea>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

</body>

</html>
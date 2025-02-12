<?php
session_start();
include_once("../assets/php/permissions.php");
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
                <h1>Fallübersicht</h1>
                <table class="table table-striped">
                    <thead>
                        <th scope="col">Fall-Nr.</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Status</th>
                        <th scope="col">Datum</th>
                        <th scope="col"></th>
                    </thead>
                    <tbody>
                        <?php
                        include '../assets/php/mysql-con.php';
                        $sql = "SELECT * FROM cirs_cases WHERE cirs_status = 0 OR cirs_status = 3 ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['cirs_status'] == 1) {
                                    $cirs_state = "Offen";
                                } else if ($row['cirs_status'] == 0) {
                                    $cirs_state = "Kein CIRS-Fall";
                                } else if ($row['cirs_status'] == 2) {
                                    $cirs_state = "In Prüfung";
                                } else if ($row['cirs_status'] == 3) {
                                    $cirs_state = "Archiviert";
                                } else if ($row['cirs_status'] == 4) {
                                    $cirs_state = "Archiviert - Privat";
                                } else {
                                    $cirs_state = "Unbekannt";
                                }

                                $datetime = new DateTime($row['time_added']);
                                $date = $datetime->format('d.m.Y | H:i');

                                if ($row['cirs_status'] == 0) {
                                    echo "<tr style='--bs-table-striped-bg:rgba(255,0,0,.05);--bs-table-bg:rgba(255,0,0,.05)'><td>" . $row['uniqueid'] . "</td><td data-bs-toggle='tooltip' data-bs-title='" . $row['freitext'] . "'>" . $row['cirs_title'] . "</td><td>" . $cirs_state . "</td><td>" . $date . "</td><td><a class='btn btn-sh-blue btn-sm' href='/cirs/case" . $row['uniqueid'] . "'>Öffnen</a></td></tr>";
                                } else if ($row['cirs_status'] == 3) {
                                    echo "<tr style='--bs-table-striped-bg:rgba(0,255,0,.05);--bs-table-bg:rgba(0,255,0,.05)'><td>" . $row['uniqueid'] . "</td><td data-bs-toggle='tooltip' data-bs-title='" . $row['freitext'] . "'>" . $row['cirs_title'] . "</td><td>" . $cirs_state . "</td><td>" . $date . "</td><td><a class='btn btn-sh-blue btn-sm' href='/cirs/case" . $row['uniqueid'] . "'>Öffnen</a></td></tr>";
                                } else {
                                    echo "<tr title='" . $row['freitext'] . "'><td>" . $row['uniqueid'] . "</td><td data-bs-toggle='tooltip' data-bs-title='" . $row['freitext'] . "'>" . $row['cirs_title'] . "</td><td>" . $cirs_state . "</td><td>" . $row['time_added'] . "</td><td><a class='btn btn-sh-blue btn-sm' href='/cirs/case" . $date . "'>Öffnen</a></td></tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='5'>Zurzeit keine Fälle vorhanden.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col"></div>
        </div>
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
</body>

</html>
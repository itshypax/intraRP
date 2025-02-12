<?php

session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) && !isset($_SESSION['permissions'])) {
    die('Bitte zuerst <a href="/admin/login.php">einloggen</a>');
}

if ($notadmincheck && !$anedit) {
    header("Location: /admin/index.php?message=error-2");
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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
                    <h1 class="mb-5">Antragsübersicht</h1>
                    <table class="table table-striped" id="table-antrag">
                        <thead>
                            <th scope="col">Nr.</th>
                            <th scope="col">Von</th>
                            <th scope="col">Status</th>
                            <th scope="col">Datum</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            <?php
                            include '../../assets/php/mysql-con.php';
                            $sql = "SELECT * FROM cirs_antraege_be";
                            $result = mysqli_query($conn, $sql);
                            $resultCheck = mysqli_num_rows($result);
                            if ($resultCheck > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['cirs_status'] == 1) {
                                        $cirs_state = "Abgelehnt";
                                    } else if ($row['cirs_status'] == 0) {
                                        $cirs_state = "in Bearbeitung";
                                    } else if ($row['cirs_status'] == 2) {
                                        $cirs_state = "Aufgeschoben";
                                    } else if ($row['cirs_status'] == 3) {
                                        $cirs_state = "Angenommen";
                                    } else {
                                        $cirs_state = "Unbekannt";
                                    }

                                    $adddat = date("d.m.Y | H:i", strtotime($row['time_added']));

                                    if ($row['cirs_status'] == 1) {
                                        echo "<tr style='--bs-table-striped-bg:rgba(255,0,0,.05);--bs-table-bg:rgba(255,0,0,.05)'><td>" . $row['uniqueid'] . "</td><td>" . $row['name_dn'] . "</td><td>" . $cirs_state . "</td><td><span style='display:none'>" . $row['time_added'] . "</span>" . $adddat . "</td><td><a class='btn btn-sh-blue btn-sm' href='/admin/antraege/antrag" . $row['uniqueid'] . "'>Öffnen</a></td></tr>";
                                    } else if ($row['cirs_status'] == 3) {
                                        echo "<tr style='--bs-table-striped-bg:rgba(0,255,0,.05);--bs-table-bg:rgba(0,255,0,.05)'><td>" . $row['uniqueid'] . "</td><td>" . $row['name_dn'] . "</td><td>" . $cirs_state . "</td><td><span style='display:none'>" . $row['time_added'] . "</span>" . $adddat . "</td><td><a class='btn btn-sh-blue btn-sm' href='/admin/antraege/antrag" . $row['uniqueid'] . "'>Öffnen</a></td></tr>";
                                    } else {
                                        echo "<tr><td>" . $row['uniqueid'] . "</td><td>" . $row['name_dn'] . "</td><td>" . $cirs_state . "</td><td><span style='display:none'>" . $row['time_added'] . "</span>" . $adddat . "</td><td><a class='btn btn-sh-blue btn-sm' href='/admin/antraege/antrag" . $row['uniqueid'] . "'>Öffnen</a></td></tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table-antrag').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [10, 20, 50, 100],
                pageLength: 20,
                order: [
                    [3, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
                language: {
                    "decimal": "",
                    "emptyTable": "Keine Daten vorhanden",
                    "info": "Zeige _START_ bis _END_  | Gesamt: _TOTAL_",
                    "infoEmpty": "Keine Daten verfügbar",
                    "infoFiltered": "| Gefiltert von _MAX_ Anträgen",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Anträge pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Anträge suchen:",
                    "zeroRecords": "Keine Einträge gefunden",
                    "paginate": {
                        "first": "Erste",
                        "last": "Letzte",
                        "next": "Nächste",
                        "previous": "Vorherige"
                    },
                    "aria": {
                        "sortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                        "sortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                    }
                }
            });
        });
    </script>
</body>

</html>
<?php
session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$perview) {
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />


</head>

<body data-page="mitarbeiter">
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
                    <div class="row mb-5">
                        <div class="col">
                            <h1>Mitarbeiterübersicht</h1>
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <?php if (isset($_GET['archiv'])) { ?>
                                    <a href="/admin/personal/list.php" class="btn btn-dark">Aktive Mitarbeiter</a>
                                <?php } else { ?>
                                    <a href="/admin/personal/list.php?archiv" class="btn btn-dark">Archiv</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" id="mitarbeiterTable">
                        <thead>
                            <th scope="col">Dienstnummer</th>
                            <th scope="col">Name</th>
                            <th scope="col">Dienstgrad</th>
                            <th scope="col">Einstellungsdatum</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            <?php
                            include '../../assets/php/mysql-con.php';
                            if (isset($_GET['archiv'])) {
                                $listQuery = "SELECT * FROM personal_profile WHERE dienstgrad = '18' ORDER BY einstdatum ASC";
                            } else {
                                $listQuery = "SELECT * FROM personal_profile WHERE dienstgrad <> '18' ORDER BY einstdatum ASC";
                            }
                            $result = mysqli_query($conn, $listQuery);
                            while ($row = mysqli_fetch_array($result)) {
                                $einstellungsdatum = date("d.m.Y", strtotime($row['einstdatum']));

                                $dg = $row['dienstgrad'];

                                $dienstgrade = [
                                    18 => "Entlassen/Archiv",
                                    16 => "Ehrenamtliche/-r",
                                    0 => "Angestellte/-r",
                                    1 => "Brandmeisteranwärter/-in",
                                    2 => "Brandmeister/-in",
                                    3 => "Oberbrandmeister/-in",
                                    4 => "Hauptbrandmeister/-in",
                                    5 => "Hauptbrandmeister/-in mit AZ",
                                    17 => "Brandinspektoranwärter/-in",
                                    6 => "Brandinspektor/-in",
                                    7 => "Oberbrandinspektor/-in",
                                    8 => "Brandamtmann/frau",
                                    9 => "Brandamtsrat/rätin",
                                    10 => "Brandoberamtsrat/rätin",
                                    19 => "Ärztliche/-r Leiter/-in Rettungsdienst",
                                    15 => "Brandreferendar/in",
                                    11 => "Brandrat/rätin",
                                    12 => "Oberbrandrat/rätin",
                                    13 => "Branddirektor/-in",
                                    14 => "Leitende/-r Branddirektor/-in",
                                ];

                                $dienstgrad = isset($dienstgrade[$dg]) ? $dienstgrade[$dg] : '';

                                $rd = $row['qualird'];

                                $rddg = [
                                    0 => "Keine",
                                    1 => "Rettungssanitäter/-in i. A.",
                                    2 => "Rettungssanitäter/-in",
                                    3 => "Notfallsanitäter/-in",
                                    4 => "Notarzt/ärztin",
                                    5 => "Ärztliche/-r Leiter/-in RD",
                                ];

                                $rdqualtext = isset($rddg[$rd]) ? $rddg[$rd] : '';


                                echo "<tr>";
                                echo "<td >" . $row['dienstnr'] . "</td>";
                                echo "<td>" . $row['fullname'] .  "</td>";
                                echo "<td>" . $dienstgrad;
                                if ($row['qualird'] > 0) {
                                    echo " <span class='badge bg-warning'>" . $rdqualtext . "</span></td>";
                                }
                                echo "<td><span style='display:none'>" . $row['einstdatum'] . "</span>" . $einstellungsdatum . "</td>";
                                echo "<td><a href='/admin/personal/profile.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Ansehen</a></td>";
                                echo "</tr>";
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
            var table = $('#mitarbeiterTable').DataTable({
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
                    "infoFiltered": "| Gefiltert von _MAX_ Mitarbeitern",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Mitarbeiter pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Mitarbeiter suchen:",
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
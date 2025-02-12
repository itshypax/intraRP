<?php
session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$edview) {
    header("Location: /admin/index.php");
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

<body data-page="edivi">
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
                    <h1 class="mb-5">Protokollübersicht</h1>
                    <div class="my-3">
                        <?php if (!isset($_GET['view']) or $_GET['view'] != 1) { ?>
                            <a href="?view=1" class="btn btn-secondary btn-sm">Bearbeitete ausblenden</a>
                        <?php } else { ?>
                            <a href="?view=0" class="btn btn-primary btn-sm">Bearbeitete einblenden</a>
                        <?php } ?>
                    </div>
                    <?php if (isset($_GET['message']) && $_GET['message'] === 'error-1') { ?>
                        <div class="alert alert-danger" role="alert">
                            <h5>Fehler!</h5>
                            Du kannst dich nicht selbst bearbeiten!
                        </div>
                    <?php } else if (isset($_GET['message']) && $_GET['message'] === 'error-2') { ?>
                        <div class="alert alert-danger" role="alert">
                            <h5>Fehler!</h5>
                            Dazu hast du nicht die richtigen Berechtigungen!
                        </div>
                    <?php } ?>
                    <table class="table table-striped" id="table-protokoll">
                        <thead>
                            <th scope="col">Einsatznummer</th>
                            <th scope="col">Patient</th>
                            <th scope="col">Angelegt am</th>
                            <th scope="col">Protokollant</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            <?php
                            include '../../assets/php/mysql-con.php';
                            $result = mysqli_query($conn, "SELECT * FROM cirs_rd_protokolle WHERE hidden <> 1");
                            while ($row = mysqli_fetch_array($result)) {
                                $datetime = new DateTime($row['sendezeit']);
                                $date = $datetime->format('d.m.Y | H:i');
                                if ($row['protokoll_status'] == 0) {
                                    $status = "<span class='badge bg-secondary'>Ungesehen</span>";
                                } else if ($row['protokoll_status'] == 1) {
                                    $status = "<span title='Prüfer: " . $row['bearbeiter'] . "' class='badge bg-warning'>in Prüfung</span>";
                                } else if ($row['protokoll_status'] == 2) {
                                    $status = "<span title='Prüfer: " . $row['bearbeiter'] . "' class='badge bg-success'>Geprüft</span>";
                                } else {
                                    $status = "<span title='Prüfer: " . $row['bearbeiter'] . "' class='badge bg-danger'>Ungenügend</span>";
                                }

                                if ($row['freigegeben'] == 0) {
                                    $freigabe_status = "";
                                } else if ($row['freigegeben'] == 1) {
                                    $freigabe_status = "<span title='Freigeber: " . $row['freigeber_name'] . "' class='badge bg-success'>F</span>";
                                }

                                if (isset($_GET['view']) && $_GET['view'] == 1) {
                                    if ($row['protokoll_status'] != 0 && $row['protokoll_status'] != 1) {
                                        continue;
                                    }
                                }

                                if ($row['patname'] != NULL) {
                                    $patname = $row['patname'];
                                } else {
                                    $patname = "Unbekannt";
                                }

                                if ($row['enr'] != NULL) {
                                    $enr = $row['enr'];
                                } else {
                                    $enr = "Unbekannt";
                                }

                                echo "<tr>";
                                echo "<td >" . $enr . "</td>";
                                echo "<td>" . $patname . "</td>";
                                echo "<td><span style='display:none'>" . $row['sendezeit'] . "</span>" . $date . "</td>";
                                echo "<td>" . $row['pfname'] . " " . $freigabe_status . "</td>";
                                echo "<td>" . $status . "</td>";
                                if ($edview || $admincheck) {
                                    echo "<td><a title='Protokoll ansehen' href='/admin/edivi/divi" . $row['id'] . "' class='btn btn-sm btn-primary'><i class='fa-solid fa-eye'></i></a> <a title='Protokoll löschen' href='/admin/edivi/delete.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' target='_blank'><i class='fa-solid fa-trash'></i></a></td>";
                                } else {
                                    echo "<td></td>";
                                }
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
            var table = $('#table-protokoll').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [10, 20, 50, 100],
                pageLength: 20,
                order: [
                    [2, 'desc']
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
                    "infoFiltered": "| Gefiltert von _MAX_ Protokollen",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Protokolle pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Protokoll suchen:",
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
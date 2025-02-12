<?php
session_start();
require_once '../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$frsrd) {
    header("Location: /admin/users/list.php?message=error-2");
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
    <?php include "../assets/php/preload.php"; ?>
    <?php include "../assets/components/c_topnav.php"; ?>
    <!-- NAVIGATION -->
    <div class="container shadow rounded-3 position-relative bg-light mb-3" style="margin-top:-50px;z-index:10" id="mainpageContainer">
        <?php include '../assets/php/admin-nav-v2.php' ?>
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row" id="startpage">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1>Prüfungsverwaltung</h1>
                    <div class="my-5 text-center">
                        <a href="generate.php" class="btn btn-secondary">Rettungssanitäter generieren</a> <span class="mx-2"></span> <a href="#" class="btn btn-secondary">Notfallsanitäter generieren</a>
                    </div>
                    <table class="table table-striped" id="test-table">
                        <thead>
                            <th scope="col">ID</th>
                            <th scope="col">Hash / Link</th>
                            <th scope="col">Test</th>
                            <th scope="col">Status</th>
                            <th scope="col">Zeitstempel</th>
                        </thead>
                        <tbody>
                            <?php
                            include '../assets/php/mysql-con.php';
                            $result = mysqli_query($conn, "SELECT * FROM cirs_frs_exams");
                            while ($row = mysqli_fetch_array($result)) {
                                $datetime = new DateTime($row['timestamp']);
                                $date = $datetime->format('d.m.Y | H:i');

                                $datetime2 = new DateTime($row['timestamp_used']);
                                $date2 = $datetime2->format('d.m.Y | H:i');

                                if ($datetime == $datetime2) {
                                    $date2 = NULL;
                                }

                                if ($date2 == NULL) {
                                    $date2text = "";
                                } else {
                                    $date2text = " // Geöffnet: " . $date2;
                                }

                                if ($row['test'] <= 10) {
                                    $testtext = "RS - " . $row['test'];
                                } else if ($row['test'] == 11) {
                                    $testtext = "NFS - 1";
                                }

                                if ($row['used'] == 0) {
                                    $status = "<span class='badge bg-success'>Ungeöffnet</span>";
                                } else {
                                    $status = "<span class='badge bg-danger'>Geöffnet</span>";
                                }

                                echo "<tr>";
                                echo "<td >" . $row['id'] . "</td>";
                                if ($row['used'] == 0) {
                                    echo "<td><a href='https://intra.muster.de/frsrd/test?code=" . $row['hash'] . "' class='copy-link' style='text-decoration:none'>" . $row['hash'] .  " <i class='fa-solid fa-copy fa-2xs'></i></a></td>";
                                } else {
                                    echo "<td>" . $row['hash'] .  "</a></td>";
                                }
                                echo "<td >" . $testtext . "</td>";
                                echo "<td >" . $status . "</td>";
                                echo "<td><span style='display:none'>" . $row['timestamp'] . "</span>" . $date . $date2text . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
                var table = $('#test-table').DataTable({
                    stateSave: true,
                    paging: true,
                    lengthMenu: [5, 10, 20],
                    pageLength: 10,
                    order: [
                        [4, 'desc']
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
                        "infoFiltered": "| Gefiltert von _MAX_ Prüfungen",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "_MENU_ Prüfungen pro Seite anzeigen",
                        "loadingRecords": "Lade...",
                        "processing": "Verarbeite...",
                        "search": "Prüfung suchen:",
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var links = document.querySelectorAll('.copy-link');
                links.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default link behavior (opening the link)

                        var linkUrl = this.getAttribute('href'); // Get the link from the href attribute
                        copyToClipboard(linkUrl); // Call the function to copy the link to the clipboard
                    });
                });

                // Function to copy text to clipboard
                function copyToClipboard(text) {
                    var textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                }
            });
        </script>
</body>

</html>
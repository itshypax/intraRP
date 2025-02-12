<?php
session_start();
require_once '../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
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

<body data-page="dashboard">
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
                    <h1>Dashboard</h1>
                    <?php if (isset($_GET['message']) && $_GET['message'] === 'error-2') { ?>
                        <div class="alert alert-danger" role="alert">
                            <h5>Fehler!</h5>
                            Dazu hast du nicht die richtigen Berechtigungen!
                        </div>
                    <?php } ?>
                    <div class="alert alert-primary" role="alert">
                        <h3>Hallo, <?= $_SESSION['cirs_user'] ?>!</h3>
                        Willkommen im Schweizer Taschenmesser der Berufsfeuerwehr.
                    </div>
                    <div class="row">
                        <div class="col-6 bg-sh-gray me-2">
                            <?php include "../assets/php/mysql-con.php";
                            $query3 = "SELECT cirs_status, COUNT(*) as count FROM cirs_antraege_be GROUP BY cirs_status";
                            $result3 = $conn->query($query3);

                            // Create empty arrays to store the data
                            $data3 = [];
                            $labels3 = [];

                            $antragStatus = [
                                0 => "in Bearbeitung",
                                1 => "Abgelehnt",
                                2 => "Aufgeschoben",
                                3 => "Angenommen",
                            ];

                            // Process the query result
                            if ($result3->num_rows > 0) {
                                while ($row = $result3->fetch_assoc()) {
                                    $status = $row['cirs_status'];
                                    $rankLabel = isset($antragStatus[$status]) ? $antragStatus[$status] : 'Unbekannt';

                                    $data3[] = $row['count'];
                                    $labels3[] = $rankLabel;
                                }
                            }

                            ?>
                            <canvas id="antragChart"></canvas>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                var ctx = document.getElementById('antragChart').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($labels3); ?>,
                                        datasets: [{
                                            label: 'Beförderungsanträge',
                                            data: <?php echo json_encode($data3); ?>,
                                            backgroundColor: 'rgba(110, 168, 254, .7)', // Example color
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                precision: 0
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="col bg-sh-gray">

                            <?php
                            $statusMapping = [
                                0 => 'Ungesehen',
                                1 => 'in Prüfung',
                                2 => 'Freigegeben',
                                3 => 'Ungenügend',
                            ];

                            $query2 = "SELECT protokoll_status, COUNT(*) as count FROM cirs_rd_protokolle GROUP BY protokoll_status";
                            $result2 = $conn->query($query2);

                            $data2 = [];
                            $labels2 = [];

                            if ($result2->num_rows > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    $status = $row['protokoll_status'];
                                    $statusLabel = isset($statusMapping[$status]) ? $statusMapping[$status] : 'Unbekannt';

                                    $data2[] = $row['count'];
                                    $labels2[] = $statusLabel;
                                }
                            }
                            ?>
                            <canvas id="statusChart"></canvas>
                            <script>
                                var ctx2 = document.getElementById('statusChart').getContext('2d');
                                var chart2 = new Chart(ctx2, {
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($labels2); ?>,
                                        datasets: [{
                                            label: 'eDIVI-Protokolle',
                                            data: <?php echo json_encode($data2); ?>,
                                            backgroundColor: 'rgba(255, 164, 47, .7)', // Example color
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                precision: 0
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col bg-sh-gray px-auto">
                            <?php
                            $query = "SELECT dienstgrad, COUNT(*) as count FROM personal_profile GROUP BY dienstgrad";
                            $result = $conn->query($query);

                            // Create empty arrays to store the data
                            $data = [];
                            $labels = [];

                            $dienstgrade = [
                                16 => "Ehrenamt",
                                0 => "Angestellt",
                                1 => "BMA",
                                2 => "BM",
                                3 => "OBM",
                                4 => "HBM",
                                5 => "HBMZ",
                                17 => "BIA",
                                6 => "BI",
                                7 => "OBI",
                                8 => "BAM",
                                9 => "BAR",
                                10 => "BOAR",
                                15 => "BRef",
                                11 => "BR",
                                12 => "OBR",
                                13 => "BD",
                                14 => "LBD",
                            ];

                            // Process the query result
                            $temp = []; // Temporary array to hold dienstgrad => count mapping

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $temp[$row['dienstgrad']] = $row['count'];
                                }
                            }

                            // Custom sort order
                            $customOrder = [16, 0, 1, 2, 3, 4, 5, 17, 6, 7, 8, 9, 10, 15, 11, 12, 13, 14];

                            // Populate $data and $labels based on the custom sort order
                            foreach ($customOrder as $rank) {
                                if (isset($temp[$rank])) {
                                    $data[] = $temp[$rank];
                                    $labels[] = $dienstgrade[$rank];
                                }
                            }
                            ?>
                            <canvas id="rankChart"></canvas>

                            <script>
                                var ctx = document.getElementById('rankChart').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                            label: 'Mitarbeiter pro Dienstgrad',
                                            data: <?php echo json_encode($data); ?>,
                                            backgroundColor: 'rgba(212, 0, 75, .7)', // Example color
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                precision: 0
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
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
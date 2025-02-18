<?php
session_start();
require_once '../../assets/php/permissions.php';
require '../../assets/php/mysql-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];

    try {
        // Required fields
        $fullname = $_POST['fullname'] ?? '';
        $gebdatum = $_POST['gebdatum'] ?? '';
        $charakterid = $_POST['charakterid'] ?? '';
        $dienstgrad = $_POST['dienstgrad'] ?? '';
        $forumprofil = $_POST['forumprofil'] ?? '';
        $discordtag = $_POST['discordtag'] ?? '';
        $telefonnr = $_POST['telefonnr'] ?? '';
        $dienstnr = $_POST['dienstnr'] ?? '';
        $einstdatum = $_POST['einstdatum'] ?? '';

        // Ensure required fields are not empty
        if (empty($fullname) || empty($gebdatum) || empty($charakterid) || empty($dienstgrad)) {
            $response['message'] = "Bitte alle erforderlichen Felder ausfüllen.";
            echo json_encode($response);
            exit;
        }

        // Insert user into database
        $stmt = mysqli_prepare($conn, "INSERT INTO personal_profile (fullname, gebdatum, charakterid, dienstgrad, forumprofil, discordtag, telefonnr, dienstnr, einstdatum) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssiss", $fullname, $gebdatum, $charakterid, $dienstgrad, $forumprofil, $discordtag, $telefonnr, $dienstnr, $einstdatum);
        mysqli_stmt_execute($stmt);
        $savedId = mysqli_insert_id($conn);

        // Log the action
        $edituser = $_SESSION['cirs_user'] ?? 'Unknown';
        $logContent = 'Mitarbeiter wurde angelegt.';
        $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '6', ?, ?)");
        mysqli_stmt_bind_param($logStmt, "iss", $savedId, $logContent, $edituser);
        mysqli_stmt_execute($logStmt);

        $response['success'] = true;
        $response['message'] = "Benutzer erfolgreich erstellt!";
        $response['redirect'] = "/admin/personal/profile.php?id=" . $savedId;
    } catch (Exception $e) {
        $response['message'] = "Fehler: " . $e->getMessage();
    }

    echo json_encode($response);
    exit;
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
    <link rel="stylesheet" href="/assets/css/personal.min.css" />
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <h1 class="mb-3">Mitarbeiterprofil</h1>
                    <div class="row">
                        <div class="col p-3 shadow-sm border ma-basedata">
                            <form id="profil" method="post" novalidate>
                                <a href="#" class="btn btn-success btn-sm" id="personal-save">
                                    <i class="fa-solid fa-floppy-disk"></i> Speichern / Benutzer erstellen
                                </a>
                                <?php
                                // Function to remove the 'edit' parameter from the URL
                                function removeEditParamFromURL()
                                {
                                    $currentURL = $_SERVER['REQUEST_URI'];
                                    $parsedURL = parse_url($currentURL);
                                    parse_str($parsedURL['query'], $queryParams);
                                    unset($queryParams['edit']);
                                    $newQuery = http_build_query($queryParams);
                                    $modifiedURL = $parsedURL['path'] . '?' . $newQuery;
                                    return $modifiedURL;
                                }
                                ?>
                                <div class="w-100 text-center">
                                    <i class="fa-solid fa-circle-user" style="font-size:94px"></i>
                                    <?php
                                    $options = [
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
                                    ?>
                                    <select class="form-select mt-3" name="dienstgrad" id="dienstgrad" required>
                                        <option value="" selected hidden>Dienstgrad wählen</option>
                                        <?php foreach ($options as $value => $label) : ?>
                                            <option value="<?php echo $value; ?>">
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <hr class="my-3">
                                    <input type="hidden" name="new" value="1" />
                                    <table class="mx-auto">
                                        <tbody class="text-start">
                                            <tr>
                                                <td class="fw-bold" style="width:33%">Vor- und Zuname</td>
                                                <td><span class="mx-1"></span></td>
                                                <td style="width:66%">
                                                    <input class="form-control w-100" type="text" name="fullname" id="fullname" value="" required>
                                                    <div class="invalid-feedback">Bitte gebe einen Namen ein.</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Geburtsdatum</td>
                                                <td><span class="mx-1"></span></td>
                                                <td>
                                                    <input class="form-control" type="date" name="gebdatum" id="gebdatum" value="" min="1900-01-01" required>
                                                    <div class="invalid-feedback">Bitte gebe ein Geburtsdatum ein.</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Charakter-ID</td>
                                                <td><span class="mx-1"></span></td>
                                                <td>
                                                    <input class="form-control" type="text" name="charakterid" id="charakterid" value="" pattern="[a-zA-Z]{3}[0-9]{5}" required>
                                                    <div class="invalid-feedback">Bitte gebe eine charakter-ID ein.</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Foren-Profil</td>
                                                <td><span class="mx-1"></span></td>
                                                <td><input class="form-control" type="number" name="forumprofil" id="forumprofil" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Discord-Tag</td>
                                                <td><span class="mx-1"></span></td>
                                                <td><input class="form-control" type="text" name="discordtag" id="discordtag" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Telefonnummer</td>
                                                <td><span class="mx-1"></span></td>
                                                <td><input class="form-control" type="text" name="telefonnr" id="telefonnr" value="0176 00 00 00 0"></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Dienstnummer</td>
                                                <td><span class="mx-1"></span></td>
                                                <td>
                                                    <input class="form-control" type="number" name="dienstnr" id="dienstnr" value="" oninput="checkDienstnrAvailability()" required>
                                                    <div class="invalid-feedback">Bitte gebe eine Dienstnummer ein.</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Einstellungsdatum</td>
                                                <td><span class="mx-1"></span></td>
                                                <td>
                                                    <input class="form-control" type="date" name="einstdatum" id="einstdatum" value="" min="2022-01-01" required>
                                                    <div class="invalid-feedback">Bitte gebe ein Einstellungsdatum ein.</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
    <script>
        var delayTimer; // Variable to hold the timer

        function checkDienstnrAvailability() {
            clearTimeout(delayTimer); // Clear any existing timer

            delayTimer = setTimeout(function() {
                var dienstnr = $('#dienstnr').val(); // Get the entered dienstnr value

                $.ajax({
                    url: 'check_dienstnr_availability.php', // PHP file to handle the AJAX request
                    method: 'POST',
                    data: {
                        dienstnr: dienstnr
                    }, // Send dienstnr value to the server
                    success: function(response) {
                        if (response === 'exists') {
                            alert('Diese Dienstnummer ist bereits vergeben - wähle eine andere!');
                            $('#dienstnr').val(''); // Clear the input field
                        }
                    }
                });
            }, 500); // Delay in milliseconds (adjust as needed)
        }
    </script>
</body>

</html>
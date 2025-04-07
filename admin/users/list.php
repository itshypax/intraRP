<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$usview) {
    header("Location: /admin/users/list.php");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration &rsaquo; <?php echo SYSTEM_NAME ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/_ext/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/_ext/datatables/datatables.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="<?php echo SYSTEM_NAME ?>" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />
    <!-- Metas -->
    <meta name="theme-color" content="<?php echo SYSTEM_COLOR ?>" />
    <meta property="og:site_name" content="<?php echo SERVER_NAME ?>" />
    <meta property="og:url" content="https://<?php echo SYSTEM_URL ?>/dash.php" />
    <meta property="og:title" content="<?php echo SYSTEM_NAME ?> - Intranet <?php echo SERVER_CITY ?>" />
    <meta property="og:image" content="<?php echo META_IMAGE_URL ?>" />
    <meta property="og:description" content="Verwaltungsportal der <?php echo RP_ORGTYPE . " " .  SERVER_CITY ?>" />

</head>

<body data-bs-theme="dark" data-page="benutzer">
    <?php include "../../assets/components/navbar.php"; ?>
    <div class="container-full position-relative" id="mainpageContainer">
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1 class="mb-5">Benutzerübersicht</h1>
                    <?php
                    $messages = [
                        'error-1' => [
                            'type' => 'danger',
                            'title' => 'Fehler!',
                            'text' => 'Du kannst dich nicht selbst bearbeiten!'
                        ],
                        'error-2' => [
                            'type' => 'danger',
                            'title' => 'Fehler!',
                            'text' => 'Dazu hast du nicht die richtigen Berechtigungen!'
                        ],
                        'error-3' => [
                            'type' => 'danger',
                            'title' => 'Fehler!',
                            'text' => 'Du kannst keine Benutzer mit den Selben oder höheren Berechtigungen bearbeiten!'
                        ],
                        'success-1' => [
                            'type' => 'success',
                            'title' => 'Erfolg!',
                            'text' => 'Das Passwort für den Benutzer <strong>' . htmlspecialchars($_GET['user'] ?? '') . '</strong> wurde bearbeitet.<br>- Neues Passwort: <code>' . htmlspecialchars($_GET['pass'] ?? '') . '</code>'
                        ]
                    ];

                    if (isset($_GET['message']) && array_key_exists($_GET['message'], $messages)) {
                        $msg = $messages[$_GET['message']];
                    ?>
                        <div class="alert alert-<?= htmlspecialchars($msg['type']) ?> alert-dismissible fade show" role="alert">
                            <h5><?= htmlspecialchars($msg['title']) ?></h5>
                            <?= $msg['text'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
                        </div>
                    <?php } ?>
                    <div class="intra__tile py-2 px-3">
                        <table class="table table-striped" id="userTable">
                            <thead>
                                <th scope="col">UID</th>
                                <th scope="col">Name (Benutzername)</th>
                                <th scope="col">Rolle/Gruppe</th>
                                <th scope="col">Angelegt am</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                <?php
                                require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                                $stmt = $pdo->prepare("SELECT * FROM intra_users");
                                $stmt->execute();
                                $result = $stmt->fetchAll();

                                $stmt2 = $pdo->prepare("SELECT * FROM intra_users_roles");
                                $stmt2->execute();
                                $result2 = $stmt2->fetchAll(PDO::FETCH_UNIQUE);
                                foreach ($result as $row) {

                                    if ($row['full_admin'] == 1) {
                                        $role_color = "danger";
                                        $role_name = "Admin+";
                                    } else {
                                        $role_color = $result2[$row['role']]['color'];
                                        $role_name = $result2[$row['role']]['name'];
                                    }

                                    $date = (new DateTime($row['created_at']))->format('d.m.Y | H:i');
                                    echo "<tr>";
                                    echo "<td >" . $row['id'] . "</td>";
                                    echo "<td>" . $row['fullname'] .  " (<strong>" . $row['username'] . "</strong>)</td>";
                                    echo "<td><span class='badge bg-" . $role_color . "'>" . $role_name . "</span></td>";
                                    echo "<td><span style='display:none'>" . $row['created_at'] . "</span>" . $date . "</td>";
                                    if ($usedit || $admincheck) {
                                        echo "<td><a href='/admin/users/edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Bearbeiten</a>";
                                        if (isset($row['aktenid']) && $row['aktenid'] > 0) {
                                            echo " <a href='/admin/personal/profile.php?id=" . $row['aktenid'] . "' class='btn btn-sm btn-warning'>Profil</a>";
                                        }
                                        echo "</td>";
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
    </div>

    <script src="/assets/_ext/jquery/jquery.dataTables.min.js"></script>
    <script src="/assets/_ext/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#userTable').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [5, 10, 20],
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
                language: {
                    "decimal": "",
                    "emptyTable": "Keine Daten vorhanden",
                    "info": "Zeige _START_ bis _END_  | Gesamt: _TOTAL_",
                    "infoEmpty": "Keine Daten verfügbar",
                    "infoFiltered": "| Gefiltert von _MAX_ Benutzern",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Benutzer pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Benutzer suchen:",
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/assets/components/footer.php"; ?>
</body>

</html>
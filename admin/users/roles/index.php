<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

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
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/assets/components/navbar.php"; ?>
    <div class="container-full position-relative" id="mainpageContainer">
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h1 class="mb-0">Rollenverwaltung</h1>

                        <?php if ($fadmin) : ?>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                <i class="las la-plus"></i> Rolle erstellen
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php
                    $alerts = [
                        'success' => [
                            'updated' => ['type' => 'success', 'title' => 'Erfolg!', 'text' => 'Änderung erfolgreich gespeichert.'],
                            'deleted' => ['type' => 'success', 'title' => 'Erfolg!', 'text' => 'Die Rolle wurde erfolgreich gelöscht.'],
                            'created' => ['type' => 'success', 'title' => 'Erfolg!', 'text' => 'Die Rolle wurde erfolgreich erstellt.'],
                        ],
                        'error' => [
                            'exception' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Beim Speichern ist ein Fehler aufgetreten.'],
                            'invalid' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Ungültige Eingabe.'],
                            'not-allowed' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Keine Berechtigung.'],
                            'not-found' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Die Rolle wurde nicht gefunden.'],
                            'invalid-id' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Ungültige Rollen-ID.'],
                            'invalid-input' => ['type' => 'danger', 'title' => 'Fehler!', 'text' => 'Bitte fülle alle Pflichtfelder aus, um eine Rolle anzulegen.'],
                        ]
                    ];

                    foreach (['success', 'error'] as $type) {
                        if (isset($_GET[$type]) && isset($alerts[$type][$_GET[$type]])) {
                            $alert = $alerts[$type][$_GET[$type]];
                    ?>
                            <div class="alert alert-<?= htmlspecialchars($alert['type']) ?> alert-dismissible fade show" role="alert">
                                <strong><?= htmlspecialchars($alert['title']) ?></strong> <?= htmlspecialchars($alert['text']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
                            </div>
                    <?php
                            break;
                        }
                    }
                    ?>
                    <div class="intra__tile py-2 px-3">
                        <table class="table table-striped" id="table-rollen">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Priorität</th>
                                    <th scope="col">Bezeichnung</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                                $stmt = $pdo->prepare("SELECT * FROM intra_users_roles");
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {

                                    $actions = ($fadmin)
                                        ? "<a title='Rolle bearbeiten' href='#' class='btn btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editRoleModal' data-id='{$row['id']}' data-name='{$row['name']}' data-priority='{$row['priority']}' data-color='{$row['color']}' data-perms='{$row['permissions']}'><i class='las la-pen'></i></a>"
                                        : "";

                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['priority'] . "</td>";
                                    echo "<td><span class='badge text-bg-" . $row['color'] . "'>" . $row['name'] . "</span></td>";
                                    echo "<td>{$actions}</td>";
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

    <!-- MODAL BEGIN -->
    <?php if ($admincheck) : ?>
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/users/roles/update.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel">Rolle bearbeiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="role-id">

                            <div class="mb-3">
                                <label for="role-name" class="form-label">Bezeichnung</label>
                                <input type="text" class="form-control" name="name" id="role-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="role-priority" class="form-label">Priorität <small style="opacity:.5">(Je niedriger die Zahl, desto höher sortiert)</small></label>
                                <input type="number" class="form-control" name="priority" id="role-priority" required>
                            </div>

                            <?php
                            $permission_groups = [
                                'Anträge' => [
                                    'antraege_view' => 'Anträge ansehen',
                                    'antraege_edit' => 'Anträge bearbeiten'
                                ],
                                'eDIVI' => [
                                    'edivi_view' => 'eDIVI Protokolle ansehen',
                                    'edivi_edit' => 'eDIVI Protokolle bearbeiten'
                                ],
                                'Benutzer' => [
                                    'users_view' => 'Benutzer ansehen',
                                    'users_edit' => 'Benutzer bearbeiten',
                                    'users_create' => 'Benutzer erstellen',
                                    'users_delete' => 'Benutzer löschen'
                                ],
                                'Personal' => [
                                    'personal_view' => 'Mitarbeiter ansehen',
                                    'personal_edit' => 'Mitarbeiter bearbeiten',
                                    'personal_delete' => 'Mitarbeiter löschen',
                                    'personal_kommentar_delete' => 'Mitarbeiter-Kommentare löschen',
                                    'intra_mitarbeiter_dokumente' => 'Mitarbeiter-Dokumente verwalten'
                                ],
                                'Dateien' => [
                                    'files_upload' => 'Dateien hochladen',
                                    'files_log' => 'Datei-Uploads einsehen'
                                ],
                                'Admin' => [
                                    'admin' => 'Alle Rechte (Admin)'
                                ]
                            ];
                            ?>
                            <div class="mb-3">
                                <label class="form-label">Berechtigungen</label>

                                <?php foreach ($permission_groups as $groupName => $group): ?>
                                    <div class="mb-3 border-bottom pb-2">
                                        <h6 class="mb-2"><span style="opacity:.5;font-size:.8rem"><?= $groupName ?></span></h6>
                                        <div class="row">
                                            <?php foreach ($group as $perm => $desc): ?>
                                                <div class="col-6 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= $perm ?>" id="perm-<?= $perm ?>">
                                                        <label class="form-check-label" for="perm-<?= $perm ?>">
                                                            <?= $desc ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Badge</label>
                                <div class="row">
                                    <?php
                                    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                                    foreach ($colors as $color) :
                                    ?>
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="color" id="role-color-<?= $color ?>" value="<?= $color ?>" required>
                                                <label class="form-check-label w-100" for="role-color-<?= $color ?>">
                                                    <span class="badge text-bg-<?= $color ?> w-100 py-2 d-block text-center"><?= ucfirst($color) ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" id="delete-role-btn">Löschen</button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                <button type="submit" class="btn btn-primary">Speichern</button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-role-form" action="/admin/users/roles/delete.php" method="POST" style="display:none;">
                        <input type="hidden" name="id" id="role-delete-id">
                    </form>
                </div>
            </div>
        </div>
        </div>
    <?php endif; ?>
    <!-- MODAL END -->
    <!-- MODAL 2 BEGIN -->
    <?php if ($fadmin) : ?>
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/users/roles/create.php" method="POST">

                        <div class="modal-header">
                            <h5 class="modal-title" id="createRoleModalLabel">Neue Rolle erstellen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="new-role-name" class="form-label">Bezeichnung</label>
                                <input type="text" class="form-control" name="name" id="new-role-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="new-role-priority" class="form-label">Priorität</label>
                                <input type="number" class="form-control" name="priority" id="new-role-priority" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Berechtigungen</label>
                                <div class="row">
                                    <?php foreach ($permission_groups as $groupName => $group): ?>
                                        <div class="mb-2 border-bottom pb-2">
                                            <h6 class="mb-2"><span style="opacity:.5;font-size:.8rem"><?= $groupName ?></span></h6>
                                            <div class="row">
                                                <?php foreach ($group as $perm => $desc): ?>
                                                    <div class="col-6 mb-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= $perm ?>" id="perm-create-<?= $perm ?>">
                                                            <label class="form-check-label" for="perm-create-<?= $perm ?>"><?= $desc ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Badge</label>
                                <div class="row">
                                    <?php
                                    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                                    foreach ($colors as $color) :
                                    ?>
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="color" id="new-role-color-<?= $color ?>" value="<?= $color ?>" required>
                                                <label class="form-check-label w-100" for="new-role-color-<?= $color ?>">
                                                    <span class="badge text-bg-<?= $color ?> w-100 py-2 d-block text-center"><?= ucfirst($color) ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-success">Erstellen</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- MODAL 2 END -->

    <script src="/assets/_ext/jquery/jquery.dataTables.min.js"></script>
    <script src="/assets/_ext/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table-rollen').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [5, 10, 20],
                pageLength: 10,
                order: [
                    [1, 'asc']
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
                    "infoFiltered": "| Gefiltert von _MAX_ Rollen",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Rollen pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Rolle suchen:",
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
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    document.getElementById('role-id').value = id;
                    document.getElementById('role-name').value = this.dataset.name;
                    document.getElementById('role-priority').value = this.dataset.priority;

                    const perms = JSON.parse(this.dataset.perms || '[]');

                    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                        checkbox.checked = perms.includes(checkbox.value);
                    });

                    const colorValue = this.dataset.color || '';
                    const radio = document.getElementById('role-color-' + colorValue);
                    if (radio) radio.checked = true;

                    document.getElementById('role-delete-id').value = id;
                });
            });

            document.getElementById('delete-role-btn').addEventListener('click', function() {
                if (confirm('Möchtest du diese Rolle wirklich löschen?')) {
                    document.getElementById('delete-role-form').submit();
                }
            });
        });
    </script>
</body>

</html>
<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    header("Location: /admin/login.php");
    exit();
}

use App\Auth\Permissions;
use App\Helpers\Flash;
use App\Localization\Lang;

Lang::setLanguage(LANG ?? 'de');

if (!Permissions::check(['admin', 'personnel.view'])) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/index.php");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= lang('title', [SYSTEM_NAME]) ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="/vendor/components/jquery/jquery.min.js"></script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/vendor/datatables.net/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
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
    <meta property="og:url" content="https://<?php echo SYSTEM_URL ?>/dashboard.php" />
    <meta property="og:title" content="<?= lang('metas.title', [SYSTEM_NAME, SERVER_CITY]) ?>" />
    <meta property="og:image" content="<?php echo META_IMAGE_URL ?>" />
    <meta property="og:description" content="<?= lang('metas.description', [RP_ORGTYPE, SERVER_CITY]) ?>" />

</head>

<body data-bs-theme="dark" data-page="mitarbeiter">
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
                        <h1 class="mb-0"><?= lang('personnel.fwqualifications.title') ?></h1>

                        <?php if (Permissions::check('admin')) : ?>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createDienstgradModal">
                                <i class="las la-plus"></i> <?= lang('personnel.fwqualifications.create') ?>
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php
                    Flash::render();
                    ?>
                    <div class="intra__tile py-2 px-3">
                        <table class="table table-striped" id="table-dienstgrade">
                            <thead>
                                <tr>
                                    <th scope="col"><?= lang('personnel.fwqualifications.table.priority') ?></th>
                                    <th scope="col"><?= lang('personnel.fwqualifications.table.name') ?> <i class="las la-venus-mars"></i></th>
                                    <th scope="col"><?= lang('personnel.fwqualifications.table.name') ?> <i class="las la-mars"></i></th>
                                    <th scope="col"><?= lang('personnel.fwqualifications.table.name') ?> <i class="las la-venus"></i></th>
                                    <th scope="col"><?= lang('personnel.fwqualifications.table.empty') ?></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                                $stmt = $pdo->prepare("SELECT * FROM intra_mitarbeiter_fwquali");
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    $dimmed = '';

                                    switch ($row['none']) {
                                        case 0:
                                            $dgActive = "<span class='badge text-bg-success'>" . lang('personnel.fwqualifications.table.no') . "</span>";
                                            break;
                                        default:
                                            $dgActive = "<span class='badge text-bg-danger'>" . lang('personnel.fwqualifications.table.yes') . "</span>";
                                            $dimmed = "style='color:var(--tag-color)'";
                                            break;
                                    }

                                    $actions = (Permissions::check('admin'))
                                        ? "<a title='" . lang('personnel.fwqualifications.table.manage') . "' href='#' class='btn btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editDienstgradModal' data-id='{$row['id']}' data-shortname='{$row['shortname']}' data-name='{$row['name']}' data-name_m='{$row['name_m']}' data-name_w='{$row['name_w']}' data-priority='{$row['priority']}' data-none='{$row['none']}'><i class='las la-pen'></i></a>"
                                        : "";

                                    echo "<tr>";
                                    echo "<td " . $dimmed . ">" . $row['priority'] . "</td>";
                                    echo "<td " . $dimmed . ">" . $row['name'] . "</td>";
                                    echo "<td " . $dimmed . ">" . $row['name_m'] . "</td>";
                                    echo "<td " . $dimmed . ">" . $row['name_w'] . "</td>";
                                    echo "<td>" . $dgActive . "</td>";
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
    <?php if (Permissions::check('admin')) : ?>
        <div class="modal fade" id="editDienstgradModal" tabindex="-1" aria-labelledby="editDienstgradModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/personal/management/qualifw/update.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDienstgradModalLabel"><?= lang('personnel.fwqualifications.modals.edit.title') ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="dienstgrad-id">

                            <div class="mb-3">
                                <label for="dienstgrad-shortname" class="form-label"><?= lang('personnel.fwqualifications.modals.edit.shortname') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.edit.shortname_info') ?></small></label>
                                <input type="text" class="form-control" name="shortname" id="dienstgrad-shortname" required>
                            </div>

                            <div class="mb-3">
                                <label for="dienstgrad-name" class="form-label"><?= lang('personnel.fwqualifications.modals.edit.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.edit.name_general') ?></small></label>
                                <input type="text" class="form-control" name="name" id="dienstgrad-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="dienstgrad-name_m" class="form-label"><?= lang('personnel.fwqualifications.modals.edit.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.edit.name_male') ?></small></label>
                                <input type="text" class="form-control" name="name_m" id="dienstgrad-name_m" required>
                            </div>

                            <div class="mb-3">
                                <label for="dienstgrad-name_w" class="form-label"><?= lang('personnel.fwqualifications.modals.edit.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.edit.name_female') ?></small></label>
                                <input type="text" class="form-control" name="name_w" id="dienstgrad-name_w" required>
                            </div>

                            <div class="mb-3">
                                <label for="dienstgrad-priority" class="form-label"><?= lang('personnel.fwqualifications.modals.edit.priority') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.edit.priority_info') ?></small></label>
                                <input type="number" class="form-control" name="priority" id="dienstgrad-priority" required>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="none" id="dienstgrad-none">
                                <label class="form-check-label" for="dienstgrad-none"><?= lang('personnel.fwqualifications.modals.edit.empty') ?></label>
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" id="delete-dienstgrad-btn"><?= lang('personnel.fwqualifications.modals.edit.delete') ?></button>

                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('personnel.fwqualifications.modals.edit.close') ?></button>
                                <button type="submit" class="btn btn-primary"><?= lang('personnel.fwqualifications.modals.edit.save') ?></button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-dienstgrad-form" action="/admin/personal/management/qualifw/delete.php" method="POST" style="display:none;">
                        <input type="hidden" name="id" id="dienstgrad-delete-id">
                    </form>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- MODAL END -->
    <!-- MODAL 2 BEGIN -->
    <?php if (Permissions::check('admin')) : ?>
        <div class="modal fade" id="createDienstgradModal" tabindex="-1" aria-labelledby="createDienstgradModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/admin/personal/management/qualifw/create.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createDienstgradModalLabel"><?= lang('personnel.fwqualifications.modals.create.title') ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="new-dienstgrad-shortname" class="form-label"><?= lang('personnel.fwqualifications.modals.create.shortname') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.create.shortname_info') ?></small></label>
                                <input type="text" class="form-control" name="shortname" id="new-dienstgrad-shortname" required>
                            </div>

                            <div class="mb-3">
                                <label for="new-dienstgrad-name" class="form-label"><?= lang('personnel.fwqualifications.modals.create.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.create.name_general') ?></small></label>
                                <input type="text" class="form-control" name="name" id="new-dienstgrad-name" required>
                            </div>

                            <div class="mb-3">
                                <label for="new-dienstgrad-name_m" class="form-label"><?= lang('personnel.fwqualifications.modals.create.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.create.name_male') ?></small></label>
                                <input type="text" class="form-control" name="name_m" id="new-dienstgrad-name_m" required>
                            </div>

                            <div class="mb-3">
                                <label for="new-dienstgrad-name_w" class="form-label"><?= lang('personnel.fwqualifications.modals.create.name') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.create.name_female') ?></small></label>
                                <input type="text" class="form-control" name="name_w" id="new-dienstgrad-name_w" required>
                            </div>

                            <div class="mb-3">
                                <label for="new-dienstgrad-priority" class="form-label"><?= lang('personnel.fwqualifications.modals.create.priority') ?> <small style="opacity:.5"><?= lang('personnel.fwqualifications.modals.create.priority_info') ?></small></label>
                                <input type="number" class="form-control" name="priority" id="new-dienstgrad-priority" value="0" required>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="none" id="new-dienstgrad-none">
                                <label class="form-check-label" for="new-dienstgrad-none"><?= lang('personnel.fwqualifications.modals.create.empty') ?></label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('personnel.fwqualifications.modals.create.close') ?></button>
                            <button type="submit" class="btn btn-success"><?= lang('personnel.fwqualifications.modals.create.save') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- MODAL 2 END -->


    <script src="/vendor/datatables.net/datatables.net/js/dataTables.min.js"></script>
    <script src="/vendor/datatables.net/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table-dienstgrade').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [5, 10, 20],
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
                language: {
                    "decimal": "",
                    "emptyTable": <?= json_encode(lang('datatable.emptytable')) ?>,
                    "info": <?= json_encode(lang('datatable.info')) ?>,
                    "infoEmpty": <?= json_encode(lang('datatable.infoempty')) ?>,
                    "infoFiltered": <?= json_encode(lang('personnel.fwqualifications.datatable.infofiltered')) ?>,
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": <?= json_encode(lang('personnel.fwqualifications.datatable.lengthmenu')) ?>,
                    "loadingRecords": <?= json_encode(lang('datatable.loadingrecords')) ?>,
                    "processing": <?= json_encode(lang('datatable.processing')) ?>,
                    "search": <?= json_encode(lang('personnel.fwqualifications.datatable.search')) ?>,
                    "zeroRecords": <?= json_encode(lang('datatable.zerorecords')) ?>,
                    "paginate": {
                        "first": <?= json_encode(lang('datatable.paginate.first')) ?>,
                        "last": <?= json_encode(lang('datatable.paginate.last')) ?>,
                        "next": <?= json_encode(lang('datatable.paginate.next')) ?>,
                        "previous": <?= json_encode(lang('datatable.paginate.previous')) ?>
                    },
                    "aria": {
                        "sortAscending": <?= json_encode(lang('datatable.aria.sortascending')) ?>,
                        "sortDescending": <?= json_encode(lang('datatable.aria.sortdescending')) ?>
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
                    document.getElementById('dienstgrad-id').value = id;
                    document.getElementById('dienstgrad-name').value = this.dataset.name;
                    document.getElementById('dienstgrad-name_m').value = this.dataset.name_m;
                    document.getElementById('dienstgrad-name_w').value = this.dataset.name_w;
                    document.getElementById('dienstgrad-priority').value = this.dataset.priority;
                    document.getElementById('dienstgrad-shortname').value = this.dataset.shortname;
                    document.getElementById('dienstgrad-none').checked = this.dataset.none == 1;

                    document.getElementById('dienstgrad-delete-id').value = id;
                });
            });

            document.getElementById('delete-dienstgrad-btn').addEventListener('click', function() {
                if (confirm('Möchtest du diese Qualifikation wirklich löschen?')) {
                    document.getElementById('delete-dienstgrad-form').submit();
                }
            });
        });
    </script>
</body>

</html>
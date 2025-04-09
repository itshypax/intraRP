<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . "/assets/config/database.php";

use App\Localization\Lang;

Lang::setLanguage(LANG ?? 'de');

$caseid = $_GET['antrag'];

$stmt = $pdo->prepare("SELECT * FROM intra_antrag_bef WHERE uniqueid = ?");
$stmt->execute([$caseid]);
$row = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= lang('application.title', [SYSTEM_NAME]) ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/cirs.min.css" />
    <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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

<body id="antrag">
    <!-- NAVIGATION -->
    <nav class="navbar bg-main-color" id="cirs-nav">
        <div class="container-fluid">
            <div class="container">
                <div class="row w-100">
                    <div class="col d-flex align-items-center justify-content-start">
                        <a id="sb-logo" href="#">
                            <img src="/assets/img/schriftzug_stadt_weiss.png" alt="<?= lang('application.create.city_name', [SERVER_CITY]) ?>" width="auto" height="64px">
                        </a>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end text-light" id="pageTitle">
                        <?= lang('application.create.title') ?>
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
            <div class="col-2 border-2 border-top border-semigray bg-gray-color" id="cirs-links">
                <hr class="text-gray-color my-3">
                <?php include '../assets/components/navbar_antraege.php' ?>
            </div>
            <div class="col"></div>
            <div class="col-6 my-5">
                <hr class="text-light my-3">
                <?php
                if ($row['cirs_status'] == "0") {
                    $badge_color = "bg-info";
                    $badge_text = lang('application.status.0');
                } elseif ($row['cirs_status'] == "1") {
                    $badge_color = "bg-danger";
                    $badge_text = lang('application.status.1');
                } elseif ($row['cirs_status'] == "2") {
                    $badge_color = "bg-warning";
                    $badge_text = lang('application.status.2');
                } elseif ($row['cirs_status'] == "3") {
                    $badge_color = "bg-success";
                    $badge_text = lang('application.status.3');
                } else {
                    $badge_color = "bg-dark";
                    $badge_text = lang('error');
                }
                ?>
                <h1><?= lang('application.create.view_application') ?> <span class="badge text-<?= $badge_color ?>"><?= $badge_text ?></span></h1>
                <hr class="text-light my-3">
                <form action="" id="cirs-form" method="post">
                    <input type="hidden" name="new" value="1" />
                    <input type="hidden" name="case_id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="cirs_manger" value="<?= $_SESSION['cirs_user'] ?? "Fehler Fehler" ?>">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name_dn" class="form-label fw-bold"><?= lang('application.create.form.name_and_servicenr') ?> <span class="text-main-color">*</span></label>
                            <input type="text" class="form-control" id="name_dn" name="name_dn" placeholder="" value="<?= $row['name_dn'] ?>" required disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dienstgrad" class="form-label fw-bold"><?= lang('application.create.form.current_rank') ?> <span class="text-main-color">*</span></label>
                            <input type="text" class="form-control" id="dienstgrad" name="dienstgrad" placeholder="" value="<?= $row['dienstgrad'] ?>" required disabled>
                        </div>
                    </div>
                    <hr class="text-light my-3">
                    <h5><?= lang('application.create.form.written_request') ?></h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="freitext" name="freitext" rows="5" disabled><?= $row['freitext'] ?></textarea>
                    </div>
                    <hr class="text-light my-3">
                    <div class="mb-3">
                        <?php if ($row['cirs_manager'] != NULL) { ?>
                            <h5><?= lang('application.view.application_editor') ?> <?= $row['cirs_manager'] ?></h5>
                        <?php } else { ?>
                            <h5><?= lang('application.view.application_no_editor') ?></h5>
                        <?php } ?>
                    </div>
                    <hr class="text-light my-3">
                    <h5><?= lang('application.view.note') ?></h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="cirs_text" name="cirs_text" rows="5" disabled><?= $row['cirs_text'] ?></textarea>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/assets/components/footer.php"; ?>
</body>

</html>
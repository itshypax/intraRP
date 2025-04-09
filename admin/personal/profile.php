<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    header("Location: /admin/login.php");
}

use App\Auth\Permissions;
use App\Helpers\Flash;
use App\Localization\Lang;

Lang::setLanguage(LANG ?? 'de');

if (!Permissions::check(['admin', 'personnel.view'])) {
    Flash::set('error', 'no-permissions');
    header("Location: /admin/index.php");
}

$userid = $_SESSION['userid'];

$stmt = $pdo->prepare("SELECT * FROM intra_mitarbeiter WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['aktenid'] != null) {
    $statement = $pdo->prepare("SELECT * FROM intra_mitarbeiter WHERE id = :id");
    $statement->execute(array('id' => $_SESSION['aktenid']));
    $profile = $statement->fetch();
}

$openedID = $_GET['id'];
$edituser = $_SESSION['cirs_user'];
$edituseric = $profile['fullname'];
$editdg = $profile['dienstgrad'];

$stmtg = $pdo->prepare("SELECT * FROM intra_mitarbeiter_dienstgrade WHERE id = :id");
$stmtg->execute(['id' => $row['dienstgrad']]);
$dginfo = $stmtg->fetch();

$stmtr = $pdo->prepare("SELECT * FROM intra_mitarbeiter_rdquali WHERE id = :id");
$stmtr->execute(['id' => $row['qualird']]);
$rdginfo = $stmtr->fetch();

$stmtf = $pdo->prepare("SELECT * FROM intra_mitarbeiter_fwquali WHERE id = :id");
$stmtf->execute(['id' => $row['qualifw2']]);
$fwginfo = $stmtf->fetch();

$bfqualtext = $fwginfo['shortname'];

if ($row['geschlecht'] == 0) {
    $dienstgradText = $dginfo['name_m'];
    $rdqualtext = $rdginfo['name_m'];
} elseif ($row['geschlecht'] ==  1) {
    $dienstgradText = $dginfo['name_w'];
    $rdqualtext = $rdginfo['name_w'];
} else {
    $dienstgradText = $dginfo['name'];
    $rdqualtext = $rdginfo['name'];
}

if (isset($_POST['new'])) {
    if ($_POST['new'] == 1) {
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $gebdatum = $_POST['gebdatum'];
        $dienstgrad = $_POST['dienstgrad'];
        $discordtag = $_POST['discordtag'];
        $telefonnr = $_POST['telefonnr'];
        $dienstnr = $_POST['dienstnr'];
        $qualird = $_POST['qualird'];
        $qualifw2 = $_POST['qualifw2'];
        $geschlecht = $_POST['geschlecht'];
        $zusatzqual = $_POST['zusatzqual'];

        if (CHAR_ID) {
            $charakterid = $_POST['charakterid'];
            $stmt = $pdo->prepare("SELECT dienstgrad, fullname, gebdatum, charakterid, discordtag, telefonnr, dienstnr, qualird, qualifw2, geschlecht, zusatz FROM intra_mitarbeiter WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("SELECT dienstgrad, fullname, gebdatum, discordtag, telefonnr, dienstnr, qualird, qualifw2, geschlecht, zusatz FROM intra_mitarbeiter WHERE id = :id");
        }

        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $currentDienstgrad = $data['dienstgrad'];
            $currentFullname = $data['fullname'];
            $currentGebdatum = $data['gebdatum'];
            if (CHAR_ID) {
                $currentCharakterid = $data['charakterid'];
            }
            $currentDiscordtag = $data['discordtag'];
            $currentTelefonnr = $data['telefonnr'];
            $currentDienstnr = $data['dienstnr'];
            $currentQualird = $data['qualird'];
            $currentQualifw = $data['qualifw2'];
            $currentGeschlecht = $data['geschlecht'];
            $currentZusatzqual = $data['zusatz'];
        } else {
            die("Kein Datensatz gefunden.");
        }

        if ($currentDienstgrad != $dienstgrad) {
            $stmt = $pdo->prepare("UPDATE intra_mitarbeiter SET dienstgrad = :dienstgrad WHERE id = :id");
            $stmt->execute([
                'dienstgrad' => $dienstgrad,
                'id' => $id
            ]);

            $stmtcdg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_dienstgrade WHERE id = :id");
            $stmtcdg->execute(['id' => $currentDienstgrad]);
            $cdginfo = $stmtcdg->fetch();

            $stmtndg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_dienstgrade WHERE id = :id");
            $stmtndg->execute(['id' => $dienstgrad]);
            $ndginfo = $stmtndg->fetch();

            $logContent = lang('personnel.logs.rank_changed', [$cdginfo['name'], $ndginfo['name']]);
            $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '4', :content, :paneluser)");
            $logStmt->execute([
                'id' => $id,
                'content' => $logContent,
                'paneluser' => $edituser
            ]);
        }

        if ($currentQualird != $qualird) {
            $stmt = $pdo->prepare("UPDATE intra_mitarbeiter SET qualird = :qualird WHERE id = :id");
            $stmt->execute([
                'qualird' => $qualird,
                'id' => $id
            ]);

            $stmtcrg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_rdquali WHERE id = :id");
            $stmtcrg->execute(['id' => $currentQualird]);
            $crginfo = $stmtcrg->fetch();

            $stmtnrg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_rdquali WHERE id = :id");
            $stmtnrg->execute(['id' => $qualird]);
            $nrginfo = $stmtnrg->fetch();

            $logContent = lang('personnel.logs.qualification_rd_changed', [$crginfo['name'], $nrginfo['name']]);
            $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '4', :content, :paneluser)");
            $logStmt->execute([
                'id' => $id,
                'content' => $logContent,
                'paneluser' => $edituser
            ]);
        }

        if ($currentQualifw != $qualifw2) {
            $stmt = $pdo->prepare("UPDATE intra_mitarbeiter SET qualifw2 = :qualifw2 WHERE id = :id");
            $stmt->execute([
                'qualifw2' => $qualifw2,
                'id' => $id
            ]);

            $stmtcfg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_fwquali WHERE id = :id");
            $stmtcfg->execute(['id' => $currentQualifw]);
            $cfginfo = $stmtcfg->fetch();

            $stmtnfg = $pdo->prepare("SELECT id,name FROM intra_mitarbeiter_fwquali WHERE id = :id");
            $stmtnfg->execute(['id' => $qualifw2]);
            $nfginfo = $stmtnfg->fetch();

            $logContent = lang('personnel.logs.qualification_fw_changed', [$cfginfo['name'], $nfginfo['name']]);
            $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '5', :content, :paneluser)");
            $logStmt->execute([
                'id' => $id,
                'content' => $logContent,
                'paneluser' => $edituser
            ]);
        }

        if (CHAR_ID) {
            $dataChanged = (
                $currentFullname != $fullname ||
                $currentGebdatum != $gebdatum ||
                $currentCharakterid != $charakterid ||
                $currentDiscordtag != $discordtag ||
                $currentTelefonnr != $telefonnr ||
                $currentDienstnr != $dienstnr ||
                $currentGeschlecht != $geschlecht ||
                $currentZusatzqual != $zusatzqual
            );
        } else {
            $dataChanged = (
                $currentFullname != $fullname ||
                $currentGebdatum != $gebdatum ||
                $currentDiscordtag != $discordtag ||
                $currentTelefonnr != $telefonnr ||
                $currentDienstnr != $dienstnr ||
                $currentGeschlecht != $geschlecht ||
                $currentZusatzqual != $zusatzqual
            );
        }

        if ($dataChanged) {
            if (CHAR_ID) {
                $stmt = $pdo->prepare("UPDATE intra_mitarbeiter SET fullname = :fullname, gebdatum = :gebdatum, charakterid = :charakterid, discordtag = :discordtag, telefonnr = :telefonnr, dienstnr = :dienstnr, geschlecht = :geschlecht, zusatz = :zusatzqual WHERE id = :id");
                $stmt->execute([
                    'fullname' => $fullname,
                    'gebdatum' => $gebdatum,
                    'charakterid' => $charakterid,
                    'discordtag' => $discordtag,
                    'telefonnr' => $telefonnr,
                    'dienstnr' => $dienstnr,
                    'geschlecht' => $geschlecht,
                    'zusatzqual' => $zusatzqual,
                    'id' => $id
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE intra_mitarbeiter SET fullname = :fullname, gebdatum = :gebdatum, discordtag = :discordtag, telefonnr = :telefonnr, dienstnr = :dienstnr, geschlecht = :geschlecht, zusatz = :zusatzqual WHERE id = :id");
                $stmt->execute([
                    'fullname' => $fullname,
                    'gebdatum' => $gebdatum,
                    'discordtag' => $discordtag,
                    'telefonnr' => $telefonnr,
                    'dienstnr' => $dienstnr,
                    'geschlecht' => $geschlecht,
                    'zusatzqual' => $zusatzqual,
                    'id' => $id
                ]);
            }

            $logContent = lang('personnel.logs.data_changed');
            $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '5', :content, :paneluser)");
            $logStmt->execute([
                'id' => $id,
                'content' => $logContent,
                'paneluser' => $edituser
            ]);
        }

        $currentURL = $_SERVER['REQUEST_URI'];
        $parsedURL = parse_url($currentURL);
        parse_str($parsedURL['query'], $queryParams);
        unset($queryParams['edit']);
        $newQuery = http_build_query($queryParams);
        $modifiedURL = $parsedURL['path'] . ($newQuery ? '?' . $newQuery : '');

        header("Location: $modifiedURL");
        exit();
    } elseif ($_POST['new'] == 4) {
        $qualifikationen_fd = isset($_POST['fachdienste']) && is_array($_POST['fachdienste']) ? $_POST['fachdienste'] : [];
        $qualifd = json_encode($qualifikationen_fd);

        $stmt = $pdo->prepare("SELECT fachdienste FROM intra_mitarbeiter WHERE id = :id");
        $stmt->execute(['id' => $openedID]);
        $currentQualifd = $stmt->fetchColumn();

        if ($qualifd !== $currentQualifd) {
            $updateStmt = $pdo->prepare("UPDATE intra_mitarbeiter SET fachdienste = :fachdienste WHERE id = :id");
            $updateStmt->execute([
                'fachdienste' => $qualifd,
                'id' => $openedID
            ]);

            $logContent = lang('personnel.logs.specialities_changed');
            $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '5', :content, :paneluser)");
            $logStmt->execute([
                'id' => $openedID,
                'content' => $logContent,
                'paneluser' => $edituser
            ]);
        }

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    } elseif ($_POST['new'] == 5) {
        $logContent = $_POST['content'];
        $logType = $_POST['noteType'];
        $logStmt2 = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, :logType, :content, :paneluser)");
        $logStmt2->execute([
            'id' => $openedID,
            'logType' => $logType,
            'content' => $logContent,
            'paneluser' => $edituser
        ]);

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    } elseif ($_POST['new'] == 6) {
        $erhalter = $_POST['erhalter'];
        $inhalt = $_POST['inhalt'] ?? NULL;
        $suspendtime = !empty($_POST['suspendtime']) ? $_POST['suspendtime'] : NULL;
        $erhalter_gebdat = $_POST['erhalter_gebdat'];
        $erhalter_rang = $_POST['erhalter_rang'] ?? NULL;
        $erhalter_rang_rd = $_POST['erhalter_rang_rd'] ?? NULL;
        $ausstellerid = $_POST['ausstellerid'];
        $aussteller_name = $_POST['aussteller_name'];
        $aussteller_rang = $_POST['aussteller_rang'];
        $profileid = $_POST['profileid'];
        $docType = $_POST['docType'];
        $anrede = $_POST['anrede'];

        $ausstDtNr = in_array($docType, ['10', '11', '12', '13']) ? '10' : $docType;

        $ausstellungsdatum = date('Y-m-d', strtotime($_POST['ausstellungsdatum_' . $ausstDtNr] ?? $_POST['ausstellungsdatum_0']));

        do {
            $random_number = mt_rand(1000000, 9999999);
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM intra_mitarbeiter_dokumente WHERE docid = :docid");
            $stmt->execute(['docid' => $random_number]);
            $exists = $stmt->fetchColumn();
        } while ($exists > 0);

        $new_number = $random_number;

        $docStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_dokumente 
        (docid, type, anrede, erhalter, inhalt, suspendtime, erhalter_gebdat, erhalter_rang, erhalter_rang_rd, ausstellungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) 
        VALUES (:docid, :type, :anrede, :erhalter, :inhalt, :suspendtime, :erhalter_gebdat, :erhalter_rang, :erhalter_rang_rd, :ausstellungsdatum, :ausstellerid, :profileid, :aussteller_name, :aussteller_rang)");

        $docStmt->execute([
            'docid' => $new_number,
            'type' => $docType,
            'anrede' => $anrede,
            'erhalter' => $erhalter,
            'inhalt' => $inhalt,
            'suspendtime' => $suspendtime,
            'erhalter_gebdat' => $erhalter_gebdat,
            'erhalter_rang' => $erhalter_rang,
            'erhalter_rang_rd' => $erhalter_rang_rd,
            'ausstellungsdatum' => $ausstellungsdatum,
            'ausstellerid' => $ausstellerid,
            'profileid' => $profileid,
            'aussteller_name' => $aussteller_name,
            'aussteller_rang' => $aussteller_rang
        ]);

        $docLink = $docLink = '<a href="/assets/functions/docredir.php?docid=' . $new_number . '" target="_blank">#' . $new_number . '</a>';
        $logContent = lang('personnel.logs.document_created', [$docLink]);
        $logStmt = $pdo->prepare("INSERT INTO intra_mitarbeiter_log (profilid, type, content, paneluser) VALUES (:id, '7', :content, :paneluser)");
        $logStmt->execute([
            'id' => $profileid,
            'content' => $logContent,
            'paneluser' => $edituser
        ]);

        header('Location: /assets/functions/docredir.php?docid=' . $new_number, true, 302);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= lang('personnel.title', [$row['fullname'], SYSTEM_NAME]) ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/css/personal.min.css" />
    <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <link rel="stylesheet" href="/assets/_ext/ckeditor5/ckeditor5.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="/vendor/components/jquery/jquery.min.js"></script>
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

<body data-bs-theme="dark" data-page="mitarbeiter">
    <?php include "../../assets/components/navbar.php"; ?>
    <div class="container-full position-relative" id="mainpageContainer">
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1 class="mb-3"><?= lang('personnel.profile.title') ?></h1>
                    <?php
                    require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                    $stmt = $pdo->prepare("SELECT id, username, fullname, aktenid FROM intra_users WHERE aktenid = :aktenid");
                    $stmt->execute([':aktenid' => $openedID]);
                    $num = $stmt->rowCount();
                    $panelakte = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($num != 0) {

                        if (Permissions::check(['admin', 'users.view'])) {
                            $profileLink = '<a href="admin/users/edit.php?id=' . $panelakte['id'] . '" class="text-decoration-none">' . $panelakte['fullname'] . ' (' . $panelakte['username'] . ')</a>';
                        } else {
                            $profileLink = $panelakte['fullname'] . ' (' . $panelakte['username'] . ')';
                        }
                    ?>
                        <div class="alert alert-info" role="alert">
                            <?= lang('personnel.profile.user_account_alert', [$profileLink]) ?>
                        </div>
                    <?php
                    }
                    include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/checks.php' ?>
                    <div class="row">
                        <div class="col-5 p-3 shadow-sm border ma-basedata">
                            <form id="profil" method="post">
                                <div class="row">
                                    <div class="col">
                                        <?php if (!isset($_GET['edit'])) { ?>
                                            <div class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNewComment" title="<?= lang('personnel.profile.create_note') ?>"><i class="las la-sticky-note"></i></div>
                                        <?php } ?>
                                        <?php if (!isset($_GET['edit']) && Permissions::check(['admin', 'personnel.documents.manage'])) { ?>
                                            <div class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDokuCreate" title="<?= lang('personnel.profile.create_document') ?>"><i class="las la-print"></i></div>
                                        <?php } ?>
                                        <?php if (!isset($_GET['edit']) && Permissions::check(['admin', 'personnel.edit'])) { ?>
                                            <a href="?id=<?= $_GET['id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') ?>&edit" class="btn btn-dark btn-sm" id="personal-edit" title="<?= lang('personnel.profile.edit_profile') ?>"><i class="las la-edit"></i></a>
                                            <div class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFDQuali" title="<?= lang('personnel.profile.edit_specialities') ?>"><i class="las la-graduation-cap"></i></div>
                                        <?php } elseif (isset($_GET['edit']) && Permissions::check(['admin', 'personnel.edit'])) { ?>
                                            <a href="#" class="btn btn-success btn-sm" id="personal-save" onclick="document.getElementById('profil').submit()"><i class="las la-save"></i></a>
                                            <a href="<?php echo removeEditParamFromURL(); ?>" class="btn btn-dark btn-sm"><i class="las la-arrow-left"></i></a>
                                            <?php if (Permissions::check(['admin', 'personnel.delete'])) { ?>
                                                <div class="btn btn-danger btn-sm" id="personal-delete" data-bs-toggle="modal" data-bs-target="#modalPersoDelete"><i class="las la-trash"></i></div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <div class="col text-end" style="color:var(--tag-color)"><?= lang('personnel.profile.files_id', [$row['id']]) ?></div>
                                </div>
                                <?php
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
                                    <i class="las la-user-circle" style="font-size:94px"></i>
                                    <?php if (!isset($_GET['edit']) || !Permissions::check(['admin', 'personnel.edit'])) { ?>
                                        <p class="mt-3">
                                            <?php if ($row['geschlecht'] == 0) {
                                                $geschlechtText = lang('personnel.profile.salutation_male');
                                            } elseif ($row['geschlecht'] == 1) {
                                                $geschlechtText = lang('personnel.profile.salutation_female');
                                            } else {
                                                $geschlechtText = lang('personnel.profile.salutation_other');
                                            }
                                            $profileName = $geschlechtText . " " . $row['fullname'];
                                            ?>
                                        <h4 class="mt-0"><?= $profileName ?></h4>
                                        <?php
                                        if ($dginfo['badge']) {
                                        ?>
                                            <img src="<?= $dginfo['badge'] ?>" height="16px" width="auto" alt="<?= lang('personnel.profile.rank') ?>" />
                                        <?php } ?>
                                        <?= $dienstgradText ?><br>
                                        <?php if (!$rdginfo['none']) { ?>
                                            <span style="text-transform:none; color:var(--black)" class="badge text-bg-warning"><?= $rdqualtext ?></span>
                                        <?php }
                                        if (!$fwginfo['none']) { ?>
                                            <span style="text-transform:none" class="badge text-bg-danger"><?= $bfqualtext ?></span>
                                        <?php } ?>
                                        </p>
                                    <?php } else {
                                        include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/dienstgradselector_bf.php';
                                        include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/dienstgradselector_rd.php';
                                        include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/qualiselector.php';
                                    } ?>
                                    <hr class="my-3">
                                    <?php if (!isset($_GET['edit']) || !Permissions::check(['admin', 'personnel.edit'])) { ?>
                                        <table class="mx-auto w-100">
                                            <tbody class="text-start">
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.birthday') ?></td>
                                                    <td><?= $geburtstag ?></td>
                                                </tr>
                                                <?php if (CHAR_ID) : ?>
                                                    <tr>
                                                        <td class="fw-bold"><?= lang('personnel.profile.form.characterid') ?></td>
                                                        <td><?= $row['charakterid'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.discord') ?></td>
                                                    <td><?= $row['discordtag'] ?? 'N. hinterlegt' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.phone') ?></td>
                                                    <td><?= $row['telefonnr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.servicenr') ?></td>
                                                    <td><?= $row['dienstnr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.position') ?></td>
                                                    <td><?= $row['zusatz'] ?? 'Keine' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.hiring_date') ?></td>
                                                    <td><?= $einstellungsdatum ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr class="my-3">
                                        <div id="fd-container">
                                            <?php include $_SERVER['DOCUMENT_ROOT'] . "/assets/components/profiles/anzeige_fachdienste.php" ?>
                                        </div>
                                    <?php } elseif (isset($_GET['edit']) && Permissions::check(['admin', 'personnel.edit'])) { ?>
                                        <input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>" />
                                        <input type="hidden" name="new" value="1" />
                                        <table class="mx-auto w-100">
                                            <tbody class="text-start">
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.fullname') ?></td>
                                                    <td class="col-8"><input class="form-control" type="text" name="fullname" id="fullname" value="<?= $row['fullname'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.birthday') ?></td>
                                                    <td><input class="form-control" type="date" name="gebdatum" id="gebdatum" value="<?= $row['gebdatum'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.gender') ?></td>
                                                    <td>
                                                        <select name="geschlecht" id="geschlecht" class="form-select">
                                                            <option value="0" <?php if ($row['geschlecht'] == 0) echo 'selected' ?>><?= lang('personnel.profile.form.gender_male') ?></option>
                                                            <option value="1" <?php if ($row['geschlecht'] == 1) echo 'selected' ?>><?= lang('personnel.profile.form.gender_female') ?></option>
                                                            <option value="2" <?php if ($row['geschlecht'] == 2) echo 'selected' ?>><?= lang('personnel.profile.form.gender_other') ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php if (CHAR_ID) : ?>
                                                    <tr>
                                                        <td class="fw-bold"><?= lang('personnel.profile.form.characterid') ?></td>
                                                        <td><input class="form-control" type="text" name="charakterid" id="charakterid" value="<?= $row['charakterid'] ?>"></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.discord') ?></td>
                                                    <td><input class="form-control" type="text" name="discordtag" id="discordtag" value="<?= $row['discordtag'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.phone') ?></td>
                                                    <td><input class="form-control" type="text" name="telefonnr" id="telefonnr" value="<?= $row['telefonnr'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.servicenr') ?></td>
                                                    <td><input class="form-control" type="number" name="dienstnr" id="dienstnr" value="<?= $row['dienstnr'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.position') ?></td>
                                                    <td><input class="form-control" type="text" name="zusatzqual" id="zusatzqual" maxlength="255" value="<?= $row['zusatz'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold"><?= lang('personnel.profile.form.hiring_date') ?></td>
                                                    <td><input class="form-control" type="date" name="einstdatum" id="einstdatum" value="<?= $row['einstdatum'] ?>" readonly disabled></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <div class="col ms-4 p-3 shadow-sm border ma-comments">
                            <div class="comment-settings mb-3">
                                <h4><?= lang('personnel.profile.title_comments') ?></h4>
                            </div>
                            <div class="comment-container">
                                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/comments/main.php' ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="col p-3 shadow-sm border ma-documents">
                            <h4><?= lang('personnel.profile.title_documents') ?></h4>
                            <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/documents/main.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/profiles/modals.php' ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/assets/components/footer.php"; ?>
</body>

</html>
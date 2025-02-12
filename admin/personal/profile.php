<?php
session_start();
require_once '../../assets/php/permissions.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    header("Location: /admin/login.php");
} elseif ($notadmincheck) {
    if ($perview) {
        $canView = true;
        $canEdit = $peredit;
    } else {
        $canView = false;
        $canEdit = false;
    }

    if (!$canView && !$canEdit) {
        header("Location: /admin/index.php");
    }
} else {
    $canView = true;
    $canEdit = true;
}

include '../../assets/php/mysql-con.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$result = mysqli_query($conn, "SELECT * FROM personal_profile WHERE id = " . $_GET['id']) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);

$openedID = $_GET['id'];
$edituser = $_SESSION['cirs_user'];
$edituseric = $_SESSION['ic_name'];
$editdg = $_SESSION['cirs_dg'];

if (isset($_POST['new'])) {
    if ($_POST['new'] == 1) {
        // Get and sanitize input values
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $gebdatum = $_POST['gebdatum'];
        $charakterid = $_POST['charakterid'];
        $dienstgrad = $_POST['dienstgrad'];
        $forumprofil = $_POST['forumprofil'];
        $discordtag = $_POST['discordtag'];
        $telefonnr = $_POST['telefonnr'];
        $dienstnr = $_POST['dienstnr'];

        // Retrieve the current dienstgrad and other data from the database
        $stmt = mysqli_prepare($conn, "SELECT dienstgrad, fullname, gebdatum, charakterid, forumprofil, discordtag, telefonnr, dienstnr FROM personal_profile WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $currentDienstgrad, $currentFullname, $currentGebdatum, $currentCharakterid, $currentForumprofil, $currentDiscordtag, $currentTelefonnr, $currentDienstnr);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $dienstgradMapping = array(
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
        );

        // Update the dienstgrad only if it has changed
        if ($currentDienstgrad != $dienstgrad) {
            // Update the database using prepared statements
            $stmt = mysqli_prepare($conn, "UPDATE personal_profile SET dienstgrad = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ii", $dienstgrad, $id);
            mysqli_stmt_execute($stmt);

            // Retrieve the text representations for the current and new dienstgrad
            $currentDienstgradText = isset($dienstgradMapping[$currentDienstgrad]) ? $dienstgradMapping[$currentDienstgrad] : 'Unknown';
            $newDienstgradText = isset($dienstgradMapping[$dienstgrad]) ? $dienstgradMapping[$dienstgrad] : 'Unknown';

            // Insert a log entry for dienstgrad modification
            $logContent = 'Dienstgrad wurde von <strong>' . $currentDienstgradText . '</strong> auf <strong>' . $newDienstgradText . '</strong> geändert.';
            $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '4', ?, ?)");
            mysqli_stmt_bind_param($logStmt, "iss", $id, $logContent, $edituser);
            mysqli_stmt_execute($logStmt);
        }

        // Update other profile data if it has changed
        $dataChanged = false;
        if (
            $currentFullname != $fullname ||
            $currentGebdatum != $gebdatum ||
            $currentCharakterid != $charakterid ||
            $currentForumprofil != $forumprofil ||
            $currentDiscordtag != $discordtag ||
            $currentTelefonnr != $telefonnr ||
            $currentDienstnr != $dienstnr
        ) {
            $dataChanged = true;
            // Update the database using prepared statements
            $stmt = mysqli_prepare($conn, "UPDATE personal_profile SET fullname = ?, gebdatum = ?, charakterid = ?, forumprofil = ?, discordtag = ?, telefonnr = ?, dienstnr = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssssii", $fullname, $gebdatum, $charakterid, $forumprofil, $discordtag, $telefonnr, $dienstnr, $id);
            mysqli_stmt_execute($stmt);
        }

        // Insert a log entry for profile data modification if dienstgrad and/or other data changed
        if ($dataChanged) {
            $logContent = 'Profilangaben wurden bearbeitet.';
            $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '5', ?, ?)");
            mysqli_stmt_bind_param($logStmt, "iss", $id, $logContent, $edituser);
            mysqli_stmt_execute($logStmt);
        }

        // Redirect to the modified URL
        $currentURL = $_SERVER['REQUEST_URI'];
        $parsedURL = parse_url($currentURL);
        parse_str($parsedURL['query'], $queryParams);
        unset($queryParams['edit']);
        $newQuery = http_build_query($queryParams);
        $modifiedURL = $parsedURL['path'] . '?' . $newQuery;
        header("Location: $modifiedURL");
        exit();
    } elseif ($_POST['new'] == 2) {
        if (isset($_POST['qualifw']) && is_array($_POST['qualifw'])) {
            $qualifikationen_fw = $_POST['qualifw'];
            $qualifw = json_encode($qualifikationen_fw);

            // Retrieve the current value of qualifw from the database
            $stmt = mysqli_prepare($conn, "SELECT qualifw FROM personal_profile WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $openedID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $currentQualifw);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt); // Close the statement

            // Compare the new value with the current value
            if ($qualifw != $currentQualifw) {
                // Update the database using prepared statements
                $updateStmt = mysqli_prepare($conn, "UPDATE personal_profile SET qualifw = ? WHERE id = ?");
                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "si", $qualifw, $openedID);
                    mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt); // Close the statement

                    // Insert a log entry for qualifw modification
                    $logContent = 'Feuerwehr Qualifikationen wurden bearbeitet.';
                    $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '5', ?, ?)");
                    if ($logStmt) {
                        mysqli_stmt_bind_param($logStmt, "iss", $openedID, $logContent, $edituser);
                        mysqli_stmt_execute($logStmt);
                        mysqli_stmt_close($logStmt); // Close the statement
                    }
                }
            }
        }
        header('Refresh: 0');
    } elseif ($_POST['new'] == 3) {
        if (isset($_POST['qualird'])) {
            $qualird = $_POST['qualird'];

            // Retrieve the current value of qualird from the database
            $stmt = mysqli_prepare($conn, "SELECT qualird FROM personal_profile WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $openedID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $currentQualird);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt); // Close the statement

            // Compare the new value with the current value
            if ($qualird != $currentQualird) {
                // Update the database using prepared statements
                $updateStmt = mysqli_prepare($conn, "UPDATE personal_profile SET qualird = ? WHERE id = ?");
                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "si", $qualird, $openedID);
                    $updateResult = mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt); // Close the statement

                    if ($updateResult) {
                        // Insert a log entry for qualird modification
                        $logContent = 'Rettungsdienst Qualifikationen wurden bearbeitet.';
                        $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '5', ?, ?)");
                        if ($logStmt) {
                            mysqli_stmt_bind_param($logStmt, "iss", $openedID, $logContent, $edituser);
                            mysqli_stmt_execute($logStmt);
                            mysqli_stmt_close($logStmt); // Close the statement
                        }
                    }
                }
            }
        }
        header('Refresh: 0');
    } elseif ($_POST['new'] == 4) {
        if (isset($_POST['fachdienste']) && is_array($_POST['fachdienste'])) {
            $qualifikationen_fd = $_POST['fachdienste'];
            $qualifd = json_encode($qualifikationen_fd);

            // Retrieve the current value of fachdienste from the database
            $stmt = mysqli_prepare($conn, "SELECT fachdienste FROM personal_profile WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $openedID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $currentQualifd);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt); // Close the statement

            // Compare the new value with the current value
            if ($qualifd != $currentQualifd) {
                // Update the database using prepared statements
                $updateStmt = mysqli_prepare($conn, "UPDATE personal_profile SET fachdienste = ? WHERE id = ?");
                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "si", $qualifd, $openedID);
                    $updateResult = mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt); // Close the statement

                    if ($updateResult) {
                        // Insert a log entry for fachdienste modification
                        $logContent = 'Fachdienste wurden bearbeitet.';
                        $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '5', ?, ?)");
                        if ($logStmt) {
                            mysqli_stmt_bind_param($logStmt, "iss", $openedID, $logContent, $edituser);
                            mysqli_stmt_execute($logStmt);
                            mysqli_stmt_close($logStmt); // Close the statement
                        }
                    }
                }
            }
        }
        header('Refresh: 0');
    } elseif ($_POST['new'] == 5) {
        // Insert a log entry for qualifw modification
        $logContent = $_POST['content'];
        $logType = $_POST['noteType'];
        $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($logStmt, "isss", $openedID, $logType, $logContent, $edituser);
        mysqli_stmt_execute($logStmt);
        header('Refresh: 0');
    } elseif ($_POST['new'] == 6) {
        $erhalter = $_POST['erhalter'];
        $erhalter_gebdat =  $_POST['erhalter_gebdat'];
        $ausstellerid = $_POST['ausstellerid'];
        $aussteller_name = $_POST['aussteller_name'];
        $aussteller_rang = $_POST['aussteller_rang'];
        $profileid = $_POST['profileid'];
        $docType = $_POST['docType'];

        $random_number = mt_rand(1000000, 9999999);
        $rncheck = "SELECT * FROM personal_dokumente WHERE docid = $random_number";
        $rnres = $conn->query($rncheck);
        while ($rnres->num_rows > 0) {
            $random_number = mt_rand(1000000, 9999999);
            $rncheck = "SELECT * FROM personal_dokumente WHERE docid = $random_number";
            $rnres = $conn->query($rncheck);
        }
        $new_number = $random_number;

        if ($docType <= 1) {
            $anrede = $_POST['anrede'];
            $erhalter_rang = $_POST['erhalter_rang'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_0']));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, erhalter_rang, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iisssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $erhalter_rang, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/02/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/02/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 2) {
            $anrede = $_POST['anrede'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_' . $docType]));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iissssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/02/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/02/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 3) {
            $anrede = $_POST['anrede'];
            $erhalter_rang_rd_2 = $_POST['erhalter_rang_rd_2'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_' . $docType]));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, erhalter_rang_rd, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iisssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $erhalter_rang_rd_2, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/04/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/04/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 5) {
            $anrede = $_POST['anrede'];
            $erhalter_rang_rd = $_POST['erhalter_rang_rd'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_' . $docType]));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, erhalter_rang_rd, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iisssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $erhalter_rang_rd, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/03/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/03/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 6 || $docType == 7) {
            $anrede = $_POST['anrede'];
            $erhalter_quali = $_POST['erhalter_quali'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_' . $docType]));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, erhalter_quali, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iisssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $erhalter_quali, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/03/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/03/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 10 || $docType == 12 || $docType == 13) {
            $anrede = $_POST['anrede'];
            $inhalt = $_POST['inhalt'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_10']));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, inhalt, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iisssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $inhalt, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/01/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/01/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        } elseif ($docType == 11) {
            $anrede = $_POST['anrede'];
            $inhalt = $_POST['inhalt'];
            $suspendtime = $_POST['suspendtime'];
            $ausstelungsdatum = date('Y-m-d', strtotime($_POST['ausstelungsdatum_10']));

            $docStmt = mysqli_prepare($conn, "INSERT INTO personal_dokumente (docid, type, anrede, erhalter, erhalter_gebdat, inhalt, suspendtime, ausstelungsdatum, ausstellerid, profileid, aussteller_name, aussteller_rang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($docStmt, "iissssssiisi", $new_number, $docType, $anrede, $erhalter, $erhalter_gebdat, $inhalt, $suspendtime, $ausstelungsdatum, $ausstellerid, $profileid, $aussteller_name, $aussteller_rang);
            header('Location: /dokumente/01/' . $new_number, true, 302);
            $logContent = 'Ein neues Dokument (<a href="/dokumente/01/' . $new_number . '" target="_blank">' . $new_number . '</a>) wurde erstellt.';
        }

        mysqli_stmt_execute($docStmt);
        $logStmt = mysqli_prepare($conn, "INSERT INTO personal_log (profilid, type, content, paneluser) VALUES (?, '7', ?, ?)");
        if ($logStmt) {
            mysqli_stmt_bind_param($logStmt, "iss", $openedID, $logContent, $edituser);
            mysqli_stmt_execute($logStmt);
            mysqli_stmt_close($logStmt); // Close the statement
        }
        header('Refresh: 0');
    }
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
    <link rel="stylesheet" href="/assets/redactorx/redactorx.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/jquery/jquery-3.7.0.min.js"></script>
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
                    <h1 class="mb-3">Mitarbeiterprofil</h1>
                    <?php
                    $panelakten = mysqli_query($conn, "SELECT id, username, fullname, aktenid FROM cirs_users WHERE aktenid = '$openedID'") or die(mysqli_error($conn));
                    $num = mysqli_num_rows($panelakten);
                    $panelakte = mysqli_fetch_assoc($panelakten);

                    if ($num != 0) {
                    ?>
                        <div class="alert alert-info" role="alert">
                            <h5 class="fw-bold">Achtung!</h5>
                            Dieses Mitarbeiterprofil gehört einem Funktionsträger - dieser besitzt ein registriertes Benutzerkonto im Intranet.<br>
                            <?php if ($admincheck || $usedit) { ?>
                                <strong>Name u. Benutzername:</strong> <a href="/admin/users/user<?= $panelakte['id'] ?>" class="text-decoration-none"><?= $panelakte['fullname'] ?> (<?= $panelakte['username'] ?>)</a>
                            <?php } else { ?>
                                <strong>Name u. Benutzername:</strong> <?= $panelakte['fullname'] ?> (<?= $panelakte['username'] ?>)
                            <?php } ?>
                        </div>
                    <?php
                    }
                    include('../../assets/php/personal-checks.php') ?>
                    <div class="row">
                        <div class="col-5 p-3 shadow-sm border ma-basedata">
                            <form id="profil" method="post">
                                <?php if (!isset($_GET['edit']) && $canEdit) { ?>
                                    <a href="?id=<?= $_GET['id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') ?>&edit" class="btn btn-dark btn-sm" id="personal-edit"><i class="fa-solid fa-edit"></i></a>
                                <?php } elseif (isset($_GET['edit']) && $canEdit) { ?>
                                    <a href="#" class="btn btn-success btn-sm" id="personal-save" onclick="document.getElementById('profil').submit()"><i class="fa-solid fa-floppy-disk"></i></a>
                                    <a href="<?php echo removeEditParamFromURL(); ?>" class="btn btn-dark btn-sm"><i class="fa-solid fa-arrow-left"></i></a>
                                    <?php if ($admincheck || $perdelete) { ?>
                                        <div class="btn btn-danger btn-sm" id="personal-delete" data-bs-toggle="modal" data-bs-target="#modalPersoDelete"><i class="fa-solid fa-trash"></i></div>
                                <?php }
                                } ?>
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

                                $dienstgradMapping = array(
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
                                );

                                $rankIcons = [
                                    1 => '/assets/img/dienstgrade/bf/1.png',
                                    2 => '/assets/img/dienstgrade/bf/2.png',
                                    3 => '/assets/img/dienstgrade/bf/3.png',
                                    4 => '/assets/img/dienstgrade/bf/4.png',
                                    5 => '/assets/img/dienstgrade/bf/5.png',
                                    17 => '/assets/img/dienstgrade/bf/17_2.png',
                                    6 => '/assets/img/dienstgrade/bf/6.png',
                                    7 => '/assets/img/dienstgrade/bf/7.png',
                                    8 => '/assets/img/dienstgrade/bf/8.png',
                                    9 => '/assets/img/dienstgrade/bf/9.png',
                                    10 => '/assets/img/dienstgrade/bf/10.png',
                                    15 => '/assets/img/dienstgrade/bf/15.png',
                                    11 => '/assets/img/dienstgrade/bf/11.png',
                                    12 => '/assets/img/dienstgrade/bf/12.png',
                                    13 => '/assets/img/dienstgrade/bf/13.png',
                                    14 => '/assets/img/dienstgrade/bf/14.png',
                                ];

                                ?>
                                <div class="w-100 text-center">
                                    <i class="fa-solid fa-user-circle" style="font-size:94px"></i>
                                    <?php if (!isset($_GET['edit']) || !$canEdit) { ?>
                                        <p class="mt-3" style="text-transform:uppercase">
                                            <?php
                                            $rank = $row['dienstgrad'];
                                            if (isset($rankIcons[$rank])) {
                                            ?>
                                                <img src="<?= $rankIcons[$rank] ?>" height='16px' width='auto' alt='Dienstgrad' />
                                            <?php } ?>
                                            <?= $dienstgrad ?>
                                            <?php if ($row['qualird'] > 0) { ?>
                                                <br><span style="text-transform:none" class="badge bg-warning"><?= $rdqualtext ?></span>
                                            <?php } ?>
                                        </p>
                                    <?php } else {
                                        include('../../assets/php/personal-dg-select.php');
                                    } ?>
                                    <hr class="my-3">
                                    <?php if (!isset($_GET['edit']) || !$canEdit) { ?>
                                        <table class="mx-auto">
                                            <tbody class="text-start">
                                                <tr>
                                                    <td class="fw-bold">Vor- und Zuname</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $row['fullname'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Geburtsdatum</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $geburtstag ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Charakter-ID</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $row['charakterid'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Discord-Tag</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $row['discordtag'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Telefonnummer</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $row['telefonnr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Dienstnummer</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $row['dienstnr'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Einstellungsdatum</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><?= $einstellungsdatum ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php } elseif (isset($_GET['edit']) && $canEdit) { ?>
                                        <input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>" />
                                        <input type="hidden" name="new" value="1" />
                                        <table class="mx-auto">
                                            <tbody class="text-start">
                                                <tr>
                                                    <td class="fw-bold">Vor- und Zuname</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="text" name="fullname" id="fullname" value="<?= $row['fullname'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Geburtsdatum</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="date" name="gebdatum" id="gebdatum" value="<?= $row['gebdatum'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Charakter-ID</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="text" name="charakterid" id="charakterid" value="<?= $row['charakterid'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Discord-Tag</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="text" name="discordtag" id="discordtag" value="<?= $row['discordtag'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Telefonnummer</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="text" name="telefonnr" id="telefonnr" value="<?= $row['telefonnr'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Dienstnummer</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="number" name="dienstnr" id="dienstnr" value="<?= $row['dienstnr'] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Einstellungsdatum</td>
                                                    <td><span class="mx-1"></span></td>
                                                    <td><input class="form-control" type="date" name="einstdatum" id="einstdatum" value="<?= $row['einstdatum'] ?>" readonly disabled></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                    <hr class="my-3">
                                    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalFWQuali">FW Qualifikationen einsehen</div>
                                    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalRDQuali">RD Qualifikationen einsehen</div>
                                    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalFDQuali">Fachdienste einsehen</div>

                                    <?php if ($canView) { ?>
                                        <div class="btn btn-primary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalNewComment">Notiz anlegen</div>
                                    <?php } ?>
                                    <?php if ($admincheck || $perdoku) { ?>
                                        <div class="btn btn-primary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalDokuCreate">Dokument erstellen</div>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <div class="col ms-4 p-3 shadow-sm border ma-comments">
                            <div class="comment-settings mb-3">
                                <h4>Kommentare/Notizen</h4>
                            </div>
                            <div class="comment-container">
                                <?php include('../../assets/php/personal-comments.php') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="col p-3 shadow-sm border ma-documents">
                            <h4>Dokumente</h4>
                            <?php include('../../assets/php/personal-documents.php') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('../../assets/php/personal-modals.php') ?>
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
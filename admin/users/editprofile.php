<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    header("Location: /admin/login.php");
    exit();
}

use App\Helpers\Flash;

$userid = $_SESSION['userid'];

$stmt = $pdo->prepare("SELECT * FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $userid, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['id'];
    $aktenid = $_REQUEST['aktenid'];
    $fullname = $_REQUEST['fullname'];

    $new_password = $_REQUEST['passwort'];
    $new_password_2 = $_REQUEST['passwort2'];

    if (!empty($new_password) && !empty($new_password_2) && $new_password === $new_password_2) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE intra_users SET passwort = :password, fullname = :fullname, aktenid = :aktenid WHERE id = :id");
        $stmt->execute([
            'password' => $new_password_hash,
            'fullname' => $fullname,
            'aktenid' => $aktenid,
            'id' => $id
        ]);

        Flash::set('own', 'pw-changed');
        header("Refresh:0");
        exit();
    } else {
        $stmt = $pdo->prepare("UPDATE intra_users SET fullname = :fullname, aktenid = :aktenid WHERE id = :id");
        $stmt->execute([
            'fullname' => $fullname,
            'aktenid' => $aktenid,
            'id' => $id
        ]);

        Flash::set('own', 'data-changed');
        header("Refresh:0");
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
    <title>Profil bearbeiten &rsaquo; Administration &rsaquo; <?php echo SYSTEM_NAME ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
    <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/_ext/jquery/jquery.min.js"></script>
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

<body data-bs-theme="dark">
    <?php include "../../assets/components/navbar.php"; ?>
    <div class="container-full position-relative" id="mainpageContainer">
        <!-- ------------ -->
        <!-- PAGE CONTENT -->
        <!-- ------------ -->
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <hr class="text-light my-3">
                    <h1 class="mb-5">Eigene Daten bearbeiten</h1>
                    <?php
                    Flash::render();
                    ?>
                    <form name="form" method="post" action="">
                        <div class="intra__tile py-2 px-3">
                            <input type="hidden" name="new" value="1" />
                            <input name="id" type="hidden" value="<?= $row['id'] ?>" />
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="fullname" class="form-label fw-bold">Vor- und Zuname</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" value="<?= $row['fullname'] ?>">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                    <input type="number" class="form-control" id="aktenid" name="aktenid" placeholder="" value="<?= $row['aktenid'] ?>">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 mb-3">
                                    <label for="passwort" class="form-label fw-bold">Neues Passwort</label>
                                    <input type="password" class="form-control" id="passwort" name="passwort" placeholder="Leer lassen um nichts zu ändern">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="passwort2" class="form-label fw-bold">Passwort wiederholen</label>
                                    <input type="password" class="form-control" id="passwort2" name="passwort2" placeholder="Passwort wiederholen">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3 mx-auto">
                                <input class="mt-4 btn btn-success btn-sm" name="submit" type="submit" value="Änderungen speichern" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
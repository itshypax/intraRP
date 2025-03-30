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
}

if ($notadmincheck && !$usedit) {
    header("Location: /admin/users/list.php?message=error-2");
}

require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

$stmt = $pdo->prepare("SELECT * FROM intra_users WHERE id = :id");
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$roleID = $row['role'];

$stmt2 = $pdo->prepare("SELECT* FROM intra_users_roles WHERE id = :roleID");
$stmt2->execute(['roleID' => $row['role']]);
$rowrole = $stmt2->fetch(PDO::FETCH_ASSOC);

if ($row['id'] == $userid) {
    header("Location: /admin/users/list.php?message=error-1");
}

if ($rowrole['priority'] <= $_SESSION['role_priority']) {
    header("Location: /admin/users/list.php?message=error-3");
}

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_REQUEST['id'];
    $username = $_REQUEST['username'];
    $fullname = $_REQUEST['fullname'];
    $aktenid = $_REQUEST['aktenid'];
    $role = $_REQUEST['role'];

    $sql = "UPDATE intra_users 
        SET fullname = :fullname, 
            aktenid = :aktenid, 
            role = :role 
        WHERE id = :id";

    $stmti = $pdo->prepare($sql);
    $stmti->execute([
        'fullname' => $fullname,
        'aktenid' => $aktenid,
        'role' => $role,
        'id' => $id
    ]);

    header("Refresh: 0");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $row['username'] ?> &rsaquo; Administration &rsaquo; <?php echo SYSTEM_NAME ?></title>
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
                    <h1 class="mb-3">Benutzer bearbeiten <span class="mx-3"></span> <button class="btn btn-main-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-trash"></i> Benutzer löschen</button> <?php if ($admincheck) : ?><button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#newPassword"><i class="las la-key"></i> Neues Passwort generieren</button><?php endif; ?></h1>

                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <input name="id" type="hidden" value="<?= $row['id'] ?>" />
                        <div class="row">
                            <div class="col me-2">
                                <div class="intra__tile py-2 px-3">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="username" class="form-label fw-bold">Benutzername <span class="text-main-color">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?= $row['username'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="fullname" class="form-label fw-bold">Vor- und Zuname <span class="text-main-color">*</span></label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" value="<?= $row['fullname'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="intra__tile py-2 px-3">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                            <input type="number" class="form-control" id="aktenid" name="aktenid" placeholder="" value="<?= $row['aktenid'] ?? NULL ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="role" class="form-label fw-bold">Rolle/Gruppe <span class="text-main-color">*</span></label>
                                            <select name="role" id="role" class="form-select" required>
                                                <?php
                                                require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                                                $stmt = $pdo->prepare("SELECT * FROM intra_users_roles WHERE priority > :own_prio");
                                                $stmt->execute(['own_prio' => $_SESSION['role_priority']]);
                                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($result as $rr) {
                                                    if ($rr['id'] == $roleID) {
                                                        echo "<option value ='{$rr['id']}' selected='selected'>{$rr['name']}</option>";
                                                    } else {
                                                        echo "<option value ='{$rr['id']}'>{$rr['name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
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

    <!-- MODAL BEGIN -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bestätigung erforderlich</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Willst du wirklich den Benutzer <span class="fw-bold"><?= $row['fullname'] ?></span> löschen?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-color" data-bs-dismiss="modal">Ne, Upsi</button>
                    <button type="button" class="btn btn-main-color" onclick="window.location.href='delete.php?id=<?= $row['id'] ?>';">Benutzer endgültig löschen</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL END & BEGIN -->
    <?php if ($admincheck) : ?>
        <div class="modal fade" id="newPassword" tabindex="-1" aria-labelledby="newPasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newPasswordLabel">Bestätigung erforderlich</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Willst du wirklich für den Benutzer <span class="fw-bold"><?= $row['fullname'] ?></span> ein neues Passwort generieren?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary-color" data-bs-dismiss="modal">Ne, Upsi</button>
                        <button type="button" class="btn btn-warning" onclick="window.location.href='generatenewpass.php?id=<?= $row['id'] ?>';">Neues Passwort generieren</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- MODAL END -->

</body>

</html>
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
} else if ($notadmincheck && !$uscreate) {
    header("Location: /admin/users/list.php?message=error-2");
}

require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $username = $_REQUEST['username'];
    $fullname = $_REQUEST['fullname'];
    $aktenid = $_REQUEST['aktenid'];
    if ($aktenid == 0) {
        $aktenid = NULL;
    }
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
    $role = $_REQUEST['role'];
    $jetzt = date("Y-m-d H:i:s");

    $sql = "INSERT INTO intra_users (username, fullname, aktenid, passwort, created_at, role) 
        VALUES (:username, :fullname, :aktenid, :passwort, :created_at, :role)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'fullname' => $fullname,
        'aktenid' => $aktenid,
        'passwort' => $password,
        'created_at' => $jetzt,
        'role' => $role
    ]);
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
                    <h1>Benutzer anlegen</h1>
                    <form name="form" method="post" action="">
                        <input type="hidden" name="new" value="1" />
                        <div class="row">
                            <div class="col mb-3">
                                <label for="username" class="form-label fw-bold">Benutzername <span class="text-main-color">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                            </div>
                            <div class="col mb-3">
                                <label for="fullname" class="form-label fw-bold">Vor- und Zuname <span class="text-main-color">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" required>
                            </div>
                            <div class="col mb-3">
                                <label for="password" class="form-label fw-bold">Passwort <span class="text-main-color">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                                    <button title="Passwort anzeigen" class="btn btn-outline-warning" type="button" id="show-password-btn"><i class="las la-eye"></i></button>
                                    <button title="Passwort generieren" class="btn btn-outline-primary" type="button" id="generate-password-btn"><i class="las la-random"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="aktenid" class="form-label fw-bold">Mitarbeiterakten-ID</label>
                                <input type="text" class="form-control" id="aktenid" name="aktenid" placeholder="">
                            </div>
                            <div class="col mb-3">
                                <label for="role" class="form-label fw-bold">Rolle/Gruppe <span class="text-main-color">*</span></label>
                                <select name="role" id="role" class="form-select" required>
                                    <option selected hidden disabled>Bitte wählen</option>
                                    <?php
                                    require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';
                                    $stmt = $pdo->prepare("SELECT * FROM intra_users_roles WHERE priority > :own_prio");
                                    $stmt->execute(['own_prio' => $_SESSION['role_priority']]);
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $rr) {
                                        echo "<option value ='{$rr['id']}'>{$rr['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3 mx-auto">
                                <input class="btn btn-outline-success btn-sm" name="submit" type="submit" value="Benutzer anlegen" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get a reference to the generate password button
        const generatePasswordBtn = document.getElementById('generate-password-btn');

        // Add a click event listener to the generate password button
        generatePasswordBtn.addEventListener('click', function() {
            // Define the characters that can be used in the generated password
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+~`|}{[]\\:;?><,./-=';

            // Generate a random password of length 12
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            // Set the value of the password input to the generated password
            const passwordInput = document.getElementById('password');
            passwordInput.value = password;
        });
    </script>
    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordButton = document.getElementById('show-password-btn');

        showPasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>
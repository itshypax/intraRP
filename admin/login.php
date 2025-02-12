<?php
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_path', '/');  // Set the cookie path to the root directory
ini_set('session.cookie_domain', '.muster.de');  // Set the cookie domain to your domain
ini_set('session.cookie_lifetime', 604800);  // Set the cookie lifetime (in seconds)
ini_set('session.cookie_secure', true);  // Set to true if using HTTPS, false otherwise

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/assets/php/mysql-con.php';

if (isset($_SESSION['userid']) && isset($_SESSION['permissions'])) {
    header('Location: /admin/index.php');
}

if (isset($_GET['login'])) {
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM cirs_users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        $_SESSION['cirs_user'] = $user['fullname'];
        $permissions = json_decode($user['permissions'], true) ?? [];
        $_SESSION['permissions'] = $permissions;

        if ($user['aktenid'] != null) {
            $statement = $pdo->prepare("SELECT * FROM personal_profile WHERE id = :id");
            $result = $statement->execute(array('id' => $user['aktenid']));
            $profile = $statement->fetch();

            $_SESSION['cirs_dg'] = $profile['dienstgrad'];
            $_SESSION['ic_name'] = $profile['fullname'];
        }

        if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']); // Remove the stored URL
            header("Location: $redirect_url");
            exit();
        } else {
            header('Location: /admin/index.php');
        }
    } else {
        $errorMessage = "Benutzername oder Passwort ungültig.<br>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />

</head>

<body id="dashboard" class="d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col">
            <div class="card px-4 py-3">
                <h1 id="loginHeader">intra<span class="text-sh-red">SB</span></h1>
                <p class="subtext">Das Intranet der Hansestadt!</p>
                <?php
                if (isset($errorMessage)) {
                    echo '<div class="alert alert-danger mb-5" role="alert">';
                    echo $errorMessage;
                    echo '</div>';
                }
                ?>

                <form action="?login=1" method="post">
                    <strong>Benutzername:</strong><br>
                    <input class="form-control" type="text" size="40" maxlength="250" name="username"><br><br>

                    <strong>Passwort:</strong><br>
                    <input class="form-control" type="password" size="40" maxlength="250" name="passwort"><br>

                    <input class="btn btn-primary w-100" type="submit" value="Anmelden">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div class="footerCopyright">
            <a href="https://hypax.wtf" target="_blank"><i class="fa-solid fa-code"></i> hypax</a>
            <span>© 2023 | v0.1 WIP</span>
        </div>
        <div class="footerLegal">
            <span>
                <a href="#">
                    Impressum
                </a>
            </span>
            <span>
                <a href="#">
                    Datenschutzerklärung
                </a>
            </span>
        </div>
    </footer>
</body>

</html>
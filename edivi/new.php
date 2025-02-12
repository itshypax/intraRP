<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/assets/php/mysql-con.php';

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $enr = $_POST['enr'];
    // check if there already is a protocol with this enr in the database
    $check = $pdo->prepare("SELECT * FROM cirs_rd_protokolle WHERE enr = :enr");
    $check->execute(array('enr' => $enr));
    $check = $check->fetch();
    if ($check) {
        // if there is, do nothing
    } else {
        // if there is not, create a new protocol
        $statement = $pdo->prepare("INSERT INTO cirs_rd_protokolle (enr) VALUES (:enr)");
        $result = $statement->execute(array('enr' => $enr));
    }
    header('Location: /edivi/protokoll.php?id=' . $enr);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>eDIVI &rsaquo; intraRP</title>
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
                <h4 class="text-center my-2">Protokoll öffnen/anlegen</h4>
                <form name="form" method="post" action="">
                    <input type="hidden" name="new" value="1" />
                    <strong>Einsatznummer:</strong><br>
                    <input class="form-control" type="text" size="40" maxlength="250" name="enr"><br><br>

                    <input class="btn btn-primary w-100" type="submit" value="Suchen">
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
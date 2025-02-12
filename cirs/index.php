<?php
session_start();
include_once("../assets/php/permissions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CIRS &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/cirs.min.css" />
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

<body>
    <!-- NAVIGATION -->
    <nav class="navbar bg-sh-red" id="cirs-nav">
        <div class="container-fluid">
            <div class="container">
                <div class="row w-100">
                    <div class="col d-flex align-items-center justify-content-end text-light" id="pageTitle">
                        Critical Incident Reporting System (CIRS)
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
            <div class="col-2 border-2 border-top border-sh-semigray bg-sh-gray" id="cirs-links">
                <hr class="text-sh-gray my-3">
                <?php include '../assets/php/cirs-nav.php' ?>
            </div>
            <div class="col">
                <?php if (isset($_GET['message']) && $_GET['message'] === 'error-2') { ?>
                    <div class="alert alert-danger" role="alert">
                        <h5>Fehler!</h5>
                        Du hast nicht die richtigen Berechtigungen!
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>
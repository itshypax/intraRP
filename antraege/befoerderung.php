<?php

session_start();

include("../assets/php/mysql-con.php");

if (isset($_POST['new']) && $_POST['new'] == 1) {
    // Antragsdaten
    $name_dn = $_REQUEST['name_dn'];
    $dienstgrad = $_REQUEST['dienstgrad'];
    // Freitext
    $freitext = $_REQUEST['freitext'];
    // Unique ID
    // generate a random number
    $random_number = mt_rand(100000, 999999);
    // check if the number already exists in the database
    $rncheck = "SELECT * FROM cirs_antraege_be WHERE uniqueid = $random_number";
    $rnres = $conn->query($rncheck);

    while ($rnres->num_rows > 0) {
        // if the number already exists, generate a new number and check again
        $random_number = mt_rand(100000, 999999);
        $rncheck = "SELECT * FROM cirs_antraege_be WHERE uniqueid = $random_number";
        $rnres = $conn->query($rncheck);
    }
    // store the new number in a variable
    $new_number = $random_number;
    // MYSQL QUERY
    mysqli_query($conn, "INSERT INTO cirs_antraege_be (`name_dn`, `dienstgrad`, `freitext`, `uniqueid`) VALUES ('$name_dn', '$dienstgrad', '$freitext', '$new_number')") or die();
    header('Location: view.php?antrag=' . $new_number . '');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Anträge &rsaquo; intraRP</title>
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
                        Antragsmanagement
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
                <?php include '../assets/php/antrag-nav.php' ?>
            </div>
            <div class="col"></div>
            <div class="col-6 my-5">
                <hr class="text-light my-3">
                <h1>Beförderungsantrag stellen</h1>
                <hr class="text-light my-3">
                <form action="" id="cirs-form" method="post">
                    <input type="hidden" name="new" value="1" />
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name_dn" class="form-label fw-bold">Name und Dienstnummer <span class="text-sh-red">*</span></label>
                            <input type="text" class="form-control" id="name_dn" name="name_dn" placeholder="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dienstgrad" class="form-label fw-bold">Aktueller Dienstgrad <span class="text-sh-red">*</span></label>
                            <input type="text" class="form-control" id="dienstgrad" name="dienstgrad" placeholder="" required>
                        </div>
                    </div>
                    <hr class="text-light my-3">
                    <h5>Schriftlicher Antrag</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="freitext" name="freitext" rows="5"></textarea>
                    </div>
                    <!-- <div class="text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation" style="margin-right:10px"></i>Um Bilder zu Meldung hinzuzufügen kann die Upload-Funktion des CIRS verwendet werden: abc.de</div> -->
                    <p><input class="mt-4 btn btn-lg rounded-3 btn-sh-red btn-sm" name="submit" type="submit" value="Absenden" /></p>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

</body>

</html>
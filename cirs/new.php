<?php

include("../assets/php/mysql-con.php");

if (isset($_POST['new']) && $_POST['new'] == 1) {
    // Betrifft (BTR)
    $btr_bf = $_REQUEST['btr_bf'] ?? "0";
    $btr_rd = $_REQUEST['btr_rd'] ?? "0";
    // Begründungen (R)easons
    $r_mitarbeiter = $_REQUEST['r_mitarbeiter'] ?? "0";
    $r_fahrzeug = $_REQUEST['r_fahrzeug'] ?? "0";
    $r_geraet = $_REQUEST['r_geraet'] ?? "0";
    $r_zivilisten = $_REQUEST['r_zivilisten'] ?? "0";
    $r_bos = $_REQUEST['r_bos'] ?? "0";
    $r_sonst = $_REQUEST['r_sonst'] ?? "0";
    // Art (T)ype
    $t_beschwerde = $_REQUEST['t_beschwerde'] ?? "0";
    $t_mangel = $_REQUEST['t_mangel'] ?? "0";
    $t_wunsch = $_REQUEST['t_wunsch'] ?? "0";
    $t_sonst = $_REQUEST['t_sonst'] ?? "0";
    // Freitext
    $freitext = $_REQUEST['freitext'];
    // Unique ID
    // generate a random number
    $random_number = mt_rand(100000, 999999);
    // check if the number already exists in the database
    $rncheck = "SELECT * FROM cirs_cases WHERE uniqueid = $random_number";
    $rnres = $conn->query($rncheck);

    while ($rnres->num_rows > 0) {
        // if the number already exists, generate a new number and check again
        $random_number = mt_rand(100000, 999999);
        $rncheck = "SELECT * FROM cirs_cases WHERE uniqueid = $random_number";
        $rnres = $conn->query($rncheck);
    }
    // store the new number in a variable
    $new_number = $random_number;
    // MYSQL QUERY
    mysqli_query($conn, "INSERT INTO cirs_cases (`btr_bf`, `btr_rd`, `r_mitarbeiter`, `r_fahrzeug`, `r_geraet`, `r_zivilisten`, `r_bos`, `r_sonst`, `t_beschwerde`, `t_mangel`, `t_wunsch`, `t_sonst`, `freitext`, `uniqueid`) VALUES ('$btr_bf', '$btr_rd', '$r_mitarbeiter', '$r_fahrzeug', '$r_geraet', '$r_zivilisten', '$r_bos', '$r_sonst', '$t_beschwerde', '$t_mangel', '$t_wunsch', '$t_sonst', '$freitext', '$new_number')") or die();
    header('Location: case' . $new_number . '');
}

session_start();
include_once '../assets/php/permissions.php';

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
            <div class="col"></div>
            <div class="col-6 my-5">
                <hr class="text-light my-3">
                <h1>Neue Meldung einreichen</h1>
                <hr class="text-light my-3">
                <form action="" id="cirs-form" method="post">
                    <input type="hidden" name="new" value="1" />
                    <h5>Meldung betrifft</h5>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="btr_bf" name="btr_bf">
                                <label class="form-check-label" for="btr_bf">
                                    Berufsfeuerwehr
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="btr_rd" name="btr_rd">
                                <label class="form-check-label" for="btr_rd">
                                    Rettungsdienst
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="text-light my-3">
                    <h5>Was hat das Problem ausgelöst?</h5>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_mitarbeiter" name="r_mitarbeiter">
                                <label class="form-check-label" for="r_mitarbeiter">
                                    Mitarbeiter
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_fahrzeug" name="r_fahrzeug">
                                <label class="form-check-label" for="r_fahrzeug">
                                    Fahrzeug
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_geraet" name="r_geraet">
                                <label class="form-check-label" for="r_geraet">
                                    Gerät
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_zivilisten" name="r_zivilisten">
                                <label class="form-check-label" for="r_zivilisten">
                                    Außenstehende / Dritte (Zivilisten)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_bos" name="r_bos">
                                <label class="form-check-label" for="r_bos">
                                    Andere Behörden / Organisationen (BOS)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="r_sonst" name="r_sonst">
                                <label class="form-check-label" for="r_sonst">
                                    Sonstiges (Bitte im Text ausführen)
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="text-light my-3">
                    <h5>Art der Meldung</h5>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="t_beschwerde" name="t_beschwerde">
                                <label class="form-check-label" for="t_beschwerde">
                                    Beschwerde
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="t_mangel" name="t_mangel">
                                <label class="form-check-label" for="t_mangel">
                                    Mängelmeldung
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="t_wunsch" name="t_wunsch">
                                <label class="form-check-label" for="t_wunsch">
                                    Wunsch der Besserung
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="t_sonst" name="t_sonst">
                                <label class="form-check-label" for="t_sonst">
                                    Sonstiges (Bitte im Text ausführen)
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="text-light my-3">
                    <h5>Meldung</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="freitext" name="freitext" rows="5"></textarea>
                    </div>
                    <!-- <div class="text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation" style="margin-right:10px"></i>Um Bilder zu Meldung hinzuzufügen kann die Upload-Funktion des CIRS verwendet werden: abc.de</div> -->
                    <p><input class="mt-4 btn btn-lg rounded-3 btn-sh-red" name="submit" type="submit" value="Eintrag erstellen" /></p>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>

</html>
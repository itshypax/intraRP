<?php
session_start();
require_once '../../assets/php/permissions.php';

if (!isset($_SESSION['userid']) || !isset($_SESSION['permissions'])) {
    // Store the current page's URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Redirect the user to the login page
    header("Location: /admin/login.php");
    exit();
} else if ($notadmincheck && !$edview) {
    header("Location: /admin/index.php");
}

include '../../assets/php/mysql-con.php';

$result = mysqli_query($conn, "SELECT * FROM cirs_rd_protokolle WHERE id = " . $_GET['id']) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$rowamount = mysqli_num_rows($result);

if ($rowamount == 0) {
    header("Location: /admin/edivi/list.php");
}

if ($row['freigegeben'] == 1) {
    $ist_freigegeben = true;
} else {
    $ist_freigegeben = false;
}

$row['last_edit'] = date("d.m.Y H:i", strtotime($row['last_edit']));

$old_status = $row['protokoll_status'];

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $bearbeiter = $_POST['bearbeiter'];
    $protokoll_status = $_POST['protokoll_status'];
    $qmkommentar = $_POST['qmkommentar'];

    if ($protokoll_status == 0) {
        $status_klar = "Ungesehen";
    } else if ($protokoll_status == 1) {
        $status_klar = "in Prüfung";
    } else if ($protokoll_status == 2) {
        $status_klar = "Freigegeben";
    } else if ($protokoll_status == 3) {
        $status_klar = "Ungenügend";
    }

    if ($protokoll_status != $old_status) {
        $statusstring = "Der Status wurde von " . $bearbeiter . " auf " . $status_klar . " gesetzt.";
        $querylog = "INSERT INTO cirs_rd_prot_log (protokoll_id, kommentar, bearbeiter, log_aktion) VALUES (" . $_GET['id'] . ", '$statusstring', '$bearbeiter', '1')";
    }

    if ($qmkommentar != NULL) {
        $queryins = "INSERT INTO cirs_rd_prot_log (protokoll_id, kommentar, bearbeiter, log_aktion) VALUES (" . $_GET['id'] . ", '$qmkommentar', '$bearbeiter', '0')";
    }
    $query = "UPDATE cirs_rd_protokolle SET bearbeiter = '$bearbeiter', protokoll_status = '$protokoll_status' WHERE id = " . $_GET['id'];
    if (isset($queryins)) {
        mysqli_query($conn, $queryins);
    }
    if (isset($querylog)) {
        mysqli_query($conn, $querylog);
    }
    mysqli_query($conn, $query);
    echo "<script>window.onload = function() { window.close(); }</script>";
}

$prot_url = "https://intra.muster.de/admin/edivi/divi" . $row['id']; // ! URL ANPASSEN

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>[#<?= $row['enr'] . "] " . $row['patname'] ?> &rsaquo; eDIVI &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/divi.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/jquery/jquery-3.7.0.min.js"></script>
    <!-- html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />


</head>

<body>
    <form name="form" method="post" action="">
        <input type="hidden" name="new" value="1" />
        <div class="container-fluid" id="edivi__container">
            <div class="row h-100">
                <div class="col">
                    <div class="row edivi__box">
                        <div class="col">
                            <h5 class="mb-3">QM-Funktionen [#<?= $row['enr'] ?>]</h5>
                            <div class="row mt-2 mb-1">
                                <div class="col-3 fw-bold">Gesichtet von</div>
                                <div class="col"><input style="border-radius: 0 !important" type="text" name="bearbeiter" id="bearbeiter" class="w-100 form-control edivi__admin" value="<?= $_SESSION['cirs_user'] ?>" readonly></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-3 fw-bold">Status</div>
                                <div class="col">
                                    <select name="protokoll_status" id="protokoll_status" class="form-select w-100 edivi__admin" style="border-radius: 0 !important">
                                        <option value="0" <?php echo ($row['protokoll_status'] == 0 ? 'selected' : '') ?>>Ungesehen</option>
                                        <option value="1" <?php echo ($row['protokoll_status'] == 1 ? 'selected' : '') ?>>in Prüfung</option>
                                        <option value="2" <?php echo ($row['protokoll_status'] == 2 ? 'selected' : '') ?>>Freigegeben</option>
                                        <option value="3" <?php echo ($row['protokoll_status'] == 3 ? 'selected' : '') ?>>Ungenügend</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-3 fw-bold">Bemerkung</div>
                                <div class="col">
                                    <textarea name="qmkommentar" id="qmkommentar" rows="8" class="w-100 form-control edivi__admin" style="resize: none"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-3 fw-bold">Öffentl. Link</div>
                                <div class="col">
                                    https://intra.muster.de/edivi/p-<?= $row['enr'] ?>
                                    <!-- ! URL ANPASSEN  -->
                                </div>
                            </div>
                            <div class="row mt-5 mb-4">
                                <div class="col text-center">
                                    <input class="btn btn-success" name="submit" type="submit" value="Speichern" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php if (!$admincheck && !$ededit) : ?>
        <script>
            window.close();
        </script>
    <?php endif; ?>
    <script>
        document.getElementById('delete-button').addEventListener('click', function() {
            window.close();
        });
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>
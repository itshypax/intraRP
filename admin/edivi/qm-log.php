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
        $status_klar = "Geprüft";
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

$prot_url = "https://intra.muster.de/admin/edivi/divi" . $row['id'];

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
            <h5 class="mb-3 text-center">QM-Log [#<?= $row['enr'] ?>]</h5>
            <div class="row h-100">
                <div class="col">
                    <?php
                    // get data from db and use foreach loop
                    $log_result = mysqli_query($conn, "SELECT * FROM cirs_rd_prot_log WHERE protokoll_id = " . $_GET['id'] . " ORDER BY id ASC") or die(mysqli_error($conn));
                    $log_rowamount = mysqli_num_rows($log_result);
                    if ($log_rowamount == 0) {
                        echo "<div class='row edivi__box'><div class='col'><p class='text-center'>Keine Einträge vorhanden.</p></div></div>";
                    } else {
                        while ($log_row = mysqli_fetch_array($log_result)) {
                            $log_row['timestamp'] = date("d.m.Y H:i", strtotime($log_row['timestamp']));
                            if ($log_row['log_aktion'] == 0) {
                    ?>
                                <div class='row edivi__box edivi__log-comment'>
                                    <div class="col-1 d-flex justify-content-center align-items-center"><i class="fa-solid fa-info"></i></div>
                                    <div class='col'>
                                        <small style="opacity:.6" class='mb-0'><b><?= $log_row['bearbeiter'] ?></b> | <?= $log_row['timestamp'] ?></small>
                                        <p class='mb-0'><?= $log_row['kommentar'] ?></p>
                                    </div>
                                </div>
                            <?php
                            } else if ($log_row['log_aktion'] == 1) {
                            ?>
                                <div class='row'>
                                    <div class='col text-center'>
                                        <small class="badge" title="<?= $log_row['timestamp'] ?>" style="opacity:.6" class='mb-0'><?= $log_row['kommentar'] ?></small>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
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
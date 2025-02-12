<?php
include '../assets/php/mysql-con.php';

$openedID = $_GET['dok'];

$result = mysqli_query($conn, "SELECT * FROM personal_dokumente WHERE docid = " . $_GET['dok']) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);

if ($row['anrede'] == 0) {
    $anrede = "Frau";
} else {
    $anrede = "Herr";
}

$erhalter_gebdat = $row['erhalter_gebdat'];
$date = DateTime::createFromFormat('Y-m-d', $erhalter_gebdat);
$month_number = $date->format('m');
$month_names = array(
    'Januar',
    'Februar',
    'März',
    'April',
    'Mai',
    'Juni',
    'Juli',
    'August',
    'September',
    'Oktober',
    'November',
    'Dezember'
);
$formatted_date = $date->format('d. ') . $month_names[$month_number - 1] . $date->format(' Y');
$ausstelldatum = date("d.m.Y", strtotime($row['ausstelungsdatum']));

$result2 = mysqli_query($conn, "SELECT id,fullname,aktenid FROM cirs_users WHERE id = " . $row['ausstellerid']) or die(mysqli_error($conn));
$adata = mysqli_fetch_array($result2);

$dienstgrade = [
    16 => "Ehrenamtliche/-r",
    0 => "Angestellte/-r",
    1 => "Brandmeisteranwärter/-in",
    2 => "Brandmeister/-in",
    3 => "Oberbrandmeister/-in",
    4 => "Hauptbrandmeister/-in",
    5 => "Hauptbrandmeister/-in mit AZ",
    17 => "Brandinspektoranwärter/-in",
    6 => "Brandinspektor/-in",
    7 => "Oberbrandinspektor/-in",
    8 => "Brandamtmann/frau",
    9 => "Brandamtsrat/rätin",
    10 => "Brandoberamtsrat/rätin",
    19 => "Ärztliche/-r Leiter/-in Rettungsdienst",
    15 => "Brandreferendar/in",
    11 => "Brandrat/rätin",
    12 => "Oberbrandrat/rätin",
    13 => "Branddirektor/-in",
    14 => "Leitende/-r Branddirektor/-in",
];

if ($row['suspendtime'] == "0000-00-00" || $row['suspendtime'] == NULL) {
    $suspenstring = "bis auf unbestimmt";
} else {
    $suspendtime = date("d.m.Y", strtotime($row['suspendtime']));
    $suspenstring = "bis zum " . $suspendtime;
}

if ($row['aussteller_name'] != NULL) {
    $fullname = $row['aussteller_name'];
} else {
    $fullname = $adata['fullname'];
}
$splitname = explode(" ", $fullname);
$lastname = end($splitname);

if ($adata['aktenid'] > 0) {
    $result3 = mysqli_query($conn, "SELECT id,fullname,dienstgrad,qualird FROM personal_profile WHERE id = " . $adata['aktenid']) or die(mysqli_error($conn));
    $rdata = mysqli_fetch_array($result3);
    if ($row['aussteller_rang'] != NULL) {
        $bfrang = $row['aussteller_rang'];
    } else {
        $bfrang = $rdata['dienstgrad'];
    }
    $dienstgrad2 = isset($dienstgrade[$bfrang]) ? $dienstgrade[$bfrang] : '';
}

$rankIcons = [
    1 => '/assets/img/dienstgrade/bf/1.png',
    2 => '/assets/img/dienstgrade/bf/2.png',
    3 => '/assets/img/dienstgrade/bf/3.png',
    4 => '/assets/img/dienstgrade/bf/4.png',
    5 => '/assets/img/dienstgrade/bf/5.png',
    17 => '/assets/img/dienstgrade/bf/17_2.png',
    6 => '/assets/img/dienstgrade/bf/6.png',
    7 => '/assets/img/dienstgrade/bf/7.png',
    8 => '/assets/img/dienstgrade/bf/8.png',
    9 => '/assets/img/dienstgrade/bf/9.png',
    10 => '/assets/img/dienstgrade/bf/10.png',
    15 => '/assets/img/dienstgrade/bf/15.png',
    11 => '/assets/img/dienstgrade/bf/11.png',
    12 => '/assets/img/dienstgrade/bf/12.png',
    13 => '/assets/img/dienstgrade/bf/13.png',
    14 => '/assets/img/dienstgrade/bf/14.png',
];

$typ = $row['type'];
$typen = [
    10 => "Schriftliche Abmahnung",
    11 => "Vorläufige Dienstenthebung",
    12 => "Dienstentfernung",
    13 => "Außerordentliche Kündigung",
];
$typtext = isset($typen[$typ]) ? $typen[$typ] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Schreiben &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/dokumente.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/freehand/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />

</head>

<?php if ($row['type'] == 10) { ?>

    <body class="bg-secondary" data-page-amount="1" data-page-type="10">
    <?php } else if ($row['type'] == 11) { ?>

        <body class="bg-secondary" data-page-amount="1" data-page-type="11">
        <?php } else if ($row['type'] == 12) { ?>

            <body class="bg-secondary" data-page-amount="1" data-page-type="12">
            <?php } else if ($row['type'] == 13) { ?>

                <body class="bg-secondary" data-page-amount="1" data-page-type="13">
                <?php } else { ?>

                    <body class="bg-secondary" data-page-amount="1">
                    <?php } ?>
                    <div class="page-container">
                        <div class="page shadow mx-auto mt-2 bg-light" id="page1">
                            <div class="col-4 float-end">
                                <div class="my-4"></div>
                                <p style="font-size:10pt">Datum</p>
                                <p style="font-size:12pt;margin-top:-18px"><?= $ausstelldatum ?></p>
                            </div>
                            <p style="font-size:10pt">Berufsfeuerwehr - Hauptstadtstraße 17 - 12345 Musterstadt</p>
                            <p><?= $anrede ?><br>
                                <?= $row['erhalter'] ?><br>
                                12345 Musterstadt
                            </p>
                            <div class="my-5"></div>
                            <p style="font-size:15pt;font-weight:bolder" class="mb-3"><?= $typtext ?></p>
                            <div class="letter-content">
                                <p>Sehr
                                    <?php if ($row['anrede'] == 0) {
                                        echo "geehrte";
                                    } else {
                                        echo "geehrter";
                                    }
                                    ?>
                                    <?= $anrede ?> <?= $row['erhalter'] ?>,
                                </p>
                                <!-- Schriftliche Abmahnung -->
                                <p class="dt-10">hiermit werden Sie schriftlich bezüglich der unten genannten Vorfälle abgemahnt.</p>
                                <p class="dt-10">Sollten Sie weiterhin dienstlich auffällig werden, müssen Sie mit weiteren dienstrechtlichen Konsequenzen bis hin zur Dienstentfernung rechnen.</p>
                                <p class="dt-10">Der Grund der Abmahnung lautet:</p>
                                <!-- Vorläufige Dienstenthebung -->
                                <p class="dt-11">Mit diesem Schreiben informieren wir Sie über Ihre vorläufige Dienstenthebung.</p>
                                <p class="dt-11">Ab sofort sind Sie <?= $suspenstring ?> suspendiert. In diesem Zeitraum sind Sie von Ihren dienstlichen Pflichten entbunden.</p>
                                <p class="dt-11">Der Grund der Suspendierung lautet:</p>
                                <!-- Dienstentfernung -->
                                <p class="dt-12">Mit diesem Schreiben informieren wir Sie über Ihre Entfernung aus dem Beamtendienst.</p>
                                <p class="dt-12">Mit sofortiger Wirkung ist das Arbeitsverhältnis mit der Berufsfeuerwehr beendigt. Eine Wiedereinstellung ist ausgeschlossen.</p>
                                <p class="dt-12">Der Grund der Dienstentfernung lautet:</p>
                                <!-- Kündigung -->
                                <p class="dt-13">Mit diesem Schreiben informieren wir Sie über Ihre außerordentliche Kündigung.</p>
                                <p class="dt-13">Mit sofortiger Wirkung ist das Arbeitsverhältnis mit der Berufsfeuerwehr beendigt. Eine Wiedereinstellung ist ausgeschlossen. </p>
                                <p class="dt-13">Der Grund für die Kündigung lautet:</p>
                                <div class="reasoning border border-2 border-dark py-3 px-2">
                                    <?= $row['inhalt'] ?>
                                </div>
                            </div>
                            <div class="my-5"></div>
                            <div class="row signatures">
                                <div class="col">
                                    <table>
                                        <tbody>
                                            <tr class="text-center" style="border-bottom: 2px solid #000">
                                                <td class="signature"><?= $lastname ?></td>
                                            </tr>
                                            <tr>
                                                <td>Berufsfeuerwehr<br><?= $fullname ?> | <?php if (isset($rankIcons[$bfrang])) { ?><img src="<?= $rankIcons[$bfrang] ?>" height='12px' width='auto' alt='Dienstgrad' /><?php } ?> <?= $dienstgrad2 ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col"></div>
                            </div>
                            <div class="document-styling">
                                <img src="/assets/img/bf_strich.png" alt="BF Strich">
                            </div>
                        </div>
                    </div>
                    </body>

</html>
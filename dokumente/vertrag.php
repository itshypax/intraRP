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
$dg = $row['erhalter_rang_rd'];
$dienstgrade = [
    0 => 'Rettungssanitäter/-in in Ausbildung',
    1 => 'Rettungssanitäter/-in',
    2 => 'Notfallsanitäter/-in',
];
$dienstgrad = isset($dienstgrade[$dg]) ? $dienstgrade[$dg] : '';

$dienstgradebf = [
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

$fullname2 = $row['erhalter'];
$splitname2 = explode(" ", $fullname2);
$lastname2 = end($splitname2);

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
    3 => "Arbeitsvertrag",
];
$typtext = isset($typen[$typ]) ? $typen[$typ] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arbeitsvertrag &rsaquo; intraRP</title>
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

<body class="bg-secondary" data-page-amount="6" data-page-type="3">
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
                <p>mit diesem Schreiben übersenden wir Ihnen Ihren Arbeitsvertrag bei der Berufsfeuerwehr. Bitte lesen Sie sich den Vertrag gründlich durch und speichern Sie ihn ab.</p>
                <p>Mit Arbeitsbeginn bestätigen Sie Ihre Unterschrift am Ende des Dokuments.</p>
                <p>Bei Rückfragen steht Ihnen das Personalmanagement jederzeit zur Verfügung.</p>
                <p><strong>Hinweis:</strong> Im Vertrag wird auf eine mehrgeschlechtliche Formulierung verzichtet. Alle Bezeichnungen sind sowohl für weibliche als auch männliche Personen zu verstehen.</p>
            </div>
            <hr class="text-light my-5">
            <div class="row signatures">
                <div class="col">
                    <table>
                        <tbody>
                            <tr class="text-center" style="border-bottom: 2px solid #000">
                                <td class="signature"><?= $lastname ?></td>
                            </tr>
                            <tr>
                                <td>Berufsfeuerwehr<br><?= $rdata['fullname'] ?> | <img src="<?= $rankIcons[$bfrang] ?>" height='12px' width='auto' alt='Dienstgrad' /> <?= $dienstgrad2 ?></td>
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
        <div class="page shadow mx-auto mt-4 bg-light" id="page2">
            <table class="docheader">
                <tbody>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Version</strong><span class="subtext">1.0</span></td>
                        <td class="text-center" rowspan="2" style="font-size:12pt"><strong><?= $typtext ?></strong><br>Berufsfeuerwehr</td>
                    </tr>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Seite</strong><span class="subtext">1 von 5</span></td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-center">§1 Rahmenbedingungen</h1>
            <div class="av-body" style="text-align:justify">
                <p>Dieses Dokument umfasst einen Arbeitsvertrag zwischen folgenden Parteien:</p>
                <p class="ms-5" style="margin-top:-10px">1) Die Berufsfeuerwehr – nachfolgend als Arbeitgeber bezeichnet – und, </p>
                <p class="ms-5" style="margin-top:-10px">2) <?= $anrede ?> <?= $row['erhalter'] ?> – nachfolgend als Arbeitnehmer bezeichnet</p>
                <p style="margin-top:-10px">Unter den hier aufgeführten Umständen ist der Arbeitgeber gewillt den Arbeitnehmer einzustellen und der Arbeitnehmer ist gewillt eingestellt zu werden. </p>
            </div>
            <h1 class="text-center">§2 Gültigkeit</h1>
            <div class="av-body" style="text-align:justify">
                <p>Mit Beginn der Arbeit stimmt der Arbeitnehmer diesem Vertrag zu und verpflichtet sich, alle Regelungen dieses Vertrages sowie alle Regelungen der aktuellen Dienstverordnung der Berufsfeuerwehr zu berücksichtigen und sich daran zu halten. Ein Verstoß gegen diese Regelungen kann mit Disziplinarmaßnahmen geahndet werden.</p>
                <p style="margin-top:-10px">Sollten einzelne Bestimmungen dieses Vertrages unwirksam oder nichtig sein oder weist der Vertrag Lücken auf, so bleiben die übrigen Bestimmungen dieses Vertrages unberührt und behalten ihre Gültigkeit.</p>
            </div>
            <h1 class="text-center">§3 Arbeitsbeginn, Probezeit</h1>
            <div class="av-body" style="text-align:justify">
                <p>Das Arbeitsverhältnis beginnt am <?= $ausstelldatum ?>. Das Verhältnis wird auf unbestimmte Zeit geschlossen. </p>
                <p style="margin-top:-10px">Der Arbeitnehmer befindet sich ab Arbeitsbeginn in einer Probezeit von fünf Tagen. Während dieser Probezeit kann das Arbeitsverhältnis seitens des Arbeitnehmers oder des Arbeitgebers ohne eine Kündigungsfrist oder die Angabe von Gründen beendigt werden. </p>
            </div>
            <div class="document-styling">
                <img src="/assets/img/bf_strich.png" alt="BF Strich">
            </div>
        </div>
        <div class="page shadow mx-auto mt-4 bg-light" id="page3">
            <table class="docheader">
                <tbody>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Version</strong><span class="subtext">1.0</span></td>
                        <td class="text-center" rowspan="2" style="font-size:12pt"><strong><?= $typtext ?></strong><br>Berufsfeuerwehr</td>
                    </tr>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Seite</strong><span class="subtext">2 von 5</span></td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-center">§4 Arbeitsort</h1>
            <div class="av-body" style="text-align:justify">
                <p>Als Arbeitsort ist die Berufsfeuerwehr mit deren Hauptquartier in der Hauptstadtstraße 17, 12345 Musterstadt und allen Außenstandorten bezeichnet. Es liegt dem Arbeitgeber frei, den Arbeitnehmer innerhalb aller Standorte der Berufsfeuerwehr zu versetzen, wie der Arbeitgeber es für sinnvoll hält.</p>
            </div>
            <h1 class="text-center">§5 Tätigkeit</h1>
            <div class="av-body" style="text-align:justify">
                <p>Mit Beginn der Arbeit stimmt der Arbeitnehmer diesem Vertrag zu und verpflichtet sich, alle Regelungen dieses Vertrages sowie alle Regelungen der aktuellen Dienstverordnung der Berufsfeuerwehr zu berücksichtigen und sich daran zu halten. Ein Verstoß gegen diese Regelungen kann mit Disziplinarmaßnahmen geahndet werden.</p>
                <p style="margin-top:-10px">Das Arbeitsspektrum umfasst alle Tätigkeiten, die einem Mitarbeiter mit diesem Dienstgrad und dessen Qualifikationen zumutbar sind. Unter Umständen kann ein Vorgesetzter des Arbeitnehmers auch zusätzliche Arbeiten anordnen, solange diese dem Arbeitnehmer zumutbar sind.</p>
            </div>
            <h1 class="text-center">§6 Weisungsrecht</h1>
            <div class="av-body" style="text-align:justify">
                <p>Der Arbeitnehmer ist aufgrund des Arbeitsverhältnisses verpflichtet, den Weisungen des Arbeitgebers nachzukommen. Befolgt der Arbeitnehmer eine rechtmäßig ergangene Weisung nicht, kann dies zu Disziplinarmaßnahmen führen. </p>

            </div>
            <h1 class="text-center">§7 Vergütung</h1>
            <div class="av-body" style="text-align:justify">
                <p>Der Arbeitnehmer erhält eine tarifliche Vergütung nach Dienstgrad und Qualifikation.</p>
                <p style="margin-top:-10px">Es ist dem Arbeitnehmer untersagt, Gehalt einzuziehen, während dieser sich nicht im Dienst befindet oder dienstlichen Tätigkeiten nachgeht. </p>
            </div>
            <div class="document-styling">
                <img src="/assets/img/bf_strich.png" alt="BF Strich">
            </div>
        </div>
        <div class="page shadow mx-auto mt-4 bg-light" id="page4">
            <table class="docheader">
                <tbody>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Version</strong><span class="subtext">1.0</span></td>
                        <td class="text-center" rowspan="2" style="font-size:12pt"><strong><?= $typtext ?></strong><br>Berufsfeuerwehr</td>
                    </tr>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Seite</strong><span class="subtext">3 von 5</span></td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-center">§8 Urlaub, Krankheitsfall</h1>
            <div class="av-body" style="text-align:justify">
                <p>Der Arbeitnehmer hat einen Anspruch auf unbezahlten Urlaub. Dieser muss im Voraus angemeldet werden. Ein Urlaubsantrag muss spätestens ab fünf dienstfreien Werktagen eingereicht werden. </p>
                <p style="margin-top:-10px">Im Krankheitsfall ist der Arbeitnehmer verpflichtet, dem Arbeitgeber die Arbeitsverhinderung unverzüglich mitzuteilen. Sollte es möglich sein, muss auch eine voraussichtliche Dauer des Ausfalls angegeben werden. </p>
            </div>
            <h1 class="text-center">§9 Verschwiegenheitspflicht</h1>
            <div class="av-body" style="text-align:justify">
                <p>Der Arbeitnehmer ist verpflichtet sich während der Dauer des Arbeitsverhältnisses und auch nach Beendigung über alle Betriebs- und Geschäftsgeheimnisse Stillschweigen zu bewahren. Dies umfasst auch den Inhalt dieses Vertrages. </p>
                <p style="margin-top:-10px">Im Kontext der Tätigkeit des Arbeitnehmers ist der Arbeitnehmer dazu verpflichtet, über alle sensiblen Daten von Betroffenen oder Empfängern der Dienstleistungen im dienstlichen Rahmen, Stillschweigen zu bewahren. </p>
            </div>
            <h1 class="text-center">§10 Alkohol- und Drogenverbot</h1>
            <div class="av-body" style="text-align:justify">
                <p>Die Arbeit ist ohne vorherigen Alkohol- und/oder Drogengenuss aufzunehmen. Auch während der Dienstzeit ist dem Arbeitnehmer jeglicher Konsum von Alkohol oder Drogen untersagt. </p>
                <p style="margin-top:-10px"> Ebenso untersagt ist die Mitführung von kontrollierten oder berauschenden Substanzen oder Suchtmitteln während des Dienstes. Ausgenommen hiervon sind Zigaretten oder ähnliche Nikotin- / Tabakprodukte. Außerdem ausgenommen sind Ausrüstung, die dem Mitarbeiter für die dienstliche Tätigkeit ausgehändigt wird oder persönliche Medikamente. </p>
            </div>
            <div class="document-styling">
                <img src="/assets/img/bf_strich.png" alt="BF Strich">
            </div>
        </div>
        <div class="page shadow mx-auto mt-4 bg-light" id="page5">
            <table class="docheader">
                <tbody>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Version</strong><span class="subtext">1.0</span></td>
                        <td class="text-center" rowspan="2" style="font-size:12pt"><strong><?= $typtext ?></strong><br>Berufsfeuerwehr</td>
                    </tr>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Seite</strong><span class="subtext">4 von 5</span></td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-center">§11 Nebentätigkeit</h1>
            <div class="av-body" style="text-align:justify">
                <p>Der Arbeitnehmer benötigt für eine Beschäftigung in einer Nebentätigkeit die vorherige Zustimmung durch den Arbeitgeber.</p>
                <p style="margin-top:-10px">Die Zustimmung ist zu erteilen, wenn die durch den Arbeitnehmer angestrebte Nebenbeschäftigung den Arbeitnehmer nicht oder nicht wesentlich an der Wahrnehmung der dienstlichen Pflichten hindert und auch sonstige Interessen des Arbeitgebers nicht berührt werden.</p>
            </div>
            <h1 class="text-center">§12 Beendigung des Arbeitsverhältnisses</h1>
            <div class="av-body" style="text-align:justify">
                <p>Das Arbeitsverhältnis kann nach Ablauf der Probezeit mit einer Kündigungsfrist von einer Woche gekündigt werden. Diese vereinbarte Kündigungsfrist gilt sowohl für den Arbeitgeber als auch für den Arbeitnehmer.</p>
                <p style="margin-top:-10px">Die Kündigung bedarf einer schriftlichen Information an den Arbeitgeber. Mit Eingang des Kündigungsschreibens beginnt die Kündigungsfrist. Eine Angabe von Gründen muss nicht stattfinden.</p>
                <p style="margin-top:-10px">Der Arbeitnehmer ist nach der Kündigung verpflichtet, alle ihm vom Arbeitgeber zur Verfügung gestellten Arbeitsmittel innerhalb von vier Tagen zurückzuführen. </p>
            </div>
            <h1 class="text-center">§13 Disziplinarmaßnahmen</h1>
            <div class="av-body" style="text-align:justify">
                <p>m Falle eines Verstoßes gegen die Vereinbarungen dieses Vertrages, die Regelungen der Dienstverordnung oder bei grobem Fehlverhalten steht es dem Arbeitgeber frei, eine Disziplinarmaßnahme auszusprechen. </p>
                <p style="margin-top:-10px">Die passende Maßnahme wird nach Schwere des Vergehens und Verhalten des Arbeitnehmers gewählt. Gegebenenfalls können auch mehrere Disziplinarmaßnahmen angewendet werden oder eine Disziplinarmaßnahme kann auf eine andere folgen. </p>
            </div>
            <div class="document-styling">
                <img src="/assets/img/bf_strich.png" alt="BF Strich">
            </div>
        </div>
        <div class="page shadow mx-auto mt-4 bg-light" id="page7">
            <table class="docheader">
                <tbody>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Version</strong><span class="subtext">1.0</span></td>
                        <td class="text-center" rowspan="2" style="font-size:12pt"><strong><?= $typtext ?></strong><br>Berufsfeuerwehr</td>
                    </tr>
                    <tr>
                        <td style="width:20%;padding-left:5px;font-size:8pt"><strong>Seite</strong><span class="subtext">5 von 5</span></td>
                    </tr>
                </tbody>
            </table>
            <div class="av-body" style="text-align:justify">
                <p class="ms-5">1) Abmahnung – Der Arbeitnehmer erhält eine schriftliche Verwarnung vom Arbeitgeber.</p>
                <p class="ms-5" style="margin-top:-10px">2) Suspendierung – Der Arbeitnehmer wird vorrübergehend aus dem Dienst entfernt. Eine Vergütung findet während einer Suspendierung nicht statt.</p>
                <p class="ms-5" style="margin-top:-10px">3) Außerordentliche Kündigung – Im Falle einer außerordentlichen Kündigung wird das Arbeitsverhältnis mit sofortiger Wirkung beendigt. Die Kündigungsfrist gilt hier nicht.</p>
                <p class="ms-5" style="margin-top:-10px">4) Geldstrafe – Bei groben Verstößen steht es dem Arbeitgeber frei, vom Arbeitnehmer eine Entschädigung in Form einer Geldstrafe zu verlangen. Die Höhe richtet sich nach dem entstandenen Schaden und am Gehalt des Arbeitnehmers.</p>
            </div>
            <h1 class="text-center">§14 Sonstige Regelungen</h1>
            <div class="av-body" style="text-align:justify">
                <p>Die Leitungsebene der Berufsfeuerwehr behält sich vor, zu jedem Zeitpunkt eine Einsicht in die polizeiliche Akte des Arbeitnehmers zu nehmen. </p>
                <p style="margin-top:-10px">Der Arbeitnehmer gestattet dem Arbeitgeber zu jedem Zeitpunkt, ohne richterlichen Beschluss und bei begründetem Verdacht die Privatfahrzeuge, sowie sich selbst, durchsuchen zu lassen. </p>
                <p style="margin-top:-10px">Diese Berechtigungen gelten bis zu 5 Tage über die Beendigung des Arbeitsverhältnisses hinaus.</p>
            </div>
            <hr class="text-light my-3">
            <p>Musterstadt, den <?= $ausstelldatum ?>,</p>
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
                <div class="col">
                    <table>
                        <tbody>
                            <tr class="text-center" style="border-bottom: 2px solid #000">
                                <td class="signature"><?= $lastname2 ?></td>
                            </tr>
                            <tr>
                                <td>Arbeitnehmer<br><?= $row['erhalter'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="document-styling">
                <img src="/assets/img/bf_strich.png" alt="BF Strich">
            </div>
        </div>
    </div>
</body>

</html>
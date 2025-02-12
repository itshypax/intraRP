<?php

include 'mysql-con.php';

// STAMMDATEN
$patname = $_POST['patname'] ?? NULL;
$patgebdat = $_POST['patgebdat'] ?? NULL;
$patsex = $_POST['patsex'] ?? NULL;
$edatum = $_POST['edatum'] ?? NULL;
$ezeit = $_POST['ezeit'] ?? NULL;
$enr = $_POST['enr'];
// A - ATEMWEGE
$awfrei_1 = (isset($_POST['awfrei_1']) && $_POST['awfrei_1'] >= 1) ? $_POST['awfrei_1'] : 0;
$awfrei_2 = (isset($_POST['awfrei_2']) && $_POST['awfrei_2'] >= 1) ? $_POST['awfrei_2'] : 0;
$awfrei_3 = (isset($_POST['awfrei_3']) && $_POST['awfrei_3'] >= 1) ? $_POST['awfrei_3'] : 0;
$awsicherung_1 = (isset($_POST['awsicherung_1']) && $_POST['awsicherung_1'] >= 1) ? $_POST['awsicherung_1'] : 0;
$awsicherung_2 = (isset($_POST['awsicherung_2']) && $_POST['awsicherung_2'] >= 1) ? $_POST['awsicherung_2'] : 0;
$zyanose_1 = (isset($_POST['zyanose_1']) && $_POST['zyanose_1'] >= 1) ? $_POST['zyanose_1'] : 0;
$zyanose_2 = (isset($_POST['zyanose_2']) && $_POST['zyanose_2'] >= 1) ? $_POST['zyanose_2'] : 0;
$o2gabe = (isset($_POST['o2gabe']) && $_POST['o2gabe'] >= 1) ? $_POST['o2gabe'] : 0;
// B - ATMUNG
$b_symptome = $_POST['b_symptome'] ?? NULL;
$b_auskult = $_POST['b_auskult'] ?? NULL;
$spo2 = $_POST['spo2'] ?? NULL;
$atemfreq = $_POST['atemfreq'] ?? NULL;
$etco2 = $_POST['etco2'] ?? NULL;
// C - KREISLAUF
$c_kreislauf = $_POST['c_kreislauf'] ?? NULL;
$rrsys = $_POST['rrsys'] ?? NULL;
$rrdias = $_POST['rrdias'] ?? NULL;
$herzfreq = $_POST['herzfreq'] ?? NULL;
$c_ekg = $_POST['c_ekg'] ?? NULL;
// D - NEUROLOGIE
$d_bewusstsein = $_POST['d_bewusstsein'] ?? NULL;
$d_pupillenw_1 = $_POST['d_pupillenw_1'] ?? NULL;
$d_pupillenw_2 = $_POST['d_pupillenw_2'] ?? NULL;
$d_lichtreakt_1 = $_POST['d_lichtreakt_1'] ?? NULL;
$d_lichtreakt_2 = $_POST['d_lichtreakt_2'] ?? NULL;
$d_gcs_1 = $_POST['d_gcs_1'] ?? NULL;
$d_gcs_2 = $_POST['d_gcs_2'] ?? NULL;
$d_gcs_3 = $_POST['d_gcs_3'] ?? NULL;
$d_ex_1 = $_POST['d_ex_1'] ?? NULL;
// BZ + TEMP
$bz = $_POST['bz'] ?? NULL;
$temp = $_POST['temp'] ?? NULL;
// VERLETZUNGEN
$v_muster_k = $_POST['v_muster_k'] ?? NULL;
$v_muster_k1 = $_POST['v_muster_k1'] ?? NULL;
$v_muster_t = $_POST['v_muster_t'] ?? NULL;
$v_muster_t1 = $_POST['v_muster_t1'] ?? NULL;
$v_muster_al = $_POST['v_muster_al'] ?? NULL;
$v_muster_al1 = $_POST['v_muster_al1'] ?? NULL;
$v_muster_a = $_POST['v_muster_a'] ?? NULL;
$v_muster_a1 = $_POST['v_muster_a1'] ?? NULL;
$v_muster_bl = $_POST['v_muster_bl'] ?? NULL;
$v_muster_bl1 = $_POST['v_muster_bl1'] ?? NULL;
$v_muster_w = $_POST['v_muster_w'] ?? NULL;
$v_muster_w1 = $_POST['v_muster_w1'] ?? NULL;
// MEDIKAMENTE
$medis = $_POST['medis'] ?? NULL;
// DIAGNOSE
$diagnose = $_POST['diagnose'] ?? NULL;
// ANMERKUNGEN
$anmerkungen = $_POST['anmerkungen'] ?? NULL;
// PROTOKOLLDATEN
$notfallteam = (isset($_POST['notfallteam']) && $_POST['notfallteam'] >= 1) ? $_POST['notfallteam'] : 0;
$transportverw = (isset($_POST['transportverw']) && $_POST['transportverw'] >= 1) ? $_POST['transportverw'] : 0;
$nacascore = (isset($_POST['nacascore']) && $_POST['nacascore'] >= 1) ? $_POST['nacascore'] : 0;
$pfname =  $_POST['pfname'] ?? NULL;
$naname =  $_POST['naname'] ?? NULL;
$transportziel =  $_POST['transportziel2'] ?? NULL;

$result = mysqli_query($conn, "SELECT * FROM cirs_rd_protokolle WHERE enr = '$enr'");
if (mysqli_num_rows($result) > 0) {
    $query = "UPDATE cirs_rd_protokolle SET patname = '$patname', patgebdat = '$patgebdat', patsex = '$patsex', edatum = '$edatum', ezeit = '$ezeit', enr = '$enr', awfrei_1 = '$awfrei_1', awfrei_2 = '$awfrei_2', awfrei_3 = '$awfrei_3', awsicherung_1 = '$awsicherung_1', awsicherung_2 = '$awsicherung_2', zyanose_1 = '$zyanose_1', zyanose_2 = '$zyanose_2', o2gabe = '$o2gabe', b_symptome = '$b_symptome', b_auskult = '$b_auskult', spo2 = '$spo2', atemfreq = '$atemfreq', etco2 = '$etco2', c_kreislauf = '$c_kreislauf', rrsys = '$rrsys', rrdias = '$rrdias', herzfreq = '$herzfreq', c_ekg = '$c_ekg', d_bewusstsein = '$d_bewusstsein', d_pupillenw_1 = '$d_pupillenw_1', d_pupillenw_2 = '$d_pupillenw_2', d_lichtreakt_1 = '$d_lichtreakt_1', d_lichtreakt_2 = '$d_lichtreakt_2', d_gcs_1 = '$d_gcs_1', d_gcs_2 = '$d_gcs_2', d_gcs_3 = '$d_gcs_3', d_ex_1 = '$d_ex_1', bz = '$bz', temp = '$temp', v_muster_k = '$v_muster_k', v_muster_k1 = '$v_muster_k1', v_muster_t = '$v_muster_t', v_muster_t1 = '$v_muster_t1', v_muster_al = '$v_muster_al', v_muster_al1 = '$v_muster_al1', v_muster_a = '$v_muster_a', v_muster_a1 = '$v_muster_a1', v_muster_bl = '$v_muster_bl', v_muster_bl1 = '$v_muster_bl1', v_muster_w = '$v_muster_w', v_muster_w1 = '$v_muster_w1', medis = '$medis', diagnose = '$diagnose', anmerkungen = '$anmerkungen', notfallteam = '$notfallteam', transportverw = '$transportverw', nacascore = '$nacascore', pfname = '$pfname', naname = '$naname', transportziel2 = '$transportziel' WHERE enr = '$enr'";
    mysqli_query($conn, $query);
    $response = ["updated" => true];
} else {
    $response = ["updated" => false, "message" => "Ein unbekannter Fehler ist aufgetreten."];
}

// Send a JSON response back to the JavaScript
echo json_encode($response);

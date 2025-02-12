<?php

// ----------------- //
// Dienstgrad abfragen
// ----------------- //

$dg = $row['dienstgrad'];

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

$dienstgrad = isset($dienstgrade[$dg]) ? $dienstgrade[$dg] : '';

// ----------------- //
// Geburstdatum u. Einstellungsdatum formattieren
// ----------------- //

$geburtstag = date("d.m.Y", strtotime($row['gebdatum']));
$einstellungsdatum = date("d.m.Y", strtotime($row['einstdatum']));

// ----------------- //
// RD Quali abfragen
// ----------------- // 

$rd = $row['qualird'];

$rddg = [
    0 => "Keine",
    1 => "Rettungssanitäter/-in i. A.",
    2 => "Rettungssanitäter/-in",
    3 => "Notfallsanitäter/-in",
    4 => "Notarzt/ärztin",
    5 => "Ärztliche/-r Leiter/-in RD",
];

$rdqualtext = isset($rddg[$rd]) ? $rddg[$rd] : '';

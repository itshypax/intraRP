<?php

$dg = $row['dienstgrad'];
$rdq = $row['qualird'];
$bfq2 = $row['qualifw2'];

$geburtstag = (new DateTime($row['gebdatum']))->format('d.m.Y');
$einstellungsdatum = (new DateTime($row['einstdatum']))->format('d.m.Y');

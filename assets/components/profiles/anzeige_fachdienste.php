<?php
$currentFd = $row['fachdienste'];
if (!empty($currentFd)) {
    $fdDecode = json_decode($currentFd, true);

    $fdNamen = [
        "211" => "Integrierte Leitstelle",
        "212" => "Einsatzleitdienst",
        "213" => "Presseabteilung",
        "221" => "FW Schule",
        "222" => "Personaleinsatz BF",
        "223" => "Lager und Logistik",
        "231" => "Spezialrettung",
        "232" => "CBRN-Schutz",
        "233" => "Krisenintervention",
        "411" => "RD Schule",
        "412" => "Einsatzleitung RD",
        "413" => "Luftrettung",
        "414" => "Qualitätsmanagement RD"
    ];

    $fd210 = [];
    $fd220 = [];
    $fd230 = [];
    $fd410 = [];

    foreach ($fdDecode as $fdValue) {
        if (preg_match('/^21\d/', $fdValue)) {
            $fd210[] = $fdValue;
        } elseif (preg_match('/^22\d/', $fdValue)) {
            $fd220[] = $fdValue;
        } elseif (preg_match('/^23\d/', $fdValue)) {
            $fd230[] = $fdValue;
        } elseif (preg_match('/^41\d/', $fdValue)) {
            $fd410[] = $fdValue;
        }
    }

    if (empty($fd210) && empty($fd220) && empty($fd230) && empty($fd410)) {
        echo "<p class='mb-0'>Keine Fachdienste hinterlegt</p>";
    }

    if (!empty($fd210)) {
        echo "<div class='abteilung-container'>";
        echo "<p class='abteilung mb-0'>Abteilung 210</p>";
        foreach ($fd210 as $item) {
            $fdNameText = $fdNamen[$item] ?? "Unknown";
            echo '<span class="badge text-bg-secondary">' . $fdNameText . '</span>';
        }
        echo "</div>";
    }
    if (!empty($fd220)) {
        echo "<div class='abteilung-container'>";
        echo "<p class='abteilung mb-0'>Abteilung 220</p>";
        foreach ($fd220 as $item) {
            $fdNameText = $fdNamen[$item] ?? "Unknown";
            echo '<span class="badge text-bg-secondary">' . $fdNameText . '</span>';
        }
        echo "</div>";
    }
    if (!empty($fd230)) {
        echo "<div class='abteilung-container'>";
        echo "<p class='abteilung mb-0'>Abteilung 230</p>";
        foreach ($fd230 as $item) {
            $fdNameText = $fdNamen[$item] ?? "Unknown";
            echo '<span class="badge text-bg-secondary">' . $fdNameText . '</span>';
        }
        echo "</div>";
    }
    if (!empty($fd410)) {
        echo "<div class='abteilung-container'>";
        echo "<p class='abteilung mb-0'>Abteilung 410</p>";
        foreach ($fd410 as $item) {
            $fdNameText = $fdNamen[$item] ?? "Unknown";
            echo '<span class="badge text-bg-secondary">' . $fdNameText . '</span>';
        }
        echo "</div>";
    }
}

<?php
$options = [
    14 => "Leitende/-r Branddirektor/-in",
    13 => "Branddirektor/-in",
    12 => "Oberbrandrat/rätin",
    11 => "Brandrat/rätin",
    15 => "Brandreferendar/in",
    19 => "Ärztliche/-r Leiter/-in Rettungsdienst",
    10 => "Brandoberamtsrat/rätin",
    9 => "Brandamtsrat/rätin",
    8 => "Brandamtmann/frau",
    7 => "Oberbrandinspektor/-in",
    6 => "Brandinspektor/-in",
    17 => "Brandinspektoranwärter/-in",
    5 => "Hauptbrandmeister/-in mit AZ",
    4 => "Hauptbrandmeister/-in",
    3 => "Oberbrandmeister/-in",
    2 => "Brandmeister/-in",
    1 => "Brandmeisteranwärter/-in",
    0 => "Angestellte/-r",
    16 => "Ehrenamtliche/-r",
    18 => "Entlassen/Archiv"
];
?>

<select class="form-select mt-3" name="dienstgrad" id="dienstgrad">
    <?php foreach ($options as $value => $label) : ?>
        <option value="<?php echo $value; ?>" <?php if ($dg == $value) echo 'selected="selected"'; ?>>
            <?php echo $label; ?>
        </option>
    <?php endforeach; ?>
</select>
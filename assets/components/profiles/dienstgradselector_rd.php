<?php
$stmt = $pdo->prepare("SELECT id,name,priority FROM intra_mitarbeiter_rdquali ORDER BY priority ASC");
$stmt->execute();
$rdqsel = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-floating">
    <select class="form-select mt-3" name="qualird" id="qualird">
        <?php foreach ($rdqsel as $data) {
            if ($rdq == $data['id']) {
                echo "<option value='{$data['id']}' selected='selected'>{$data['name']}</option>";
            } else {
                echo "<option value='{$data['id']}'>{$data['name']}</option>";
            }
        } ?>
    </select>
    <label for="qualird"><?= lang('personnel.selectors.qualification_rescue') ?></label>
</div>
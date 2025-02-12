<!-- 
    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalFWQuali">FW Qualifikationen einsehen</div>
    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalRDQuali">RD Qualifikationen einsehen</div>
    <div class="btn btn-secondary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalFDQuali">Fachdienste einsehen</div>
    <div class="btn btn-primary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalNewComment">Notiz anlegen</div>
    <div class="btn btn-primary mb-2" style="border-radius:0;max-width:80%;width:80%" data-bs-toggle="modal" data-bs-target="#modalDokuCreator">Dokument erstellen</div>
-->

<!-- MODAL -->
<div class="modal fade" id="modalFWQuali" tabindex="-1" aria-labelledby="modalFWQualiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFWQualiLabel">Feuerwehr Qualifikationen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="fwqualiForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        $fwqualis = json_decode($row['qualifw'], true) ?? [];
                        if (!$canEdit) {
                            $qualifications = [
                                'bm' => 'B1 (Grundausbildung)',
                                'sfz' => 'B2 (M-SFZ)',
                                'gf' => 'B3 (Gruppenführer)',
                                'zf' => 'B4 (Zugführer)',
                                'b5' => 'B5 (Verbandsführer)',
                                'b6' => 'B6 (Brandreferendar)',
                            ];

                            foreach ($qualifications as $key => $qualification) {
                                $hasQualification = in_array($key, $fwqualis);
                                $badgeColor = $hasQualification ? 'bg-success' : 'bg-danger';

                                echo '<span class="badge ' . $badgeColor . '">' . $qualification . '</span>&nbsp;';
                            }
                        } elseif ($canEdit) { ?>
                            <input type="hidden" name="new" value="2" />
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Ja/Nein</th>
                                        <th colspan="2">Bezeichnung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="bm" <?php if (in_array('bm', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B1</td>
                                        <td>Grundausbildung</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="sfz" <?php if (in_array('sfz', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B2</td>
                                        <td>Maschinist SFZ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="gf" <?php if (in_array('gf', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B3</td>
                                        <td>Gruppenführer</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="zf" <?php if (in_array('zf', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B4</td>
                                        <td>Zugführer</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="b5" <?php if (in_array('b5', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B5</td>
                                        <td>Verbandsführer</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="qualifw[]" value="b6" <?php if (in_array('b6', $fwqualis)) echo 'checked'; ?>></td>
                                        <td class="fw-bold">B6</td>
                                        <td>Brandreferendar</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <?php if ($canEdit) { ?>
                        <button type="button" class="btn btn-success" id="fwq-save" onclick="document.getElementById('fwqualiForm').submit()">Speichern</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL ENDE -->

<!-- MODAL -->
<div class="modal fade" id="modalRDQuali" tabindex="-1" aria-labelledby="modalRDQualiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRDQualiLabel">Rettungsdienst Qualifikationen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rdqualiForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        if (!$canEdit) {
                        ?>
                            <label>
                                <select class="form-select" name="qualird" disabled>
                                    <option value="" <?php if ($row['qualird'] == 0) echo 'selected'; ?>>Keine</option>
                                    <option value="" <?php if ($row['qualird'] == 1) echo 'selected'; ?>>Rettungssanitäter/-in i. A.</option>
                                    <option value="" <?php if ($row['qualird'] == 2) echo 'selected'; ?>>Rettungssanitäter/-in</option>
                                    <option value="" <?php if ($row['qualird'] == 3) echo 'selected'; ?>>Notfallsanitäter/-in</option>
                                    <option value="" <?php if ($row['qualird'] == 4) echo 'selected'; ?>>Notarzt/ärztin</option>
                                    <option value="" <?php if ($row['qualird'] == 5) echo 'selected'; ?>>Ärztliche/-r Leiter/-in RD</option>
                                </select>
                            </label>
                        <?php
                        } elseif ($canEdit) { ?>
                            <input type="hidden" name="new" value="3" />
                            <label>
                                <select class="form-select" name="qualird">
                                    <option value="0" <?php if ($row['qualird'] == 0) echo 'selected'; ?>>Keine</option>
                                    <option value="1" <?php if ($row['qualird'] == 1) echo 'selected'; ?>>Rettungssanitäter/-in i. A.</option>
                                    <option value="2" <?php if ($row['qualird'] == 2) echo 'selected'; ?>>Rettungssanitäter/-in</option>
                                    <option value="3" <?php if ($row['qualird'] == 3) echo 'selected'; ?>>Notfallsanitäter/-in</option>
                                    <option value="4" <?php if ($row['qualird'] == 4) echo 'selected'; ?>>Notarzt/ärztin</option>
                                    <option value="5" <?php if ($row['qualird'] == 5) echo 'selected'; ?>>Ärztliche/-r Leiter/-in RD</option>
                                </select>
                            </label>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <?php if ($canEdit) { ?>
                        <button type="button" class="btn btn-success" id="rdq-save" onclick="document.getElementById('rdqualiForm').submit()">Speichern</button>
                    <?php } ?>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- MODAL ENDE -->

<!-- MODAL -->
<div class="modal fade" id="modalFDQuali" tabindex="-1" aria-labelledby="modalFDQualiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFDQualiLabel">Fachdienste</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="fdqualiForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        $fdqualis = json_decode($row['fachdienste'], true) ?? [];
                        if (!$canEdit) {
                            $qualificationsfd = [
                                'ils' => 'Integrierte Leitstelle',
                                'el' => 'Einsatzleitung',
                                'elrd' => 'Einsatzleitung RettD',
                                'llg' => 'Lager-/Logistikgruppe',
                                'uus' => 'Löschzug Gefahrgut',
                                'szr' => 'Spezialrettung',
                                'lfr' => 'Luftrettung',
                                'kit' => 'Krisenintervention',
                                'seg' => 'Schnelleinsatzgruppe',
                            ];

                            foreach ($qualificationsfd as $keyfd => $qualificationfd) {
                                $hasQualification = in_array($keyfd, $fdqualis);
                                $badgeColor = $hasQualification ? 'bg-success' : 'bg-danger';

                                echo '<span class="badge ' . $badgeColor . '">' . $qualificationfd . '</span>&nbsp;';
                            }
                        } elseif ($canEdit) { ?>
                            <input type="hidden" name="new" value="4" />
                            <label><input type="checkbox" name="fachdienste[]" value="ils" <?php if (in_array('ils', $fdqualis)) echo 'checked'; ?>> Integrierte Leitstelle</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="el" <?php if (in_array('el', $fdqualis)) echo 'checked'; ?>> Einsatzleitung</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="elrd" <?php if (in_array('elrd', $fdqualis)) echo 'checked'; ?>> Einsatzleitung RettD</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="llg" <?php if (in_array('llg', $fdqualis)) echo 'checked'; ?>> Lager-/Logistikgruppe</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="uus" <?php if (in_array('uus', $fdqualis)) echo 'checked'; ?>> Löschzug Gefahrgut</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="szr" <?php if (in_array('szr', $fdqualis)) echo 'checked'; ?>> Spezialrettung</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="lfr" <?php if (in_array('lfr', $fdqualis)) echo 'checked'; ?>> Luftrettung</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="kit" <?php if (in_array('kit', $fdqualis)) echo 'checked'; ?>> Krisenintervention</label><br>
                            <label><input type="checkbox" name="fachdienste[]" value="seg" <?php if (in_array('seg', $fdqualis)) echo 'checked'; ?>> Schnelleinsatzgruppe</label>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <?php if ($canEdit) { ?>
                        <button type="button" class="btn btn-success" id="fdq-save" onclick="document.getElementById('fdqualiForm').submit()">Speichern</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL ENDE -->

<!-- MODAL -->
<div class="modal fade" id="modalNewComment" tabindex="-1" aria-labelledby="modalNewCommentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNewCommentLabel">Neue Notiz erstellen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newNoteForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="new" value="5" />
                        <select class="form-select mb-2" name="noteType" id="noteType">
                            <option value="0">Allgemein</option>
                            <option value="1">Positiv</option>
                            <option value="2">Negativ</option>
                        </select>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Notiztext" style="resize:none"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <?php if ($canView) { ?>
                        <button type="button" class="btn btn-success" id="fdq-save" onclick="document.getElementById('newNoteForm').submit()">Speichern</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL ENDE -->

<!-- MODAL -->
<?php if ($admincheck || $perdelete) { ?>
    <div class="modal fade" id="modalPersoDelete" tabindex="-1" aria-labelledby="modalPersoDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPersoDeleteLabel">Mitarbeiterakte löschen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newNoteForm" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <p>Die Mitarbeiterakte von <strong><?= $row['fullname'] ?></strong> wird mit der Bestätigung <strong>unwiderruflich gelöscht</strong>. Es ist nicht möglich diese im Nachhinein wiederherzustellen.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <a href="/admin/personal/delete.php?id=<?= $row['id'] ?>" type="button" class="btn btn-danger" id="complete-delete">Endgültig löschen</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<!-- MODAL ENDE -->

<!-- MODAL -->
<?php if ($admincheck || $perdoku) { ?>
    <div class="modal fade" id="modalDokuCreate" tabindex="-1" aria-labelledby="modalDokuCreateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDokuCreateLabel">Dokument anlegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newDocForm" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="new" value="6" />
                            <input type="hidden" name="erhalter" value="<?= $row['fullname'] ?>" />
                            <input type="hidden" name="erhalter_gebdat" value="<?= $row['gebdatum'] ?>" />
                            <input type="hidden" name="ausstellerid" value="<?= $userid ?>" />
                            <input type="hidden" name="aussteller_name" value="<?= $edituseric ?>" />
                            <input type="hidden" name="aussteller_rang" value="<?= $editdg ?>" />
                            <input type="hidden" name="profileid" value="<?= $openedID ?>" />
                            <label for="docType">Dokumenten-Typ</label>
                            <select class="form-select mb-2" name="docType" id="docType">
                                <option disabled hidden selected>Bitte wählen</option>
                                <option value="0">Ernennungsurkunde</option>
                                <option value="1">Beförderungsurkunde</option>
                                <option value="2">Entlassungsurkunde</option>
                                <option value="3">Ausbildungsvertrag</option>
                                <option value="5">Ausbildungszertifikat</option>
                                <option value="6">Lehrgangszertifikat</option>
                                <option value="7">Lehrgangszertifikat (Fachdienste)</option>
                                <option value="10">Schriftliche Abmahnung</option>
                                <option value="11">Vorläufige Dienstenthebung</option>
                                <option value="12">Dienstentfernung</option>
                                <option value="13">Außerordentliche Kündigung</option>
                            </select>
                            <hr>
                            <div id="form-0" style="display: none;">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <?php
                                $doptions = [
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
                                    16 => "Ehrenamtliche/-r"
                                ];
                                ?>
                                <label for="erhalter_rang">Neuer Dienstgrad</label>
                                <select class="form-select" name="erhalter_rang" id="erhalter_rang">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <?php foreach ($doptions as $dvalue => $dlabel) : ?>
                                        <option value="<?php echo $dvalue; ?>">
                                            <?php echo $dlabel; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ausstelungsdatum_0">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_0" id="ausstelungsdatum_0" class="form-control">
                            </div>
                            <div id="form-1" style="display: none;">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <label for="ausstelungsdatum_2">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_2" id="ausstelungsdatum_2" class="form-control">
                            </div>
                            <div id="form-2" style="display:none">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <?php
                                $rdoptions = [
                                    2 => 'Notfallsanitäter/-in',
                                    1 => 'Rettungssanitäter/-in',
                                ];
                                ?>
                                <label for="erhalter_rang_rd">Qualifikation</label>
                                <select class="form-select" name="erhalter_rang_rd" id="erhalter_rang_rd">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <?php foreach ($rdoptions as $rdvalue => $rdlabel) : ?>
                                        <option value="<?php echo $rdvalue; ?>">
                                            <?php echo $rdlabel; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ausstelungsdatum_5">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_5" id="ausstelungsdatum_5" class="form-control">
                            </div>
                            <div id="form-3" style="display:none">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <?php
                                $qoptions = [
                                    4 => 'Sonderfahrzeug-Maschinist/-in',
                                    2 => 'Zugführer/-in',
                                    1 => 'Gruppenführer/-in',
                                    0 => 'Brandmeister/-in',
                                ];
                                ?>
                                <label for="erhalter_quali">Qualifikation</label>
                                <select class="form-select" name="erhalter_quali" id="erhalter_quali">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <?php foreach ($qoptions as $qvalue => $qlabel) : ?>
                                        <option value="<?php echo $qvalue; ?>">
                                            <?php echo $qlabel; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ausstelungsdatum_6">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_6" id="ausstelungsdatum_6" class="form-control">
                            </div>
                            <div id="form-7" style="display:none">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <?php
                                $qoptions2 = [
                                    9 => 'Luftrettungspilot/-in',
                                    8 => 'HEMS-TC',
                                    3 => 'ILS Disponent/-in',
                                    5 => 'Helfergrundmodul (SEG)',
                                    6 => 'SEG-Sanitäter',
                                    7 => 'Gruppenführer-BevS',
                                ];
                                ?>
                                <label for="erhalter_quali">Qualifikation</label>
                                <select class="form-select" name="erhalter_quali" id="erhalter_quali">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <?php foreach ($qoptions2 as $qvalue2 => $qlabel2) : ?>
                                        <option value="<?php echo $qvalue2; ?>">
                                            <?php echo $qlabel2; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ausstelungsdatum_7">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_7" id="ausstelungsdatum_7" class="form-control">
                            </div>
                            <div id="form-4" style="display:none">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <label for="ausstelungsdatum_10">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_10" id="ausstelungsdatum_10" class="form-control">
                                <div id="form-5" style="display:none">
                                    <label for="suspendtime">Suspendiert bis <small>(leer lassen für unbestimmt)</small></label>
                                    <input type="date" name="suspendtime" id="suspendtime" class="form-control">
                                </div>
                                <label for="inhalt">Begründung</label>
                                <textarea name="inhalt" id="inhalt" style="resize:none"></textarea>
                            </div>
                            <div id="form-6" style="display:none">
                                <label for="anrede">Anrede</label>
                                <select class="form-select mb-2" name="anrede" id="anrede">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <option value="0">Frau</option>
                                    <option value="1">Herr</option>
                                </select>
                                <?php
                                $rdoptions2 = [
                                    2 => 'Notfallsanitäter/-in',
                                    1 => 'Rettungssanitäter/-in',
                                    0 => 'Rettungssanitäter/-in in Ausbildung',
                                ];
                                ?>
                                <label for="erhalter_rang_rd_2">Qualifikation</label>
                                <select class="form-select" name="erhalter_rang_rd_2" id="erhalter_rang_rd_2">
                                    <option disabled hidden selected>Bitte wählen</option>
                                    <?php foreach ($rdoptions2 as $rdvalue => $rdlabel) : ?>
                                        <option value="<?php echo $rdvalue; ?>">
                                            <?php echo $rdlabel; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="ausstelungsdatum_3">Ausstellungsdatum</label>
                                <input type="date" name="ausstelungsdatum_3" id="ausstelungsdatum_3" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-success" id="fdq-save" onclick="document.getElementById('newDocForm').submit()">Erstellen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const docTypeSelect = document.getElementById('docType');
        const form0 = document.getElementById('form-0');
        const form1 = document.getElementById('form-1');
        const form2 = document.getElementById('form-2');
        const form3 = document.getElementById('form-3');
        const form4 = document.getElementById('form-4');
        const form5 = document.getElementById('form-5');
        const form6 = document.getElementById('form-6');
        const form7 = document.getElementById('form-7');

        docTypeSelect.addEventListener('change', function() {
            const selectedValue = docTypeSelect.value;

            if (selectedValue === '0' ||
                selectedValue === '1') {
                form0.style.display = 'block';
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'none';
                form7.style.display = 'none';
            } else if (selectedValue === '2') {
                form0.style.display = 'none';
                form1.style.display = 'block';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'none';
                form7.style.display = 'none';
            } else if (selectedValue === '3') {
                form0.style.display = 'none';
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'block';
                form7.style.display = 'none';
            } else if (selectedValue === '5') {
                form0.style.display = 'none';
                form1.style.display = 'none';
                form2.style.display = 'block';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'none';
                form7.style.display = 'none';
            } else if (selectedValue === '6') {
                form0.style.display = 'none';
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'block';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'none';
                form7.style.display = 'none';
            } else if (selectedValue === '7') {
                form0.style.display = 'none';
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form6.style.display = 'none';
                form7.style.display = 'block';
            } else if (selectedValue === '10' || selectedValue === '11' || selectedValue === '12' || selectedValue === '13') {
                form0.style.display = 'none';
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'block';
                if (selectedValue === '11') {
                    form5.style.display = 'block';
                } else {
                    form5.style.display = 'none';
                }
                form6.style.display = 'none';
            }
        });
    </script>
    <script src="/assets/redactorx/redactorx.min.js"></script>
    <script>
        RedactorX('#inhalt', {
            editor: {
                minHeight: '200px'
            },
            format: ['p', 'ul', 'ol']
        });
    </script>
<?php } ?>
<!-- MODAL ENDE -->
<?php
session_start();

include '../assets/php/mysql-con.php';

if (isset($_POST['new']) && $_POST['new'] == 1) {
    // STAMMDATEN
    $patname = $_POST['patname'] ?? NULL;
    $patgebdat = $_POST['patgebdat'] ?? NULL;
    $patsex = $_POST['patsex'];
    $ezeit = $_POST['ezeit'];
    $enr = $_POST['enr'];
    // A - ATEMWEGE
    $awfrei_1 = $_POST['awfrei_1'] >= 1 ? $_POST['awfrei_1'] : 0;
    $awfrei_2 = $_POST['awfrei_2'] >= 1 ? $_POST['awfrei_2'] : 0;
    $awsicherung_1 = $_POST['awsicherung_1'] >= 1 ? $_POST['awsicherung_1'] : 0;
    $awsicherung_2 = $_POST['awsicherung_2'] >= 1 ? $_POST['awsicherung_2'] : 0;
    $zyanose_1 = $_POST['zyanose_1'] >= 1 ? $_POST['zyanose_1'] : 0;
    $zyanose_2 = $_POST['zyanose_2'] >= 1 ? $_POST['zyanose_2'] : 0;
    $o2gabe = $_POST['o2gabe'] >= 1 ? $_POST['o2gabe'] : 0;
    // B - ATMUNG
    $b_symptome = $_POST['b_symptome'];
    $b_auskult = $_POST['b_auskult'];
    $spo2 = $_POST['spo2'] ?? NULL;
    $atemfreq = $_POST['atemfreq'] ?? NULL;
    $etco2 = $_POST['etco2'] ?? NULL;
    // C - KREISLAUF
    $c_kreislauf = $_POST['c_kreislauf'];
    $rrsys = $_POST['rrsys'] ?? NULL;
    $rrdias = $_POST['rrdias'] ?? NULL;
    $herzfreq = $_POST['herzfreq'] ?? NULL;
    $c_ekg = $_POST['c_ekg'];
    // D - NEUROLOGIE
    $d_bewusstsein = $_POST['d_bewusstsein'];
    $d_pupillenw_1 = $_POST['d_pupillenw_1'];
    $d_pupillenw_2 = $_POST['d_pupillenw_2'];
    $d_lichtreakt_1 = $_POST['d_lichtreakt_1'];
    $d_lichtreakt_2 = $_POST['d_lichtreakt_2'];
    $d_gcs_1 = $_POST['d_gcs_1'];
    $d_gcs_2 = $_POST['d_gcs_2'];
    $d_gcs_3 = $_POST['d_gcs_3'];
    $d_ex_1 = $_POST['d_ex_1'];
    // BZ + TEMP
    $bz = $_POST['bz'] ?? NULL;
    $temp = $_POST['temp'] ?? NULL;
    // VERLETZUNGEN
    $v_muster_k = $_POST['v_muster_k'];
    $v_muster_k1 = $_POST['v_muster_k1'];
    $v_muster_t = $_POST['v_muster_t'];
    $v_muster_t1 = $_POST['v_muster_t1'];
    $v_muster_al = $_POST['v_muster_al'];
    $v_muster_al1 = $_POST['v_muster_al1'];
    $v_muster_a = $_POST['v_muster_a'];
    $v_muster_a1 = $_POST['v_muster_a1'];
    $v_muster_bl = $_POST['v_muster_bl'];
    $v_muster_bl1 = $_POST['v_muster_bl1'];
    $v_muster_w = $_POST['v_muster_w'];
    $v_muster_w1 = $_POST['v_muster_w1'];
    // MEDIKAMENTE
    $medis = $_POST['medis'] ?? NULL;
    // DIAGNOSE
    $diagnose = $_POST['diagnose'] ?? NULL;
    // ANMERKUNGEN
    $anmerkungen = $_POST['anmerkungen'] ?? NULL;
    // PROTOKOLLDATEN
    $notfallteam = $_POST['notfallteam'] >= 1 ? $_POST['notfallteam'] : 0;
    $transportverw = $_POST['transportverw'] >= 1 ? $_POST['transportverw'] : 0;
    $nacascore = $_POST['nacascore'] >= 1 ? $_POST['nacascore'] : 0;
    $pfname =  $_POST['pfname'];
    $naname =  $_POST['naname'] ?? NULL;
    $transportziel =  $_POST['transportziel2'] ?? NULL;
    // SQL-Query ausführen
    $query = "INSERT INTO cirs_rd_protokolle (patname, patgebdat, patsex, ezeit, enr, awfrei_1, awfrei_2, awsicherung_1, awsicherung_2, zyanose_1, zyanose_2, o2gabe, b_symptome, b_auskult, spo2, atemfreq, etco2, c_kreislauf, rrsys, rrdias, rrmad, herzfreq, c_ekg, d_bewusstsein, d_pupillenw_1, d_pupillenw_2, d_lichtreakt_1, d_lichtreakt_2, d_gcs_1, d_gcs_2, d_gcs_3, d_ex_1, d_ex_2, d_ex_3, d_ex_4, bz, temp, v_muster_k, v_muster_k1, v_muster_t, v_muster_t1, v_muster_al, v_muster_al1, v_muster_a, v_muster_a1, v_muster_bl, v_muster_bl1, v_muster_w, v_muster_w1, medis, diagnose, anmerkungen, notfallteam, transportverw, nacascore, pfname, naname, transportziel2)
    VALUES ('$patname', '$patgebdat', '$patsex', '$ezeit', '$enr', '$awfrei_1', '$awfrei_2', '$awsicherung_1', '$awsicherung_2', '$zyanose_1', '$zyanose_2', '$o2gabe', '$b_symptome',  '$b_auskult', '$spo2', '$atemfreq', '$etco2', '$c_kreislauf', '$rrsys', '$rrdias', '$rrmad', '$herzfreq', '$c_ekg', '$d_bewusstsein', '$d_pupillenw_1', '$d_pupillenw_2', '$d_lichtreakt_1', '$d_lichtreakt_2', '$d_gcs_1', '$d_gcs_2', '$d_gcs_3', '$d_ex_1', '$d_ex_2', '$d_ex_3', '$d_ex_4', '$bz', '$temp', '$v_muster_k', '$v_muster_k1', '$v_muster_t', '$v_muster_t1', '$v_muster_al', '$v_muster_al1', '$v_muster_a', '$v_muster_a1', '$v_muster_bl', '$v_muster_bl1', '$v_muster_w', '$v_muster_w1', '$medis', '$diagnose', '$anmerkungen', '$notfallteam', '$transportverw', '$nacascore', '$pfname', '$naname', '$transportziel')";
    mysqli_query($conn, $query);
    header("Refresh: 0");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>eDIVI &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/divi.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />

</head>

<body>
    <form name="form" method="post" action="">
        <input type="hidden" name="new" value="1" />
        <div class="container-fluid bg-light">
            <div class="row h-100">
                <div class="col">
                    <!-- ------------ -->
                    <!-- ! STAMMDATEN -->
                    <!-- ------------ -->
                    <div class="row diviRow1">
                        <div class="col border border-1 border-bottom-0 border-dark">
                            <h6 class="bg-dark text-light text-center p-1">Stammdaten</h6>
                            <div class="col">
                                <div class="row my-2">
                                    <div class="col-4 fw-bold fieldDescription">Name</div>
                                    <div class="col"><input type="text" name="patname" id="patname" class="w-100 form-control"></div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Geburtsdatum</div>
                                <div class="col"><input type="date" name="patgebdat" id="patgebdat" class="w-100 form-control"></div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Geschlecht</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><input class="form-check-input" type="radio" name="patsex" id="patsex" value="0"> männlich</div>
                                        <div class="col"><input class="form-check-input" type="radio" name="patsex" id="patsex" value="1"> weiblich</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Einsatzdatum u. -zeit</div>
                                <div class="col">
                                    <input type="date" name="edatum" id="edatum" class="w-100 form-control" required>
                                </div>
                                <div class="col">
                                    <input type="time" name="ezeit" id="ezeit" class="w-100 form-control" required>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Einsatznummer</div>
                                <div class="col">
                                    <input type="text" name="enr" id="enr" class="w-100 form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row diviRow2">
                        <div class="col border border-1 border-dark">
                            <!-- ------------ -->
                            <!-- A - ATEMWEGE -->
                            <!-- ------------ -->
                            <h6 class="bg-dark text-light text-center p-1">A - Atemwege <em>(Airway)</em></h6>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Atemwege frei</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="awfrei_1" name="awfrei_1" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="awfrei_1">Ja</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="awfrei_2" name="awfrei_2" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="awfrei_2">Nein</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Atemwegssicherung</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="awsicherung_1" name="awsicherung_1" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="awsicherung_1">Nein</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="awsicherung_2" name="awsicherung_2" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="awsicherung_2">Ja</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Zyanose</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="zyanose_1" name="zyanose_1" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="zyanose_1">Nein</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="zyanose_2" name="zyanose_2" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="zyanose_2">Ja</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">O2 Gabe</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="o2gabe" name="o2gabe" value="0" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-dark w-100" for="o2gabe" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <span id="o2gabe-value"></span> l/min
                                            </label>
                                        </div>
                                        <!-- MODAL -->
                                        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Wert eingeben</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="o2gabe-input" class="form-label">Liter pro Minute:</label>
                                                            <input type="number" class="form-control" id="o2gabe-input" name="o2gabe-input" min="0" max="15" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                        <button type="button" class="btn btn-primary" id="save-btn">Speichern</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL ENDE -->
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">A-Befund</div>
                                <div class="col">
                                    <textarea name="abefund" id="abefund" rows="2" class="form-control w-100" style="resize:none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  BEGIN OF SECOND COLUMN -->
                <div class="col">
                    <div class="row diviRow1">
                        <div class="col border border-1 border-start-0 border-bottom-0 border-dark">
                            <h6 class="bg-dark text-light text-center p-1">Einsatzdaten</h6>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="notfallteam" name="notfallteam" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-danger w-100" for="notfallteam">Übergabe Notfallteam</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" class="btn-check" id="transportverw" name="transportverw" value="1" autocomplete="off">
                                            <label class="btn btn-sm btn-outline-warning w-100" for="transportverw">Transportverweigerung</label>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-sm btn-info w-100" type="button" data-bs-toggle="modal" data-bs-target="#myModal3">Voranmeldung</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL -->
                            <div class="modal fade" id="myModal3" tabindex="-1" aria-labelledby="myModalLabel3" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel3">Voranmeldung Klinik</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mt-2 mb-1">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="10" name="nacascore" id="nacascore">
                                                        <label class="form-check-label" for="nacascore">
                                                            Schockraum
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="11" name="nacascore" id="nacascore">
                                                        <label class="form-check-label" for="nacascore">
                                                            ZNA
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="12" name="nacascore" id="nacascore">
                                                        <label class="form-check-label" for="nacascore">
                                                            Herzkatheter
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="13" name="nacascore" id="nacascore">
                                                        <label class="form-check-label" for="nacascore">
                                                            Stroke-Unit
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL ENDE -->
                            <div class="row mt-3">
                                <div class="col-3 fw-bold fieldDescription">Transportführer</div>
                                <div class="col"><input type="text" name="pfname" id="pfname" class="w-100 form-control" required></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3 fw-bold fieldDescription">Bet. RM</div>
                                <div class="col"><input type="text" name="naname" id="naname" class="w-100 form-control"></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3 fw-bold fieldDescription">Transportziel</div>
                                <div class="col">
                                    <select name="transportziel2" id="transportziel2" class="form-select w-100" required>
                                        <option value="0" selected>Kein Transport</option>
                                        <option value="1">Uniklinik SB</option>
                                        <option value="2">Städtisches Klinikum</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row diviRow2">
                        <div class="col border border-1 border-start-0 border-dark">
                            <!-- ------------ -->
                            <!-- B - ATMUNG -->
                            <!-- ------------ -->
                            <h6 class="bg-dark text-light text-center p-1">B - Atmung <em>(Breathing)</em></h6>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Atmung</div>
                                <div class="col">
                                    <select name="b_symptome" id="b_symptome" class="form-select w-100" required>
                                        <option disabled hidden selected>Symptomauswahl</option>
                                        <option value="0">unauffällig</option>
                                        <option value="1">Dyspnoe</option>
                                        <option value="2">Apnoe</option>
                                        <option value="3">Schnappatmung</option>
                                        <option value="4">Andere pathol.</option>
                                        <option value="99">nicht untersucht</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">Auskultation</div>
                                <div class="col">
                                    <select name="b_auskult" id="b_auskult" class="form-select w-100" required>
                                        <option disabled hidden selected>---</option>
                                        <option value="0">unauffällig</option>
                                        <option value="1">Spastik</option>
                                        <option value="2">Stridor</option>
                                        <option value="3">Rasselgeräusche</option>
                                        <option value="4">Andere pathol.</option>
                                        <option value="99">nicht untersucht</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">SpO2</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><input class="w-100 vitalparam form-control" type="text" name="spo2" id="spo2" style="display:inline"> <small>%</small></div>
                                    </div>
                                </div>
                                <div class="col-4 fw-bold fieldDescription">Atemfrequenz</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><input class="w-100 vitalparam form-control" type="text" name="atemfreq" id="atemfreq" style="display:inline"> <small>/min</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">etCO2</div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><input class="w-100 vitalparam form-control" type="text" name="etco2" id="etco2" style="display:inline"> <small>mmHg</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4 fw-bold fieldDescription">B-Befund</div>
                                <div class="col">
                                    <textarea name="bbefund" id="bbefund" rows="2" class="form-control w-100" style="resize:none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // eDIVI Buttons
        const o2gabe = document.getElementById("o2gabe");

        function checkCheckbox() {
            if (o2gabe.value > 0) {
                o2gabe.checked = true;
            } else {
                o2gabe.checked = false;
            }
        }

        o2gabe.addEventListener("click", checkCheckbox);
    </script>
    <script>
        // eDIVI Verletzungen
        const selectElements = document.querySelectorAll(".divi-v-select");

        selectElements.forEach((selectElement) => {
            selectElement.addEventListener("change", () => {
                if (selectElement.value === "0") {
                    selectElement.style.backgroundColor = "red";
                } else if (selectElement.value === "1") {
                    selectElement.style.backgroundColor = "yellow";
                } else if (selectElement.value === "2") {
                    selectElement.style.backgroundColor = "green";
                } else {
                    selectElement.style.backgroundColor = "";
                }
            });
        });
    </script>
    <script>
        // eDIVI Medikamente
        function addData() {
            const time = document.getElementById("time").value;
            const medicament = document.getElementById("medikament").value;
            const notarzt = document.getElementById("notarzt").checked;

            if (!time || !medicament) {
                alert("Bitte bei den Medikamenten alle Felder ausfüllen!");
                return;
            }

            let newData = `${time} - ${medicament} ${document.getElementById("applikation").value}`;

            if (notarzt) {
                newData += "(NA)";
            }

            const output = document.getElementById("medis");

            if (output.value) {
                output.value += "\n";
            }

            output.value += newData;
        }
    </script>
    <script>
        const input = document.getElementById('o2gabe-input');
        const value = document.getElementById('o2gabe-value');
        const saveBtn = document.getElementById('save-btn');
        const o2gabeCheckbox = document.getElementById('o2gabe');

        saveBtn.addEventListener('click', () => {
            if (input.value > 0) {
                value.innerText = input.value;
            }
            o2gabeCheckbox.value = input.value;
            o2gabeCheckbox.checked = input.value !== '0';
            $('#myModal').modal('hide');
        });

        $('#myModal').on('shown.bs.modal', function() {
            input.focus();
        });

        $('#myModal2').on('shown.bs.modal', function() {
            input.focus();
        });

        $('#myModal3').on('shown.bs.modal', function() {
            input.focus();
        });
    </script>
</body>

</html>
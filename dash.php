<?php
require $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Startseite &rsaquo; <?php echo SYSTEM_NAME ?></title>
  <!-- Stylesheets -->
  <link rel="stylesheet" href="/assets/css/style.min.css" />
  <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="/assets/favicon/site.webmanifest" />
  <!-- Metas -->
  <meta name="theme-color" content="<?php echo SYSTEM_COLOR ?>" />
  <meta property="og:site_name" content="<?php echo SERVER_NAME ?>" />
  <meta property="og:url" content="https://<?php echo SYSTEM_URL ?>/dash.php" />
  <meta property="og:title" content="<?php echo SYSTEM_NAME ?> - Intranet <?php echo SERVER_CITY ?>" />
  <meta property="og:image" content="<?php echo META_IMAGE_URL ?>" />
  <meta property="og:description" content="Verwaltungsportal der <?php echo RP_ORGTYPE . " " .  SERVER_CITY ?>" />
</head>

<body id="dashboard">
  <div class="container-full mx-5">
    <div class="row mt-3">
      <div class="col-4 mx-auto">
        <div class="glass">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="417.75"
            height="78.9" viewBox="0 0 2785 526">
            <image id="Ebene_1" data-name="Ebene 1" y="14" width="2704" height="434"
              xlink:href="data:img/png;base64,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" />
          </svg>

        </div>
      </div>
    </div>
    <div class="row">
      <!-- BF -->
      <div class="col" id="cards">
        <h2 class="text-light">Berufsfeuerwehr <?php echo SERVER_CITY ?></h2>
        <div class="row my-3">
          <!-- <div class="col">
            <a href="/cirs/new.php">
              <div class="card">
                <div class="card-body">
                  <div class="card-fa mb-3 text-center d-block">
                    <i class="fa-solid fa-circle-exclamation"></i>
                  </div>
                  <h5 class="card-title text-center fw-bold">CIRS Meldung</h5>
                </div>
              </div>
            </a>
          </div> -->
          <div class="col">
            <a href="/antraege/befoerderung.php">
              <div class="card">
                <div class="card-body">
                  <div class="card-fa mb-3 text-center d-block">
                    <i class="fa-solid fa-paper-plane"></i>
                  </div>
                  <h5 class="card-title text-center fw-bold">
                    Beförderungsantrag
                  </h5>
                </div>
              </div>
            </a>
          </div>
          <div class="col">
            <a href="/edivi/protokoll.php">
              <div class="card">
                <div class="card-body">
                  <div class="card-fa mb-3 text-center d-block">
                    <i class="fa-solid fa-truck-medical"></i>
                  </div>
                  <h5 class="card-title text-center fw-bold">
                    eDIVI Protokoll
                  </h5>
                </div>
              </div>
            </a>
          </div>

          <h2 class="text-light">Quick Links</h2>
          <div class="row my-3">
            <div class="col">
              <a href="https://<?php echo SYSTEM_URL ?>/assets/upload/RD_SB_Kompetenzmatrix_08.2023.pdf">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="fa-solid fa-syringe"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">
                      Kompetenzmatrix RD
                    </h5>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="https://<?php echo SYSTEM_URL ?>/assets/upload/png2pdf.pdf">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="fa-solid fa-square-parking"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">Parkordnung</h5>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="https://<?php echo SYSTEM_URL ?>/assets/upload/RD_SB_Beladelisten_06.2023.pdf">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="fa-solid fa-box"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">
                      Beladelisten RD
                    </h5>
                  </div>
                </div>
              </a>
            </div>
            <!-- <div class="col-4 mt-3">
            <a href="https://<?php echo SYSTEM_URL ?>/schnittstelle/anmeldung">
              <div class="card">
                <div class="card-body">
                  <div class="card-fa mb-3 text-center d-block">
                    <i class="fa-solid fa-bed-pulse"></i>
                  </div>
                  <h5 class="card-title text-center fw-bold">
                    Patienten Anmeldung KH
                  </h5>
                </div>
              </div>
            </a>
          </div> -->
            <!-- <div class="col-4 mt-3">
            <a href="https://<?php echo SYSTEM_URL ?>/schnittstelle/klinikmonitor">
              <div class="card">
                <div class="card-body">
                  <div class="card-fa mb-3 text-center d-block">
                    <i class="fa-sharp fa-solid fa-circle-h"></i>
                  </div>
                  <h5 class="card-title text-center fw-bold">
                    Kapazitätsübersicht KH
                  </h5>
                </div>
              </div>
            </a>
          </div> -->
          </div>
        </div>
      </div>
      <footer>
        <div class="row mx-5 pt-2">
          <div class="col text-light">
            Made by Hypax
          </div>
        </div>
      </footer>
    </div>
</body>

</html>
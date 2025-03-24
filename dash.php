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
  <link rel="stylesheet" href="/assets/_ext/lineawesome/css/line-awesome.min.css" />
  <link rel="stylesheet" href="/assets/fonts/mavenpro/css/all.min.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
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
      <div class="col-4 mx-auto text-center">
        <img src="<?php echo SYSTEM_LOGO ?>" alt="<?php echo SYSTEM_NAME ?>" style="height:128px;width:auto">
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
                    <i class="las la-exclamation-circle"></i>
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
                    <i class="las la-paper-plane" style="transform:rotate(-45deg);"></i>
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
                    <i class="las la-ambulance"></i>
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
            <!-- <div class="col">
              <a href="#">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="las la-syringe"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">
                      Kompetenzmatrix RD
                    </h5>
                  </div>
                </div>
              </a>
            </div> -->
            <!-- <div class="col">
              <a href="#">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="las la-parking"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">Parkordnung</h5>
                  </div>
                </div>
              </a>
            </div> -->
            <!-- <div class="col">
              <a href="#">
                <div class="card">
                  <div class="card-body">
                    <div class="card-fa mb-3 text-center d-block">
                      <i class="las la-box"></i>
                    </div>
                    <h5 class="card-title text-center fw-bold">
                      Beladelisten RD
                    </h5>
                  </div>
                </div>
              </a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="footerCopyright">
        <a href="https://hypax.wtf" target="_blank"><i class="las la-code"></i> hypax</a>
        <span>© 2023-<?php echo date("Y"); ?> intraRP | Version <?php echo SYSTEM_VERSION ?></span>
      </div>
    </footer>
</body>

</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>eDIVI &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/jquery/jquery-3.7.0.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/favicon/site.webmanifest" />

</head>

<body id="dashboard" class="d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col">
            <div class="card px-4 py-3">
                <form method="post">
                    <strong>Einsatznummer:</strong><br>
                    <input class="form-control" type="text" size="40" maxlength="250" id="enrInput" oninput="validateInput(this)"><br><br>
                </form>

                <button class="btn btn-primary p-3" onclick="openOrCreate()">
                    <i class="fa-solid fa-2xl fa-eye mb-3"></i><br> Protokoll öffnen
                </button>
            </div>
        </div>
    </div>
    <footer>
        <div class="footerCopyright">
            <a href="https://hypax.wtf" target="_blank"><i class="fa-solid fa-code"></i> hypax</a>
            <span>© 2023 | v0.1 WIP</span>
        </div>
        <div class="footerLegal">
            <span>
                <a href="#">
                    Impressum
                </a>
            </span>
            <span>
                <a href="#">
                    Datenschutzerklärung
                </a>
            </span>
        </div>
    </footer>
    <script>
        function openOrCreate() {
            const enrInput = document.getElementById("enrInput");
            const inputValue = enrInput.value;

            if (inputValue.trim() === "") {
                alert("Bitte gib eine gültige Einsatznummer an.");
                return;
            }

            // Send an AJAX request to the server to handle the open/create logic
            $.ajax({
                type: "POST",
                url: "/assets/functions/f_enrprocess.php",
                data: {
                    action: "openOrCreate",
                    enr: inputValue
                },
                success: function(redirectUrl) {
                    // Redirect to the specified URL
                    window.location.href = redirectUrl;
                },
            });
        }
    </script>
    <script>
        function isNumber(event) {
            // Check if the pressed key is a number (0-9) or a valid numeric character.
            const key = event.key;
            return /^[0-9_]+$/.test(key);
        }

        function validateInput(inputField) {
            // Remove any non-numeric characters from the input value.
            inputField.value = inputField.value.replace(/[^0-9_]/g, '');
        }
    </script>

</body>

</html>
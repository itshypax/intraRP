<?php
session_start();

// Check if the request is coming from Discord's server
$isDiscordPreview = false;
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, 'Discordbot') !== false) {
        $isDiscordPreview = true;
    }
}

if (!isset($_GET['code'])) {
    header("Location: /frsrd/error.php");
    exit();
} else if (!$isDiscordPreview && $notadmincheck && !$frsrd) {
    header("Location: /admin/users/list.php?message=error-2");
}

include '../assets/php/mysql-con.php';

$testid = $_REQUEST['code'];

// Select from database 'ws_ids' where 'hash' = $testid and 'used' is 0
$sql = "SELECT * FROM cirs_frs_exams WHERE hash = '$testid' AND used = 0";
// Get the number of results and store it in $result
$result = mysqli_num_rows(mysqli_query($conn, $sql));
$resultdata = mysqli_fetch_array(mysqli_query($conn, $sql));

if ($result != 1) {
    // If the number of results is not 1, redirect to error.php
    header("Location: error.php");
    exit();
} else {
    // If the number of results is 1 and request is not from Discord, continue
    if (!$isDiscordPreview) {
        $sql2 = "UPDATE cirs_frs_exams SET used = 1 WHERE hash = '$testid'";
        mysqli_query($conn, $sql2);
    }
}

?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test &rsaquo; intraRP</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.min.css" />
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

<body>
    <div style="height:199vh;width:100vw;">
        <?php if ($resultdata['test'] == 1) { ?>
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeEIfDbJCU1-W9K1Y2rzNaBWDMvK7RG9IWDm8LIPU6dxGCRlg/viewform?embedded=true" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0">Wird geladen…</iframe>
        <?php } else if ($resultdata['test'] == 2) { ?>
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfNakA_KY3QJxGgH2rpVtqCK8a4Kwr2WDXkTyxvFH-cQxaUCA/viewform?embedded=true" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0">Wird geladen…</iframe>
        <?php } ?>
    </div>
</body>

</html>
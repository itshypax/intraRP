<?php
// Verbindungsdaten
$db_host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/config/database.php';

use App\Helpers\DocRedirector;

$docId = isset($_GET['docid']) ? (int) $_GET['docid'] : null;

if (!$docId) {
    http_response_code(400);
    exit('Fehlende Dokument-ID.');
}

$redirector = new DocRedirector($pdo);
$redirector->redirect($docId);

<?php

namespace App\Helpers;

use PDO;
use PDOException;

class DocRedirector
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function redirect(int $docId): void
    {
        try {
            $stmt = $this->pdo->prepare("SELECT type FROM intra_mitarbeiter_dokumente WHERE docid = :docid");
            $stmt->execute(['docid' => $docId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                http_response_code(404);
                exit('Dokument nicht gefunden.');
            }

            $docType = (int) $row['type'];
            $routes = [
                10 => "/dokumente/schreiben/abmahnung/",
                11 => "/dokumente/schreiben/dienstenthebung/",
                12 => "/dokumente/schreiben/dienstentfernung/",
                13 => "/dokumente/schreiben/kuendigung/",
                0 => "/dokumente/urkunden/ernennung/",
                1 => "/dokumente/urkunden/befoerderung/",
                2 => "/dokumente/urkunden/entlassung/",
                5 => "/dokumente/zertifikate/ausbildung/",
                6 => "/dokumente/zertifikate/lehrgang/",
                7 => "/dokumente/zertifikate/fachlehrgang/",
            ];

            if (isset($routes[$docType])) {
                header("Location: " . $routes[$docType] . $docId);
                exit;
            }

            http_response_code(400);
            exit('Ungültiger Dokumenttyp.');
        } catch (PDOException $e) {
            http_response_code(500);
            exit('Datenbankfehler: ' . htmlspecialchars($e->getMessage()));
        }
    }
}

# Roleplay Intranet für fiktive Berufsfeuerwehren

MYSQL-Datei wurde **nicht** gesynct.
Diese unter `/assets/php/` mit dem Namen `mysql-con.php` erstellen.

## Beispiel-Inhalt für die Datei

```php
<?php

// Verbindungsdaten
$db_host = ""; // IP/Host
$db_user = ""; // Benutzername für MYSQL
$db_pass = ""; // Passwort für MYSQL-Benutzer
$db_name = ""; // Name der Datenbank
$dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Verbindung aufbauen
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$pdo = new PDO($dsn, $db_user, $db_pass, $options);

// Verbindung prüfen
if (!$conn) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}
```

Hiernach müsste eine passende DB erstellt werden. Die zugehörige Struktur ist als Datei beigefügt.
Der erste (initiale) Benutzer muss in der DB (Tabelle `cirs_users`) angelegt werden. Das Passwort wird **nicht** als Klartext gespeichert. Um ein gehashtes Passwort zu generieren habe ich den Generator von [Bcrypt](https://bcrypt.online/) verwendet. Außerdem benötigt der Benutzer die Berechtigung (in der Zeile `permissions`) `["full_admin"]` - sonst besteht kein ausreichender Zugriff auf das System.

Außerdem sollte für den Login-Cookie in der `login.php` unter `/admin/login.php` die `ini_set('session.cookie_domain', '.muster.de');` angepasst bzw. die Domain ausgetauscht werden.

### Disclaimer: Es handelte sich hierbei um ein **Hobbyprojekt**! Es ist dementsprechend eine Lernerfahrung mit stetigen Anpassungen gewesen. Das System ist sicherlich keinesfalls fehlerfrei oder sicher vor Angriffen.

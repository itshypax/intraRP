![intraRP Logo](/assets/img/defaultLogo.png)

# intraRP - Roleplay Intranet für fiktive Fraktionen
Das Ziel von **intraRP** ist es eine Allround-Lösung für die Fraktionsverwaltung fiktiver Feuerwehren & Rettungsdienste vor allem für FiveM und andere ähnliche Settings anzubieten. Das System ist grundsätzlich zur Verwaltung eines deutschen Systems ausgelegt, kann aber mit eigenen Veränderungen durchaus auch an ein amerikanisches oder anderes Setting angepasst werden.

### **Der Vorteil - immer kostenlos & immer Open Source!**
Das Projekt wird hobbymäßig weiterentwickelt und ist für jegliche Unterstützung, Anpassungen, Wünsche & Ideen offen. Einen Vorteil kann man jedoch dauerhaft genießen: Das Projekt ist vollkommen Open Source und kann von jedem angewandt, umgesetzt und verändert/angepasst werden.

### Wiki & Informationen
- [Setup ‐ intraRP aufsetzen & einrichten](https://github.com/itshypax/intraRP/wiki/Setup-%E2%80%90-intraRP-aufsetzen-&-einrichten)
   - [Was wird benötigt?](https://github.com/itshypax/intraRP/wiki/Setup-%E2%80%90-intraRP-aufsetzen-&-einrichten#was-wird-ben%C3%B6tigt)
   - [intraRP aufsetzen](https://github.com/itshypax/intraRP/wiki/Setup-%E2%80%90-intraRP-aufsetzen-&-einrichten#intrarp-aufsetzen)
   - [Weitere Fragen?](https://github.com/itshypax/intraRP/wiki/Setup-%E2%80%90-intraRP-aufsetzen-&-einrichten#weitere-fragen)
- [Übersicht aller Berechtigungen](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen)
   - [Administration](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#administration)
   - [Antragsverwaltung](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#antragsverwaltung)
   - [Protokollverwaltung (eDIVI)](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#protokollverwaltung-edivi)
   - [Benutzerverwaltung (für Intranet-Benutzer)](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#benutzerverwaltung-f%C3%BCr-intranet-benutzer)
   - [Mitarbeiterverwaltung (für Mitarbeiter-Akten)](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#mitarbeiterverwaltung-f%C3%BCr-mitarbeiter-akten)
   - [Datei-Upload](https://github.com/itshypax/intraRP/wiki/%C3%9Cbersicht-aller-Berechtigungen#datei-upload)

> [!CAUTION]
> Es handelte sich hierbei um ein **Hobbyprojekt**! Es ist dementsprechend eine Lernerfahrung mit stetigen Anpassungen gewesen. Das System ist sicherlich keinesfalls fehlerfrei oder sicher vor Angriffen.

#### --- OLD ---

Hiernach müsste eine passende DB erstellt werden. Die zugehörige Struktur ist als Datei beigefügt.
Der erste (initiale) Benutzer muss in der DB (Tabelle `cirs_users`) angelegt werden. Das Passwort wird **nicht** als Klartext gespeichert. Um ein gehashtes Passwort zu generieren habe ich den Generator von [Bcrypt](https://bcrypt.online/) verwendet. Außerdem benötigt der Benutzer die Berechtigung (in der Zeile `permissions`) `["full_admin"]` - sonst besteht kein ausreichender Zugriff auf das System.

[Favicon generator](https://realfavicongenerator.net/)

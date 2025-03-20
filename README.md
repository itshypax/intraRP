![intraRP Logo](/assets/img/defaultLogo.png)

# intraRP - Roleplay Intranet für fiktive Fraktionen

Das Ziel von **intraRP** ist es eine Allround-Lösung für die Fraktionsverwaltung fiktiver Feuerwehren & Rettungsdienste vor allem für FiveM und andere ähnliche Settings anzubieten. Das System ist grundsätzlich zur Verwaltung eines deutschen Systems ausgelegt, kann aber mit eigenen Veränderungen durchaus auch an ein amerikanisches oder anderes Setting angepasst werden.

### **Der Vorteil - immer kostenlos & immer Open Source!**

Das Projekt wird hobbymäßig weiterentwickelt und ist für jegliche Unterstützung, Anpassungen, Wünsche & Ideen offen. Einen Vorteil kann man jedoch dauerhaft genießen: Das Projekt ist vollkommen Open Source und kann von jedem angewandt, umgesetzt und verändert/angepasst werden.

> [!CAUTION]
> Disclaimer: Es handelte sich hierbei um ein **Hobbyprojekt**! Es ist dementsprechend eine Lernerfahrung mit stetigen Anpassungen gewesen. Das System ist sicherlich keinesfalls fehlerfrei oder sicher vor Angriffen.

#### --- OLD ---

Hiernach müsste eine passende DB erstellt werden. Die zugehörige Struktur ist als Datei beigefügt.
Der erste (initiale) Benutzer muss in der DB (Tabelle `cirs_users`) angelegt werden. Das Passwort wird **nicht** als Klartext gespeichert. Um ein gehashtes Passwort zu generieren habe ich den Generator von [Bcrypt](https://bcrypt.online/) verwendet. Außerdem benötigt der Benutzer die Berechtigung (in der Zeile `permissions`) `["full_admin"]` - sonst besteht kein ausreichender Zugriff auf das System.

[Favicon generator](https://realfavicongenerator.net/)

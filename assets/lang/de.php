<?php
// /assets/lang/de.php

return [
    'title' => 'Administration &rsaquo; %s',
    'metas' => [
        'title' => '%s - Intranet %s',
        'description' => 'Verwaltungsportal der %s %s',
    ],
    'dashboard' => [
        'dashboard' => 'Dashboard',
        'welcome' => 'Hallo, %s!',
        'quotes' => [
            'quote-1' => 'Willkommen im Intranet der %s %s.',
            'quote-2' => 'Fun Fact: Die ersten Rettungswagen waren Leichenwagen. Manchmal kamen Bestatter an und mussten feststellen, dass die Person noch gar nicht gestorben war..',
            'quote-3' => 'Das Schweizer Taschenmesser der %ser %s.',
            'quote-4' => 'Die %s %s - Immer für Sie da.',
            'quote-5' => '%s powered by intraRP.',
        ],
        'charts' => [
            'application' => [
                'title' => 'Beförderungsanträge',
                'status' => [
                    0 => 'in Bearbeitung',
                    1 => 'Abgelehnt',
                    2 => 'Aufgeschoben',
                    3 => 'Angenommen',
                ],
            ],
            'edivi' => [
                'title' => 'eDIVI-Protokolle',
                'status' => [
                    0 => 'Ungesehen',
                    1 => 'in Prüfung',
                    2 => 'Freigegeben',
                    3 => 'Ungenügend',
                ],
            ],
            'unknown' => 'Unbekannt',
        ],
    ],
    'login' => [
        'page_title' => 'Login &rsaquo; %s',
        'error' => 'Benutzername oder Passwort ungültig.<br>',
        'form' => [
            'subtext' => 'Das Intranet der Stadt %s!',
            'no_user_found' => 'Kein Benutzer gefunden. Du erstellst jetzt den ersten Administrator-Account.',
            'username' => 'Benutzername:',
            'password' => 'Passwort:',
            'password_confirm' => 'Passwort wiederholen:',
            'fullname' => 'Vor- und Zuname (RP):',
            'create' => 'Erstellen',
            'login' => 'Anmelden',
        ],
    ],
    'users' => [
        'list' => [
            'title' => 'Benutzerübersicht',
            'table' => [
                'id' => 'ID',
                'name' => 'Name (Benutzername)',
                'role' => 'Rolle',
                'created_at' => 'Erstellt',
                'manage' => 'Bearbeiten',
                'profile' => 'Profil',
            ],
            'datatable' => [
                'infofiltered' => '| Gefiltert von _MAX_ Benutzern',
                'lengthmenu' => '_MENU_ Benutzer pro Seite anzeigen',
                'search' => 'Benutzer suchen:',
            ]
        ],
    ],
    'datatable' => [
        'emptytable' => 'Keine Daten vorhanden',
        'info' => 'Zeige _START_ bis _END_  | Gesamt: _TOTAL_',
        'infoempty' => 'Keine Daten verfügbar',
        'loadingrecords' => 'Lade...',
        'processing' => 'Verarbeite...',
        'zerorecords' => 'Keine Einträge gefunden',
        'paginate' => [
            'first' => 'Erste',
            'last' => 'Letzte',
            'next' => 'Nächste',
            'previous' => 'Vorherige',
        ],
        'aria' => [
            'sortascending' => ': aktivieren, um Spalte aufsteigend zu sortieren',
            'sortdescending' => ': aktivieren, um Spalte absteigend zu sortieren',
        ],
    ],
    'edit_profile' => [
        'page_title' => 'Profil bearbeiten &rsaquo; Administration &rsaquo; %s',
        'edit_self' => 'Eigene Daten bearbeiten',
        'fullname' => 'Vor- und Zuname',
        'files_id' => 'Mitarbeiterakten-ID',
        'new_pass' => 'Neues Passwort',
        'new_pass_placeholder' => 'Leer lassen um nichts zu ändern',
        'new_pass_confirm' => 'Passwort wiederholen',
        'submit' => 'Änderungen speichern',
    ],
    'auditlog' => [
        'pw_changed' => 'Passwort & Daten geändert [ID: %d]',
        'data_changed' => 'Daten geändert [ID: %d]',
        'self' => 'Selbst',
    ],
];

<div class="col-2 border-2 border-top border-sh-semigray bg-sh-gray" id="admin-links">
    <hr class="text-sh-gray my-3">
    <div class="admin-nav">
        <h6>Administration</h6>
        <div class="accordion" id="admin-accordion">
            <div class="accordion-item">
                <a href="/admin/index.php">
                    <h2 class="accordion-header" id="accordionh-dashboard">
                        <button class="accordion-button collapsed" type="button">
                            <i class="fa-solid fa-house fa-xl" style="margin-right:15px"></i> Dashboard
                    </h2>
                </a>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="accordionh-cirs">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-cirs" aria-expanded="false" aria-controls="accordion-cirs">
                        <i class="fa-solid fa-brake-warning fa-xl" style="margin-right:15px"></i> CIRS
                    </button>
                </h2>
                <div id="accordion-cirs" class="accordion-collapse collapse" aria-labelledby="accordionh-cirs">
                    <div class="accordion-body">
                        <div class="admin-link mb-2">
                            <a href="/cirs/index.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Übersicht</i></a>
                        </div>
                        <?php if (in_array('cirs_team', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                            <div class="admin-link mb-2">
                                <a href="/admin/cirs/list.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Fall-Liste (Gesamt)</i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (in_array('antraege_view', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionh-antrag">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-antrag" aria-expanded="false" aria-controls="accordion-antrag">
                            <i class="fa-solid fa-code-pull-request fa-xl" style="margin-right:15px"></i> Antragsverwaltung
                        </button>
                    </h2>
                    <div id="accordion-antrag" class="accordion-collapse collapse" aria-labelledby="accordionh-antrag">
                        <div class="accordion-body">
                            <div class="admin-link mb-2">
                                <a href="/admin/antraege/list.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Beförderungsanträge</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array('users_view', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionh-users">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-users" aria-expanded="false" aria-controls="accordion-users">
                            <i class="fa-solid fa-user-secret fa-xl" style="margin-right:15px"></i> Benutzerverwaltung
                        </button>
                    </h2>
                    <div id="accordion-users" class="accordion-collapse collapse" aria-labelledby="accordionh-users">
                        <div class="accordion-body">
                            <div class="admin-link mb-2">
                                <a href="/admin/users/list.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Übersicht</i></a>
                            </div>
                            <?php if (in_array('users_create', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                                <div class="admin-link mb-2">
                                    <a href="/admin/users/create.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Erstellen</i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array('personal_view', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionh-personal">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-personal" aria-expanded="false" aria-controls="accordion-users">
                            <i class="fa-solid fa-suitcase fa-xl" style="margin-right:15px"></i> Mitarbeiterverwaltung
                        </button>
                    </h2>
                    <div id="accordion-personal" class="accordion-collapse collapse" aria-labelledby="accordionh-personal">
                        <div class="accordion-body">
                            <div class="admin-link mb-2">
                                <a href="/admin/personal/list.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Übersicht</i></a>
                            </div>
                            <?php if (in_array('personal_edit', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                                <div class="admin-link mb-2">
                                    <a href="/admin/personal/create.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Erstellen</i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="accordionh-edivi" data-bs-toggle="collapse" data-bs-target="#accordion-edivi" aria-expanded="false" aria-controls="accordion-edivi">
                    <button class="accordion-button collapsed" type="button">
                        <i class="fa-solid fa-newspaper fa-xl" style="margin-right:15px"></i> eDIVI
                </h2>
                <div id="accordion-edivi" class="accordion-collapse collapse" aria-labelledby="accordionh-edivi">
                    <div class="accordion-body">
                        <div class="admin-link mb-2">
                            <a href="/edivi/protokoll.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Protokoll anlegen</i></a>
                        </div>
                        <?php if (in_array('edivi_view', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                            <div class="admin-link mb-2">
                                <a href="/admin/edivi/list.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Übersicht</i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (in_array('files_upload', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionh-upload" data-bs-toggle="collapse" data-bs-target="#accordion-upload" aria-expanded="false" aria-controls="accordion-upload">
                        <button class="accordion-button collapsed" type="button">
                            <i class="fa-solid fa-upload fa-xl" style="margin-right:15px"></i> Upload
                    </h2>
                    <div id="accordion-upload" class="accordion-collapse collapse" aria-labelledby="accordionh-upload">
                        <div class="accordion-body">
                            <div class="admin-link mb-2">
                                <a href="/admin/upload/index.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Datei hochladen</i></a>
                            </div>
                            <?php if (in_array('files_log', $_SESSION['permissions']) || in_array('full_admin', $_SESSION['permissions']) || in_array('admin', $_SESSION['permissions'])) { ?>
                                <div class="admin-link mb-2">
                                    <a href="/admin/upload/overview.php" class="text-decoration-none"><i class="fa-solid fa-dash"></i> Upload-Log</i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="accordion-item">
                <a href="/admin/logout.php">
                    <h2 class="accordion-header" id="accordionh-logout">
                        <button class="accordion-button collapsed" type="button">
                            <i class="fa-solid fa-right-from-bracket fa-xl" style="margin-right:15px"></i> Abmelden
                    </h2>
                </a>
            </div>
        </div>
    </div>
</div>
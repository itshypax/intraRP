    <div class="container" id="adminnav-new">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav mx-auto">
                        <a class="nav-link" href="/admin/index.php" data-page="dashboard" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dashboard"><i class="fa-solid fa-house"></i></a>
                        <?php if ($anview || $admincheck) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-page="antrag" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-code-pull-request" style="margin-right:8px"></i> Antragsverwaltung
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/antraege/list.php">Beförderungsanträge</a></li>
                                </ul>
                            </li>
                        <?php }
                        if ($usview || $admincheck) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-page="benutzer" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user-secret" style="margin-right:8px"></i> Benutzerverwaltung
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/users/list.php">Übersicht</a></li>
                                    <?php if ($uscreate || $admincheck) { ?>
                                        <li><a class="dropdown-item" href="/admin/users/create.php">Erstellen</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                        if ($perview || $admincheck) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-page="mitarbeiter" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-suitcase" style="margin-right:8px"></i> Mitarbeiterverwaltung
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/personal/list.php">Übersicht</a></li>
                                    <?php if ($peredit || $admincheck) { ?>
                                        <li><a class="dropdown-item" href="/admin/personal/create.php">Erstellen</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-page="edivi" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-newspaper" style="margin-right:8px"></i> eDIVI
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/edivi/protokoll.php">Protokoll anlegen</a></li>
                                <?php if ($edview || $admincheck) { ?>
                                    <li><a class="dropdown-item" href="/admin/edivi/list.php">Prüf-/Arbeitsliste</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if ($filupload || $admincheck) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-page="upload" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-upload" style="margin-right:8px"></i> Datei-Upload
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/upload/index.php">Datei hochladen</a></li>
                                    <?php if ($fillog || $admincheck) { ?>
                                        <li><a class="dropdown-item" href="/admin/upload/overview.php">Upload-Protokoll</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <a class="nav-link" href="/admin/logout.php" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Abmelden"><i class="fa-solid fa-right-from-bracket"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <script>
        $(document).ready(function() {
            var currentPage = $("body").data("page");

            // Remove active class from all nav-links
            $(".nav-link").removeClass("active");

            // Add active class to the appropriate nav-link
            $(".nav-link[data-page='" + currentPage + "']").addClass("active");
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
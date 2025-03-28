<nav class="navbar navbar-expand-lg" id="intra-nav">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="<?php echo SYSTEM_LOGO ?>" alt="<?php echo SYSTEM_NAME ?>" style="height:36px;width:auto"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <a class="nav-link" href="/admin/index.php" data-page="dashboard"><i class="las la-home" style="margin-right:3px"></i> Dashboard</a>
                <!-- Beförderungsanträge -->
                <?php if ($anview || $admincheck) { ?>
                    <li class="nav-item"><a href="/admin/antraege/list.php" class="nav-link" data-page="antrag"><i class="las la-code-branch" style="margin-right:3px"></i> Anträge</a></li>
                <?php }
                if ($usview || $admincheck) { ?>
                    <!-- Benutzerverwaltung -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-page="benutzer" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="las la-user-secret" style="margin-right:3px"></i> Benutzer
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
                            <i class="las la-suitcase" style="margin-right:3px"></i> Personal
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
                        <i class="las la-newspaper" style="margin-right:3px"></i> RD Protokolle
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/edivi/protokoll.php" target="_blank">Neues Protokoll</a></li>
                        <?php if ($edview || $admincheck) { ?>
                            <li><a class="dropdown-item" href="/admin/edivi/list.php">Qualitätsmanagement</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if ($filupload || $admincheck) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-page="upload" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="las la-upload" style="margin-right:3px"></i> Dateien
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/admin/upload/index.php">Datei hochladen</a></li>
                            <?php if ($fillog || $admincheck) { ?>
                                <li><a class="dropdown-item" href="/admin/upload/overview.php">Verlauf</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown" id="intra-usermenu">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['cirs_username'] ?> <span class="badge bg-<?= $_SESSION['role_color'] ?>"><?= $_SESSION['role_name'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/users/editprofile.php">Profil bearbeiten</a></li>
                        <li><a class="dropdown-item" href="/admin/logout.php">Abmelden</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
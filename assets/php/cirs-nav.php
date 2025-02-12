<div class="cirs-nav">
    <h6>Neue Meldung</h6>
    <div class="cirs-link">
        <a href="/cirs/new.php" class="text-decoration-none">Neue Meldung eingeben <i class="fa-light fa-square-plus"></i></i></a>
    </div>
    <hr class="my-3">
    <h6>Übersicht</h6>
    <div class="cirs-link mb-2">
        <a href="/cirs/archive.php" class="text-decoration-none">Fall-Liste (Archiv)</i></a>
    </div>
    <?php
    if (isset($_SESSION['userid']) && isset($_SESSION['permissions'])) {
        if ($notadmincheck && !$cteam) {
    ?>
            <div class="cirs-login">
                <a href="#" class="text-decoration-none">Impressum</a>
                <a href="#" class="text-decoration-none">Datenschutz</a>
            </div>
        <?php } else { ?>
            <hr class="my-3">
            <h6>CIRS-Team</h6>
            <div class="cirs-link mb-2">
                <a href="/admin/cirs/list.php" class="text-decoration-none">Fall-Liste (Gesamt)</i></a>
            </div>
            <div class="cirs-link mb-2">
                <a href="/admin/index.php" class="text-decoration-none">Zurück zum Dashboard</i></a>
            </div>
            <div class="cirs-link mb-2">
                <a href="/admin/logout.php" class="text-decoration-none">Abmelden</a>
            </div>
            <div class="cirs-login">
                <a href="#" class="text-decoration-none">Impressum</a>
                <a href="#" class="text-decoration-none">Datenschutz</a>
            </div>
        <?php }
    } else { ?>
        <div class="cirs-login">
            <a href="/admin/login.php" class="text-decoration-none"><i class="fa-solid fa-user"></i> Login</a>
            <a href="#" class="text-decoration-none">Impressum</a>
            <a href="#" class="text-decoration-none">Datenschutz</a>
        </div>
    <?php } ?>
</div>
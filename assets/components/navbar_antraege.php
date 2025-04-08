<?php

use App\Auth\Permissions; ?>

<div class="cirs-nav">
    <h6><?= lang('application.navbar.title') ?></h6>
    <div class="cirs-link">
        <a href="/antraege/befoerderung.php" class="text-decoration-none"><?= lang('application.navbar.new') ?></a>
    </div>
    <?php
    if (isset($_SESSION['userid']) && isset($_SESSION['permissions'])) {
        if (Permissions::check(['admin', 'application.view'])) { ?>
            <hr class="my-3">
            <h6>Verwaltung</h6>
            <div class="cirs-link mb-2">
                <a href="/admin/antraege/list.php" class="text-decoration-none"><?= lang('application.navbar.overview') ?></a>
            </div>
            <div class="cirs-link mb-2">
                <a href="/admin/index.php" class="text-decoration-none"><?= lang('application.navbar.to_dashboard') ?></a>
            </div>
            <div class="cirs-link mb-2">
                <a href="/admin/logout.php" class="text-decoration-none"><?= lang('application.navbar.logout') ?></a>
            </div>
        <?php }
    } else { ?>
        <div class="cirs-login">
            <a href="/admin/login.php" class="text-decoration-none"><i class="las la-user"></i> <?= lang('application.navbar.login') ?></a>
        </div>
    <?php } ?>
</div>
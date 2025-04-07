<!-- Footer für das Intranet-System -->
<footer class="footer mt-auto py-3 bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5><?php echo SYSTEM_NAME ?></h5>
                <p class="small">Verwaltungsportal der <?php echo RP_ORGTYPE . " " . SERVER_CITY ?></p>
            </div>
            <div class="col-md-4 text-center">
                <p class="small">&copy; <?php echo date("Y") ?> <?php echo RP_ORGTYPE . " " . SERVER_CITY ?></p>
                <p class="small">Alle Rechte vorbehalten</p>
            </div>
            <div class="col-md-4 text-end">
                <p class="small">Version <?php echo SYSTEM_VERSION ?? "1.0" ?></p>
                <p class="small">Powered by hypax</p>
            </div>
        </div>
    </div>
</footer> 
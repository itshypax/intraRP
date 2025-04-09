<!-- Footer für das Intranet-System -->
<footer class="footer mt-auto py-3 text-light">
    <div class="container">
        <div class="row d-flex align-items-end justify-content-between">
            <div class="col-md-4">
                <h5><?php echo SYSTEM_NAME ?></h5>
                <p class="small"><?= lang('footer.site_desc', [RP_ORGTYPE, SERVER_CITY]) ?></p>
            </div>
            <div class="col-md-4 text-end">
                <p class="small"><?= lang('footer.copyright', [date("Y"), SYSTEM_VERSION ?? "1.0"]) ?></p>
            </div>
        </div>
    </div>
</footer>
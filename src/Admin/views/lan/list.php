<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>LAN Begivenheder</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#createLanModal">Opret begivenhed <span class="dashicons dashicons-calendar"></span></a>
        </div>
    </div>

    <div class="content">
        <div class="events-list list gap-10">
            <div class="row">
                <?php require dirname(__FILE__) . "/partials/lan-list.php"; ?>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__FILE__) . "/partials/create-lan-modal.php"; ?>
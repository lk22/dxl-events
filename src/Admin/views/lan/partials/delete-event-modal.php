<div class="modal fade modal-xl" id="deleteLanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Slet <?php echo $event->title; ?></h5>
            </div>
            <div class="modal-body">
                <p>Er du sikker på du gerne vil slette begivenheden, <?php echo $event->title; ?>?</p>
            </div>
            <div class="modal-footer">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk <span class="dashicons dashicons-no"></span></button>
                <button class="button-primary delete-lan-modal-btn" data-event="<?php echo $event->id; ?>">Slet begivenhed</button>
            </div>
        </div>
    </div>
</div>
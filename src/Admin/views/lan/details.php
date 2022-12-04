<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1><?php echo $event->title ?? ''; ?></h1>
        <div class="actions">
            <?php 
                if( $event->is_draft ) {
                    ?>
                        <a href="#" class="button-primary publish-event" data-event="<?php echo $event->id ?>">Offentliggør <span class="dashicons dashicons-calendar"></span></a>
                    <?php
                } else {
                    ?>
                        <a href="#" class="button-primary unpublish-event" data-event="<?php echo $event->id ?>">Skjul <span class="dashicons dashicons-calendar"></span></a>
                    <?php
                }
            ?>
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#updateEventModal">Opdater begivenhed <span class="dashicons dashicons-calendar"></span></a>
            <button class="button-primary delete-lan-btn" data-bs-toggle="modal" data-bs-target="#deleteLanModal">Slet begivenhed</button>
        </div>
    </div>

    <div class="content">
        <?php
            include dirname(__FILE__) . "/partials/is-configured.php";
        ?>
        <div class="details flex">
            <div class="row">
                <div class="col-md-6">
                    <h1>Begivenheds info</h1>
                    <div class="event-start">
                        <p class="lead">Start dato: <span><?php echo date("d-m-Y", $event->start); ?></span></p>
                    </div>
                    <div class="event-end">
                        <p class="lead">Slut dato: <span><?php echo date("d-m-Y", $event->end); ?></span></p>
                    </div>
                    <div class="event-available-seats">
                        <p class="lead">Ledige pladser: <span><?php echo $event->seats_available ?></span></p>
                    </div>
        
                    <?php require_once dirname(__FILE__) . "/partials/food-details.php"; ?>
                </div>
                <div class="col-md-6">
                    <?php 
                        if( $event->description ) {
                            ?>
                                <div class="event-description">
                                    <h2>Beskrivelse</h2>
                                    <?php echo str_replace("\\", "\n", $event->description); ?>
                                </div>
                            <?php
                        }
        
                        if( $event->extra_description ) {
                            ?>
                                <div class="event-description-extra mt-4">
                                    <h2>Ekstra beskrivelse</h2>
                                    <?php echo str_replace("\\", "\n", $event->extra_description); ?>
                                </div>
                            <?php
                        }
                    ?>
        
                    <!-- list of participants and attached tournaments -->
                    <div class="accordion accordion-flush mt-4" id="eventAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Turneringer (<?php echo count($tournaments); ?>)
                            </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#eventAccordion">
                        
                                <?php 
                                    require dirname(__FILE__) . "/partials/tournament-list.php";
                                ?>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Tilmeldinger (<?php echo count($participants); ?>)
                            </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#eventAccordion">
                                <?php require_once dirname(__FILE__) . "/partials/participant-list.php"; ?>
                            </div>
                        </div>
                    </div>
                    <div class="lan-export-participants mt-4">
                        <button class="button-primary export-participants" data-event="<?php echo $event->id; ?>">
                            Export tilmeldinger
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__FILE__) . "/partials/config-event-modal.php"; ?>
<?php require dirname(__FILE__) . "/partials/update-event-modal.php"; ?>
<?php require dirname(__FILE__) . "/partials/delete-event-modal.php"; ?>
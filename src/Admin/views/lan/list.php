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
        <div class="events-list list flex-wrap gap-10">
            <?php 
                if( $events ) {
                    foreach($events as $event) {
                        ?>
                            <div class="card" style="border-radius: 10px;">
                                <div class="card-header flex">
                                    <h3>
                                        <?php echo $event->title; ?>
                                    </h3>
                                    <span>
                                        <?php
                                            if( $event->is_draft ) {
                                                ?>
                                                    <span class="status-label warning">Udkast</span>
                                                <?php
                                            }
                                        ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="available-seats">
                                        <p>Ledige sæder: <span><?php echo $event->seats_available ?> pladser</span></p>
                                    </div>
                                    <div class="tournaments-count">
                                        <p><?php echo $event->tournaments_count; ?> turneringer</p>
                                    </div>
                                    <div class="participants-count">
                                        <p><?php echo $event->participants_count; ?> antal deltagere</p>
                                    </div>
                                    <div class="start-date">
                                        <p>Start dato: <span><?php echo date("d-m-Y", $event->start) ?></span></p>
                                    </div>
                                    <div class="end-date">
                                        <p>Slut dato: <span><?php echo date("d-m-Y", $event->end) ?></span></p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo generate_dxl_subpage_url(["action" => "details", "id" => $event->id]); ?>" class="button-primary">Se begivenhed</a>
                                </div>
                            </div>
                        <?php
                    }
                } else {
                    ?>
                        <div class="status-label danger">Du har ingen registreret begivenheder</div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>


<div class="modal fade modal-xl" id="createLanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opret ny LAN begivenhed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Opret en ny begivenhed ved at udfylde formularen nedenfor, du vil efterfølgende blive viderført til begivenheden for videre opsætning.</h4>
                <form action="#" class="createEventForm">
                    <div class="left-form">
                        <div class="form-group name-field">
                            <label for="event-title">
                                <h3>Begivendhed:</h3> <input type="text" name="event-title" id="event-title" required>
                            </label>
                        </div>

                        <div class="form-group event-description">
                            <label for="event-description">
                                <h3>Beskrivelse</h3>
                                <?php 
                                    wp_editor('Udfyld begivenheds beskrivelse', 'event-description', array(
                                        "textarea_rows" => 100,
                                        "height" => 400
                                    ));
                                ?>
                            </label>
                        </div>

                        <div class="form-group event-description-extra">
                            <label for="event-description-extra">
                                <h3>Beskrivelse (ekstra):</h3>
                                <?php 
                                    wp_editor('Udfyld ekstra beskrivelse, evt medbringningsliste.', 'event-description-extra', array(
                                        "textarea_rows" => 100,
                                        "height" => 400
                                    ))
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="right-form">
                        <div class="form-group location">
                            <label for="event-location">
                                <h3>Lokation:</h3>
                                <input type="text" name="event-location" id="event-location" required>
                            </label>
                        </div>

                        <div class="form-group available-seats">
                            <label for="event-seats">
                                <h3>Antal ledige pladser</h3>
                                <input type="number" name="event-seats" id="event-seats">
                            </label>
                        </div>

                        <div class="form-group startdate">
                            <label for="event-startdate">
                                <h3>Start dato:</h3>
                                <input type="date" name="event-startdate" id="event-startdate" required>
                            </label>
                        </div>

                        <div class="form-group enddate">
                            <label for="event-enddate">
                                <h3>Slut dato:</h3>
                                <input type="date" name="event-enddate" id="event-enddate" required>
                            </label>
                        </div>

                        <div class="form-group participation_due">
                            <label for="event-participation_due">
                                <h3>Seneste tilmeldingsfrist</h3>
                                <input type="date" name="event-participation_due" id="event-participation_due" required>
                            </label>
                        </div>

                        <div class="form-group participation-open">
                            <label for="event-participation-open">
                                <h3>Dato for åbning (tilmelding)</h3>
                                <input type="date" name="event-participation-open" id="event-participation-open" required>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button-primary close-modal">Luk</button>
                <button class="button-primary create-event-button">Opret <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>
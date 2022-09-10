
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
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary create-event-button">Opret <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>
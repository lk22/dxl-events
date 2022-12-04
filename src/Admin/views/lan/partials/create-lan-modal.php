
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
                        <div class="form-group name-field mb-3">
                            <label for="event-title">
                                <p class="lead">Begivendhed:</p> <input type="text" name="event-title" id="event-title" required>
                            </label>
                        </div>

                        <div class="form-group event-description mb-3">
                            <label for="event-description">
                                <p class="lead">Beskrivelse</p>
                                <?php 
                                    wp_editor('Udfyld begivenheds beskrivelse', 'event-description', array(
                                        "textarea_rows" => 5,
                                        "height" => 400
                                    ));
                                ?>
                            </label>
                        </div>

                        <div class="form-group event-description-extra mb-3">
                            <label for="event-description-extra">
                                <p class="lead">Beskrivelse (ekstra):</p>
                                <?php 
                                    wp_editor('En Xbox med strøm og HDMI-kabel, HUSK en controller og headset
                                    Minimum 5 M netkabel
                                    Maksimum en 32” monitor eller tv, med strømkabel.
                                    Der er 3 strømstik til dig, så der er plads til en harddisk også.
                                    En sovepose og et liggeunderlag/madras eller lignende
                                    Rent tøj, håndklæde til et bad, og glem nu ikke din tandbørste', 'event-description-extra', array(
                                        "textarea_rows" => 5,
                                        "height" => 400
                                    ))
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="right-form">
                        <div class="form-group location mb-3">
                            <label for="event-location">
                                <p class="lead">Lokation:</p>
                                <input type="text" name="event-location" id="event-location" required>
                            </label>
                        </div>

                        <div class="form-group available-seats mb-3">
                            <label for="event-seats">
                                <p class="lead">Antal ledige pladser</p>
                                <input type="number" name="event-seats" id="event-seats">
                            </label>
                        </div>

                        <div class="form-group startdate mb-3 mb-3">
                            <label for="event-startdate">
                                <p class="lead">Start dato:</p>
                                <input type="date" name="event-startdate" id="event-startdate" required>
                            </label>
                        </div>

                        <div class="form-group enddate mb-3">
                            <label for="event-enddate">
                                <p class="lead">Slut dato:</p>
                                <input type="date" name="event-enddate" id="event-enddate" required>
                            </label>
                        </div>

                        <div class="form-group participation_due mb-3">
                            <label for="event-participation_due">
                                <p class="lead">Seneste tilmeldingsfrist</p>
                                <input type="date" name="event-participation_due" id="event-participation_due" required>
                            </label>
                        </div>

                        <div class="form-group participation-open mb-3">
                            <label for="event-participation-open">
                                <p class="lead">Dato for åbning (tilmelding)</p>
                                <input type="date" name="event-participation-open" id="event-participation-open" required>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer gap-2">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary create-event-button">Opret <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>
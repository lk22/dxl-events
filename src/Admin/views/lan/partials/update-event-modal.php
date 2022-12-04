<div class="modal modal-lg fade fadeInUp" id="updateEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Opdater <?php echo $event->title; ?>
                </h5>
            </div>
            <div class="modal-body">
                <p class="lead">Opdater LAN Begivenheden med ny information, er begivenheden allerede offentliggjort vil ændringerne blive vist for alle besøgende.</p>
                <form action="#" class="updateEventForm">
                    <input type="hidden" name="event_id" value="<?php echo $event->id; ?>">
                    <div class="left-form">
                        <div class="form-group name-field">
                            <label for="event-title">
                                <p class="lead">Begivendhed:</p> <input type="text" name="event-title" id="event-title" value="<?php echo $event->title; ?>" required>
                            </label>
                        </div>

                        <div class="form-group event-description mt-2 ">
                            <label for="event-description">
                                <p class="lead">Beskrivelse</p>
                                <?php 
                                    wp_editor($event->description, 'event-description', array(
                                        "textarea_rows" => 5,
                                        "height" => 100
                                    ));
                                ?>
                            </label>
                        </div>

                        <div class="form-group event-description-extra mt-2">
                            <label for="event-description-extra">
                                <p class="lead">Beskrivelse (ekstra):</p>
                                <?php 
                                    wp_editor($event->extra_description, 'event-description-extra', array(
                                        "textarea_rows" => 5,
                                        "height" => 100
                                    ))
                                ?>
                            </label>
                        </div>
                        <div class="form-group breakfast-friday-field mt-2">
                            <label for="breakfast-friday">
                                <p class="lead">Pris for morgenmad (Fredag)</p>
                                <input type="number" name="breakfast-friday" value="<?php echo $settings->breakfast_friday_price; ?>" id="breakfast-friday">
                            </label>
                        </div>

                        <div class="form-group breakfast-saturday-field mt-2">
                            <label for="breakfast-saturday">
                                <p class="lead">Pris for morgenmad (Lørdag)</p>
                                <input type="number" name="breakfast-saturday" value="<?php echo $settings->breakfast_saturday_price; ?>" id="breakfast-saturday">
                            </label>
                        </div>
                
                        <div class="form-group lunch-saturday-field mt-2">
                            <label for="lunch-saturday">
                                <p class="lead">Prist for frokost (Lørdag)</p>
                                <input type="number" name="lunch-saturday" value="<?php echo $settings->lunch_saturday_price; ?>"id="lunch-saturday">
                            </label>
                        </div>
                    
                        <div class="form-group dinner-saturday-field mt-2">
                            <label for="dinner-saturday">
                                <p class="lead">Pris for aftensmad (Lørdag)</p>
                                <input type="number" name="dinner-saturday" value="<?php echo $settings->dinner_saturday_price; ?>" id="dinner-saturday">
                            </label>
                        </div>

                        <div class="form-group breakfast-sunday-field mt-2">
                            <label for="breakfast-sunday">
                                <p class="lead">Pris for morgenmad (Søndag)</p>
                                <input type="number" name="breakfast-sunday" value="<?php echo $settings->breakfast_sunday_price; ?>" id="breakfast-sunday">
                            </label>
                        </div>
                        
                    </div>
                    <div class="right-form">
                        <div class="form-group location mt-2">
                            <label for="event-location">
                                <p class="lead">Lokation:</p>
                                <input type="text" name="event-location" value="<?php echo $settings->event_location ?>" id="event-location" required>
                            </label>
                        </div>

                        <div class="form-group available-seats mt-2">
                            <label for="event-seats">
                                <p class="lead">Antal ledige pladser</p>
                                <input type="number" name="event-seats" value="<?php echo $event->seats_available ?>" id="event-seats">
                            </label>
                        </div>

                        <div class="form-group startdate mt-2">
                            <label for="event-startdate">
                                <p class="lead">Start dato:</p>
                                <input type="date" name="event-startdate" value="<?php echo date("Y-m-d", $event->start) ?>" id="event-startdate" required>
                            </label>
                        </div>

                        <div class="form-group enddate mt-2">
                            <label for="event-enddate">
                                <p class="lead">Slut dato:</p>
                                <input type="date" name="event-enddate" value="<?php echo date("Y-m-d", $event->end) ?>" id="event-enddate" required>
                            </label>
                        </div>

                        <div class="form-group start-at-field mt-2">
                            <label for="start-at">
                                <p class="lead">Start tidspunkt</p>
                                <input type="time" value="<?php echo date("H:i", $settings->start_at) ?>" name="start-at" id="start-at">
                            </label>
                        </div>
                        <div class="form-group end-at-field mt-2">
                            <label for="end-at">
                                <p class="lead">Slut tidspunkt</p>
                                <input type="time" name="end-at" value="<?php echo date("H:i", $settings->end_at); ?>" id="end-at">
                            </label>
                        </div>

                        <div class="form-group participation_due mt-2">
                            <label for="event-participation_due">
                                <p class="lead">Seneste tilmeldingsfrist</p>
                                <input type="date" name="event-participation_due" value="<?php echo date("Y-m-d", $settings->latest_participation_date); ?>" id="event-participation_due" required>
                            </label>
                        </div>

                        <div class="form-group participation-open mt-2">
                            <label for="event-participation-open">
                                <p class="lead">Dato for åbning (tilmelding)</p>
                                <input type="date" name="event-participation-open" value="<?php echo date("Y-m-d", $settings->participation_opening_date); ?>" id="event-participation-open" required>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer gap-2">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary update-event-button">Opdater <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>
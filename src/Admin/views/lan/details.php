<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1><?php echo $event->title; ?></h1>
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
            <a href="#" class="button-primary modal-button" data-modal="#updateEventModal">Opdater begivenhed <span class="dashicons dashicons-calendar"></span></a>
        </div>
    </div>

    <div class="content">
        <?php
            if( ! $is_configured ) {
                ?>
                    <div class="alert alert-danger">
                        Der mangler konfiguration til begivenheden, se følgende informationer
                        <div class="config-list">
                            <ul>
                                <?php 
                                    if( $breakfast_friday == 0 ) {
                                        ?>
                                            <li>- Morgenmad (fredag)</li>
                                        <?php
                                    }

                                    if( $breakfast_saturday == 0 ) {
                                        ?>
                                            <li>- Morgenmad (Lørdag)</li>
                                        <?php
                                    }

                                    if( $lunch_saturday == 0 ) {
                                        ?>
                                            <li>- Frokost (Lørdag)</li>
                                        <?php
                                    }

                                    if( $dinner_saturday == 0 ) {
                                        ?>
                                            <li>- Aftensmad (Lørdag)</li>
                                        <?php
                                    }

                                    if( $breakfast_sunday == 0 ) {
                                        ?>
                                            <li>- Morgenmad (Søndag)</li>
                                        <?php
                                    }

                                    if( $start_at == 0 ) {
                                        ?>
                                            <li>- Start tidspunkt</li>
                                        <?php
                                    }

                                    if( $end_at == 0 ) {
                                        ?>
                                            <li>- Slut tidspunkt</li>
                                        <?php
                                    }

                                    if( $latest_participation_date == 0 ) {
                                        ?>
                                            <li>- Senest tilmeldingsfrist</li>
                                        <?php
                                    }

                                    if( $participant_opening_date == 0 ) {
                                        ?>
                                            <li>- Åbning for tilmelding</li>
                                        <?php
                                    }
                                ?>
                            </ul>
                            <span><button class="button-primary modal-button" data-modal="#configEventModal">Konfigurer</button></span>
                        </div>
                    </div>
                <?php
            }
        ?>
        <div class="details flex">
            <div class="left-details">
                <h1>Begivenheds info</h1>
                <div class="event-start">
                    <h3>Start dato: <span><?php echo date("d-m-Y", $event->start); ?></span></h3>
                </div>
                <div class="event-end">
                    <h3>Slut dato: <span><?php echo date("d-m-Y", $event->end); ?></span></h3>
                </div>
                <div class="event-available-seats">
                    <h3>Ledige pladser: <span><?php echo $event->seats_available ?></span></h3>
                </div>

                <?php 
                    if( $start_at != 0 ) {
                        ?>
                            <div class="event-start-at">
                                <h3>Start tidspunkt: <span><?php echo date("H:i", $start_at) ?></span></h3>
                            </div>
                        <?php
                    }

                    if( $end_at != 0 ) {
                        ?>
                            <div class="event-end-at">
                                <h3>Start tidspunkt: <span><?php echo date("H:i", $end_at) ?></span></h3>
                            </div>
                        <?php
                    }

                    if( $participant_opening_date != 0 ) {
                        ?>
                            <div class="event-opening-participation">
                                <h3>Åbning for tilmelding: <span><?php echo date("d-m-Y", $participant_opening_date) ?></span></h3>
                            </div>
                        <?php
                    }

                    if( $end_at != 0 ) {
                        ?>
                            <div class="event-latest-participation">
                                <h3>Seneste tilmeldingsfrist: <span><?php echo date("d-m-Y", $latest_participation_date) ?></span></h3>
                            </div>
                        <?php
                    }

                    if ( $breakfast_friday != 0 ) 
                    {
                        ?>
                            <div class="event-breakfast-friday-price">
                                <h3>Pris morgenmad (Fredag): <?php echo $breakfast_friday; ?> DKK</h3>
                            </div>
                        <?php
                    }

                    if ( $breakfast_saturday != 0 ) 
                    {
                        ?>
                            <div class="event-breakfast-saturday-price">
                                <h3>Pris morgenmad (Lørdag): <?php echo $breakfast_saturday; ?> DKK</h3>
                            </div>
                        <?php
                    }

                    if ( $lunch_saturday != 0 ) 
                    {
                        ?>
                            <div class="event-breakfast-saturday-price">
                                <h3>Pris frokost (Lørdag): <?php echo $lunch_saturday; ?> DKK</h3>
                            </div>
                        <?php
                    }

                    if ( $dinner_saturday != 0 ) 
                    {
                        ?>
                            <div class="event-breakfast-saturday-price">
                                <h3>Pris aftensmad (Lørdag): <?php echo $dinner_saturday; ?> DKK</h3>
                            </div>
                        <?php
                    }

                    if ( $breakfast_sunday != 0 ) 
                    {
                        ?>
                            <div class="event-breakfast-saturday-price">
                                <h3>Pris Morgenmad (Søndag): <?php echo $breakfast_sunday; ?> DKK</h3>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <div class="right-details">
                <?php 
                    if( $event->description ) {
                        ?>
                            <div class="event-description">
                                <h2>Beskrivelse</h2>
                                <?php echo $event->description; ?>
                            </div>
                        <?php
                    }

                    if( $event->extra_description ) {
                        ?>
                            <div class="event-description-extra">
                                <h2>Ekstra beskrivelse</h2>
                                <?php echo $event->extra_description; ?>
                            </div>
                        <?php
                    }
                ?>
                <!-- list of participants and attached tournaments -->
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="item-header">
                            <h3>Antal turneringer (<?php echo $event->tournaments_count; ?>)</h3>
                        </div>
                        <div class="item-body hidden">
                            <?php 
                                if( $event->tournaments_count > 0 ) {
                                    ?>
                                        <table class="widefat fixed striped event-tournaments-list">
                                            <thead>
                                                <th>Turnering</th>
                                                <th>Antal deltagere</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($tournamentData as $tournament) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $tournament["title"]; ?></td>
                                                                <td><?php echo $tournament["participants_count"] ?> deltagere</td>
                                                            </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php
                                } else {
                                    ?>
                                        <div class="alert alert-warning">Du har ingen turneringer tilknyttet</div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="item-header">
                            <h3>Antal deltagere (<?php echo $event->participants_count?>)</h3>
                        </div>
                        <div class="item-body hidden">
                            <?php 
                                if( $event->participants_count > 0 ) {
                                    ?>
                                        <table class="table table-responsive">
                                            <thead>
                                                <th>Navn:</th>
                                                <th>Gamertag:</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                
                                                foreach($participants as $participant) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $participant->name; ?></td>
                                                            <td><?php echo $participant->gamertag; ?></td>
                                                        </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php
                                    
                                } else {
                                    ?>
                                        <div class="alert alert-warning">Du har ingen tilmeldinger</div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- event configuration modal -->
<div class="modal configEventModal hidden" id="configEventModal">
    <div class="modal-header">
        <h2>Konfigurer Begivenhed - <?php echo $event->title ?></h2>
    </div>
    <div class="modal-body">
        <form action="#" class="configEventForm">
            <input type="hidden" name="event" value="<?php echo $event->id ?>">
            <div class="left-form">
                <?php 
                    if( $breakfast_friday == 0 ) {
                        ?>
                            <div class="form-group breakfast-friday-field">
                                <label for="breakfast-friday">
                                    <h3>Pris for morgenmad (Fredag)</h3>
                                    <input type="number" name="breakfast-friday" id="breakfast-friday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $breakfast_saturday == 0 ) {
                        ?>
                            <div class="form-group breakfast-saturday-field">
                                <label for="breakfast-saturday">
                                    <h3>Pris for morgenmad (Lørdag)</h3>
                                    <input type="number" name="breakfast-saturday" id="breakfast-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $lunch_saturday == 0 ) {
                        ?>
                            <div class="form-group lunch-saturday-field">
                                <label for="lunch-saturday">
                                    <h3>Prist for frokost (Lørdag)</h3>
                                    <input type="number" name="lunch-saturday" id="lunch-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $dinner_saturday == 0 ) {
                        ?>
                            <div class="form-group dinner-saturday-field">
                                <label for="dinner-saturday">
                                    <h3>Pris for aftensmad (Lørdag)</h3>
                                    <input type="number" name="dinner-saturday" id="dinner-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $breakfast_sunday == 0 ) {
                        ?>
                            <div class="form-group breakfast-sunday-field">
                                <label for="breakfast-sunday">
                                    <h3>Pris for morgenmad (Søndag)</h3>
                                    <input type="number" name="breakfast-sunday" id="breakfast-sunday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $start_at == 0 ) {
                        ?>
                            <div class="form-group start-at-field">
                                <label for="start-at">
                                    <h3>Start tidspunkt</h3>
                                    <input type="time" name="start-at" id="start-at">
                                </label>
                            </div>
                        <?php
                    }

                    if( $end_at == 0 ) {
                        ?>
                            <div class="form-group end-at-field">
                                <label for="end-at">
                                    <h3>Slut tidspunkt</h3>
                                    <input type="time" name="end-at" id="end-at">
                                </label>
                            </div>
                        <?php
                    }

                    if( $participant_opening_date == 0 ) {
                        ?>
                            <div class="form-group participation-opening-date-field">
                                <label for="participation-opening-date">
                                    <h3>Åbning for tilmelding (vælg dato)</h3>
                                    <input type="date" name="participation-opening-date" id="participation-opening-date">
                                </label>
                            </div>
                        <?php
                    }

                    if( $latest_participation_date == 0 ) {
                        ?>
                            <div class="form-group latest-participation-date-field">
                                <label for="latest-participation-date">
                                    <h3>Seneste tilmeldings frist (Vælg dato)</h3>
                                    <input type="date" name="latest-participation-date" id="latest-participation-date">
                                </label>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk</button>
        <button class="button-primary config-event-btn">Konfigurer</button>
    </div>
</div>

<!-- updating event modal -->
<div class="modal updateEventModal hidden" id="updateEventModal">
    <div class="modal-header">
        <h2>Opret ny LAN Begivenhed</h2>
    </div>
    <div class="modal-body">
        <h4>Opdater LAN Begivenheden med ny information, er begivenheden allerede offentliggjort vil ændringerne blive vist for alle besøgende.</h4>
        <form action="#" class="updateEventForm">
            <input type="hidden" name="event_id" value="<?php echo $event->id; ?>">
            <div class="left-form">
                <div class="form-group name-field">
                    <label for="event-title">
                        <h3>Begivendhed:</h3> <input type="text" name="event-title" id="event-title" value="<?php echo $event->title; ?>" required>
                    </label>
                </div>

                <div class="form-group event-description">
                    <label for="event-description">
                        <h3>Beskrivelse</h3>
                        <?php 
                            wp_editor($event->description, 'event-description', array(
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
                            wp_editor($event->extra_description, 'event-description-extra', array(
                                "textarea_rows" => 100,
                                "height" => 400
                            ))
                        ?>
                    </label>
                </div>
                <div class="form-group breakfast-friday-field">
                    <label for="breakfast-friday">
                        <h3>Pris for morgenmad (Fredag)</h3>
                        <input type="number" name="breakfast-friday" value="<?php echo $settings->breakfast_friday_price; ?>" id="breakfast-friday">
                    </label>
                </div>

                <div class="form-group breakfast-saturday-field">
                    <label for="breakfast-saturday">
                        <h3>Pris for morgenmad (Lørdag)</h3>
                        <input type="number" name="breakfast-saturday" value="<?php echo $settings->breakfast_saturday_price; ?>" id="breakfast-saturday">
                    </label>
                </div>
          
                <div class="form-group lunch-saturday-field">
                    <label for="lunch-saturday">
                        <h3>Prist for frokost (Lørdag)</h3>
                        <input type="number" name="lunch-saturday" value="<?php echo $settings->lunch_saturday_price; ?>"id="lunch-saturday">
                    </label>
                </div>
            
                <div class="form-group dinner-saturday-field">
                    <label for="dinner-saturday">
                        <h3>Pris for aftensmad (Lørdag)</h3>
                        <input type="number" name="dinner-saturday" value="<?php echo $settings->dinner_saturday_price; ?>" id="dinner-saturday">
                    </label>
                </div>

                <div class="form-group breakfast-sunday-field">
                    <label for="breakfast-sunday">
                        <h3>Pris for morgenmad (Søndag)</h3>
                        <input type="number" name="breakfast-sunday" value="<?php echo $settings->breakfast_sunday_price; ?>" id="breakfast-sunday">
                    </label>
                </div>
                
            </div>
            <div class="right-form">
                <div class="form-group location">
                    <label for="event-location">
                        <h3>Lokation:</h3>
                        <input type="text" name="event-location" value="<?php echo $settings->event_location ?>" id="event-location" required>
                    </label>
                </div>

                <div class="form-group available-seats">
                    <label for="event-seats">
                        <h3>Antal ledige pladser</h3>
                        <input type="number" name="event-seats" value="<?php echo $event->seats_available ?>" id="event-seats">
                    </label>
                </div>

                <div class="form-group startdate">
                    <label for="event-startdate">
                        <h3>Start dato:</h3>
                        <input type="date" name="event-startdate" value="<?php echo date("Y-m-d", $event->start) ?>" id="event-startdate" required>
                    </label>
                </div>

                <div class="form-group enddate">
                    <label for="event-enddate">
                        <h3>Slut dato:</h3>
                        <input type="date" name="event-enddate" value="<?php echo date("Y-m-d", $event->end) ?>" id="event-enddate" required>
                    </label>
                </div>

                <div class="form-group start-at-field">
                    <label for="start-at">
                        <h3>Start tidspunkt</h3>
                        <input type="time" value="<?php echo date("H:i", $settings->start_at) ?>" name="start-at" id="start-at">
                    </label>
                </div>
                <div class="form-group end-at-field">
                    <label for="end-at">
                        <h3>Slut tidspunkt</h3>
                        <input type="time" name="end-at" value="<?php echo date("H:i", $settings->end_at); ?>" id="end-at">
                    </label>
                </div>

                <div class="form-group participation_due">
                    <label for="event-participation_due">
                        <h3>Seneste tilmeldingsfrist</h3>
                        <input type="date" name="event-participation_due" value="<?php echo date("Y-m-d", $settings->latest_participation_date); ?>" id="event-participation_due" required>
                    </label>
                </div>

                <div class="form-group participation-open">
                    <label for="event-participation-open">
                        <h3>Dato for åbning (tilmelding)</h3>
                        <input type="date" name="event-participation-open" value="<?php echo date("Y-m-d", $settings->participation_opening_date); ?>" id="event-participation-open" required>
                    </label>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk</button>
        <button class="button-primary update-event-button">Opdater <span class="dashicons dashicons-calendar"></span></button>
    </div>
</div>

<div class="overlay hidden"></div>
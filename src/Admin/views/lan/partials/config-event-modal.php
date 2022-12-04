<div class="modal modal-lg fade fadeInUp" id="configEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Konfigurer <?php echo $event->title; ?></h2>
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
                                    <p class="lead">Pris for morgenmad (Lørdag)</p>
                                    <input type="number" name="breakfast-saturday" id="breakfast-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $lunch_saturday == 0 ) {
                        ?>
                            <div class="form-group lunch-saturday-field">
                                <label for="lunch-saturday">
                                    <p class="lead">Prist for frokost (Lørdag)</p>
                                    <input type="number" name="lunch-saturday" id="lunch-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $dinner_saturday == 0 ) {
                        ?>
                            <div class="form-group dinner-saturday-field">
                                <label for="dinner-saturday">
                                    <p class="lead">Pris for aftensmad (Lørdag)</p>
                                    <input type="number" name="dinner-saturday" id="dinner-saturday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $breakfast_sunday == 0 ) {
                        ?>
                            <div class="form-group breakfast-sunday-field">
                                <label for="breakfast-sunday">
                                    <p class="lead">Pris for morgenmad (Søndag)</p>
                                    <input type="number" name="breakfast-sunday" id="breakfast-sunday">
                                </label>
                            </div>
                        <?php
                    }

                    if( $start_at == 0 ) {
                        ?>
                            <div class="form-group start-at-field">
                                <label for="start-at">
                                    <p class="lead">Start tidspunkt</p>
                                    <input type="time" name="start-at" id="start-at">
                                </label>
                            </div>
                        <?php
                    }

                    if( $end_at == 0 ) {
                        ?>
                            <div class="form-group end-at-field">
                                <label for="end-at">
                                    <p class="lead">Slut tidspunkt</p>
                                    <input type="time" name="end-at" id="end-at">
                                </label>
                            </div>
                        <?php
                    }

                    if( $participant_opening_date == 0 ) {
                        ?>
                            <div class="form-group participation-opening-date-field">
                                <label for="participation-opening-date">
                                    <p class="lead">Åbning for tilmelding (vælg dato)</p>
                                    <input type="date" name="participation-opening-date" id="participation-opening-date">
                                </label>
                            </div>
                        <?php
                    }

                    if( $latest_participation_date == 0 ) {
                        ?>
                            <div class="form-group latest-participation-date-field">
                                <label for="latest-participation-date">
                                    <p>Seneste tilmeldings frist (Vælg dato)</p>
                                    <input type="date" name="latest-participation-date" id="latest-participation-date">
                                </label>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </form>
            </div>
            <div class="modal-footer gap-2">
                <button class="button-primary" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary config-event-btn">Konfigurer</button>
            </div>
        </div>
    </div>
</div>

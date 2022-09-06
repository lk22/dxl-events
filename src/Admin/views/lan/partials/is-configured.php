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
                    <span><button class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#configEventModal">Konfigurer</button></span>
                </div>
            </div>
        <?php
    }
?>
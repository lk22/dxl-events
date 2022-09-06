<?php 
    if( $start_at != 0 ) {
        ?>
            <div class="event-start-at">
                <p class="lead">Start tidspunkt: <span><?php echo date("H:i", $start_at) ?></span></p>
            </div>
        <?php
    }

    if( $end_at != 0 ) {
        ?>
            <div class="event-end-at">
                <p class="lead">Start tidspunkt: <span><?php echo date("H:i", $end_at) ?></span></p>
            </div>
        <?php
    }

    if( $participant_opening_date != 0 ) {
        ?>
            <div class="event-opening-participation">
                <p class="lead">Åbning for tilmelding: <span><?php echo date("d-m-Y", $participant_opening_date) ?></span></p>
            </div>
        <?php
    }

    if( $end_at != 0 ) {
        ?>
            <div class="event-latest-participation">
                <p class="lead">Seneste tilmeldingsfrist: <span><?php echo date("d-m-Y", $latest_participation_date) ?></span></p>
            </div>
        <?php
    }

    if ( $breakfast_friday != 0 ) 
    {
        ?>
            <div class="event-breakfast-friday-price">
                <p class="lead">Pris morgenmad (Fredag): <?php echo $breakfast_friday; ?> DKK</p>
            </div>
        <?php
    }

    if ( $breakfast_saturday != 0 ) 
    {
        ?>
            <div class="event-breakfast-saturday-price">
                <p class="lead">Pris morgenmad (Lørdag): <?php echo $breakfast_saturday; ?> DKK</p>
            </div>
        <?php
    }

    if ( $lunch_saturday != 0 ) 
    {
        ?>
            <div class="event-breakfast-saturday-price">
                <p class="lead">Pris frokost (Lørdag): <?php echo $lunch_saturday; ?> DKK</p>
            </div>
        <?php
    }

    if ( $dinner_saturday != 0 ) 
    {
        ?>
            <div class="event-breakfast-saturday-price">
                <p class="lead">Pris aftensmad (Lørdag): <?php echo $dinner_saturday; ?> DKK</p>
            </div>
        <?php
    }

    if ( $breakfast_sunday != 0 ) 
    {
        ?>
            <div class="event-breakfast-saturday-price">
                <p class="lead">Pris Morgenmad (Søndag): <?php echo $breakfast_sunday; ?> DKK</p>
            </div>
        <?php
    }
?>
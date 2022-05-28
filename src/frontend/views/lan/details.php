<?php 
    // var_dump($participants);
?>

<div class="event lan-event">
    <div class="event__header">
        <div class="inner">
            <div class="event__header--title">
                <h1><?php echo strtoupper($event->title); ?></h1>
            </div>
            <div class="event__heading--meta">
                <div class="start-date meta__field">
                    <p>Start dato: <?php echo date("j F Y", $event->start); ?></p>
                </div>
                <div class="end-date meta__field">
                    <p>Slut dato: <?php echo date("j F Y", $event->end); ?></p>
                </div>
                <div class="start-time meta__field">
                    <p>
                        Dørene åbner kl. <?php echo date("H:i", $settings->start_at); ?>
                    </p>
                </div>
                <div class="end-time meta__field">
                    <p>
                        Slutter kl. <?php echo date("H:i", $settings->end_at); ?> 
                    </p>
                </div>
                <div class="participation-start meta__field">
                    <p>
                        Tilmelding åbner: <?php echo date("j F Y", $settings->participation_opening_date); ?>
                    </p>
                </div>
                <div class="latest-participation-date meta__field">
                    <p>
                        Seneste tilmeldings frist: <?php echo date("j F Y", $settings->latest_participation_date); ?>
                    </p>
                </div>
            </div>
            <div class="event__header--actions">
                <?php 
                    if( $member && !$participated ) {
                        ?>
                            <button>Deltag</button>
                        <?php
                    } else if ( $member && $participated) {
                        ?>
                            <button>Afmeld</button>
                        <?php
                    }
                ?>
                <button class="modal-button" data-modal="#lanEventParticipantsModal">Deltagerliste</button>
                <button>Turneringer</button>
            </div>
        </div>
    </div>
    <div class="details-body">
        <h2>Begivenheds information</h2>
        <div class="event-details">
            <div class="descriptions info-field">
                <h2>Beskrivelse</h2>
                <?php 
                    echo $event->description;
                ?>
            </div>
    
            <div class="extra-information info-field">
                <h2>Huskeliste</h2>
                <p>
                    <?php echo $event->extra_description; ?>
                </p>
            </div>
    
            <div class="event-food-details info-field">
                <h4>Mad priser</h4>
                <p>
                    Fredag (Aftensmad): <?php echo $settings->breakfast_friday_price; ?>,-
                </p>
                <p>
                    Lørdag:
                    <ul>
                        <li>
                            Morgenmad: <?php echo $settings->breakfast_saturday_price; ?>,-
                        </li>
                        <li>
                            Frokost: <?php echo $settings->lunch_saturday_price; ?>,-
                        </li>
                        <li>
                            Morgenmad: <?php echo $settings->dinner_saturday_price; ?>,-
                        </li>
                    </ul>
                </p>
                <p>Søndag (Morgenmad): <?php echo $settings->breakfast_sunday_price ?>,-</p>
            </div>
        </div>
    </div>
    <div class="details-footer">

    </div>
</div>

<div class="modal modal-sm" id="lanEventParticipantsModal">
    <div class="modal-inner">
        <div class="modal-header">
            <h1>Deltagerliste</h1>
        </div>
        <div class="modal-body">
            <div class="event-participants-lists">
                <?php 
                    foreach($participants as $participant) {
                        ?>
                            <div class="participant">
                                <div class="participant-name">
                                    <?php echo $participant->name ?? ""; ?>
                                </div>
                                <div class="participant-email">
                                    <?php echo $participant->gamertag ?? ""; ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <button class="close-modal button-primary">Luk</button>
        </div>
    </div>
</div>
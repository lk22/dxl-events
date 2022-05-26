<?php 
    var_dump($settings);
?>

<div class="event lan-event">
    <div class="details-header">
        <div class="inner">
            <div class="heading">
                <h1><?php echo strtoupper($event->title); ?></h1>
            </div>
            <div class="heading-meta">
                <div class="start-date meta-field">
                    <p>Start dato: <?php echo date("j F Y", $event->start); ?></p>
                </div>
                <div class="end-date meta-field">
                    <p>Slut dato: <?php echo date("j F Y", $event->end); ?></p>
                </div>
                <div class="start-time meta-field">
                    <p>
                        Dørene åbner kl. <?php echo date("H:i", $settings->start_at); ?>
                    </p>
                </div>
                <div class="end-time meta-field">
                    <p>
                        Slutter kl. <?php echo date("H:i", $settings->end_at); ?> 
                    </p>
                </div>
                <div class="participation-start meta-field">
                    <p>
                        Tilmelding åbner: <?php echo date("j F Y", $settings->participation_opening_date); ?>
                    </p>
                </div>
                <div class="latest-participation-date meta-field">
                    <p>
                        Seneste tilmeldings frist: <?php echo date("j F Y", $settings->latest_participation_date); ?>
                    </p>
                </div>
            </div>
            <div class="heading-actions">
                <button>Deltag</button>
                <button>Deltagerliste</button>
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
                    Fredag (Aftensmad): <?php echo $settings->breakfast_friday_price; ?>
                </p>
                <p>
                    Lørdag:
                    <ul>
                        <li>
                            Morgenmad: <?php echo $settings->breakfast_saturday_price; ?>
                        </li>
                        <li>
                            Frokost: <?php echo $settings->lunch_saturday_price; ?>
                        </li>
                        <li>
                            Morgenmad: <?php echo $settings->dinner_saturday_price; ?>
                        </li>
                    </ul>
                </p>
                <p>Søndag (Morgenmad): <?php echo $settings->breakfast_sunday_price ?></p>
            </div>
        </div>
    </div>
    <div class="details-footer">

    </div>
</div>
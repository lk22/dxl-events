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
        <div class="descriptions">
            <h2>Beskrivelse</h2>
        </div>
    </div>
    <div class="details-footer">

    </div>
</div>
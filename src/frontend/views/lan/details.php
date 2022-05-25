<?php 
    // var_dump($event);
?>

<div class="event event-details-container lan-event">
    <div class="details-header">
        <div class="inner">
            <div class="heading">
                <h1><?php echo $event->title; ?></h1>
            </div>
            <div class="heading-meta">
                <div class="start-date">
                    <p>Start dato: <?php echo date("j F Y", $event->start); ?></p>
                </div>
                <div class="end-date">
                    <p>Slut dato: <?php echo date("j F Y", $event->end); ?></p>
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
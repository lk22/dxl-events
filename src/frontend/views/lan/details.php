<?php 
    // var_dump($settings);
?>

<div class="container-fluid event lan-event h-100"">
    <div class="row event-header p-5 align-items-end" style="height: 800px;">
        <div class="container pb-5">
            <div class="col-lg-5 col-xl-5 text-white">
                <div class="row title mb-5">
                    <h1 class="text-white display-5 fw-bold"><?php echo strtoupper($event->title); ?></h1>
                </div>

                <div class="row meta">
                    <div class="col-12 location">
                        <p class="lead text-white fw-bold">
                            <?php echo $settings->event_location; ?>
                        </p>
                    </div>
                    <div class="col-12 start-date">
                        <p>Start dato: <?php echo date("j F Y", $event->start); ?></p>
                    </div>
                    <div class="col-12 end-date">
                        <p>Slut dato: <?php echo date("j F Y", $event->end); ?></p>
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
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-success modal-button" data-bs-toggle="modal" data-bs-target="#lanEventParticipantsModal">Deltagerliste</button>
                        <?php 
                            if( $participated ) {
                                ?>
                                    <a href="events/?action=unparticipate&event=<?php echo $event->id; ?>" class="btn btn-success">Afmeld</a>
                                <?php
                            } else {
                                ?>
                                    <a href="events/?action=participate&event=<?php echo $event->id; ?>" class="btn btn-success">Deltag</a>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5 px-4 my-5 overflow-hidden rounded rounded-md">
        <div class="row gx-5 gy-5 tournaments">
            <div class="col col-xl-7 p-5 rounded rounded-md">
            <div class="descriptions info-field mb-5">
                <h2>Beskrivelse</h2>
                <?php 
                    echo $event->description;
                ?>
            </div>
    
            <div class="extra-information info-field mb-5">
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
            <div class="col col-xl-5 p-4 rounded rounded-md">
                <?php 
                    foreach( $tournaments as $t => $tournament) {
                        ?>
                            <div class="col-12 p-4 rounded rounded-2xl tournament">
                                <div class="tournament__title fw-bold text-success text-uppercase">
                                    <h3 class="fw-bold"><?php echo $tournament->title; ?></h3>
                                </div>
                                <div class="tournament__meta">
                                    <div class="tournament__meta--field">
                                        <p>Antal deltagere: <?php echo $tournament->participants_count; ?></p>
                                    </div>
                                    <div class="tournament__meta--field">
                                        <p>Starter D. <?php echo date("d F, H:i");?></p>
                                    </div>
                                    <div class="tournament__meta--field">
                                        <button
                                            class="btn btn-success tournament-button" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#lanTournamentModal"
                                            data-event="<?php echo $event->id; ?>"
                                            data-tournament="<?php echo $tournament->id; ?>"
                                        >
                                            Se mere
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp modal-sm" id="lanEventParticipantsModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <div class="col-lg-8 col-xl-8">
                        <h1>Deltagerliste</h1>
                    </div>
                    <div class="col-4">
                        <p><?php echo count($participants); ?> <small>Deltagere</small></p>
                    </div>
                </div>
                <!-- <h1>Deltagerliste <?php echo count($participants); ?> <small>Deltagere</small></h1> -->
            </div>
            <div class="modal-body">
                <div class="event-participants-lists">
                    <?php 
                        foreach($participants as $participant) {
                            ?>
                                <div class="participant my-4">
                                    <div class="participant-name lead fw-normal">
                                        <?php echo $participant->name ?? ""; ?>
                                    </div>
                                    <div class="participant-email lead fw-normal">
                                        <?php echo $participant->gamertag ?? ""; ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-modal button-primary btn btn-cancel" data-bs-dismiss="modal">Luk</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp" id="lanTournamentModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <?php 
                    if( $participated ) {
                        ?>
                            <button
                                class="participate-tournament-btn btn btn-success"
                                data-member="<?php echo $member->id; ?>"
                            >Tilmeld</button>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- modal for showing information about a tournament event attached to LAN event -->
<!-- <div class="modal" id="lanTournamentModal">
    <div class="modal-inner">
        <div class="modal-header">

        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button class="close-modal button-primary">Luk</button>
            <?php 
                if( $participated ) {
                    ?>
                        <button
                            class="participate-tournament-btn button-success"
                            data-member="<?php echo $member->id; ?>"
                        >Tilmeld</button>
                    <?php
                }
            ?>
        </div>
    </div>
</div> -->
<div class="container-fluid event lan-event h-100"">
    <div class="row event-header p-5 align-items-end">
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
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#lanUnparticipateModal">Afmeld</button>
                                    <!-- <a href="events/?action=unparticipate&event=<?php echo $event->id; ?>" class="btn btn-success">Afmeld</a> -->
                                <?php
                            } else if( !$participated && $member ) {
                                ?>
                                    <a href="events/?action=participate&event=<?php echo $event->slug; ?>" class="btn btn-success">Deltag</a>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5 px-4 my-5 overflow-hidden rounded rounded-md">
        <?php 
            if ( $event->is_held ) {
                ?>
                    <div class="row event-is-held">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <p class="lead display-6 fw-bold">LAN begivenheden er afholdt</p>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
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

<div class="modal modal-xl fade fadeInUp" tabindex="-1" aria-modal="true" role="dialog" id="lanEventParticipantsModal" aria-labelledby="myModalLabel">>
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
                <button class="close-modal button-primary btn btn-cancel text-white" data-bs-dismiss="modal">Luk</button>
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

<div class="modal modal-lg fade fadeInUp" id="lanUnparticipateModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ønsker du at afmelde dig <?php echo $event->title; ?></h2>
            </div>
            <div class="modal-body">
                <div class="form-container">
                    <p>Ønsker du og fortælle os hvorfor du ikke kan deltage, er du velkommen til at udfylde feltet nedenfor</p>
                    <form action="#" class="unparticipate-lan-form">
                        <div class="form-floating">
                            <textarea required class="form-control" placeholder="Noget vi særligt skal være opmærksom på?" name="participant-message"  id="floatingTextarea2 participant-message" style="height: 300px"></textarea>
                            <label for="floatingTextarea2">Udfyld besked</label>
                        </div>
                    </form>
                </div>
                <div class="unparticipated" style="display:none;">
                    <h3 class="text-center text-success">
                        Du er nu afmeldt <?php echo $event->title; ?>
                    </h3>
                    <p>Du modtager en mail med din afmeldelses bekræftelse inden for kort.</p>
                    <p>Vi er kede af du ikke kan deltage alligevel</p>
                    <p>vi håber på at se dig næste gang!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <button
                    class="unparticipate-lan-btn btn btn-success"
                    data-member="<?php echo $member->id; ?>"
                    data-event="<?php echo $event->id; ?>"
                >Afmeld</button>
            </div>
        </div>
    </div>
</div>
<?php 
// var_dump($event); 
// var_dump((isset($settings) ? $settings : [])); 
// var_dump((isset($participants) ? $participants : [])); 
// var_dump($participants);
// var_dump($member);
?>

<div class="event event-details-container">
    <div class="details-body">
        <div class="col-12 left-body">
        <div class="details-header">
            <div class="event-title">
            <?php 
                echo (isset($event->title) ? "<h2>" . $event->title . "</h2>" : "");
                echo (isset($event->name) ? "<h2>" . $event->name . "</h2>" : "");
            ?>
            </div>
            <div class="event-actions">
                <?php 
                    if( isset($participated) && $participated ) {
                        ?>
                            <button class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#eventUnparticipantModal">Afmeld</button>
                        <?php
                    } else if ($member) {
                        ?>
                            <button class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#eventParticipateModal">Deltag</button>
                        <?php 
                    }
                ?>
                
                <button class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#eventParticipantsModal" onclick="">Se deltagere</button>
            </div>
        </div>
        
        <div class="description">
            <h3>Begivenheds beskrivelse</h3>
            <p>
                <?php echo $event->description ?? "Der er ingen beskrivelse"; ?>
            </p>
        </div>
        <?php 
            if( $event->starttime ){
                ?>
                    <div class="event-starttime">
                        <h5>Start tidspunkt</h5>
                        <p>
                            kl. <?php echo date("H:i", $event->starttime) ?>
                        </p>
                    </div>
                <?php
            }
            if( $event->endtime ){
                ?>
                    <div class="event-starttime">
                        <h5>Slut tidspunkt</h5>
                        <p>
                            kl. <?php echo date("H:i", $event->endtime) ?>
                        </p>
                    </div>
                <?php
            }
        ?>
        <?php 
            if( isset($event->event_day) && isset($event->is_recurring) ) {
                ?>
                    <div class="event-day">
                        <h5>Begivenheds dag</h5>
                        hver <?php echo $event->event_day ?? "" ?>
                    </div>
                <?php
            }

            if( isset($author) ) {
                ?>
                    <div class="event-author mt-2">
                        <h5>Arrangør</h5>
                        <h6>
                            <?php 
                                echo $author->gamertag ?? "";
                            ?>
                        </h6>
                    </div>
                <?php
            }
        ?>
            <div class="event-gaem">
                <?php 
                    if( isset($gameMode->name) ) {
                        ?>
                            <div class="game-mode">
                                <h5>Spil</h5>
                                <h6>
                                    <?php 
                                        echo $gameMode->name ?? "";
                                        // echo (isset($gameMode)) ? "Spilletilstand: " . $gameType->name : "";
                                    ?>
                                </h6>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="right-details">

        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp" tabindex="-1" id="eventParticipantsModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Se hvem du kommer til at træne med.</h2>
            </div>
            <div class="modal-body">
            <h4>Vi fandt <?php echo count($participants) . ' deltagere.' ?></h4>
            <?php 
                foreach($participants as $participant) {
                    ?>
                        <div class="participant">
                            <div class="name">
                                <?php echo $participant->name ?? ''; ?>
                            </div>
                            <div class="gamertag">
                                <?php echo $participant->gamertag ?? ''; ?>
                            </div>
                        </div>
                    <?php
                }
            ?>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp" id="eventParticipateModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tilmelding: <?php echo $event->title ?? $event->name; ?></h2>
            </div>
            <div class="modal-body">
                <h4>Tilmeld dig ved at udfylde formularen nedenfor</h4>
                <form action="#">
                    <input type="hidden" name="event" value="<?php echo $event->id; ?>">
                    <input type="hidden" name="type" value="<?php  echo $_GET["type"]?>">
                    <div class="form-group email-field">
                        <label for="participant-name">E-mail: <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="participant-email" 
                            value="<?php echo $member->email ?? ""; ?>"
                            required>
                            <div class="error-msg"></div>
                    </div>

                    <div class="form-group gamertag-field">
                    <label for="participant-gamertag">Gamertag: <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="participant-gamertag" 
                            value="<?php echo $member->gamertag ?? ""; ?>"
                            required>
                            <div class="error-msg"></div>
                    </div>

                    <div class="response">
                        <div class="error-msg"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <button class="btn btn-success event-participate-btn">Deltag</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp" id="eventUnparticipantModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                Afmelding: <?php echo $event->title ?? $event->name; ?>
            </div>
            <div class="modal-body">
                <h2>Er du sikker?</h2>
                <p>Er du sikker på du vil afmelde dig denne begienvehd?</p>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <button 
                    class="btn btn-success event-unparticipate-btn" 
                    data-event="<?php echo $event->id; ?>" 
                    data-type="<?php echo $_GET["type"]; ?>"
                    data-member="<?php echo $member->id ?? 0; ?>"
                >
                    Afmeld
                </button>
            </div>
        </div>
    </div>
</div>

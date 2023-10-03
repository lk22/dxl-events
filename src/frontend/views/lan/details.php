<div class="container-fluid event lan-event h-100"">
    <div class="row event-header p-5 align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-8 text-white">
                    <div class="row title mb-0">
                        <h1 class="text-white display-5 fw-bold"><?php echo strtoupper($event->title); ?></h1>
                    </div>

                    <div class="row meta">
                        <div class="col-12 location">
                            <p class="lead text-white fw-bold">
                                <strong>Lokation: </strong> <?php echo $settings->event_location; ?>
                            </p>
                        </div>
                        <div class="col-12 start-date">
                            <p><strong>Start dato:</strong> <?php echo date("j F Y", $event->start); ?></p>
                        </div>
                        <div class="col-12 end-date">
                            <p><strong>Slut dato:</strong> <?php echo date("j F Y", $event->end); ?></p>
                        </div>
                        <div class="participation-start meta__field">
                        <p>
                            <strong>Tilmelding åbner:</strong> <?php echo date("j F Y", $settings->participation_opening_date); ?>
                        </p>
                    </div>
                    <div class="latest-participation-date meta__field">
                        <p>
                            <strong>Seneste tilmeldings frist:</strong> <?php echo date("j F Y", $settings->latest_participation_date); ?>
                        </p>
                    </div>
                    </div>
                    <?php 
                        if ( ! strtotime("today") <= $settings->latest_participation_date ) {
                            ?>
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
                            <?php
                        } else {
                            ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-success modal-button" data-bs-toggle="modal" data-bs-target="#lanEventParticipantsModal">Deltagerliste</button>
                                        <?php
                                            if ( $participated ) {
                                                ?>
                                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#lanUnparticipateModal">Afmeld</button>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
                <?php 
                    if ( strtotime('today') > $settings->latest_participation_date ) {
                        ?>
                            <div class="col-lg-4 col-xl-4 mt-3 mt-lg-0 mt-xl-0 mt-xxl-0">
                                <div class="alert alert-primary">
                                    <p class="lead text-center mb-0 fw-bold">Der er lukket for tilmelding</p>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="container py-5 px-4 mb-5 overflow-hidden rounded rounded-md">
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
        <div class="row tournaments my-0">
            <div class="col-12 col-xl-7 p-5 rounded rounded-md">
            <div class="descriptions info-field mb-5">
                <h2>Beskrivelse</h2>
                <?php 
                    echo str_replace("\\", "\n", $event->description);
                ?>
            </div>
    
            <div class="extra-information info-field mb-5">
                <h2>Huskeliste</h2>
                <p>
                    <?php echo str_replace("\\", "\n", $event->extra_description); ?>
                </p>
            </div>
            
            <div class="event-food-details info-field">
                <h4>Mad priser</h4>
                <?php 

                    if( 
                        $settings->breakfast_friday_price !== "0" || 
                        $settings->breakfast_saturday_price !== "0" || 
                        $settings->breakfast_sunday_price !== "0" ||
                        $settings->lunch_saturday_price !== "0" ||
                        $settings->dinner_saturday_price !== "0"
                    ) {
                        ?>
                            <ul class="food-list">
                                <?php 

                                    // check friday dinner is enabled
                                    if ( $settings->breakfast_friday_price !== "0" ) {
                                        ?>
                                            <li>
                                                <p>
                                                    <span class="fw-bold">Aftensmad fredag:</span> <?php echo $settings->breakfast_friday_price; ?> kr.
                                                </p>
                                            </li>
                                        <?php
                                    }

                                    // check saturday breakfast is enabled
                                    if ( $settings->breakfast_saturday_price !== "0" ) {
                                        ?>
                                            <li>
                                                <p>
                                                    <span class="fw-bold">Morgenmad lørdag:</span> <?php echo $settings->breakfast_saturday_price; ?> kr.
                                                </p>
                                            </li>
                                        <?php
                                    }

                                    // check saturday lunch is enabled
                                    if ( $settings->lunch_saturday_price !== "0" ) {
                                        ?>
                                            <li>
                                                <p>
                                                    <span class="fw-bold">Frokost lørdag:</span> <?php echo $settings->lunch_saturday_price; ?> kr.
                                                </p>
                                            </li>
                                        <?php
                                    }

                                    // check saturday dinner is enabled
                                    if ( $settings->dinner_saturday_price !== "0" ) {
                                        ?>
                                            <li>
                                                <p>
                                                <span class="fw-bold">Aftensmad lørdag:</span> <?php echo $settings->dinner_saturday_price; ?> kr.
                                            </p>
                                            </li>
                                        <?php
                                    }

                                    // check sunday breakfast is enabled
                                    if ( $settings->breakfast_sunday_price !== "0" ) {
                                        ?>
                                            <li>
                                                <p>
                                                    <span class="fw-bold">Morgenmad søndag:</span> <?php echo $settings->breakfast_sunday_price; ?> kr.
                                                </p>
                                            </li>
                                        <?php
                                    }
                                ?>
                            </ul>
                            <?php 
                                if ( $participated ) {
                                    if (!$hasOrderedFood) {
                                        ?>
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#lanFoodOrderingModal">Tilføj mad bestilling</button>
                                        <?php
                                    } else {
                                        ?>
                                            <p class="lead mb-0 fw-bold">Din mad bestilling</p>
                                            <small>Dine madvalg</small>
                                            <ul>    
                                                <?php
                                                    echo ($participant->has_friday_lunch == "1") ? "<li><strong>Aftensmad(fredag)</strong></li>" : "";
                                                    echo ($participant->has_saturday_breakfast == "1") ? "<li><strong>Morgenmad (Lørdag)</strong></li>" : "";
                                                    echo ($participant->has_saturday_lunch == "1") ? "<li><strong>Frokost (Lørdag)</strong></li>" : "";
                                                    echo ($participant->has_saturday_dinner == "1") ? "<li><strong>Aftensmad (Lørdag)</strong></li>" : "";
                                                    echo ($participant->has_sunday_breakfast == "1") ? "<li><strong>Morgenmad (Søndag)</strong></li>" : "";
                                                ?>
                                            </ul>
                                        <?php
                                    }
                                }
                            ?>
                        <?php
                    } else {
                        ?>
                            <p class="lead fw-bold mb-0">Mad bestilling kommer snart</p>
                            <p class="lead">Du vil hurtigst muligt vide besked når du kan bestille mad</p>
                        <?php
                    }

                    if ( $participated && $event->has_timeplan ) {
                        ?>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lanTimeplanModal">
                                <i class="fas fa-calendar-alt"></i> Se tidsplan
                            </button>
                        <?php
                    }
                ?>
            </div>
            </div>
            <div class="col-12 col-xl-5 p-4 rounded rounded-md">
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
                                        <p>Starter D. <?php echo date("d F", $tournament->start);?> - <?php echo date("H:i", $tournament->starttime); ?></p>
                                    </div>
                                    <div class="tournament__meta--field">
                                        <button
                                            class="btn btn-success tournament-button" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#lanTournamentModal"
                                            data-member="<?php echo $participant->member_id ?? "0"; ?>"
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
                                    <div class="participant-name lead fw-bold">
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
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <?php 
                    if( $participated ) {
                        ?>
                            <button
                                class="bulk-participate-tournament-btn btn btn-success"
                                data-member="<?php echo $member->user_id; ?>"
                                data-event="<?php echo $event->id; ?>"
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
                            <textarea required class="form-control unparticipate-message" placeholder="Noget vi særligt skal være opmærksom på?" name="participant-message"  id="floatingTextarea2 participant-message" style="height: 300px"></textarea>
                            <label for="floatingTextarea2">Udfyld besked</label>
                        </div>
                    </form>
                </div>
                <div class="unparticipated" style="display:none;">
                    <h3 class="text-left text-success">
                        Du er nu afmeldt <?php echo $event->title; ?>
                    </h3>
                    <p>Du modtager en mail med din afmeldelses bekræftelse inden for kort tid.</p>
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

<div class="modal modal-lg fade fadeInUp" id="lanFoodOrderingModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ønsker du at bestille mad til <?php echo $event->title; ?> ?</h2>
            </div>
            <div class="modal-body">
                <p class="lead">Vælg dine mad ønsker udfra listen nedenfor</p>
                <ul class="list-group food-list-group">
                    <?php 
                        if ( $settings->breakfast_friday_price !== "0" ) {
                            ?>
                                <li class="list-group-item food-item">
                                    <label class="form-check-label" for="friday-dinner-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-1"
                                            value=""
                                            id="has_friday_breakfast"
                                        >
                                        <strong>Aftensmad fredag</strong> - <?php echo $settings->breakfast_friday_price; ?> kr.
                                    </label>
                                </li>
                            <?php
                        }

                        if ( $settings->breakfast_saturday_price !== "0" ) {
                            ?>
                                <li class="list-group-item food-item">
                                    <label class="form-check-label" for="saturday-breakfast-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-1"
                                            value=""
                                            id="has_saturday_breakfast"
                                        >
                                        <strong>Morgenmad Lørdag</strong> - <?php echo $settings->breakfast_saturday_price; ?> kr.
                                    </label>
                                </li>
                            <?php
                        }
                        if ( $settings->lunch_saturday_price !== "0" ) {
                            ?>
                                <li class="list-group-item food-item">
                                    <label class="form-check-label" for="saturday-lunch-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-1"
                                            value=""
                                            id="has_saturday_lunch"
                                        >
                                        <strong>Frokost Lørdag</strong> - <?php echo $settings->lunch_saturday_price; ?> kr.
                                    </label>
                                </li>
                            <?php
                        }
                        if ( $settings->dinner_saturday_price !== "0" ) {
                            ?>
                                <li class="list-group-item food-item">
                                    <label class="form-check-label" for="saturday-dinner-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-1"
                                            value=""
                                            id="has_saturday_dinner"
                                        >
                                    <strong>Aftensmad Lørdag</strong> - <?php echo $settings->dinner_saturday_price; ?> kr.
                                    </label>
                                </li>
                            <?php
                        }
                        if ( $settings->breakfast_sunday_price !== "0" ) {
                            ?>
                                <li class="list-group-item food-item">
                                    <label class="form-check-label" for="sunday-breakfast-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-1"
                                            value=""
                                            id="has_sunday_breakfast"
                                            data-type="has_sunday_breakfast"
                                        >
                                        <strong>Morgenmad Søndag</strong> - <?php echo $settings->breakfast_sunday_price; ?> kr.
                                    </label>
                                </li>
                            <?php
                        }
                    ?>
                </ul>
                <div class="mb-3">
                    <label for="" class="form-label heading-size-4">
                        <small class="mb-0"><strong>Bestilling af mad til ledsager?</strong></small>
                        <input type="checkbox" name="food-order-companion" id="food-order-companion"><br>
                        <small><strong>Nogle særlig allergener der skal tages hensyn til?</strong></small>
                    </label>
                    <textarea class="form-control" name="foodOrderNote" id="foodOrderNote" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
                <button
                    class="accept-food-ordering-btn"
                    data-member="<?php echo $member->id; ?>"
                    data-event="<?php echo $event->id; ?>"
                >Tilføj</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl fade fadeInUp" id="lanTimeplanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tidsplan for <?php echo $event->title; ?>
                </h5>
            </div>
            <div class="modal-body">
                <!-- make me a accordion with 3 items for each day in the timeplan -->
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item mb-4">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Fredag
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <?php
                            // TODO: make me a accordion with 3 items for each day in the timeplan
                            foreach ($timeplanContent->friday as $timeplanItem ) {
                                ?>
                                    <div class="timeplan-item d-flex row my-2">
                                        <div class="timeplan-item-start col-6">
                                            <strong><?php echo $timeplanItem->start; ?> - <?php echo $timeplanItem->end ?></strong>
                                        </div>
                                        <div class="timeplan-item-desc col-6">
                                            <?php echo $timeplanItem->description; ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item mb-4">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Lørdag
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <?php
                            foreach ( $timeplanContent->saturday as $timeplanItem ) {
                                ?>
                                    <div class="timeplan-item d-flex row my-2">
                                        <div class="col-6 timeplan-item-start">
                                        <strong><?php echo $timeplanItem->start; ?> - <?php echo $timeplanItem->end ?></strong>
                                        </div>
                                        <div class="timeplan-item-desc col-6">
                                            <?php echo $timeplanItem->description; ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item mb-4">
                    <h2 class="accordion-header" id="headingThree">
                      <button class="accordion-button text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Søndag
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <?php 
                            foreach ( $timeplanContent->sunday as $timeplanItem ) {
                                ?>
                                    <div class="timeplan-item d-flex row my-2">
                                        <div class="timeplan-item-start col-6">
                                        <strong><?php echo $timeplanItem->start; ?> - <?php echo $timeplanItem->end ?></strong>
                                        </div>
                                        <div class="timeplan-item-desc col-6">
                                            <?php echo $timeplanItem->description; ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                      </div>
                    </div>
                  </div>
                  
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="close-modal btn btn-success" data-bs-dismiss="modal">Luk</button>
            </div>
        </div>
    </div>
</div>
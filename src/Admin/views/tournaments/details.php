<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <p class="lead fw-bold"><?php echo $tournament->title; ?> (<?php echo $type; ?><?php if ($tournament->is_team_tournament == 1){echo " - Hold turnering";} ?>)</p>
        <div class="actions">
            <?php
                // show held button if tournament is not held
                if ( ! $tournament->is_held ) {
                    ?>
                        <button
                            class="button-primary isheld-tournament-btn"
                            data-isheld="0"
                            data-tournament="<?php echo $tournament->id; ?>"
                        >
                            Er turneringen afholdt ?
                        </button>
                    <?php
                }
                
                // show draft button if tournament is not a draft
                if( $tournament->is_draft ) {
                    ?>
                        <button 
                            class="button-primary publish-tournament-btn"
                            data-draft="1"
                            data-tournament="<?php echo $tournament->id; ?>"
                        >
                            Offentliggør
                        </button>
                    <?php
                } else {
                    ?>
                        <button
                            class="button-primary publish-tournament-btn"
                            data-draft="0"
                            data-tournament="<?php echo $tournament->id; ?>"
                        >
                            Skjul
                        </button>
                    <?php
                }

            ?>

            <button class="button-primary update-tournament-button" data-bs-toggle="modal" data-bs-target="#updateAdminTournamentModal">
                Opdater
            </button>
        </div>
    </div>
    <div class="content mt-4">
        <div class="tournament-details details flex">
            <div class="row">
                <div class="col-md-4">
                    <div class="alert alert-success rounded is-held-status" style="<?php echo ($tournament->is_held) ? "display:block" : "display:none" ?>">
                        <?php 
                            if ( $tournament->is_held ) {
                                echo "Turneringen er afholdt";
                            }
                        ?>
                    </div>
                    <h4>Start dato</h4>
                    <p class="lead"><?php echo date("d-m-Y", $tournament->start); ?></p>
                    <h4>Slut dato</h4>
                    <p class="lead"><?php echo date("d-m-Y", $tournament->end); ?></p>
                    <h4>Start tidspunkt</h4>
                    <p class="lead"><?php echo date("H:s", $tournament->starttime); ?></p>
                    <h4>Slut tidspunkt</h4>
                    <p class="lead"><?php echo date("H:s", $tournament->endtime); ?></p>
                </div>
                <div class="col-md-8">

                    <p class="lead fw-bold">Extra turnerings informationer</p>
                    <p class="lead fw-bold">Beskrivelse</p>
                    <p class="tournament-description">
                        <?php echo (strlen($tournament->description)) ? $tournament->description : "<div class='status-label warning description-label'>Ingen beskrivelse</div>"; ?>
                    </p>
                    <button class="button-primary update-description-btn modal-button" data-bs-toggle="modal" data-bs-target="#tournamentDescriptionModal">Opdater</button>
                    <div class="divider"></div>
                    <?php 
                        // show game field
                        if( count($games) ) {
                            ?>
                                <form action="#" class="attachGameForm">
                                    <p class="lead">Vælg spil</p>
                                    <select name="game-field" id="game-field">
                                        <?php
                                        if ( $attachedGame ) {
                                            ?>
                                                <option value="<?php echo $attachedGame->id; ?>"><?php echo $attachedGame->name; ?></option>
                                            <?php
                                        }
                                        if( $games > 0 ) {
                                            foreach($games as $game) {
                                                ?>
                                                    <option value="<?php echo $game->id; ?>"><?php echo $game->name ?? "" ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="divider"></div>
                                    <div>
                                        <select class="hidden" name="game-mode" id="game-mode"></select>
                                    </div>
                                    <small>Valgt spilletilstand: <?php echo $attachedGameMode->name ?></small>
                                    <div class="divider"></div>
                                    <div>
                                        <button class="attachGameButton button-primary" data-tournament="<?php echo $tournament->id; ?>">Opdater</button>
                                    </div>
                                    <div class="divider"></div>
                                </form>
                            <?php
                        } else {
                            ?>
                                <div class="status-label danger">Der er ikke oprettet nogle LAN begivenheder</div>
                            <?php
                        }
        
                        // if there exists any lan events show them in a select field
                        if( $tournament->has_lan ) {
                            if( count($lan)) {
                                ?>
                                    <h3>Vælg LAN begivenhed</h3>
                                    <form action="#">
                                        <select name="lan-event" id="lan-event">
                                            <?php 
                                                foreach($lan as $l) {
                                                    ?>
                                                        <option value="<?php echo $l->id; ?>"><?php echo $l->title; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
        
                                        <button class="button-primary attach-event-btn" data-tournament="<?php echo $tournament->id ?>">Tilknyt</button>
                                    </form>
                                    <div class="divider"></div>
                                <?php
                            } else {
                                ?>
                                    <div class="status-label danger">Der er ikke oprettet nogle LAN begivenheder</div>
                                    <div class="divider"></div>
                                <?php
                            }
                        }

                        /**
                         * show options for team tournaments
                         */
                        /*if ( $tournament->is_team_tournament ) {
                            ?>
                                <p class="lead fw-bold">
                                    Angiv max størrelse pr hold
                                </p>
                                <input type="number" class="form-control w-25" name="max-team-size" id="max-team-size" value="<?php echo $settings->max_team_size ?? 0; ?>">
                                <button class="button-primary mt-2 set-team-size-btn" data-tournament="<?php echo $tournament->id; ?>">Sæt hold størrelse</button>
                            <?php
                        }*/
                    ?>
                <div class="col-md-12">
                    <?php require dirname(__FILE__) . "/partials/tournament-participants.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp modal-open" id="tournamentDescriptionModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Udfyld beskrivelse</h2>
            </div>
            <div class="modal-body">
                <form action="#" class="tournamentDescriptionForm">
                    <div class="form-group">
                        <?php
                            wp_editor((!empty($tournament->description) ? $tournament->description : ''), 'tournament-description', [
                                "textarea_rows" => 100,
                                "height" => "100%"
                            ]);
                        ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button class="button-primary update-tournament-description-btn" data-tournament="<?php echo $tournament->id; ?>" data-action="bulk-update-description">Opdater <span class="dashicons dashicons-edit"></span></button>
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk <span class="dashicons dashicons-no"></span></button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade fadeInUp modal-open" id="updateAdminTournamentModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Opdater informationer på: <?php echo $tournament->title ?></h2>
            </div>
            <div class="modal-body">
                <form action="#" class="tournamentDescriptionForm">
                    <div class="form-group">
                        <label for="">Titel</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $tournament->title; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Start dato</label>
                        <input type="date" class="form-control" name="start" id="start-date" value="<?php echo $tournament->start; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Slut dato</label>
                        <input type="date" class="form-control" name="end" id="end-date" value="<?php echo $tournament->end; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Start tidspunkt</label>
                        <input type="time" class="form-control" name="starttime" id="start-time" value="<?php echo $tournament->starttime; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Slut tidspunkt</label>
                        <input type="time" class="form-control" name="endtime" id="start-time" value="<?php echo $tournament->endtime; ?>">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                 <button class="button-primary update-tournament-btn mr-4" data-tournament="<?php echo $tournament->id; ?>" data-action="bulk-update-description">Opdater <span class="dashicons dashicons-edit"></span></button>
                <button class="button-primary ml-4 close-modal" data-bs-dismiss="modal">Luk <span class="dashicons dashicons-no"></span></button>
            </div>
        </div>
    </div>
</div>
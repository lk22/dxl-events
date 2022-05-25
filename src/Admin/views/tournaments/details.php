<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1><?php echo $tournament->title; ?> (<?php echo $type; ?>)</h1>
        <div class="actions">
            <?php 
                if( $tournament->is_draft ) {
                    ?>
                        <a href="#" class="button-primary" data-draft="0" data-tournament="<?php echo $tournament->id; ?>">Offentliggør</a>
                    <?php
                } else {
                    ?>
                        <a href="#" class="button-primary" data-draft="1" data-tournament="<?php echo $tournament->id; ?>">Skjul</a>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="content">
        <div class="tournament-details details flex">
            <div class="left-details">
                <h4>Start dato</h4>
                <p><?php echo date("d-m-Y", $tournament->start); ?></p>
                <h4>Slut dato</h4>
                <p><?php echo date("d-m-Y", $tournament->end); ?></p>
                <h4>Start tidspunkt</h4>
                <p><?php echo date("H:s", $tournament->starttime); ?></p>
                <h4>Slut tidspunkt</h4>
                <p><?php echo date("H:s", $tournament->endtime); ?></p>
            </div>
            <div class="right-details">
                <h1>Extra tuernings informationer</h1>
                <h2>Beskrivelse</h2>
                <p class="tournament-description">
                    <?php echo (strlen($tournament->description)) ? $tournament->description : "<div class='status-label warning description-label'>Ingen beskrivelse</div>"; ?>
                </p>
                <button class="button-primary update-description-btn modal-button" data-modal="#tournamentDescriptionModal">Opdater</button>
                <div class="divider"></div>
                <?php 
                    // show game field
                    if( count($games) ) {
                        ?>
                            <form action="#" class="attachGameForm">
                                <h3>Vælg spil</h3>
                                <select name="game-field" id="game-field">
                                    <?php
                                    if( $games > 0 )
                                        foreach($games as $game) {
                                            ?>
                                                <option value="<?php echo $attachedGame->id; ?>"><?php echo $attachedGame->name; ?></option>
                                                <option value="<?php echo $game->id; ?>"><?php echo $game->name ?? "" ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="divider"></div>
                                <div>
                                    <select class="hidden" name="game-mode" id="game-mode"></select>
                                </div>
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
                ?>
            </div>
        </div>
    </div>
</div>

<!-- participant list -->
<div class="modal hidden tournamentDescriptionModal" id="tournamentDescriptionModal" role="dialog">
    <div class="modal-header">
        <h3>Udfyld beskrivelse</h3>
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
        <button class="button-primary close-modal">Luk <span class="dashicons dashicons-no"></span></button>
    </div>
</div>
<div class="overlay hidden"></div>
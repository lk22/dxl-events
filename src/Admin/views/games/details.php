<div class="dxl dxl-events">
        <div class="header">
            <div class="logo">
                <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
            </div>
            <h1><?php echo $game->name ?></h1>
            <div class="actions">
                <a href="<?php echo generate_dxl_subpage_url(['action' => 'list']); ?>" class="button-primary">Gå tilbage</a>
                <a href="#" class="button-primary modal-button" data-modal="#updateTournamentModal">Opdater spil <span class="dashicons dashicons-games"></span></a>
                <a href="#" class="button-primary modal-button" data-modal="#deleteTournamentModal">fjern spil <span class="dashicons dashicons-trash"></span></a>
            </div>
        </div>
        <div class="content">
            <div class="details flex">
                <div class="left-details">
                <h2>Spil type</h2>
                <h4><?php echo $gameType->name ?? ''; ?></h4>
                <h2>Spilletilstand</h2>
                    <?php
                        if( $gameModes ) {
                            ?>
                                <table class="widefat fixed striped gamemodes-list">
                                    <thead>
                                        <th>Navn</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($gameModes as $mode) {
                                                ?>
                                                    <tr data-gamemode="<?php echo $mode->id; ?>">
                                                        <td><p><?php echo $mode->name; ?></p></td>
                                                        <td><button class="button-primary remove-gamemode-btn" data-gamemode="<?php echo $mode->id; ?>">Fjern <span class="dashicons dashicons-post-trash"></span></button></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                        } else {
                            ?>
                                <div class='status-label warning'>Har ingen spilletilstande</div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal updateTournamentModal hidden" id="updateTournamentModal">
    <div class="modal-header">
        <h3>Opdater <?php echo $game->name; ?></h3>
    </div>
    <div class="modal-body">
        <form action="#" class="updateGameForm" style="flex-direction:column;">
            <input type="hidden" name="game" value="<?php echo $game->id ?>">
            <div class="form-group">
                <h3>Angiv spil type</h3>
                <label for="game-type">
                    <input type="text" id="game-type" value="<?php echo $gameType->name ?>">
                </label>
            </div>
            <div class="form-group">
                <!-- todo: add multiple game mode entries -->
                <div class="game-modes-field">
                    <div class="game-mode-row">
                        <h3>Spilletistande</h3>
                        <div class="row" data-game-mode="1" style="margin-bottom: 0.5rem;">
                            <label for="game-mode-1" data-game-mode="1">
                                <b>#1</b>
                                <input type="text" name="game-mode-1" id="game-mode-1" placeholder="Spilletilstand #1" required>
                                <span class="add-game-mode-item dashicons dashicons-plus-alt"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk</button>
        <button class="button-primary update-game-button">Opdater</button>
    </div>
</div>

<div class="modal deleteTournamentModal hidden" id="deleteTournamentModal">
    <div class="modal-header">
        <h3>Er du sikker ?</h3>
    </div>
    <div class="modal-body">
        <p>er du sikker på du vil fjerne dette spil? </p>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk</button>
        <button class="button-primary remove-game-btn" data-game="<?php echo $game->id; ?>">Slet</button>
    </div>
</div>
<div class="overlay hidden"></div>
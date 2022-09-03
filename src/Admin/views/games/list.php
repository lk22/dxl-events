<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>Spil</h1>
        <div class="actions">
            <a href="<?php echo generate_dxl_subpage_url(['action' => 'list', 'types' => true ]); ?>" class="button-primary">Se spil typer<span class="dashicons dashicons-games"></span></a>
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#createGameModal">Opret nyt spil <span class="dashicons dashicons-games"></span></a>
        </div>
    </div>

    <div class="content">
        <div class="games-list list flex-wrap gap-10">
            <?php
                foreach($gameList as $game) {
                    ?>
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-header flex"  style="border-bottom: 1px solid green;">
                                <h3>
                                    <?php 
                                        echo $game["name"];
                                    ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>Game type: <?php echo $game["type"]->name ?? "<div class='status-label warning'>Har ingen spil type</div>"  ?></p>
                                <p>Game modes: </p>
                                <ul>
                                    <?php 
                                    if($game["modes"]) {
                                        foreach( $game["modes"] as $mode ) {
                                            ?>
                                                <li><?php echo $mode->name; ?></li>
                                            <?php
                                        }
                                    } else {
                                        echo "<div class='status-label warning'>Har ingen spiletilstand</div>";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a class="button-primary" href="<?php echo generate_dxl_subpage_url(['action' => 'details', 'id' => $game["id"]]) ?>">Se mere</a>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="createGameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opret nyt spil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Udfyld formularen nedenfor for at oprette et nyt spil </p>
                <p>Spillet kan bruges til håndtering af dine turneringer eller andre events</p>
                <form action="#" class="createGameForm">
                    <div class="form-group">
                        <label for="game-name">
                            Spil titel
                            <input type="text" id="game-name" required>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="game-type">
                            Spil type
                            <select name="game-type" id="game-type">
                                <?php 
                                    foreach($gameTypes as $type) {
                                        ?>
                                            <option value="<?php echo $type->id ?>"><?php echo $type->name; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary create-game-btn">Opret spil</button>
            </div>
        </div>
    </div>
</div>
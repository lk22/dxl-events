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

        <div class="game-lile list d-flex flex-wrap gap-4">
            <?php
                foreach ( $gameList as $game ) {
                    ?>
                        <div class="card rounded w-100">
                            <div class="card-header rounded d-flex">
                                <p class="lead fw-bold">
                                    <?php echo $game["name"]; ?>
                                </p>
                            </div>
                            <div class="card-body">
                                <p class="lead game-type">
                                    <?php echo $game["type"]->name ?? "<div class='badgde badge-warning'>Ingen spil type</div>"; ?>
                                </p>
                                <p class="lead">
                                    Spille tilstand:
                                </p>
                                <?php 
                                    if ( $game["modes"] ) {
                                        ?>
                                            <ul class="play-state-list">
                                                <?php 
                                                    foreach ( $game["modes"] as $mode ) {
                                                      ?>
                                                            <li class="play-state-item"> -
                                                                <?php 
                                                                    echo $mode->name
                                                                ?>
                                                            </li>
                                                      <?php
                                                    }
                                                ?>
                                            </ul>
                                        <?php
                                    } else {
                                        echo "<div class='status-label warning'>Har ingen spiletilstand</div>";
                                    }
                                ?>
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
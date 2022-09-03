<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>Spiltyper</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-bs-toggle="modal" data-bs-target="#createGameTypeModal">Opret ny spiltype <span class="dashicons dashicons-games"></span></a>
        </div>
    </div>

    <div class="content">
        <?php 
            if( $gameTypes ) {
                ?>
                    <table class="widefat fixed striped gametypes-list">
                        <thead>
                            <th>Spiltype</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($gameTypes as $type) {
                                    ?>
                                        <tr data-game-type="<?php echo $type->id ?>">
                                            <td><?php echo $type->name ?></td>
                                            <td><button class="button-primary remove-game-type" data-game-type="<?php echo $type->id ?>">Fjern <span class="dashicons dashicons-trash"></span></button></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
            }
        ?>
    </div>
</div>

<div class="modal fade modal-xl" id="createGameTypeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opret nyt spil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Udfyld formularen nedenfor for at oprette et nyt spil </p>
                <p>Spillet kan bruges til håndtering af dine turneringer eller andre events</p>
                <form action="#" class="createGameTypeForm">
                    <div class="form-group">
                        <label for="game-type">
                            Spil type
                            <input type="text" id="game-type" required>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary create-gametype-btn">Opret spil</button>
            </div>
        </div>
    </div>
</div>

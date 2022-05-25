<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>Spiltyper</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-modal="#createGameTypeModal">Opret ny spiltype <span class="dashicons dashicons-games"></span></a>
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

<div class="modal createGameTypeModal hidden" id="createGameTypeModal">
    <div class="modal-header">
        <h2>Opret ny spiltype</h2>
    </div>
    <div class="modal-body">
        <h3>Opret ny spil type ved at udfylde formularen</h3>
        <form action="#" class="createGameTypeForm">
            <div class="form-group">
                <label for="game-type">
                    Spil ttypeitel
                    <input type="text" id="game-type" required>
                </label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk</button>
        <button class="button-primary create-gametype-btn">Opret spiltype</button>
    </div>
</div>
<div class="overlay hidden"></div>
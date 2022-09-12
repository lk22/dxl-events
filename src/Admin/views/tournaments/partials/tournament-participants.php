<?php
    if ( $participants > 0 ) {
        ?>
            <div class="tournament-participants-list mt-4">
                <h3>Deltagerliste</h3>
                <?php 
                    foreach ( $participants as $participant ) {
                        ?>
                            <div class="participant row mb-2">
                                <div class="name col-md-4">
                                    <p class="lead">Navn:</p>
                                    <?php echo $participant->name ?? "Navn ikke fundet..."; ?>
                                </div>
                                <div class="gamertag col-md-4">
                                    <p class="lead">Gamertag:</p>
                                    <?php echo $participant->gamertag ?? "Gamertag ikke fundet..."; ?>
                                </div>
                                <div class="email col-md-4">
                                    <p class="lead mb-0">E-mail:</p>
                                    <?php echo $participant->email ?? "E-mail ikke fundet..."; ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        <?php
    }
?>
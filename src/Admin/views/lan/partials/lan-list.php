<?php 
    if( $events ) {
        foreach($events as $event) {
            ?>
                <div class="card col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12" style="border-radius: 10px;">
                    <div class="card-header flex">
                        <h3>
                            <?php echo $event->title; ?>
                        </h3>
                        <span>
                            <?php
                                if( $event->is_draft ) {
                                    ?>
                                        <span class="status-label warning">Udkast</span>
                                    <?php
                                }
                            ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="available-seats">
                            <p>Ledige sæder: <span><?php echo $event->seats_available ?> pladser</span></p>
                        </div>
                        <div class="tournaments-count">
                            <p><?php echo $event->tournaments_count; ?> turneringer</p>
                        </div>
                        <div class="participants-count">
                            <p><?php echo $event->participants_count; ?> antal deltagere</p>
                        </div>
                        <div class="start-date">
                            <p>Start dato: <span><?php echo date("d-m-Y", $event->start) ?></span></p>
                        </div>
                        <div class="end-date">
                            <p>Slut dato: <span><?php echo date("d-m-Y", $event->end) ?></span></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo generate_dxl_subpage_url(["action" => "details", "id" => $event->id]); ?>" class="button-primary">Se begivenhed</a>
                    </div>
                </div>
            <?php
        }
    } else {
        ?>
            <div class="status-label danger">Du har ingen registreret begivenheder</div>
        <?php
    }
?>
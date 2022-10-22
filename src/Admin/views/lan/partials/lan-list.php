<?php 
    if( $events ) {
        foreach($events as $event) {
            ?>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 col-xxl-3 mb-4 rounded border-2 ">
                    <div class="card-header flex row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>
                                        <?php echo $event->title; ?>
                                    </h3>
                                </div>
                                <?php 
                                    if( $event->is_draft ) {
                                        ?>
                                            <div class="col-md-6">
                                                <span class="label label-warning">Udkast</span>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
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
<?php 
    if( isset($events["lan"]) && count($events["lan"]) ) {
        ?>
            <div class="row gap-4 mb-4" id="lan">
                <h3 class="fw-bold px-0">LAN begivenheder</h3>
                <?php 
                    foreach ( $events["lan"] as $event ) {
                        ?>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 event-item event-<?php echo $event["type"]; ?>" data-event-type="<?php echo $event["type"]; ?>">
                                <div class="event-title">
                                    <span>
                                        <h4><strong><?php echo $event["title"]; ?></strong></h4>
                                    </span>
                                </div>
                                <div class="event-meta row">
                                    <div class="col-12 startdate">
                                        <p>
                                        <span>
                                            <strong>Starter: </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["startdate"]; ?> - <?php echo $event["starttime"]; ?>
                                        </span>
                                    </p>
                                    </div>
                                    <div class="col-12 enddate">
                                        <p>
                                        <span>
                                            <strong>
                                                Slutter:
                                            </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["enddate"]; ?> - <?php echo $event["endtime"]; ?>
                                        </span>
                                    </p>
                                    </div>
                                    <div class="col-6 available-seats">
                                        <p>
                                        <span>
                                            <strong>
                                                Ledige pladser:
                                            </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["total_seats"]; ?>
                                        </span>
                                        </p>
                                    </div>
                                    <div class="participants-count col-6">
                                    <p>
                                        <span>
                                            <strong>
                                                Antal deltagere:
                                            </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["participants_count"]; ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="tournaments-count col-6">
                                    <p>
                                        <span>
                                            <strong>
                                                Antal turneringer:
                                            </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["tournaments_count"]; ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="participation-date col-6">
                                    <p>
                                        <span>
                                            <strong>
                                                Tilmeldingsfrist:
                                            </strong>
                                        </span>
                                        <span>
                                            <?php echo $event["latest_participation_date"]; ?>
                                        </span>
                                    </p>
                                </div>
                                <a href="<?php echo $event["link"]; ?>" class="btn btn-outline-success">Se begivenhed</a>
                                </div>
                            </div>
                        <?php
                    }
                ?>
                <div class="divider"></div>
            </div>
        <?php 
    }
?>
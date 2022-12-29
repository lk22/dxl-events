<?php 
    // var_dump($events);
?>
<div class="dxl dxl-frontend-events">
    <div class="row">
        <div class="col-12 events-filter-container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-8">
                    <h3>Søg begivenheder</h3>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="row event-filters">
                        <div class="col-4">
                            <label for="event-type-lan">
                                LAN
                                <input type="checkbox" name="event-type" id="event-type-lan" value="LAN" checked>
                            </label>
                        </div>
                        <div class="col-4">
                            <label for="event-type-tournament">
                                Turneringer
                                <input type="checkbox" name="event-type" id="event-type-tournament" value="Turnering" checked>
                            </label>
                        </div>
                        <div class="col-4">
                            <label for="event-type-training">
                                Træning
                                <input type="checkbox" name="event-type" id="event-type-training" value="Træning" checked>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 pt-4">
            <div class="row px-0">
                <?php 
                    if( is_array($events["lan"]) || is_object($events["lan"]) && count($events["lan"]) ) {
                        foreach($events["lan"] as $event) {
                            ?>
                                <div class="col-12 col-md-6 col-lg-4 event-card event-<?php echo $event["type"]; ?>" data-event-type="<?php echo $event["type"]; ?>">
                                    <div class="event-header">
                                        <h4><?php echo $event["title"] ?></h4>
                                    </div>
                                    <div class="event-meta">
                                        <div class="row event-dates">
                                            <div class="col-6 start-date-time">
                                                <p> Starter:
                                                    <?php 
                                                        echo $event["startdate"];
                                                    ?>
                                                    -
                                                    <?php 
                                                        echo $event["starttime"];
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-6 end-date-time">
                                                <p> Slutter: 
                                                    <?php 
                                                        echo $event["enddate"];
                                                    ?>
                                                    -
                                                    <?php 
                                                        echo $event["endtime"]
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row available-seats">
                                            <div class="col-6">
                                                <p>Ledige pladser: <?php echo $event["total_seats"]; ?></p>
                                            </div>
                                        </div>
                                        <div class="row tournaments-count">
                                            <p>Antal turneringer: <?php echo $event["tournaments_count"]; ?> turneringer</p>
                                        </div>
                                        <div class="row participants-count">
                                            <p>Antal deltagere: <?php echo $event["participants_count"]; ?> deltagere</p>
                                        </div>
                                        <div class="row latest-participation_date">
                                            <p>Seneste tilmeldingsfrist: <?php echo $event["latest_participation_date"] ?></p>
                                        </div>
                                    </div>
                                    <div class="event-footer">
                                        <a href="<?php echo $event["link"]; ?>" class="btn btn-primary">Se begivenhed</a>
                                    </div>
                                </div>
                            <?php
                        }
                    }

                    foreach ($events["training"] as $event) {
                        ?>
                            <div class="col-12 col-md-6 col-lg-4 event-card event-<?php echo $event["type"] ?>" data-event-type="<?php echo $event["type"] ?>">
                                <div class="event-header">
                                    <h4><?php echo $event["title"] ?></h4>
                                </div>
                                <div class="event-meta">
                                    <div class="row event-type">
                                        <p>Event type: <?php echo $event["type"] ?></p>
                                    </div>
                                    <div class="row start-date">
                                        <div class="col-6">
                                            <p>Start dato: <?php echo date("d/m/Y", strtotime($event["startdate"])) ?></p>
                                        </div>
                                        <?php 
                                            if ($event["is_recurring"]) {
                                                ?>
                                                    <div class="col-6">
                                                        <p>Hver: <?php echo $event["event_day"] ?></p>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="row participants-count">
                                        <p>Antal deltagere: <?php echo $event["participants_count"] ?></p>
                                    </div>
                                </div>
                                <div class="event-footer">
                                    <a href="<?php echo $event["link"]; ?>" class="btn btn-primary">Se begivenhed</a>
                                </div>
                            </div>
                        <?php 
                    }

                    if( is_array($events["tournaments"]) || is_object($events["tournaments"]) && count($events["tournaments"]) ) {
                        foreach ($events["tournaments"] as $event) {
                            ?>
                                <div class="col-12 col-md-6 col-lg-4 event-card event-<?php echo $event["type"] ?>" data-event-type="<?php echo $event["type"] ?>">
                                    <div class="event-header">
                                        <h4><?php echo $event["title"] ?></h4>
                                    </div>
                                    <div class="event-meta">
                                        <div class="row event-type">
                                            <p>Event type: <?php echo $event["type"] ?></p>
                                        </div>
                                        <div class="row organizer">
                                            <p>Arrangør: <?php echo $event["author"]->user_name; ?></p>
                                        </div>
                                        <div class="row start-date">
                                            <div class="col-6">
                                                <p>Start dato: <?php echo $event["startdate"] ?> - <?php echo $event["starttime"]; ?></p>
                                            </div>
    
                                            <div class="col-6">
                                                <p>Slut dato: <?php echo $event["enddate"] ?> - <?php echo $event["endtime"] ?></p>
                                            </div>
                                        </div>
                                        <div class="row participants-count">
                                            <p>Antal deltagere: <?php echo $event["participants_count"] ?></p>
                                        </div>
                                    </div>
                                    <div class="event-footer">
                                        <a href="<?php echo $event["link"]; ?>" class="btn btn-primary">Se begivenhed</a>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>

            </div>
        </div>
    </div>
</div>

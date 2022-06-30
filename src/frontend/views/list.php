<?php 
    // var_dump($events);
?>
<div class="dxl dxl-frontend-events">
    <div class="sidebar">
        <div class="sidebar__heading">
            <h4>SØG BEGIVENHEDER</h4>
        </div>

        <div class="sidebar__filter--form">
            <form action="#">
                <div class="form-group">
                    <input type="text" name="event-name" class="form-control" placeholder="Angiv begivenheds navn">
                </div>
                <div class="form-group">
                    <p>Begivenheds typer</p>
                    <div class="type">
                        <input type="checkbox" name="type" id="lan-type" value="lan">
                        <label for="lan-type">LAN</label>
                    </div>
                    <div class="type">
                        <input type="checkbox" name="type" id="lan-type" value="training">
                        <label for="lan-type">Træning</label>
                    </div>
                    <div class="type">
                        <input type="checkbox" name="type" id="lan-type" value="tournaments">
                        <label for="lan-type">Turneringer</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="event__list">
        <?php
            foreach($events["lan"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">
                        <div class="event" data-event-type="<?php echo $event["type"]; ?>">
                            <div class="event__datetime">
                                <div class="event__datetime--date">
                                    <p>
                                        <?php echo date("d", $event["startdate"]); ?> - <?php echo date("d F", $event["enddate"]); ?>
                                    </p>
                                </div>
                                <div class="event__datetime--time">
                                    <div class="starttime">
                                        <p>Starter kl. <?php echo date("H:i", $event["starttime"]);?></p>
                                    </div>
                                    <div class="endtime">
                                        <p>Slutter kl. <?php echo date("H:i", $event["endtime"]);?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="event__meta mt-4">
                                <div class="event__meta--title">
                                    <h5 class="heading"><?php echo $event["title"]; ?></h5>
                                    <div class="event__meta--title-tags">
                                        <span class="type"><?php echo $event["type"]?></span>
                                    </div>
                                </div>
                                <div class="event__meta--body">
                                    <div class="event__meta--body__field">
                                        <p><?php echo $event["tournaments_count"]; ?> turneringer</p>
                                    </div>
                                    <div class="event__meta--body__field">
                                        <p><?php echo $event["participants_count"]; ?> deltagere</p>
                                    </div>
                                    <div class="event__meta--body__field">
                                        <p><?php echo $event["available_seats"]; ?> Ledige pladser</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
            }

            foreach($events["training"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">

                        <div class="event" data-event-type="<?php echo $event["type"]; ?>">
                            <div class="event__datetime">
                                <div class="event__datetime--date">
                                    <p>
                                        Hver <?php echo $event["event_day"] ?? ""; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="event__meta mt-4">
                                <div class="event__meta--title">
                                    <h5 class="heading"><?php echo $event["title"]; ?></h5>
                                    <div class="event__meta--title-tags">
                                        <span class="type"><?php echo $event["type"] ?? ""; ?></span>
                                    </div>
                                </div>
                                <div class="event__meta--body">
                                    <div class="event__meta--body__field">
                                        <p><?php echo $event["participants_count"]; ?> deltagere</p>
                                    </div>
                                    <div class="event__meta--body__field">
                                        <p>Starter d. <?php echo $event["startdate"] ?? "";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
            }

            foreach($events["tournaments"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">
                        <div class="event" data-event-type="<?php echo $event["type"]; ?>">
                            <div class="event__datetime">
                                <div class="event__datetime--date">
                                    <p>
                                        <?php echo date("d", $event["startdate"]); ?> - <?php echo date("d F", $event["enddate"]); ?>
                                    </p>
                                </div>
                                <div class="event__datetime--time">
                                    <div class="starttime">
                                        <p>Starter kl. <?php echo $event["starttime"];?></p>
                                    </div>
                                    <div class="endtime">
                                        <p>Slutter kl. <?php echo $event["endtime"];?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="event__meta mt-4">
                                <div class="event__meta--title">
                                    <h5 class="heading"><?php echo $event["title"]; ?></h5>
                                    <div class="event__meta--title-tags">
                                        <span class="type"><?php echo $event["type"]?></span>
                                    </div>
                                </div>
                                <div class="event__meta--body">
                                    <div class="event__meta--body__field">
                                        <p><?php echo $event["participants_count"]; ?> deltagere</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
            }
        ?>
    </div>
    
</div>
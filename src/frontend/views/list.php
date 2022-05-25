<?php 
    // var_dump($events);
?>
<div class="dxl dxl-frontend-events-list-container">
    <h1>DXL EVENTS</h1>
    <div class="events-cards">
        <?php
            foreach($events["lan"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">
                        <div class="card event lan-event">
                            <div class="card-header">
                                <h5>
                                    <?php echo $event["title"]; ?>
                                </h5>
                                <p><?php echo $event["type"]; ?></p>
                            </div>
                            <div class="card-body">
                                <p>
                                    Dato:
                                    <span class="start-date">
                                        <?php echo date("d", $event["startdate"]); ?>
                                    </span> - 
                                    <span class="end-date">
                                        <?php echo date("d F", $event["enddate"]); ?>
                                    </span>
                                </p>
                                
                                <p><?php echo $event["participants_count"]; ?> Deltagere</p>
                            </div>
                        </div>
                    </a>
                <?php
            }

            foreach($events["training"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">
                        <div class="card event training-event">
                            <div class="card-header">
                                <h5>
                                    <?php echo $event["title"]; ?>
                                </h5>
                                <p><?php echo $event["type"]; ?></p>
                            </div>
                            <div class="card-body">
                                <p>
                                    Hver <?php echo $event["event_day"]; ?>
                                </p>
                                <p><?php echo $event["participants_count"]; ?> Deltagere</p>
                            </div>
                        </div>
                    </a>
                <?php
            }

            foreach($events["tournaments"] as $event) {
                ?>
                    <a href="<?php echo $event["link"]; ?>">
                        <div class="card event training-event">
                            <div class="card-header">
                                <h5>
                                    <?php echo $event["title"]; ?>
                                </h5>
                                <p><?php echo $event["type"]; ?></p>
                            </div>
                            <div class="card-body">
                                <p>
                                    Dato:
                                    <span class="start-date">
                                        <?php echo date("d", $event["startdate"]); ?>
                                    </span> - 
                                    <span class="end-date">
                                        <?php echo date("d F", $event["enddate"]); ?>
                                    </span>
                                </p>
                                <p><?php echo $event["participants_count"]; ?> Deltagere</p>
                            </div>
                        </div>
                    </a>
                <?php
            }
        ?>
    </div>
    
</div>
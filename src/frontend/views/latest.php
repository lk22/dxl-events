<?php 
    // var_dump($eventData); die();
?>

<div class="dxl-shortcode latest-events-container">
    <?php
        if( $eventData["lan"] ) {
            foreach($eventData["lan"] as $lan) {
                ?>
                    <div class="event lan">
                        <div class="event-header"><h4><?php echo $lan["title"] ?></h4></div>
                        <div class="event-body">
                            <p>Dato: 
                                <span class="startdate">
                                    <?php echo date("d/m/Y", $lan["startdate"]); ?>
                                </span>
                                - 
                                <span class="enddate">
                                    <?php echo date("d/m/", $lan["enddate"]); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                <?php
            }
        }
        
        if ( isset($eventData["training"] ) ) {
            foreach($eventData["training"] as $training) {
                ?>
                    <div class="event training">
                        <div class="event-header">
                            <h4><?php echo $training["title"]; ?> (Træning)</h4>
                        </div>
                        <div class="event-body">
                            <?php 
                                if( $training["is_recurring"] ) {
                                    ?>
                                        <p>
                                            Hver <?php echo $training["event_day"] ?>
                                            <span class="starttime">
                                                <?php echo date("H", $training["starttime"]); ?>
                                            </span>
                                             - 
                                             <span class="endtime">
                                                 <?php echo date("H", $training["endtime"]); ?>
                                             </span>
                                        </p>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php
            }
        }
    ?>
</div>
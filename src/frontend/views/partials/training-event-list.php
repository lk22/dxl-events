<div class="row gap-4 mb-4" id="training">
  <h3 class="fw-bold px-0">Trænings begivenheder</h3>
  <?php 
    if ( isset($events["training"]) && count($events["training"]) ) {
      foreach ( $events["training"] as $event ) {
        ?>
          <div class="event-item col-12 col-sm-12 col-md-6 col-lg-3 event-<?php echo $event["type"] ?>" data-event-type="<?php echo $event["type"] ?>">
            <div class="event-title">
              <span>
                <h4><?php echo $event["title"]; ?></h4>
              </span>
            </div>
            <div class="event-meta row">
              <div class="event-type col-6">
                <p>
                  <span>
                    <strong>Event type: </strong>
                  </span>
                  <span>
                    <?php echo $event["type"]; ?>
                  </span>
                </p>
              </div>
              <div class="startdate col-6">
                <p>
                  <span>
                    <strong>Start dato: </strong>
                  </span>
                  <span>
                    <?php echo $event["startdate"]; ?>
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
              <a href="<?php echo $event["link"]; ?>" class="btn btn-outline-success">Se begivenhed</a>
            </div>
          </div>
        <?php
      }
    }
  ?>
  <div class="divider"></div>
</div>
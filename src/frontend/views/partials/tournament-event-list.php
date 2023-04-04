<div class="row gap-4">
  <?php 
    if( isset($events["tournaments"]) && count($events["tournaments"]) ) {
      foreach ($events["tournaments"] as $event) {
          ?>
            <div class="event-item col-12 col-sm-12 col-md-6 col-lg-3 event-<?php echo $event["type"] ?>" data-event-type="<?php echo $event["type"] ?>">
              <div class="event-title">
                <span>
                  <h4><?php echo $event["title"]; ?></h4>
                </span>
              </div>
              <div class="event-meta row">
                <div class="event-type">
                  <p>
                    <span>
                      <strong>Event type: </strong>
                    </span>
                    <span><?php echo $event["type"]; ?></span>
                  </p>
                </div>
                <div class="event-organizer">
                  <p>
                    <span>
                      <strong>Arrangør: </strong>
                    </span>
                    <span><?php echo $event["author"]->user_name; ?></span>
                  </p>
                </div>
                <div class="start-date">
                  <p>
                    <span>
                      <strong>Start dato: </strong>
                    </span>
                    <span><?php echo $event["startdate"]; ?> - <?php echo $event["starttime"]; ?></span>
                  </p>
                </div>
                <div class="end-date">
                    <p>
                      <span>
                        <strong>Slut dato: </strong>
                      </span>
                      <span>
                        <?php echo $event["endtime"]; ?>
                      </span>
                    </p>
                </div>
                <div class="participants-count">
                  <p>
                    <span>
                      <strong><?php echo $event["participants_count"]; ?></strong>
                    </span>
                    <span>Deltagere</span>
                  </p>
                </div>
                <div class="float-end">
                  <a href="<?php echo $event["link"]; ?>" class="btn btn-outline-success">Se begivenhed</a>
                </div>
              </div>
            </div>
          <?php
      }
    }
  ?>

</div>

<?php 
  if( isset($events["tournaments"]) && count($events["tournaments"]) ) {
    foreach ($events["tournaments"] as $event) {
        ?>
            <div class="event-item row event-<?php echo $event["type"] ?>" data-event-type="<?php echo $event["type"] ?>">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 image-col">
                    <div class="event-image">
                      <figure>
                          <img src="https://images.unsplash.com/photo-1558008258-3256797b43f3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2662&q=80" alt="">
                      </figure>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 event-card-content">
                  <div class="event-title">
                    <span>
                      <h2><?php echo $event["title"]; ?></h2>
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
                    <div class="organizer col-6">
                      <p>
                        <span>
                          <strong>Arrangør: </strong>
                        </span>
                        <span>
                          <?php echo $event["author"]->user_name; ?>
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
                    <div class="starttime col-6">
                      <p>
                        <span>
                          <strong>Slut dato: </strong>
                        </span>
                        <span>
                          <?php echo $event["enddate"]; ?>
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
                    <div class="float-end">

                      <a href="<?php echo $event["link"]; ?>" class="btn btn-primary">Se begivenhed</a>
                    </div>
                  </div>
                </div>

            </div>
        <?php
    }
  }
?>
<?php 
  foreach ( $events["lan"] as $event ) {
      ?>
          <div class="event-item row event-<?php echo $event["type"]; ?>" data-event-type="<?php echo $event["type"]; ?>">
              <div class="col-12 col-sm-12 col-md-12 col-lg-4 image-col">
                  <div class="event-image">
                      <figure>
                          <!--<img src="<?php echo $event["image"] ?>" alt="">-->
                          <img src="https://images.unsplash.com/photo-1558008258-3256797b43f3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2662&q=80 alt="">
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
                      <div class="startdate col-6">
                          <p>
                              <span>
                                  <strong>Starter: </strong>
                              </span>
                              <span>
                                  <?php echo $event["startdate"]; ?> - <?php echo $event["starttime"]; ?>
                              </span>
                          </p>
                      </div>
                      <div class="enddate col-6">
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
                      <div class="available-seats col-6">
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
                      <div class="float-end">
                          <a href="<?php echo $event["link"]; ?>" class="btn btn-outline-success float-end">Se begivenhed</a>
                      </div>
                  </div>
              </div>
          </div>
      <?php
  }
?>
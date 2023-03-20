<div class="modal modal-lg fade fadeInUp" id="updateTimeplanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Opdater tidsplan for <?php echo $event->title; ?>
                </h5>
            </div>
            <div class="modal-body">
                <form action="#" class="event-timeplan-form">
                  <div class="accordion accordion-flush" id="eventTimeplanAccordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="timepplan-friday-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#timeplan-friday" aria-expanded="true" aria-controls="timepplan-friday">
                          Fredag:
                        </button>
                      </h2>
                      <div id="timeplan-friday" class="accordion-collapse collapse" aria-labelledby="timepplan-friday-heading" data-bs-parent="#eventTimeplanAccordion">
                        <div class="item-wrapper my-4">
                        <?php 
                          foreach($timeplan->friday as $pi => $planItem) {
                            ?>
                              <div class="form-group row timeplan-item" data-plan-item="<?php echo $pi ?>">
                                <div class="col-4">
                                  <label for="event-timeplan-start-time">Start tid:</label>
                                  <input type="time" name="friday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control" value="<?php echo $planItem->start ?>">
                                </div>
                                <div class="col-8">
                                  <label for="event-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                                  <input 
                                    type="text" 
                                    name="friday-timeplan-event[]" 
                                    id="" 
                                    value="<?php echo $planItem->description ?>"
                                  >
                                  <span class='dashicons dashicons-no remove-timeplan-item' data-item="<?php echo $pi ?>"></span>
                                </div>
                              </div>
                            <?php
                          }
                        ?>
                        </div>
                        <button class="button-primary add-plan-item mb-3" data-timeplan-day="friday">Tilføj</button>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="timeplan-saturday-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#timeplan-saturday" aria-expanded="false" aria-controls="timeplan-saturday">
                          Lørdag:
                        </button>
                      </h2>
                      <div id="timeplan-saturday" class="accordion-collapse collapse" aria-labelledby="timeplan-saturday-heading" data-bs-parent="#eventTimeplanAccordion">
                        <div class="item-wrapper my-4">
                          <?php 
                            foreach ($timeplan->saturday as $pi => $planItem) {
                              ?>
                                <div class="form-group row timeplan-item" data-plan-item="<?php echo $pi ?>">
                                  <div class="col-4">
                                    <label for="event-timeplan-start-time">Start tid:</label>
                                    <input type="time" name="saturday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control" value="<?php echo $planItem->start ?>">
                                  </div>
                                  <div class="col-8">
                                    <label for="event-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                                    <input 
                                      type="text" 
                                      name="saturday-timeplan-event[]" 
                                      id="" 
                                      value="<?php echo $planItem->description ?>"
                                    >
                                    <span class='dashicons dashicons-no remove-timeplan-item' data-item="<?php echo $pi ?>"></span>
                                  </div>
                                </div>
                              <?php
                            }
                          ?>
                        </div>
                        <button class="button-primary add-plan-item mb-3" data-timeplan-day="saturday">Tilføj</button>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="timeplan-sunday-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#timeplan-sunday" aria-expanded="false" aria-controls="timeplan-sunday-heading">
                          Søndag:
                        </button>
                      </h2>
                      <div id="timeplan-sunday" class="accordion-collapse collapse" aria-labelledby="timeplan-sunday-heading" data-bs-parent="#eventTimeplanAccordion">
                        <div class="item-wrapper my-4">
                          <?php 
                            foreach ($timeplan->sunday as $pi => $planItem) {
                              ?>
                                <div class="form-group row timeplan-item" data-plan-item="<?php echo $pi ?>">
                                  <div class="col-4">
                                    <label for="event-timeplan-start-time">Start tid:</label>
                                    <input type="time" name="sunday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control" value="<?php echo $planItem->start ?>">
                                  </div>
                                  <div class="col-8">
                                    <label for="sunday-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                                    <input 
                                      type="text" 
                                      name="sunday-timeplan-event[]" 
                                      id="sunday-timeplan-event"
                                      value="<?php echo $planItem->description ?>"
                                    >
                                    <span class='dashicons dashicons-no remove-timeplan-item' data-item="<?php echo $pi ?>"></span>
                                  </div>
                                </div>
                              <?php
                            }
                          ?>
                          </div>
                          <button class="button-primary add-plan-item mb-3" data-timeplan-day="sunday">Tilføj</button>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer gap-2">
              <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
              <button class="button-primary" data-bs-toggle="modal" data-bs-target="#confirmPublishTimeplanModal">Offentliggør tidsplan <span class="dashicons dashicons-calendar"></span></button>
              <button class="button-primary timeplan-button update-event-timeplan-button" data-action="update" data-event="<?php echo $event->id ?>">Opdater tidsplan <span class="dashicons dashicons-calendar"></span></button>
              <button class="button-primary" data-bs-toggle="modal" data-bs-target="#deleteTimeplanModal">Slet tidsplan <span class="dashicons dashicons-no"></span></button>
            </div>
          </div>
        </div>
      </div>
      
<div class="modal modal-lg fade fadeInUp" id="deleteTimeplanModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Slet tidsplan for <?php echo $event->title; ?>
        </h5>
      </div>
      <div class="modal-body">
        <p class="lead">Er du sikker på at du vil slette tidsplanen for <?php echo $event->title; ?>?</p>
      </div>
      <div class="modal-footer gap-2">
        <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
        <button class="button-primary timeplan-button delete-event-timeplan-button" data-action="delete" data-event="<?php echo $event->id ?>">Slet tidsplan <span class="dashicons dashicons-no"></span></button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade fadeInUp" id="confirmPublishTimeplanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Opdater tidsplan for <?php echo $event->title; ?>
                </h5>
            </div>
            <div class="modal-body">
                <p class="lead">Ønsker du og sende tidsplanen til alle deltagere via mail?</p>
            </div>
            <div class="modal-footer gap-2">
              <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
              <?php 
                if ( $timeplanIsDraft ) {
                  ?>
                    <button class="button-primary confirm-publish-timeplan-button" data-action="publish" data-event="<?php echo $event->id ?>">Offentliggør <span class="dashicons dashicons-calendar"></span></button>
                    <button class="button-primary confirm-publish-timeplan-button" data-action="sendAndPublish" data-event="<?php echo $event->id ?>">Send og offentliggør tidsplan <span class="dashicons dashicons-calendar"></span></button>
                  <?php
                } else {
                  ?>
                    <button class="button-primary confirm-publish-timeplan-button" data-action="send" data-event="<?php echo $event->id ?>">Send tidsplan <span class="dashicons dashicons-calendar"></span></button>
                  <?php
                }
              ?>
            </div>
        </div>
    </div>
</div>
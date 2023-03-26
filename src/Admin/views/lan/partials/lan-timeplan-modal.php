<div class="modal modal-lg fade fadeInUp" id="createTimeplanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Udfyld tidsplan for <?php echo $event->title; ?>
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
                          <div class="form-group row timeplan-item" data-plan-item="0">
                            <div class="col-2">
                              <label for="event-timeplan-start-time">Start tid:</label>
                              <input type="time" name="friday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control">
                            </div>
                            <div class="col-2">
                              <label for="event-timeplan-end-time">Slut tid</label>
                              <input type="time" name="friday-timeplan-end-time[]" id="event-timeplan-end-time" class="form-control">
                            </div>
                            <div class="col-8">
                              <label for="event-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                              <input 
                                type="text" 
                                name="friday-timeplan-event[]" 
                                id="" 
                              >
                            </div>
                          </div>
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
                          <div class="form-group row timeplan-item" data-plan-item="0">
                            <div class="col-2">
                              <label for="event-timeplan-start-time">Start tid:</label>
                              <input type="time" name="saturday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control">
                            </div>
                            <div class="col-2">
                              <label for="event-timeplan-end-time">Slut tid:</label>
                              <input type="time" name="saturday-timeplan-end-time[]" id="event-timeplan-end-time" class="form-control">
                            </div>
                            <div class="col-8">
                              <label for="event-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                              <input 
                                type="text" 
                                name="saturday-timeplan-event[]" 
                                id="" 
                              >
                            </div>
                          </div>
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
                          <div class="form-group row timeplan-item" data-plan-item="0">
                              <div class="col-2">
                                <label for="event-timeplan-start-time">Start tid:</label>
                                <input type="time" name="sunday-timeplan-start-time[]" id="event-timeplan-start-time" class="form-control">
                              </div>
                              <div class="col-2">
                                <label for="event-timeplan-end-time">Slut tid:</label>
                                <input type="time" name="sunday-timeplan-end-time[]" id="event-timeplan-end-time" class="form-control">
                              </div>
                              <div class="col-8">
                                <label for="sunday-timeplan-description" class="event-timeplan-description">Hvad skald der ske?</label>
                                <input 
                                  type="text" 
                                  name="sunday-timeplan-event[]" 
                                  id="sunday-timeplan-event"
                                >
                              </div>
                            </div>
                          </div>
                          <button class="button-primary add-plan-item mb-3" data-timeplan-day="sunday">Tilføj</button>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- create success message -->
                <div class="alert alert-success alert-dismissible fade show timeplan-complete d-none" role="alert">
                  <strong>Tidsplan oprettet!</strong> Du kan nu se tidsplanen på LAN siden.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="modal-footer gap-2">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary timeplan-button create-event-timeplan-button" data-action="create" data-event="<?php echo $event->id ?>">Udfyld tidsplan <span class="dashicons dashicons-calendar"></span></button>
            </div>
        </div>
    </div>
</div>
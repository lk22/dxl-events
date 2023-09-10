<?php 
  /**
   * Details view for specific calendar event 
   * @package DXL Events
   */
?>

<div class="dxl">
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col-12 event-name-column">
          <h2 class="fw-bold event-name"><?php echo $event->event_name; ?></h2>
          <?php 
            if ( $event->is_completed ) {
              ?>
                <span class="completed-status">
                  (Denne opgave er udført)
                </span>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p class="fw-bold">Beskrivelse</p>
          <p class="lead event-description">
            <?php echo $event->description; ?>
          </p>
        </div>
        <div class="col-12 mt-4">
          <p class="event-year"><strong>Årstal for opgave: </strong><span><?php echo $event->event_year; ?></span></p>
          <p class="event-date my-2"><strong>Begivenheds dato:</strong> <span class="event-date-value"><?php echo $event->event_date; ?></span></p>
          <div class="event-deadline my-2"><strong>Deadline: </strong><span class="event-deadline-value"><?php echo $event->event_deadline; ?></span></div>
          <?php
            if ( $event->created_at ) {
              ?>
                <div class="event-created-at my-2"><strong>Opgave Oprettet d.: </strong><span class="event-created-at-value"><?php echo $created_at ?></span></div>
              <?php
            }
            if ( $event->updated_at ) {
              ?>
                <div class="event-updated-at my-2"><strong>Opgave Opdateret d.: </strong><span class="event-updated-at-value"><?php echo $updated_at ?></span></div>
              <?php
            }

            if ( $event->completed_at ) {
              ?>
                <div class="event-completed-at my-2"><strong>Opgave Fuldført d.: </strong><span class="event-completed-at-value"><?php echo $completed_at ?></span></div>
              <?php
            }

            if ( $event->is_archived && $event->archived_at ) {
              ?>
                <div class="event-archived-at my-2">
                  <strong>
                    Opgave arkiveret d.:
                  </strong>
                  <span class="event-archived-at-value"><?php echo $archived_at ?></span>
                </div>
              <?php
            }

          ?>
        </div>
        <div class="col-12 mt-4">
          <div class="actions">
            <?php 
            if ( ! $event->is_completed ) {
              ?>
                <button
                  class="button-primary complete-calendar-event-btn"
                  data-event="<?php echo $event->id ?>"
                >
                  Færdiggør opgave
                </button>
                <button
                  class="button-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#updateCalendarEventModal"
                >
                  Opdater
                </button>
              <?php
            }
            ?>
            <button 
              class="button-primary delete-calendar-event-btn"
              data-bs-toggle="modal"
              data-bs-target="#deleteCalendarEventModal"
              data-calendar-event="<?php echo $event->id; ?>"
            >
            Slet
          </button>
          <button 
              class="button-primary archive-calendar-event-btn"
              data-bs-toggle="modal"
              data-bs-target="#archiveCalendarEventModal"
            >
            Arkiver opgave
          </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-lg" id="updateCalendarEventModal" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">Opdater <?php echo $event->event_name ?></div>
      <div class="modal-body">
        <form action="#" method="post" id="updateCalendarEventForm">
          <div class="form-group">
            <label for="eventName">Begivenheds navn</label>
            <input 
              type="text" 
              name="calendar-event-name" 
              id="calendar-event-name" 
              class="form-control" 
              value="<?php echo $event->event_name ?>"
              required
            >
          </div>
          <div class="form-group">
            <label for="eventName">Begivenheds årstal</label>
            <input 
              type="text" 
              name="calendar-event-year" 
              id="calendar-event-year" 
              class="form-control" 
              value="<?php echo $event->event_year ?>"
              required
            >
          </div>
          <div class="form-group">
            <label for="eventDate">Begivenheds dato</label>
            <input 
              type="date" 
              name="calendar-event-date" 
              id="calendar-event-date" 
              class="form-control" 
              value="<?php echo $event->event_date ?>"
              required
            >
          </div>
          <div class="form-group">
            <label for="eventDeadline">Deadline</label>
            <input
              type="date" 
              name="calendar-event-deadline" 
              id="calendar-event-deadline" 
              class="form-control" 
              value="<?php echo $event->event_deadline ?>"
              required
            >
          </div>
          <div class="form-group">
            <label for="description">Beskrivelse</label>
            <?php
              wp_editor($event->description, 'calendar-event-description', array(
                  "textarea_rows" => 5,
                  "height" => 100
              ));
            ?>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="button-primary mx-2" data-bs-dismiss="modal">Annuller</button>
        <button class="button-primary update-calendar-event-button" data-event="<?php echo $event->id; ?>">Opdater</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" id="deleteCalendarEventModal" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Fjern opgave</h2>
      </div>
      <div class="modal-body">
        <p class="lead">
          Ønsker du at fjerne opgaven fra kalenderen? Dette kan ikke fortrydes.
        </p>
      </div>
      <div class="modal-footer">
        <button class="button-primary mx-2" data-bs-dismiss="modal">Annuller</button>
        <button class="button-primary delete-calendar-event-button" data-event="<?php echo $event->id; ?>">Fjern</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" id="archiveCalendarEventModal" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Fjern opgave</h2>
      </div>
      <div class="modal-body">
        <p class="lead">
          Ønsker du at arkivere opgaven? du vil kunne se denne opgave under arkiverede opgaver
        </p>
      </div>
      <div class="modal-footer">
        <button class="button-primary mx-2" data-bs-dismiss="modal">Annuller</button>
        <button class="button-primary archive-calendar-event-button" data-event="<?php echo $event->id; ?>">Arkiver opgave</button>
      </div>
    </div>
  </div>
</div>
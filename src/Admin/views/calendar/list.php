<?php 
  /**
   * List view for calendar events
   * @package Dxl events
   */
?>
<div class="dxl dxl-events">
  <div class="header mb-4">
    <div class="container actions">
      <div class="row">
        <div class="col-9">
          <h2>Opgave Kalender</h2>
        </div>
        <div class="col-3">
          <button class="create-calendar-event-btn button-primary" data-bs-toggle="modal" data-bs-target="#createCalendarEventModal">Opret begivenhed</button>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="calendar-events-list">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h2><?php echo $monthNames[$currentMonth - 1] . ' ' . $currentYear; ?></h2>
            <!-- 
              navigation links
             -->
            <div class="calendar-navigation-links mb-4">
              <a href="<?php echo generate_dxl_subpage_url(['action' => 'list', 'month' => $currentMonth - 1, 'year' => $currentYear]); ?>" class="button-primary">Forrige måned</a>
              <a href="<?php echo generate_dxl_subpage_url(['action' => 'list', 'month' => $currentMonth + 1, 'year' => $currentYear]); ?>" class="button-primary">Næste måned</a>
            </div>
            <!-- 
              show archived events
             -->
             <?php 
              if ( $isArchived ) {
                ?>
                  <div class="show-archived-events mb-4">
                    <a href="<?php echo generate_dxl_subpage_url(['action' => 'list', 'archived' => 0]); ?>" class="button-primary">Vis aktive opgaver</a>
                  </div>
                <?php
              } else {
                ?>
                  <div class="show-archived-events mb-4">
                    <a href="<?php echo generate_dxl_subpage_url(['action' => 'list', 'archived' => true]); ?>" class="button-primary">Vis arkiverede opgaver</a>
                  </div>
                <?php
              }
             ?>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <?php 
              foreach($dayNames as $dayName) {
                ?>
                  <div style="width:14%">
                    <p class="text-left fw-bold"><?php echo $dayName; ?></p>
                  </div>
                <?php
              }
            ?>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <?php 
            $dayCount = 1;
            for($i = 0; $i < $daysInMonth + $firstDay; $i++) {
              if($i < $firstDay) {
                ?>
                  <div style="width: 14%" class="py-2">
                    <p class="text-left"></p>
                  </div>
                <?php
              } else {
                ?>
                  <div style="width: 14%" class="py-4">
                    <p class="text-left fw-bold"><?php echo $dayCount; ?></p>
                    <?php 
                    if ( $isArchived ) {
                      $events = $wpdb->get_results(
                        "SELECT * FROM {$wpdb->prefix}calendar_events WHERE event_date = '{$currentYear}-{$currentMonth}-{$dayCount}' AND is_archived = 1"
                      );
                    } else {
                      $events = $wpdb->get_results(
                        "SELECT * FROM {$wpdb->prefix}calendar_events WHERE event_date = '{$currentYear}-{$currentMonth}-{$dayCount}' AND is_archived = 0"
                      );
                    }
                    if (count($events)) {
                      foreach( $events as $event ) {
                        $tooltip = "<p>Deadline: {$event->event_deadline}</p><br>";
                        if ( $event->priority == 1 ) {
                          $tooltip .= "<p>Prioritet: Høj</p>";
                        } else {
                          $tooltip .= "<p>Prioritet: Lav</p>";
                        }
                        if ( $event->is_completed ) {
                          $tooltip .= "<p class='text-success'>Opgave afsluttet</p>";
                        } else {
                          $tooltip .= "<p class='text-warning'>Opgave ikke afsluttet</p>";
                        }

                        $priorityClass = ($event->priority == 1) ? "text-danger" : "text-success";
                        ?>
                          <div
                            class="row mb-2"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-html="true"
                            data-bs-title="<?php echo $tooltip; ?>"
                          >
                            <div class="col-10">
                              <small class="text-left fw-bold <?php if( $event->is_completed ) { echo "text-decoration-line-through text-muted"; }?> <?php echo $priorityClass; ?>"><?php echo $event->event_name; ?></small>
                            </div>
                            <div class="col-2">
                              <a href="<?php echo generate_dxl_subpage_url(['action' => 'details', 'id' => $event->id]); ?>" class="view-calendar-event-details text-decoration-none">
                                <span class="dashicons dashicons-edit"></span>
                              </a>
                            </div>
                          </div>
                        <?php
                      }
                    } else {
                      ?>
                        <small class="text-left">Ingen begivenheder</small>
                      <?php
                    }
                    ?>
                  </div>
                <?php
                $dayCount++;
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-lg" id="createCalendarEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opret ny kalender begivenhed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Udfyld formularen nedenfor for at oprette en ny begivenhed til kalenderen</p>
                <form action="#" id="calendarEventForm">
                  <div class="form-group event-name mb-3">
                    <label for="calendar-event-name">
                      Opgave
                    </label>
                    <input 
                      type="text" 
                      class="form-control" 
                      name="calendar-event-name" 
                      id="calendar-event-name"
                      value="Ny opgave"
                      required
                    >
                  </div>
                  <div class="form-group event-year mb-3">
                    <label for="calendar-event-year">
                      Årstal for opgave
                    </label>
                    <input 
                      type="number" 
                      class="form-control" 
                      name="calendar-event-year" 
                      id="calendar-event-year"
                      value="<?php echo date("Y"); ?>"
                      required
                      pattern="[0-9]{4}"  
                    >
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group event-date mb-3">
                        <label for="calendar-event-date">
                          Dato for opgave
                        </label>
                        <!-- render date field without year -->
                        <input 
                          type="date" 
                          class="form-control" 
                          name="calendar-event-date" 
                          id="calendar-event-date"
                          value="<?php echo date("Y-m-d"); ?>"
                          required
                        >
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group event-date mb-3">
                        <label for="calendar-event-date">
                          Slut dato for opgave
                        </label>
                        <!-- render date field without year -->
                        <input 
                          type="date" 
                          class="form-control" 
                          name="calendar-event-end-date" 
                          id="calendar-event-end-date"
                          value="<?php echo date("Y-m-d"); ?>"
                          required
                        >
                      </div>
                    </div>
                  </div>
                  <div class="form-group event-deadline mb-3">
                    <label for="calendar-event-deadline">
                      Deadline for opgave
                    </label>
                    <input 
                      type="date" 
                      class="form-control" 
                      name="calendar-event-deadline" 
                      id="calendar-event-deadline" 
                      value="<?php echo date("Y-m-d"); ?>"
                      required
                    >
                    <div class="invalid-feedback invalid-deadline-feedback">
                      Deadline kan ikke være før opgavens start dato
                    </div>
                  </div>
                  <div class="form-group associate-member mb-3 w-full">
                    <label for="associate-member">Udføres af:</label>
                    <select name="associate-members" id="associate-member" class="form-control">
                      <?php 
                        foreach ( $associates as $associate ) {
                          ?>
                            <option value="<?php echo $associate->id; ?>"><?php echo $associate->name; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group priority-field mb-3 w-full">
                    <label for="priority">Vælg prioritet
                       <small>
                        (Høj prioritet, Middel prioritet, Lav prioritet)
                       </small>
                    </label>
                    <select name="event-priority" id="priority" class="form-control">
                        <option value="1">Høj priotet</option>
                        <option value="3">Lav prioritet</option>
                    </select>
                  </div>
                  <div class="form-group event-description">
                    <label for="calendar-event-description">
                      Beskrivelse for opgave
                    </label>
                    <?php 
                      wp_editor("Beskriv din opgave her", 'calendar-event-description', array(
                          "textarea_rows" => 5,
                          "height" => 100
                      ));
                  ?>
                  </div>
                  <div class="error-response"></div>
                </form>
            </div>
            <div class="modal-footer gap-2">
                <button class="button-primary close-modal" data-bs-dismiss="modal">Luk</button>
                <button class="button-primary create-calendar-event-button">Opret til kalender</button>
            </div>
        </div>
    </div>
</div>
<?php 
  /**
   * List view for calendar events
   * @package Dxl events
   */
?>

<div class="dxl dxl-events">
  <div class="header">
    <div class="container actions">
      <div class="row">
        <div class="col-9">
          <h3>DXL Kalender</h3>
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
          </div>
        </div>
        <div class="container">
          <div class="row">
            <?php 
              foreach($dayNames as $dayName) {
                ?>
                  <div style="width:14%">
                    <p class="text-left"><?php echo $dayName; ?></p>
                  </div>
                <?php
              }
            ?>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <?php 
            // render days within 7 columns
            $dayCount = 1;
            // var_dump($firstDay);
            // var_dump($daysInMonth);
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
                    $events = $wpdb->get_results(
                      "SELECT * FROM {$wpdb->prefix}calendar_events WHERE event_date = '{$currentYear}-{$currentMonth}-{$dayCount}'"
                    );
                    if (count($events)) {
                      foreach( $events as $event ) {
                        ?>
                          <small class="text-left fw-bold"><?php echo $event->event_name; ?></small><br />
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
                    <input type="text" class="form-control" name="calendar-event-name" id="calendar-event-name">
                  </div>
                  <div class="form-group event-date mb-3">
                    <label for="calendar-event-date">
                      Dato for opgave
                    </label>
                    <!-- render date field without year -->
                    <input type="date" class="form-control" name="calendar-event-date" id="calendar-event-date">
                  </div>
                  <div class="form-group event-deadline mb-3">
                    <label for="calendar-event-deadline">
                      Deadline for opgave
                    </label>
                    <input type="date" class="form-control" name="calendar-event-deadline" id="calendar-event-deadline" required>
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
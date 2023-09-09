<?php 
  /**
   * List view for calendar events
   * @package Dxl events
   */

  // var_dump($daysPeriod);
  // var_dump([
  //   "currentDay" => $currentDay,
  //   "currentMonth" => $currentMonth,
  //   "currentYear" => $currentYear
  // ])
?>

<div class="dxl dxl-events">
  <div class="header">
    <div class="container actions">
      <div class="row">
        <div class="col-9">
          <h3>DXL Kalender</h3>
        </div>
        <div class="col-3">
          <button class="create-calendar-event-btn button-primary" data-bs-toggle="model" data-bs-target="#createCalendarEventModal">Opret begivenhed</button>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="calendar-events-list">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p class="lead fw-bold text-center">
              <?php echo $currentMonth ?>
            </p>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <?php 
              foreach($dates as $date) {
                ?>
                  <div class="col-1 py-3">
                    <div class="date">
                      <p class="lead fw-bold text-center">
                        <?php echo $date ?>
                      </p>
                    </div>
                  </div>
                <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/Partials/create-calendar-event-modal.php"; ?>
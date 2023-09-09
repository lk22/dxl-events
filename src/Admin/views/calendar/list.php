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
                  <div style="width: 14%" class="py-2">
                    <p class="text-left"><?php echo $dayCount; ?></p>
                    <?php 
                      foreach($events as $event) {
                        if($event->event_date == "{$currentYear}-{$currentMonth}-{$dayCount}") {
                          ?>
                            <p class="text-left"><?php echo $event->event_name; ?></p>
                          <?php
                        }
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

<?php require_once ABSPATH . "wp-content/plugins/dxl-events/src/Admin/views/calendar/Partials/create-calendar-event-modal.php"; ?>
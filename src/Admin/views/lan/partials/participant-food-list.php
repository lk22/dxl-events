<?php 
  if (count($participantsWithFood) > 0) {
    ?>
      <table class="table table-responsive">
          <thead>
              <th>Navn:</th>
              <th>Morgenmad (Fredag)</th>
              <th>Morgenmad (Lørdag)</th>
              <th>Frokost (Lørdag)</th>
              <th>Aftensmad (Lørdag)</th>
              <th>Morgenmad (Søndag)</th>
          </thead>
          <tbody>
              <?php 
              
              foreach($participantsWithFood as $order) {
                  ?>
                      <tr>
                          <td><?php echo $order->name; ?></td>
                          <td><?php echo ($order->has_friday_breakfast) ? "Ja" : "Nej"; ?></td>
                          <td><?php echo ($order->has_saturday_breakfast) ? "Ja" : "Nej"; ?></td>
                          <td><?php echo ($order->has_saturday_lunch) ? "Ja" : "Nej"; ?></td>
                          <td><?php echo ($order->has_saturday_dinner) ? "Ja" : "Nej"; ?></td>
                          <td><?php echo ($order->has_sunday_breakfast) ? "Ja" : "Nej"; ?></td>
                      </tr>
                  <?php
              }
              ?>
          </tbody>
      </table>
    <?php
  }
?>

<div class="modal modal-xl fade" id="configWorkChoresModal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Administrer arbejdsopgaver</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 mb-4">
            <p class="lead">Her kan du administrere arbejdsopgaver for LAN'et</p>
            <p class="lead">Du kan tilføje, redigere og slette arbejdsopgaver</p>
          </div>
          <div class="col-12">
            <form action="#" class="config-workchores-form">
              <input type="hidden" name="event" value="<?php echo $event->id; ?>">
              <div class="friday-workchores">
                <p class="lead fw-bold mb-3">Fredag</p>
                <?php 
                if ( isset($fridayChores) ) {
                  foreach( $fridayChores as $c => $chore ) {
                    ?> 
                      <div class="form-group mb-3 <?php echo $chore->key ?>">
                        <input 
                        type="text" 
                        class="form-control" 
                        id="<?php echo $c ?>" 
                        name="<?php echo $chore->key ?>" 
                        value="<?php echo $chore->name ?>"
                        style="font-size:12px"
                        >
                      </div>
                      <?php
                  }
                }
                ?>
              </div>
              <div class="saturday-workchores">
                <p class="lead fw-bold mb-3">Lørdag</p>
                <?php 
                  if ( isset($saturdayChores) ) {
                    foreach( $saturdayChores as $c => $chore ) {
                      ?> 
                        <div class="form-group mb-3 <?php echo $chore->key ?>">
                          <input 
                            type="text" 
                            class="form-control" 
                            id="<?php echo $chore->key ?>" 
                            name="<?php echo $chore->key ?>" 
                            value="<?php echo $chore->name ?>"
                            style="font-size:12px"
                          >
                        </div>
                      <?php
                    }
                  }
                ?>
              </div>
              <div class="sunday-workchores">
                <p class="lead fw-bold mb-3">Søndag</p>
                <?php 
                  if ( isset($sundayChores) ) {
                    foreach( $sundayChores as $c => $chore ) {
                      ?> 
                        <div class="form-group mb-3 <?php echo $chore->key ?>">
                          <input 
                            type="text" 
                            class="form-control" 
                            id="<?php echo $chore->key ?>" 
                            name="<?php echo $chore->key ?>" 
                            value="<?php echo $chore->name ?>"
                            style="font-size:12px"
                          >
                        </div>
                      <?php
                    }
                  }
                ?>
              </div>
            </form>
            <?php 
            ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="button-primary me-2" data-bs-dismiss="modal">Luk</button>
        <button class="button-primary me-2 config-work-chores-btn">Opdater</button>
      </div>
    </div>
  </div>
</div>
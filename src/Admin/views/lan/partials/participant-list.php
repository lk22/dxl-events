<?php 
    if( $event->participants_count > 0 ) {
        ?>
            <table class="table table-responsive">
                <thead>
                    <th>Navn:</th>
                    <th>Gamertag:</th>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach($participants as $participant) {
                        ?>
                            <tr>
                                <td><?php echo $participant->name; ?></td>
                                <td><?php echo $participant->gamertag; ?></td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        
    } else {
        ?>
            <div class="alert alert-warning">Du har ingen tilmeldinger</div>
        <?php
    }
?>
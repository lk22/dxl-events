<?php 

?>

<table class="widefat fixed striped">
    <thead>
        <th>Deltager:</th>
    </thead>
    <tbody>
        <?php
            if( $participants ) {
                foreach($participants as $participant) {
                    ?>
                        <tr>
                            <td><?php echo $participant->gamertag; ?></td>
                        </tr>
                    <?php
                }
            } else {
                ?>
                    <div class="alert alert-danger">Du har ingen deltagere</div>
                <?php
            }
        ?>
    </tbody>
</table>
<?php 
    if( $tournamentData ) {
        ?>
            <table class="widefat fixed striped event-tournaments-list">
                <thead>
                    <th>Turnering</th>
                    <th>Antal deltagere</th>
                </thead>
                <tbody>
                    <?php 
                        foreach($tournamentData as $tournament) {
                            ?>
                                <tr>
                                    <td><?php echo $tournament["title"]; ?></td>
                                    <td><?php echo $tournament["participants_count"] ?> deltagere</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        <?php
    } else {
        ?>
            <div class="alert alert-warning">Du har ingen turneringer tilknyttet</div>
        <?php
    }
?>
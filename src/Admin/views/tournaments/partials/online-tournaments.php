<?php 
        if( $onlineTournaments ) {
    ?>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Tilstand</th>
                <th>Antal deltagere</th>
                <th>Dato</th>
                <th>Tidspunkt</th>
                <th>Oprettet</th>
                <th>Oprettet af</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($onlineTournaments as $tournament) 
                {
                    $user = get_user_by('id', $tournament->author)->user_login ?? "";
                    ?>
                        <tr data-tournament="<?php echo $tournament->id ?>">
                            <td><a href="<?php echo generate_dxl_subpage_url(['action' => 'details', 'id' => $tournament->id]) ?>"><?php echo $tournament->title; ?></a></td>
                            <td><?php echo ($tournament->is_draft) ? "Udkast" : "Offentliggjort"; ?></td>
                            <td>
                                <?php echo $tournament->participants_count . " Deltagere"; ?>
                                <?php 
                                    if( $tournament->participants_count > 0 ) {
                                        ?>
                                            <div class="lookup-participants-list modal-button" data-modal="#tournamentParticipantListModal" data-tournament="<?php echo $tournament->id; ?>">Se deltager liste</div>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo date("d-m", $tournament->start) . " - " . date("d-m Y", $tournament->end); ?></td>
                            <td><?php echo date("H:i", $tournament->starttime) . " - " . date("H:i", $tournament->endtime); ?></td>
                            <td><?php echo date("d-m-Y H:i", $tournament->created_at) ?></td>
                            <td><?php echo $user ?></td>
                            <td><button class="button-primary delete-tournament-btn" data-tournament="<?php echo $tournament->id ?>"><span class="dashicons dashicons-trash"></span></button></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php 
        } else {
            ?>
                <div class="alert alert-danger">
                    <h3>Vi kunne ikke finde nogle turneringer</h3>
                </div>
            <?php
        }
    ?>
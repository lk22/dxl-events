<div class="dxl dxl-events events-container">
    <div class="header">
        <div class="logo">
            <img height="100" src="http://localhost:8888/dxl-v2/wp-content/uploads/2022/03/cropped-cropped-DXL-LOGO-Hjemmeside_192x192.png" alt="">
        </div>
        <h1>Turneringer</h1>
        <div class="actions">
            <a href="#" class="button-primary modal-button" data-modal="#createTournamentModal">Opret begivenhed <span class="dashicons dashicons-calendar"></span></a>
        </div>
    </div>

    <div class="content">
    <?php 
        if( $tournaments ) {
    ?>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Tilstand</th>
                <th>Type</th>
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
                foreach($tournaments as $tournament) 
                {
                    $type = ($tournament->type == 3) ? "LAN turnering" : "Online turnering";
                    $user = get_user_by('id', $tournament->author)->user_login ?? "";
                    ?>
                        <tr data-tournament="<?php echo $tournament->id ?>">
                            <td><a href="<?php echo generate_dxl_subpage_url(['action' => 'details', 'id' => $tournament->id]) ?>"><?php echo $tournament->title; ?></a></td>
                            <td><?php echo ($tournament->is_draft) ? "Udkast" : "Offentliggjort"; ?></td>
                            <td><?php echo $type; ?></td>
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
    </div>
</div>

<!-- create tournament modal -->
<div class="modal createTournamentModal hidden" id="createTournamentModal" role="dialog">
    <div class="modal-header">
        <h2>Opret turnering</h2>
    </div>
    <div class="modal-body">
        <form action="#" class="admin-create-tournament-form">
            <div class="left-form">
                <div class="form-group tournament-title">
                    <label for="tournament-name">
                        Turnerings titel
                        <input type="text" class="form-control" name="tournament-name" id="tournament-name" required>
                    </label>
                </div>
                <div class="form-group tournament-type">
                    <h4>Vælg type turnering</h4>
                    <label for="tournament-type">
                        Online turnering
                        <input type="radio" class="form-control" name="tournament-type" id="tournament-type" value="2" required>
                    </label>
                    <label for="tournament-type">
                        LAN Turnering
                        <input type="radio" class="form-control" name="tournament-type" id="tournament-type" value="3" required>
                    </label>
                </div>
                <div class="form-group tournament-minimum-participants">
                    <label for="tournament-min-participants">
                        Minimum antal deltagere
                        <input type="number" class="form-control" id="tournament-min-participants" name="tournament-min-participants">
                    </label>
                </div>
                <div class="form-group tournament-maximum-participants">
                    <label for="tournament-max-participants">
                        Maximum antal deltagere
                        <input type="number" class="form-control" id="tournament-max-participants" name="tournament-max-participants">
                    </label>
                </div>
                
            </div>
            <div class="right-form">
                <h1>Tidsindstillinger</h1>
                <div class="form-group start-date">
                    <label for="tournament-startdate">
                        Start dato: 
                        <input type="date" class="form-control" name="tournament-startdate" id="tournament-startdate" required>
                    </label>
                </div>
                <div class="form-group end-date">
                    <label for="tournament-startdate">
                        Slut dato: 
                        <input type="date" class="form-control" name="tournament-enddate" id="tournament-enddate" required>
                    </label>
                </div>
                <div class="form-group start-time">
                    <label for="tournament-starttime">
                        Start tidspunkt: 
                        <input type="time" class="form-control" name="tournament-starttime" id="tournament-starttime" required>
                    </label>
                </div>
                <div class="form-group end-time">
                    <label for="tournament-endtime">
                        Start tidspunkt: 
                        <input type="time" class="form-control" name="tournament-endtime" id="tournament-endtime" required>
                    </label>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk <span class="dashicons dashicons-no"></span></button>
        <button class="button-primary create-tournament-button">Opret <span class="dashicons dashicons-calendar"></span></button>
    </div>
</div>

<!-- participant list -->
<div class="modal hidden tournamentParticipantListModal" id="tournamentParticipantListModal" role="dialog">
    <div class="modal-header">
        <h3>Deltager</h3>
    </div>
    <div class="modal-body">
        <div class="text">
            <h2>Indlæser deltager liste <sh2an class="dashicons dashicons-admin-users"></span></h2>
            <p>vent venligst.</p>
        </div>
       
        <table class="participants-list widefat fixed striped">
            <thead>
                <th>Navn</th>
                <th>Gamertag</th>
                <th>E-mail</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="button-primary close-modal">Luk <span class="dashicons dashicons-no"></span></button>
    </div>
</div>
<div class="overlay hidden"></div>